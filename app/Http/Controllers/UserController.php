<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
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

    /*
     * Logs out user and updates user data.
     */
    public function update(UserUpdateRequest $request) {
        $user = User::findOrFail(Auth::user()->id);
        Auth::guard('web')->logout();
        $user->update($request->all());

        return redirect()->route('login');
    }

    /*
     * Logs the user out and redirects to the Breeze password reset page with the email filled.
     */
    public function resetPassword() {
        $email = Auth::user()->email;
        Auth::guard('web')->logout();
        return redirect()->route('password.request')->withInput(['email' => $email]);
    }
}
