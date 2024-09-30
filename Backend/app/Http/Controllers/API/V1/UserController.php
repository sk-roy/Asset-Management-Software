<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Services\API\V1\IUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $userService;

    public function __construct(IUserService $userService) 
    {
        $this->userService = $userService;
    }    

    public function getUserInfo(Request $request)
    {
        Log::info('Route /user Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];

        try {
            $user = $this->userService->getUserInfo();

            $response['success'] = true;
            $response['data'] = $user;
            $response['message'] = 'User information retrieved successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Failed to retrieve user information.';
            
            Log::error($response['message'], ['error' => $e->getMessage()]);
        }

        Log::info('Route /user End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    } 

    public function editUserInfo(Request $request)
    {
        Log::info('Route /user/update Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];

        try {
            $name = $request->input('name');
            $email = $request->input('email');
            $user = $this->userService->editUserInfo($name, $email);

            $response['success'] = true;
            $response['data'] = $user;
            $response['message'] = 'User information updated  successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Failed to update user information.';
            
            Log::error($response['message'], ['error' => $e->getMessage()]);
        }

        Log::info('Route /user/update End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }

    public function changePassword(Request $request)
    {
        Log::info('Route /user/change-password Start.', ['request' => request()->all(), 'user' => auth()->user()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];

        try {
            $user = $this->userService->changePassword($request->current_password, $request->new_password);

            $response['success'] = true;
            $response['message'] = 'Password changed successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (\Exception $e) {
            $response['success'] = false;
            $response['message'] = 'Failed to change password.';            
            Log::error($response['message'], ['error' => $e->getMessage()]);
        }

        Log::info('Route /user/change-password End.', ['response' => $response, 'user' => auth()->user()]);
        return response()->json($response);
    }

    public function logout(Request $request)
    {
        Log::info('Logout started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => '',
        ];
        try {
            $user = $this->userService->logout();
            
            $response['success'] = true;
            $response['message'] = 'Successfully logged out.';
            Log::info($response['message'], ['response' => $response]);
        } catch (Exception $e) {
            Log::error('Logout Failed:', ['error' => $e->getMessage()]);      
            $response['success'] = false;
            $response['message'] = 'Logout Failed.';
        }
        
        Log::info('Logout completed.', ['request' => request()->all()]);
        return response()->json($response);
    }
}
