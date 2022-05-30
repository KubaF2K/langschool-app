<?php

use App\Http\Controllers\CourseController;
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
    $top_courses = DB::select('
            SELECT * FROM COURSES WHERE id IN (
                SELECT course_id FROM (
                    SELECT course_id, COUNT(user_id) c FROM course_user GROUP BY course_id ORDER BY c
                ) x
            ) LIMIT 3;
        ');

    return view('index', ['top_courses' => $top_courses]);
})->name('index');

Route::controller(CourseController::class)->group(function() {
    Route::get('/courses', 'index')->name('courses.index');
});

require __DIR__.'/auth.php';
