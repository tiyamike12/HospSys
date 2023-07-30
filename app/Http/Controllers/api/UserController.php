<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\AvailabilityRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Mail\RegistrationEmail;
use App\Models\DoctorAvailability;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): JsonResponse
    {

        $randomPassword = Str::random(10); // You can change 10 to the desired length of the password

        DB::beginTransaction();

        try {
            // Create a new person record
            $person = Person::create([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'physical_address' => $request->input('physical_address'),
                'job_title' => $request->input('job_title'),
            ]);

            // Create a new user record with the initial username attempt
            $initialUsername = Str::lower(substr($request->input('firstname'), 0, 1) . $request->input('lastname'));
            $usernameAttempt = $initialUsername;

            // Check if the username is unique, if not, append random characters until it becomes unique
            while (User::where('username', $usernameAttempt)->exists()) {
                // Generate a short random string (e.g., 4 characters) and append it to the username
                $randomString = Str::random(4);
                $usernameAttempt = $initialUsername . $randomString;
            }
            // Create a new user record
            $user = User::create([
                'username' => $usernameAttempt,
                'password' => Hash::make($randomPassword),
                'role_id' => $request->input('role_id'),
            ]);

            // Associate the user with the person (assuming you have a "user_id" column in the "people" table)
            $person->user_id = $user->id;
            $person->save();

            // Send the registration email
            $this->sendRegistrationEmail($request->input('email'), $user->username, $randomPassword);

            // If everything is successful, commit the transaction
            DB::commit();

            return response()->json(['message' => 'User created successfully'], 201);

        } catch (\Exception $e) {
            // If any error occurs, rollback the transaction
            DB::rollBack();

            // Handle the error as needed (e.g., log it or throw an exception)
            return response()->json(['message' => 'Failed to create user.', 'error' => $e], 500);
        }
    }

    private function sendRegistrationEmail(string $email, string $username, string $password): void
    {
        try {
            Mail::to($email)->send(new RegistrationEmail($username, $password));
            // Email sent successfully
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Email sending failed: ' . $e->getMessage());
            // You can choose to re-throw the exception or handle it differently if needed
            throw new \Exception('Failed to send registration email', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $userId): JsonResponse
    {
        Log::info('API Update User Request Data:', ['data' => $request->all()]);
        Log::info('User ID:', ['user_id' => $userId]);
        DB::beginTransaction();

        try {
            // Find the user by ID
            $user = User::findOrFail($userId);

            // Update the user record
            $user->update([
//                'username' => $request->input('username'),
//                'password' => Hash::make($request->input('password')),
                'role_id' => $request->input('role_id'),
            ]);

            // Find or create the associated person record based on the user's ID
            $person = Person::firstOrNew(['user_id' => $user->id]);
            $person->fill([
                'firstname' => $request->input('firstname'),
                'lastname' => $request->input('lastname'),
                'date_of_birth' => $request->input('date_of_birth'),
                'gender' => $request->input('gender'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'physical_address' => $request->input('physical_address'),
                'job_title' => $request->input('job_title'),
            ]);
            $person->save();

            // If everything is successful, commit the transaction
            DB::commit();


            return response()->json(['message' => 'User updated successfully'], 200);
        } catch (\Exception $e) {
            // If any error occurs, rollback the transaction
            DB::rollBack();

            // Handle the error as needed (e.g., log it or throw an exception)
            return response()->json(['message' => 'Failed to update user.', 'error' => $e], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }

    /**
     * Get a list of doctors.
     *
     * @return JsonResponse
     */
    public function getDoctors(): JsonResponse
    {
        //$doctors = User::doctors()->get();

        $doctors = User::doctors()->with('person')->get();

        return response()->json($doctors, 200);
    }

    public function setAvailability(AvailabilityRequest $request, $doctorId): JsonResponse
    {
//        $request->validate([
//            'start_time' => 'required|date_format:H:i',
//            'end_time' => 'required|date_format:H:i|after:start_time',
//        ]);

        $doctor = User::findOrFail($doctorId);

        // Check if the doctor is the currently authenticated user or if the authenticated user has admin rights.
        // You can customize this logic based on your authentication and authorization setup.
        if ($doctor->id !== auth()->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Check if the doctor has an availability record, create or update accordingly.
        $availability = DoctorAvailability::updateOrCreate(
            ['doctor_id' => $doctor->id],
            ['start_time' => $request->input('start_time'), 'end_time' => $request->input('end_time')]
        );

        return response()->json(['message' => 'Availability set successfully', 'data' => $availability], 200);
    }

    public function getAvailability($doctorId): JsonResponse
    {
        $doctor = User::findOrFail($doctorId);

        // Check if the doctor is the currently authenticated user or if the authenticated user has admin rights.
        // You can customize this logic based on your authentication and authorization setup.
//        if ($doctor->id !== auth()->user()->id && !auth()->user()->isAdmin()) {
        if ($doctor->id !== auth()->user()->id) {

                return response()->json(['message' => 'Unauthorized'], 403);
        }

        $availability = $doctor->availability;

        return response()->json($availability, 200);
    }
}
