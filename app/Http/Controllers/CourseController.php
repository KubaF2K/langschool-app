<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\EnrollCourseRequest;
use App\Models\Course;
use App\Models\Language;
use App\Models\Role;
use App\Models\User;
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
            return redirect()->back()->withErrors(['course_id' => 'Jesteś już zapisany na ten kurs!']);
        Auth::user()->courses()->attach(Course::find($request->input('course_id')));

        //TODO redirect to your courses
        return redirect()->back()->with('msg', 'Zapisano pomyślnie!');
    }

    /*
     * Returns a view with the user's courses
     */
    public function user() {
        if (Auth::check())
            return view('courses.user', ['courses' => Auth::user()->courses]);
        return redirect()->route('login');
    }

    /*
     * Returns a view with the teacher's language's courses
     */
    public function teacher() {
        if (!Auth::check())
            return redirect()->route('login');
        if (Auth::user()->role->name == 'teacher')
            return view('courses.teacher', ['courses' => Auth::user()->language->courses]);
        else
            abort(403);
    }

    /*
     * Returns a form to create a new course
     */
    public function add() {
        if (!Auth::check())
            return redirect()->route('login');
        if (Auth::user()->can('create', Course::class))
            return view('courses.add', [
                'languages' => Language::all(),
                'teachers' => User::where('role_id', '=', Role::where('name', '=', 'teacher')->first()->id)->get()
            ]);
        else
            abort(403);
    }

    /*
     * Creates a new course
     */
    public function create(CourseCreateRequest $request) {
        $course = $request->all();
        if (!Auth::check())
            abort(401);
        if (Auth::user()->cannot('create', Course::class))
            abort(403);
        if (Auth::user()->role->name == 'teacher')
            if (Auth::user()->language_id != $course['language_id'])
                abort(403);
        if (User::find($course['teacher_id'])->role->name != 'teacher')
            return redirect()->back()->withInput()->withErrors(['teacher_id' => 'Podany użytkownik nie jest nauczycielem!']);
        if (User::find($course['teacher_id'])->language_id != $course['language_id'])
            return redirect()->back()->withInput()->withErrors(['teacher_id' => 'Podany nauczyciel nie uczy podanego języka!']);
        Course::create($course);
        return redirect()->route('courses.index')->with(['msg' => 'Utworzono kurs!']);
    }
}
