<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(Request $request): Response
    {
        return response('hello response');
    }

    public function header(Request $request): Response
    {
        $body = [
            'first' => 'Ivan',
            'laste' => 'Kristyanto'
        ];

        return response($body, 200)
            ->header('Content-Type', 'application/json')
            ->withHeaders([
                'Author' => 'Programmer Zaman Now',
                'App' => 'Belajar Laravel'
            ]);
    }

    public function responseView(Request $request): Response
    {
        return response()->view('hello', ['name' => 'Ivan']);
    }

    public function responseJson(Request $request): JsonResponse
    {
        $body = [
            'firstName' => 'Ivan',
            'lastName' => 'Kristyanto'
        ];

        return response()->json($body);
    }

    public function responseFile(Request $request): BinaryFileResponse
    {
        return response()->file(storage_path('app/public/pictures/Samuel.jpg'));
    }

    public function responseDownload(Request $request): BinaryFileResponse
    {
        return response()->download(storage_path('app/public/pictures/Samuel.jpg'));
    }
}
