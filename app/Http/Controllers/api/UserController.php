<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Person;
use App\Models\Role;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            ]);

            // Create a new user record
            $user = User::create([
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
                'role_id' => $request->input('role_id'),
            ]);

            // Associate the user with the person (assuming you have a "user_id" column in the "people" table)
            $person->user_id = $user->id;
            $person->save();

            // Retrieve the role ID for "Nurse" from the roles table
            $nurseRoleId = Role::where('name', 'Nurse')->value('id');
            $doctorRoleId = Role::where('name', 'Doctor')->value('id');
            $staffRoleId = Role::where('id', $request->input('role_id'))->value('id');

            switch ($request->input('role_id')) {
                case $doctorRoleId:
                    $doctor = Doctor::create([
                        'person_id' => $person->id,
                        'specialization' => $request->input('specialization'), // Add other doctor attributes here
                    ]);
                    break;

                case $nurseRoleId:
                    $nurse = Nurse::create([
                        'person_id' => $person->id,
                        'specialization' => $request->input('specialization'), // Add other nurse attributes here
                    ]);
                    break;

                case $staffRoleId:
                    $staff = Staff::create([
                        'person_id' => $person->id,
                        'job_title' => $request->input('specialization'), // Add other staff attributes here
                    ]);
                    break;

                default:
                    break;
            }

            // If everything is successful, commit the transaction
            DB::commit();
            return response()->json(['message' => 'User created successfully'], 201);

        } catch (\Exception $e) {
            // If any error occurs, rollback the transaction
            DB::rollBack();

            // Handle the error as needed (e.g., log it or throw an exception)
            return response()->json(['message' => 'Failed to create user.'], 500);
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
    public function update(UpdateUserRequest $request, $user): UserResource
    {

        $userOb = User::findOrFail($user);


        //dd($userOb);
        // Update user data
        $userOb->update($request->only(['username', 'password', 'role_id']));
        //echo $userOb;
        // Update person data (assuming you have the user_id column in the people table)
        $userOb->person->update($request->only(['firstname', 'lastname', 'date_of_birth', 'gender', 'email', 'phone', 'physical_address']));

        return new UserResource($userOb);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
