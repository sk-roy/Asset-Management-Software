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
        Log::info('Registration started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'token' => '',
            'message' => ''
        ];
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]);

            $user = $this->authService->register($request->all());
            $token = $this->authService->getToken($user);
            
            $response['success'] = true;
            $response['data'] = $user;
            $response['token'] = $token;
            $response['message'] = 'User registered successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);
            
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        } catch (\Exception $e) {
            Log::error('Registration Failed:', ['error' => $e->getMessage()]);
            
            $response['success'] = false;
            $response['message'] = 'Registration Failed.';
        }        

        Log::info('Registration completed', ['response' => $response]);
        return response()->json($response);
    }


    public function login(Request $request)
    {
        Log::info('Login started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'token' => '',
            'message' => ''
        ];
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:6',
            ]);

            $user = $this->authService->login($request->only('email', 'password'));
            $token = $this->authService->getToken($user);

            
            $response['success'] = true;
            $response['data'] = $user;
            $response['token'] = $token;
            $response['message'] = 'User log-in successfully.';
            Log::info($response['message'], ['response' => $response]);

        } catch (ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);            
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        Log::info($response['message'], ['response' => $response]);
        } catch (Exception $e) {
            Log::error('Login Failed:', ['error' => $e->getMessage()]);            
            $response['success'] = false;
            $response['message'] = 'User login Failed.';
        }
        
        Log::info('Login completed', ['response' => $response]);
        return response()->json($response);
    }

    public function forgotPassword(Request $request)
    {
        Log::info('Forgot password started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => ''
        ];
        try {
            $request->validate(['email' => 'required|string|email']);
            $status = $this->authService->sendResetLink($request->only('email'));

            $response['success'] = true;
            $response['message'] = __($status);
            Log::info($response['message'], ['response' => $response]);

        } catch (ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);            
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        } catch (\Exception $e) {
            Log::error('Forgetting password Failed:', ['error' => $e->getMessage()]);            
            $response['success'] = false;
            $response['message'] = 'Forgetting password Failed.';
        }
        
        Log::info('Forgot password started.', ['response' => $response]);
        return response()->json($response);
    }

    public function resetPassword(Request $request)
    {
        Log::info('Reset password started.', ['request' => request()->all()]);
        $response = [
            'success' => false,
            'data' => [],
            'message' => '',
            'status-code' => null
        ];
        try {
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);
        
            $status = $this->authService->resetPassword($request->only('token', 'email', 'password'));

            $response['success'] = true;
            $response['message'] = __($status);
            $response['status-code'] =  $status=== Password::PASSWORD_RESET ? 200 : 400;
            Log::info($response['message'], ['response' => $response]);

        } catch (ValidationException $e) {
            Log::error('Validation Error:', ['errors' => $e->errors()]);        
            $response['success'] = false;
            $response['message'] = $e->getMessage();
        } catch (\Exception $e) {
            Log::error('Reset Password Failed:', ['error' => $e->getMessage()]);        
            $response['success'] = false;
            $response['message'] = 'Reset Password Failed.';
        }
        
        Log::info('Reset password completed', ['response' => $response]);
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
            $request->user()->currentAccessToken()->delete();
            
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
