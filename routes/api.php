<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TasksController;
use App\Http\Controllers\TasksExtraController;
use App\Http\Controllers\TaskNotesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware([ 'auth', 'verified' ])->group(function () {
    Route::apiResources([
        'tasks'      => TasksController::class,
        'tasksExtra' => TasksExtraController::class,
        'taskNotes'  => TaskNotesController::class,
    ]);
});
