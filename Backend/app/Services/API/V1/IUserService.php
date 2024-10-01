<?php

namespace App\Services\API\V1;

use App\Models\User;
use Illuminate\Http\Request;

interface IUserService
{
    public function getUserInfo();
    public function editUserInfo($name, $email);
    public function changePassword($current_password, $new_password);
    public function logout();
}
