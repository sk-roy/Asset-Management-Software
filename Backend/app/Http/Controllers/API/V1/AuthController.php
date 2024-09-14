<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\API\V1\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService) 
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            $user = $this->authService->register($request->all());
            $token = $this->authService->getToken($user);

            return response()->json([
                'user' => $user, 
                'token' => $token,
                'message' => 'Registration successful'
            ], 201);

        } catch (ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            // throw $e;
            return response()->json(['message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Registration Failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:6',
            ]);

            $user = $this->authService->login($request->only('email', 'password'));
            $token = $this->authService->getToken($user);

            return response()->json([
                'user' => $user, 
                'token' => $token,
                'message' => 'Login successful'
            ], 200);

        } catch (ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Login Failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Login Failed'], 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        try {
            $request->validate(['email' => 'required|string|email']);
            $status = $this->authService->sendResetLink($request->only('email'));

            return response()->json(['message' => __($status)], 200);

        } catch (ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Forgot Password Failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 400);
            // return response()->json(['message' => 'Forgot Password Failed'], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);
        
            $status = $this->authService->resetPassword($request->only('token', 'email', 'password'));

            return $status=== Password::PASSWORD_RESET
                ? response()->json(['message' => __($status)], 200)
                : response()->json(['message' => __($status)], 400);

        } catch (ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            return response()->json(['message' => $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Reset Password Failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Reset Password Failed'], 400);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Exception $e) {
            \Log::error('Logout Failed:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to log out'], 500);
        }
    }
}
