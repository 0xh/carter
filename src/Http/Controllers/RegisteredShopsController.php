<?php

namespace NickyWoolf\Thrust\Http\Controllers;

use Facades\NickyWoolf\Thrust\AccessToken;
use Facades\NickyWoolf\Thrust\Shop;
use Illuminate\Support\Facades\Auth;

class RegisteredShopsController extends Controller
{
    public function store()
    {
        $token = AccessToken::request(request('code'));
        $shop = Shop::get($token['access_token']);

        Auth::login(config('auth.providers.users.model')::createForShop($shop, $token));

        return redirect(route('thrust.dashboard'));
    }
}