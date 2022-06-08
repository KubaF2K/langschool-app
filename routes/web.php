<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $top_course_id_stdclasses = DB::select('
                SELECT course_id FROM (
                    SELECT course_id, COUNT(user_id) c FROM course_participant GROUP BY course_id ORDER BY c
                ) x
        ');
    $top_course_ids = [];
    foreach ($top_course_id_stdclasses as $id_stdclass) {
        $top_course_ids[] = $id_stdclass->course_id;
    }
    $top_courses = Course::all()
        ->whereIn('id', $top_course_ids)
        ->take(4);
    $newest_courses = Course::select()
        ->orderByDesc('created_at')
        ->take(4)
        ->get();

    return view('index', ['top_courses' => $top_courses, 'newest_courses' => $newest_courses]);
})->name('index');

Route::controller(CourseController::class)->group(function() {
    Route::get('/courses', 'index')->name('courses.index');
    Route::post('/courses', 'enroll')->name('courses.enroll');
    Route::get('/courses/user', 'user')->name('courses.user');
    Route::get('/courses/add', 'add')->name('courses.add');
    Route::post('/courses/add', 'create')->name('courses.create');
    Route::get('/courses/{id}', 'view')->name('courses.view');
    Route::get('/courses/{id}/edit', 'edit')->name('courses.edit');
    Route::post('/courses/{id}/edit', 'update')->name('courses.update');
    Route::get('/courses/{id}/delete', 'delete')->name('courses.delete');
    Route::post('/courses/accept', 'acceptParticipant')->name('courses.accept');
    Route::post('/courses/decline', 'declineParticipant')->name('courses.decline');
    Route::post('/courses/remove-user', 'removeParticipant')->name('courses.remove-user');
});

Route::controller(UserController::class)->group(function () {
    Route::post('/user/delete', 'delete')->name('user.delete');
    Route::get('/user', 'index')->name('user.index');
    Route::get('/user/edit', 'edit')->name('user.edit');
    Route::post('/user/edit', 'update')->name('user.update');
    Route::get('/user/reset-password', 'resetPassword')->name('user.reset-password');
    Route::get('/user/teacher-panel', 'teacherPanel')->name('user.teacher-panel');
    Route::get('/user/admin-panel', 'adminPanel')->name('user.admin-panel');
});

require __DIR__.'/auth.php';
