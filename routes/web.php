<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TasksController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::permanentRedirect('/', '/dashboard');

Route::get('/dashboard', [TasksController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tasks/all', [TasksController::class, 'all'])->middleware(['auth', 'verified'])->name('tasks.all');
