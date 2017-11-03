<?php

namespace NickyWoolf\Thrust\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthenticatedShopsController extends Controller
{
    public function store()
    {
        $user = config('auth.providers.users.model')::shopOwner(request('shop'))->first();

        Auth::login($user);

        return redirect(route('thrust.dashboard'));
    }
}