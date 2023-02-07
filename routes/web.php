<?php

use App\Http\Controllers\ClassesController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::resource('/plan', PlanController::class);

Route::get('/student/zipcode/{zipcode}', [StudentController::class, 'zipcodeData']);
Route::get('/student/{id}/image', [StudentController::class, 'profile'])->name('student.profile');
Route::post('/student/{id}/image', [StudentController::class, 'profile'])->name('student.profile.store');
Route::resource('/student', StudentController::class);

// Route::resource('/student/{id}/registration', RegistrationController::class);
Route::resource('/student/{id}/class', ClassesController::class);

Route::get('/registration/_seeder', [RegistrationController::class, '__seederRegistrations']);
Route::get('/registration/{registration}/class', [RegistrationController::class, 'addClass'])->name('registration.class');
Route::post('/registration/class', [RegistrationController::class, 'setClass'])->name('registration.class.add');
Route::resource('/registration', RegistrationController::class);

Route::get('/class/{id}/presence', [ClassesController::class, 'presence'])->name('class.presence');
Route::get('/class/{id}/replacement', [ClassesController::class, 'replacement'])->name('class.replacement');
Route::get('/class/{id}/absense/{type}', [ClassesController::class, 'absense'])->name('class.absense');
Route::post('/class/{id}/replacement/store', [ClassesController::class, 'storeReplacement'])->name('class.replace.store');
Route::resource('/class', ClassesController::class);

// Route::resource('/registration', RegistrationController::class);

Route::get('/instructor/list', [InstructorController::class, 'list']);
Route::get('/instructor/zipcode/{zipcode}', [InstructorController::class, 'zipcodeData']);
Route::get('/instructor/{id}/image', [InstructorController::class, 'profile'])->name('instructor.profile');
Route::post('/instructor/{id}/image', [InstructorController::class, 'profile'])->name('instructor.profile.store');
Route::resource('/instructor', InstructorController::class);

require __DIR__.'/auth.php';
