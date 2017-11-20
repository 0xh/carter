<?php

namespace NickyWoolf\Carter\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('carter::embedded.dashboard');
    }
}