<?php

namespace App\Services\API\V1;

use App\Models\User;
use Illuminate\User\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserService implements IUserService
{
    public function getUserInfo()
    {
        Log::info('Method [UserService.getUserInfo] Start.');
        
        try {
            $user = auth()->user();
            Log::info('User Information loaded succesfully:', ['user' => $user]);

        } catch (Exception $e) {
            Log::error('User Information loading failed:', ['error' => $e->getMessage()]);
            throw new Exception('User Information loading failed.');
        }
        
        Log::info('Method [UserService.getUserInfo] Start.', ['user' => $user]);
        return $user;
    }
    
    public function editUserInfo($name, $email)
    {
        Log::info('Method [UserService.editUserInfo] Start.');

        try {
            $user = auth()->user();
            $user->name = $name;
            $user->email = $email;
            $user->save();
            Log::info('User Information updated succesfully:', ['user' => $user]);
            
        } catch (Exception $e) {
            Log::error('Failed to update user information:', ['error' => $e->getMessage()]);
            throw new \Exception('Failed to update user information.');
        }

        Log::info('Method [UserService.editUserInfo] Start.', ['user' => $user]);
        return $user;
    }
    
    public function changePassword($current_password, $new_password)
    {
        Log::info('Method [UserService.changePassword] Start.');

        try {
            $user = auth()->user();

            if (!Hash::check($current_password, $user->password)) {
                Log::error('Current password does not match:', ['error' => $e->getMessage()]);
                throw new \Exception('Current password does not match.');
            }

            $user->password = Hash::make($new_password);
            $user->save();
            Log::info('assword changed successfully:', ['user' => $user]);
        } catch (\Exception $e) {
            Log::error('Failed to change password:', ['error' => $e->getMessage()]);
        }
        
        Log::info('Method [UserService.changePassword] Start.', ['user' => $user]);
    }

    public function logout()
    {
        Log::info('Method [UserService.logout] Start.');
        try {
            auth()->user()->currentAccessToken()->delete();            
        } catch (\Exception $e) {
            Log::error('Logout failed:', ['error' => $e->getMessage()]);
            throw new \Exception('Failed to log out.');
        }

        Log::info('Method [UserService.logout] Start.', ['user' => $user]);
    }
}
