<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\TaskController;
use App\Http\Controllers\RoutineController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\SubobjectiveController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\PillarController;
use App\Http\Controllers\SubpillarController;





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
})->name('landingPage');

Route::prefix('app')->middleware(['auth:sanctum', 'verified'])->group(function () {
    // Tableau de bord après connexion
    Route::get('/app/homepage', function () {
        return Inertia::render('HomePage');
    })->name('home');

    // Les autres routes de l'application
    Route::resource("pillars", PillarController::class);
    Route::resource("subpillars", SubpillarController::class);
    Route::resource("objectives", ObjectiveController::class);
    Route::resource("subobjectives", SubobjectiveController::class);
    Route::resource("routines", RoutineController::class);
    Route::resource("tasks", TaskController::class);

    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/routines', [RoutineController::class, 'index'])->name('routines');
    Route::get('/goals', [PillarController::class, 'index'])->name('goals');
    Route::get('/calendar', [TaskController::class, 'indexCalendarPage'])->name('calendar');
});
