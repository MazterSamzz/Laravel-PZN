<?php

namespace App\Services\Impl;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserServiceImpl implements UserService
{
    // Old Username => Password
    // private array $users = [
    //     'Ivan' => 'rahasia'
    // ];

    function login(string $email, string $password): bool
    {
        // Old Login Function
        // if (!isset($this->users[$user])) {
        //     return false;
        // }

        // $correctPassword = $this->users[$user];
        // return $password == $correctPassword;
        return Auth::attempt(['email' => $email, 'password' => $password]);
    }
}
