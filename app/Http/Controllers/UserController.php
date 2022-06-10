<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserDeleteRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Course;
use App\Models\Language;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /*
     * Deletes a user
     */
    public function delete(UserDeleteRequest $request) {
        User::findOrFail($request->input('id'))->delete();
        return redirect()->back()->with(['msg' => 'Usunięto użytkownika!']);
    }

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
        $new_data = $request->all();
        $user = User::findOrFail($new_data['id']);
        if (Auth::id() == $new_data['id'])
            Auth::guard('web')->logout();
        $user->update($request->all());
        if (!Auth::check())
            return redirect()->route('login');
        return redirect()->back()->with(['msg' => 'Zaktualizowano użytkownika!']);
    }

    /*
     * Logs the user out and redirects to the Breeze password reset page with the email filled.
     */
    public function resetPassword() {
        $email = Auth::user()->email;
        Auth::guard('web')->logout();
        return redirect()->route('password.request')->withInput(['email' => $email]);
    }

    /*
     * Displays the teacher's courses and course applications
     */
    public function teacherPanel() {
        if (!Auth::check())
            abort(401);
        if (Auth::user()->role->name != 'teacher')
            abort(403);
        return view('user.teacher-panel', ['courses' => Auth::user()->taughtCourses]);
    }

    /*
     * Displays the admin panel, for managing users and courses
     */
    public function adminPanel() {
        if(!Auth::check())
            abort(401);
        if (Auth::user()->role->name != 'admin')
            abort(403);
        return view('user.admin-panel', [
            'users' => User::all(),
            'roles' => Role::all(),
            'languages' => Language::all()
        ]);
    }
}
