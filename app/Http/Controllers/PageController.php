<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function viewLoginPage()
    {
        return view('pages.login');
    }

    public function viewDashboardPage()
    {
        return view('pages.dashboard');
    }

    public function viewCreateUser()
    {
        if (Auth::user()->role == 1) {
            return view('pages.create-user');
        }
        return redirect()->route("dashboard");
    }
}
