<?php

namespace NickyWoolf\Launch\Http\Controllers;

use Facades\NickyWoolf\Launch\AccessToken;
use Facades\NickyWoolf\Launch\Shop;
use Illuminate\Support\Facades\Auth;

class RegisteredShopsController extends Controller
{
    public function store()
    {
        $token = AccessToken::request(request('code'));
        $shop = Shop::get($token['access_token']);

        Auth::login(config('auth.providers.users.model')::createForShop($shop, $token));

        return redirect(route('launch.dashboard'));
    }
}