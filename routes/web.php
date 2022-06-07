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
    // TODO test
    $top_course_id_stdclasses = DB::select('
                SELECT course_id FROM (
                    SELECT course_id, COUNT(user_id) c FROM course_user GROUP BY course_id ORDER BY c
                ) x
        ');
    $top_course_ids = [];
    foreach ($top_course_id_stdclasses as $id_stdclass) {
        $top_course_ids[] = $id_stdclass->course_id;
    }
    $top_courses = Course::all()
        ->whereIn('id', $top_course_ids)
        ->take(4);

    return view('index', ['top_courses' => $top_courses]);
})->name('index');

Route::controller(CourseController::class)->group(function() {
    Route::get('/courses', 'index')->name('courses.index');
    Route::post('/courses', 'enroll')->name('courses.enroll');
    Route::get('/courses/user', 'user')->name('courses.user');
    Route::get('/courses/add', 'add')->name('courses.add');
    Route::post('/courses/add', 'create')->name('courses.create');
    Route::get('/courses/{id}/edit', 'edit')->name('courses.edit');
    Route::post('/courses/{id}/edit', 'update')->name('courses.update');
    Route::get('/courses/{id}/delete', 'delete')->name('courses.delete');
});

Route::controller(UserController::class)->group(function () {
    Route::get('/user', 'index')->name('user.index');
    Route::get('/user/edit', 'edit')->name('user.edit');
    Route::post('/user/edit', 'update')->name('user.update');
    Route::get('/user/reset-password', 'resetPassword')->name('user.reset-password');
});

require __DIR__.'/auth.php';
