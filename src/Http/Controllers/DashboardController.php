<?php

namespace NickyWoolf\Thrust\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('thrust::embedded.dashboard');
    }
}