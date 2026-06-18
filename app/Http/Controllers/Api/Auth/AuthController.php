<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'phone_code' => 'nullable|string|max:5',
            'country' => 'required|string|max:100',
            'company_name' => 'nullable|string|max:200',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'phone_code' => $validated['phone_code'] ?? null,
            'country' => $validated['country'],
            'company_name' => $validated['company_name'] ?? null,
            'email_verified_at' => now(),
        ]);

        // Create user settings and notification preferences
        $user->settings()->create([
            'timezone' => 'Asia/Dhaka',
            'language' => 'en',
        ]);

        $user->notificationPreferences()->create([]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Login user
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.',
            ]);
        }

        if ($user->isSuspended()) {
            throw ValidationException::withMessages([
                'email' => 'Your account is suspended.',
            ]);
        }

        $user->update(['last_login_at' => now(), 'last_login_ip' => $request->ip()]);
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * Get authenticated user
     */
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }

    /**
     * Refresh token
     */
    public function refresh(Request $request)
    {
        $request->user()->tokens()->delete();
        $token = $request->user()->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Token refreshed',
            'token' => $token,
        ]);
    }
}
