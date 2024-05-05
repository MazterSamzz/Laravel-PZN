<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputController extends Controller
{
    //

    public function hello(Request $request): string
    {
        // $request->name
        // Pertama akan mencari "Object Request dengan property name" ($request->name)
        // Jika tidak ditemukan "Object Request dengan property name" maka akan mencari input dengan property name ($request->input('name'))
        
        // $name = $request->input('name');
        $name = $request->name;
        return "Hello $name";
    }
    
    public function helloFirstName(Request $request)
    {
        $firstName = $request->input('name.first');
        return "Hello $firstName";
    }
    
    public function helloInput(Request $request)
    {
        $input = $request->input();
        return json_encode($input);
    }

    public function helloArray(Request $request): string
    {
        $names = $request->input('products.*.name');
        return  json_encode($names);
    }
}