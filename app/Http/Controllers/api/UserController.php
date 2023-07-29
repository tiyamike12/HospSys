<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Person;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


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
                'job_title' => $request->input('job_title'),
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
                'username' => $request->input('username'),
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
}
