<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DayoffEmployeeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
//use Admin\UserController;


//use \App\Http\Controllers\Admin\UserController;

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
    return view('index');
});

//Admin routes
Route::prefix('admin')->middleware('auth','verified')->name('admin.')->group(function(){
    Route::resource('/users', UserController::class);
});

//Empl routes
Route::middleware('auth')->group(function(){
    Route::get('/empl/calendar', [EmployeeController::class, 'indexCalendar'])->name('empl-calendar');
    Route::get('/empl/schedule', ['App\Http\Controllers\EmployeeController', 'indexSchedule'])->name('empl-schedule');
    Route::get('empl/edit-all', ['App\Http\Controllers\EmployeeController', 'updateAll'])->name('empl-update-all');
    Route::resource('empl', EmployeeController::class);
});

//Group
Route::middleware('auth')->group(function(){
    Route::get('group/empl', [GroupController::class, 'empl'])->name('group-empl');
    Route::get('group/update-all', [GroupController::class, 'groupUpdateAllGet'])->name('group-update-all-get');
    Route::get('group/update-all/create', [GroupController::class, 'createAll'])->name('group-all-create');
    Route::post('group/update-all/', [GroupController::class, 'storeAll'])->name('group-all-store');
    Route::patch('group/update-all', [GroupController::class, 'groupUpdateAllPatch'])->name('group-update-all-patch');
    Route::resource('group', GroupController::class);
});

Route::middleware('auth')->group(function(){
    Route::get('/dayoff/empl', [DayoffEmployeeController::class, 'indexDayOff'])->name('dayoff-empl');
    Route::get('/dayoff/{year}/{month}', [DayoffEmployeeController::class, 'edit'])->name('dayoff-ym');
    Route::get('/dayoff/main', [DayoffEmployeeController::class, 'indexDayOffmain'])->name('dayoff-ym-main');
    Route::patch('/dayoff/{year}/{month}', [DayoffEmployeeController::class, 'update'])->name('dayoff-ym-patch');
    Route::resource('dayoff', DayoffEmployeeController::class);
});


Route::middleware('auth')->group(function(){
    Route::get('/schedule/', [ScheduleController::class, 'index'])->name('schedule-index');
    Route::get('/schedule/{year}/{month}', [ScheduleController::class, 'edit'])->name('schedule-ym');
    // Route::resource('schedule', ScheduleController::class);
});


