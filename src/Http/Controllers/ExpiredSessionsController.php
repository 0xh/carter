<?php

namespace NickyWoolf\Thrust\Http\Controllers;

class ExpiredSessionsController extends Controller
{
    public function index()
    {
        return view('thrust::embedded.expired-session');
    }
}