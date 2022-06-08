<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Http\Requests\EnrollCourseRequest;
use App\Http\Requests\ParticipantAcceptRequest;
use App\Http\Requests\ParticipantDeclineRequest;
use App\Http\Requests\ParticipantRemoveRequest;
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
        $course = Course::find($request->input('course_id'));
        Auth::user()->courses()->attach($course, ['cost' => $course->price-($course->price / 10 * min(3, Auth::user()->attendedCourses()->count()))]);

        //TODO redirect to your courses
        return redirect()->back()->with('msg', 'Zapisano pomyślnie!');
    }

    /*
     * Returns a view with the user's courses
     */
    public function user() {
        if (Auth::check())
            return view('courses.user', ['courses' => Auth::user()->courses, 'attended_courses' => Auth::user()->attendedCourses]);
        return redirect()->route('login');
    }

    /*
     * Returns a view with a course's details
     */
    public function view(int $id) {
        return view('courses.view', ['course' => Course::findOrFail($id)]);
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

    /*
     * Return a view to edit a course
     */
    public function edit(int $id) {
        $course = Course::findOrFail($id);
        if (!Auth::check())
            abort(401);
        if (Auth::user()->cannot('update', $course))
            abort(403);
        return view('courses.edit', ['course' => $course, 'teachers' => User::where('role_id', '=', Role::where('name', '=', 'teacher')->first()->id)->get()]);
    }

    /*
     * Update a course
     */
    public function update(CourseUpdateRequest $request, int $id) {
        $attrs = $request->all();
        $course = Course::findOrFail($id);
        if (User::find($attrs['teacher_id'])->role->name != 'teacher')
            return redirect()->back()->withInput()->withErrors(['teacher_id' => 'Podany użytkownik nie jest nauczycielem!']);
        if (User::find($attrs['teacher_id'])->language_id != $course->language_id)
            return redirect()->back()->withInput()->withErrors(['teacher_id' => 'Podany nauczyciel nie uczy podanego języka!']);
        if (Course::where('name', '=', $attrs['name'])->get()->except($id)->count() > 0)
            return redirect()->back()->withInput()->withErrors(['name' => 'Podana nazwa jest już zajęta!']);

        $course->update($attrs);
        return redirect()->route('courses.index')->with(['msg' => 'Zedytowano kurs!']);
    }

    /*
     * Deletes the course with the given id
     */
    public function delete(int $id) {
        if (!Auth::check())
            abort(401);
        $course = Course::findOrFail($id);
        if (Auth::user()->cannot('delete', $course))
            abort(403);
        $course->delete();
        return redirect()->route('courses.index')->with(['msg' => 'Usunięto kurs!']);
    }

    /*
     * Accept a user's course sign up request
     */
    public function acceptParticipant(ParticipantAcceptRequest $request) {
        $data = $request->all();
        $course = Course::findOrFail($data['course_id']);
        $course->participants()->attach($data['user_id']);
        $course->users()->detach($data['user_id']);
        return redirect()->back()->with(['msg' => 'Zaakceptowano kursanta!']);
    }

    /*
     * Decline a user's course sign up request
     */
    public function declineParticipant(ParticipantDeclineRequest $request) {
        $data = $request->all();
        if ($data['user_id'] != Auth::id() && Auth::user()->role->name != 'teacher')
            abort(403);
        Course::findOrFail($data['course_id'])->users()->detach($data['user_id']);
        return redirect()->back()->with(['msg' => 'Usunięto aplikację!']);
    }

    /*
     * Remove a participant from a course
     */
    public function removeParticipant(ParticipantRemoveRequest $request) {
        $data = $request->all();
        if ($data['user_id'] != Auth::id() && Auth::user()->role->name != 'teacher')
            abort(403);
        Course::findOrFail($data['course_id'])->participants()->detach($data['user_id']);
        return redirect()->back()->with(['msg' => 'Wypisano z kursu!']);
    }
}
