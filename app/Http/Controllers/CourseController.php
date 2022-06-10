<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\CourseDeleteRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Http\Requests\EnrollCourseRequest;
use App\Http\Requests\ParticipantAcceptRequest;
use App\Http\Requests\ParticipantDeclineRequest;
use App\Http\Requests\ParticipantRemoveRequest;
use App\Mail\ApplicationAccepted;
use App\Mail\ApplicationDeclined;
use App\Mail\RemovedFromCourse;
use App\Models\Course;
use App\Models\Language;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mail;

class CourseController extends Controller
{
    /*
     * Returns the courses view, grouped by language
     */
    public function index() {
        return view('courses.index', ['languages' => Language::with('courses')->get()]);
    }

    /*
     * Signs a user up to a course
     */
    public function enroll(EnrollCourseRequest $request) {
        if (!Auth::check())
            return redirect()->route('login');
        $user = User::findOrFail($request->input('user_id'));
        $course = Course::findOrFail($request->input('course_id'));
        $user->courses()->attach($course, [
            'cost' => $course->price-($course->price / 10 * min(3, $user->courseHistory()->count()))
        ]);

        return redirect()->route('courses.user')->with('msg', 'Zapisano pomyślnie!');
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
    public function update(CourseUpdateRequest $request) {
        $attrs = $request->except('id');
        $id = $request->input('id');
        $course = Course::findOrFail($id);
        $course->update($attrs);
        return redirect()->route('courses.index')->with(['msg' => 'Zedytowano kurs!']);
    }

    /*
     * Deletes the course with the given id
     */
    public function delete(CourseDeleteRequest $request) {
        $course = Course::findOrFail($request->input('id'));
        $course->delete();
        return redirect()->back()->with(['msg' => 'Usunięto kurs!']);
    }

    /*
     * Accept a user's course sign up request
     */
    public function acceptParticipant(ParticipantAcceptRequest $request) {
        $data = $request->all();
        $user = User::findOrFail($data['user_id']);
        $user->courseHistory()->attach($data['course_id']);
        $course = Course::findOrFail($data['course_id']);
        $course->participants()->attach($data['user_id']);
        $course->users()->detach($data['user_id']);
        Mail::to($user)->send(new ApplicationAccepted($course, Auth::user()));
        return redirect()->back()->with(['msg' => 'Zaakceptowano kursanta!']);
    }

    /*
     * Decline a user's course sign up request
     */
    public function declineParticipant(ParticipantDeclineRequest $request) {
        $data = $request->all();
        $course = Course::findOrFail($data['course_id']);
        $date = $course->users()->find($data['user_id'])->pivot->created_at;
        $course->users()->detach($data['user_id']);
        if (Auth::id() != $data['user_id'])
            Mail::to(User::find($data['user_id']))->send(new ApplicationDeclined($course, $date, Auth::user()));
        return redirect()->back()->with(['msg' => 'Usunięto aplikację!']);
    }

    /*
     * Remove a participant from a course
     */
    public function removeParticipant(ParticipantRemoveRequest $request) {
        $data = $request->all();
        $course = Course::findOrFail($data['course_id']);
        $course->participants()->detach($data['user_id']);
        if (Auth::id() != $data['user_id'])
            Mail::to(User::find($data['user_id']))->send(new RemovedFromCourse($course, Auth::user()));
        return redirect()->back()->with(['msg' => 'Wypisano z kursu!']);
    }
}
