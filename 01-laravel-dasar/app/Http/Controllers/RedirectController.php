<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirectTo(): string
    {
        return "Redirect To";
    }

    public function redirectFrom(): RedirectResponse
    {
        return redirect('/redirect/to');
    }

    public function redirectHello(string $name): string
    {
        return "Hello $name";
    }

    public function redirectName(Request $request): RedirectResponse
    {
        if ($request->cookie('User-id'))
            return to_route('redirect-hello', ['name' => $request->cookie('User-id')]);

        return to_route('redirect-hello', ['name' => 'Ivan']);
    }

    public function redirectAction(): RedirectResponse
    {
        return redirect()->action([RedirectController::class, 'redirectHello'], ['name' => 'Ivan']);
    }

    public function redirectAway(): RedirectResponse
    {
        return redirect()->away('https://programmerzamannow.com');
    }
}
