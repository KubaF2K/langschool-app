<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /*
     * Shows user information.
     */
    public function index() {
        if (Auth::check())
            return view('user.index');
        return redirect()->route('login');
    }

    /*
     * Return user details form.
     */
    public function edit() {
        if (Auth::check())
            return view('user.edit');
        return redirect()->route('login');
    }
}
