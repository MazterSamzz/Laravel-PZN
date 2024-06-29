<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $response = Auth::attempt([
            'email' => $request->get("email", "wrong"),
            'password' => $request->get("password", "wrong")
        ]);

        if ($response) {
            Session::regenerate();
            return redirect("/users/current");
        } else {
            return "Wrong Credentials";
        }
    }

    public function current()
    {
        $user = Auth::user();

        if ($user) {
            return "Hello $user->name";
        } else {
            return "Hello Guest";
        }
    }
}