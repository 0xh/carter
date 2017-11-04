<?php

namespace NickyWoolf\Launch\Http\Controllers;

class ExpiredSessionsController extends Controller
{
    public function index()
    {
        return view('launch::embedded.expired-session');
    }
}