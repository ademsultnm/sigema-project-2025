<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user_role = Auth::user()->role;
        return view('backend.dashboard')->with(compact('user_role'));
    }

}
