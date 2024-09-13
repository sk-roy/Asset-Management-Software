<?php

namespace App\Services\API\V1;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{

    public function register(array $data)
    {
        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            return $user;
        } catch (\Exception $e) {
            Log::error('Registration Error:', ['error' => $e->getMessage()]);
            throw new \Exception('Registration failed.');
        }
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            Log::warning('Login Attempt Failed:', ['email' => $credentials['email']]);
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return Auth::user();
    }

    public function sendResetLink(array $data)
    {
        try {
            $status = Password::sendResetLink($data);

            if ($status !== Password::RESET_LINK_SENT) {
                Log::warning('Reset Link Failed:', ['email' => $data['email']]);
                throw new \Exception('Failed to send reset link.');
            }

            return $status;
        } catch (\Exception $e) {
            Log::error('Forgot Password Error:', ['error' => $e->getMessage()]);
            // throw new \Exception('Failed to process forgot password request.');
            throw new \Exception($e->getMessage());
        }
    }

    public function resetPassword(array $data)
    {
        try {          
            $status = Password::reset($data,
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
        
                    $user->save();
        
                    event(new PasswordReset($user));
                }
            );
        
            return $status;              
        } catch (\Exception $e) {
            Log::error('Reset Password Error:', ['error' => $e->getMessage()]);
            throw new \Exception('Failed to process reset password request.');
        }
    }

    public function getToken(User $user) {
        try {
            return $user->createToken('authToken')->plainTextToken;          
        } catch (\Exception $e) {
            Log::error('Creating auth token failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Failed to create token.');
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();            
        } catch (\Exception $e) {
            Log::error('Logout failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Failed to log out.');
        }
    }
}
