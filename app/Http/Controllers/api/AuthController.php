<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only(['username', 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $user->load('role');
            $userRole = $user;
            $token = $user->createToken('auth_token')->plainTextToken;

            // Set the token in the cookie with HttpOnly and Secure flags
//            $cookie = cookie('token', $token, 60 * 24 * 7, null, null, true, true); // Expires in 7 days

            return response()->json(['status' => true, 'user' => $user, 'token' => $token], 200);
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid credentials'], 401);
        }
    }

//    public function register(StoreUserRequest $request)
//    {
//        $this->authorize('create-delete-users');
//        $request->validated($request->only(['name', 'email', 'password']));
//
//        $user = User::create([
//            'name' => $request->name,
//            'email' => $request->email,
//            'password' => Hash::make($request->password),
//        ]);
//
//        return response()->json([
//            'user' => $user,
//            'token' => $user->createToken('API Token')->plainTextToken
//        ]);
//    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'You have succesfully been logged out and your token has been removed'
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        // Verify the old password
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return response()->json(['message' => 'Old password is incorrect'], 400);
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return response()->json(['message' => 'Password changed successfully'], 200);
    }
}
