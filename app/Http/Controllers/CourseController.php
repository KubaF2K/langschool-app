<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollCourseRequest;
use App\Models\Course;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /*
     * Returns the courses view, grouped by language
     */
    public function index() {
        return view('courses.index', ['languages' => Language::all()]);
    }

    /*
     * Signs a user up to a course
     */
    public function enroll(EnrollCourseRequest $request) {
        if (!Auth::check())
            return redirect()->route('login');
        if (Auth::user()->courses->where('id', '=', $request->input('course_id'))->isNotEmpty())
            return redirect()->back()->with('err', 'Jesteś już zapisany na ten kurs!');
        Auth::user()->courses()->attach(Course::find($request->input('course_id')));

        //TODO redirect to your courses
        return redirect()->back()->with('msg', 'Zapisano pomyślnie!');
    }
}
