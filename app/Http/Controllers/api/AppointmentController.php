<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointments\DateRangeRequest;
use App\Http\Requests\Appointments\StoreRequest;
use App\Http\Requests\Appointments\UpdateRequest;
use App\Http\Requests\Availability\AvailabilityRequest;
use App\Http\Resources\AppointmentResource;
use App\Mail\AppointmentReminder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $perPage = 10;

        $listData = Appointment::with('user.person', 'patient')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
        return AppointmentResource::collection($listData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): AppointmentResource
    {

        $userId = $request->input('user_id');
        $patientId = $request->input('patient_id');
        $appointment = Appointment::create([
            'patient_id' => $patientId,
            'user_id' => $userId,
            'appointment_date' => $request->input('appointment_date'),
            'appointment_time' => $request->input('appointment_time'),
            'purpose' => $request->input('purpose'),
        ]);

        // Retrieve the patient's email using the relationship

        $user = Person::where('user_id', $userId)->first();
        $patient = Patient::where('id', $request->input('patient_id'))->first();

        // Concatenate first name and last name to create the full name
        $patientFullName = $patient->firstname . ' ' . $patient->lastname;
        $doctorFullName = $user->firstname . ' ' . $user->lastname;

        // Send the appointment reminder email to the patient and doctor
        $this->sendAppointmentReminderEmail(
            $patientFullName,
            $doctorFullName,
            $patient->email,
            $appointment->user->email,
            $appointment->appointment_date,
            $appointment->appointment_time
        );

//        activity()
//            ->performedOn($appointment)
//            ->causedBy($user)
//            ->withProperties(['customProperty' => 'customValue'])
//            ->log('Look, I logged something');
        return new AppointmentResource($appointment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment): AppointmentResource
    {
        return new AppointmentResource($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $appointmentId): AppointmentResource
    {
        $appointment = Appointment::findOrFail($appointmentId);

        $appointment->update([
            'patient_id' => $request->input('patient_id'),
            'user_id' => $request->input('user_id'),
            'appointment_date' => $request->input('appointment_date'),
            'appointment_time' => $request->input('appointment_time'),
            'purpose' => $request->input('purpose'),
            'status' => $request->input('status'),
        ]);

        $user = Person::where('user_id', $request->input('user_id'))->first();
        $patient = Patient::where('id', $request->input('patient_id'))->first();

        // Concatenate first name and last name to create the full name
        $patientFullName = $patient->firstname . ' ' . $patient->lastname;
        $doctorFullName = $user->firstname . ' ' . $user->lastname;

        // Send the appointment reminder email to the patient and doctor
        $this->sendAppointmentReminderEmail(
            $patientFullName,
            $doctorFullName,
            $patient->email,
            $appointment->user->email,
            $appointment->appointment_date,
            $appointment->appointment_time
        );

        return new AppointmentResource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment): JsonResponse
    {
        $appointment->delete();
        return response()->json(null, 204);
    }

    public function sendAppointmentReminderEmail($patientFullName, $doctorFullName, $patientEmail, $doctorEmail, $appointmentDate, $appointmentTime)
    {
        try {
            // Send the appointment reminder email to the patient
            Mail::to($patientEmail)->send(new AppointmentReminder(
                $patientFullName,
                $doctorFullName,
                $appointmentDate,
                $appointmentTime
            ));

            // Send the appointment reminder email to the doctor
            Mail::to($doctorEmail)->send(new AppointmentReminder(
                $patientFullName,
                $doctorFullName,
                $appointmentDate,
                $appointmentTime
            ));
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Appointment reminder email sending failed: ' . $e->getMessage());
            // Return an error response or handle the error as needed
            return response()->json(['message' => 'Failed to send appointment reminder email'], 500);
        }
    }

    /**
     * Get appointments within a specified date range.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAppointmentsByDateRange(DateRangeRequest $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validate the date inputs
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);

        // Get appointments within the date range
        $appointments = Appointment::with('user.person', 'patient')
            ->whereBetween('appointment_date', [$startDate, $endDate])
            ->get();

        return response()->json($appointments);
    }

    public function getAvailableDoctors(AvailabilityRequest $request): JsonResponse
    {
//        $request->validate([
//            'appointment_date' => 'required|date',
//            'appointment_time' => 'required|date_format:H:i',
//        ]);

        $appointmentDate = $request->input('appointment_date');
        $appointmentTime = $request->input('appointment_time');

        // Get all doctors
        $doctors = User::doctors()->get();

        // Filter doctors based on availability and existing appointments
        $availableDoctors = $doctors->filter(function ($doctor) use ($appointmentDate, $appointmentTime) {
            // Check if the doctor has an availability record for the specified date
            $availability = $doctor->availability;
            if (!$availability || $availability->start_time > $appointmentTime || $availability->end_time < $appointmentTime) {
                return false; // Doctor is not available at the specified time
            }

            // Check if the doctor has any overlapping appointments
            $overlappingAppointment = Appointment::where('user_id', $doctor->id)
                ->where('appointment_date', $appointmentDate)
                ->where('appointment_time', $appointmentTime)
                ->exists();

            return !$overlappingAppointment; // Return true if the doctor does not have any overlapping appointments
        });

        return response()->json($availableDoctors, 200);
    }

    public function getScheduledAppointmentsCount($userId): JsonResponse
    {
        $count = Appointment::where('user_id', $userId)
            ->where('status', 'scheduled')
            ->count();

        return response()->json(['scheduled' => $count]);

    }

    public function getCompletedAppointmentsCount($userId): JsonResponse
    {
        $count = Appointment::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        return response()->json(['completed' => $count]);

    }

    public function getCancelledAppointmentsCount($userId): JsonResponse
    {
        $count = Appointment::where('user_id', $userId)
            ->where('status', 'canceled')
            ->count();

        return response()->json(['canceled' => $count]);

    }

    public function getOverallStatistics()
    {
        $statistics = Appointment::getStatusStatistics();

        return response()->json($statistics);
    }
}
