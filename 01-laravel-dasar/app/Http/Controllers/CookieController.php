<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CookieController extends Controller
{
    public function createCookie(Request $request): Response
    {
        var_dump('Old User-id: ' . $request->cookie('User-id'));
        var_dump('Old Is-Member: ' . $request->cookie('Is-Member'));
        return response("Hello Cookie \n $request->cookie('User-id')\n $request->cookie('Is-Member')")
            ->cookie('User-id', 'MazterSamzz', 0, '/')
            ->cookie('Is-Member', 'true', 0, '/');
    }

    public function getCookie(Request $request): JsonResponse
    {
        var_dump('Old User-id: ' . $request->cookie('User-id'));
        var_dump('Old Is-Member: ' . $request->cookie('Is-Member'));
        return response()->json([
            'User-id' => $request->cookie('User-id', 'guest'),
            'Is-Member' => $request->cookie('Is-Member', 'false')
        ]);
    }
    public function clearCookie(Request $request): Response
    {
        var_dump('Old User-id: ' . $request->cookie('User-id'));
        var_dump('Old Is-Member: ' . $request->cookie('Is-Member'));
        return response("Clear Cookie\n $request->cookie('User-id')\n $request->cookie('Is-Member')")
            ->withoutCookie('User-id')
            ->withoutCookie('Is-Member');
    }
}
