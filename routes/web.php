<?php

use App\Http\Controllers\AccountPayableController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\EvolutionController;
use App\Http\Controllers\ExerciceController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RegistrationClassController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserProfileController;
use App\Models\RegistrationClass;
use App\Models\User;
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



Route::group(['middleware' => 'auth'], function () {

    Route::get('/profileimage/{id}', function ($id) {
        return imageProfile(User::find($id)->image);
    })->name('profile.image');

    Route::post('/user/image/{id}/store', [UserProfileController::class, 'store'])->name('user.image.store');

    Route::resource('/plan', PlanController::class);

    Route::resource('/exercice', ExerciceController::class);

    Route::get('/account/payable/{id}/receive', [AccountPayableController::class, 'receive'])->name('payable.receive');
    Route::resource('/account/payable', AccountPayableController::class);

    Route::get('/student/zipcode/{zipcode}', [StudentController::class, 'zipcodeData']);
    Route::resource('/student', StudentController::class);


    Route::resource('/student/{id}/class', ClassesController::class);

    Route::get('/registration/_seeder', [RegistrationController::class, '__seederRegistrations']);
    Route::resource('/registration', RegistrationController::class);
    Route::resource('/registration/{id}/class', RegistrationClassController::class)->names('registration.class');


    Route::resource('/class', ClassesController::class);

    Route::get('/calendar/{id}/presence', [CalendarController::class, 'presence'])->name('calendar.presence');
    Route::post('/calendar/{id}/presence', [CalendarController::class, 'storePresence'])->name('calendar.presence.store');
    Route::get('/calendar/{id}/replacement', [CalendarController::class, 'replacement'])->name('calendar.replacement');
    Route::get('/calendar/{id}/absense', [CalendarController::class, 'absense'])->name('calendar.absense');
    Route::post('/calendar/{id}/replacement/store', [CalendarController::class, 'storeReplacement'])->name('calendar.replace.store');
    Route::post('/calendar/exercice/add', [CalendarController::class, 'addExerciceOnClass'])->name('calendar.exercice.add');
    Route::resource('/calendar', CalendarController::class);

    Route::resource('/evolution', EvolutionController::class);

    Route::get('/instructor/list', [InstructorController::class, 'list']);
    Route::get('/instructor/zipcode/{zipcode}', [InstructorController::class, 'zipcodeData']);
    Route::resource('/instructor', InstructorController::class);


});
require __DIR__.'/auth.php';
