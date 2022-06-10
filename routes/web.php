<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LanguageController;
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

Route::get('/', function() {
    return view('index', [
        'top_courses' => Course::withCount('participants')
            ->orderByDesc('participants_count')
            ->take(4)
            ->get(),
        'newest_courses' => Course::orderByDesc('created_at')
            ->take(4)
            ->get()
    ]);
})->name('index');

Route::controller(CourseController::class)->group(function() {
    Route::get('/courses', 'index')->name('courses.index');
    Route::post('/courses', 'enroll')->name('courses.enroll');
    Route::get('/courses/user', 'user')->name('courses.user');
    Route::get('/courses/add', 'add')->name('courses.add');
    Route::post('/courses/add', 'create')->name('courses.create');
    Route::get('/courses/{id}', 'view')->name('courses.view');
    Route::get('/courses/{id}/edit', 'edit')->name('courses.edit');
    Route::post('/courses/edit', 'update')->name('courses.update');
    Route::post('/courses/delete', 'delete')->name('courses.delete');
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

Route::controller(LanguageController::class)->group(function () {
    Route::get('/language', 'index')->name('language.index');
    Route::get('/language/add', 'add')->name('language.add');
    Route::post('/language/add', 'create')->name('language.create');
    Route::get('/language/{id}/edit', 'edit')->name('language.edit');
    Route::post('/language/edit', 'update')->name('language.update');
    Route::post('/language/delete', 'delete')->name('language.delete');
});

require __DIR__.'/auth.php';
