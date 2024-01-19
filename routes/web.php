<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\CalendarController;


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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::resource("tasks", TaskController::class);
Route::post('/tasks/update/{task}', [TaskController::class, 'update'])->name('tasks.update');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
Route::get('/routines', [RoutineController::class, 'index'])->name('routines');

Route::get('/calendar', [TaskController::class, 'indexCalendarPage'])->name('calendar');

// Route::get('/calendar', function(){
//     return Inertia::render('Custom/CalendarPage');
// })->name('calendar');


