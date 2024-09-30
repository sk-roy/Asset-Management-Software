<?php

namespace App\Services\API\V1;

use App\Models\User;
use Illuminate\Http\Request;

interface IAuthService
{

    public function register(array $data);
    public function login(array $credentials);
    public function sendResetLink(array $data);
    public function resetPassword(array $data);
    public function getToken(User $user);
    public function logout(Request $request);
}
