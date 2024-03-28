<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\DashboardController;


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('test', [AuthController::class, 'test']);
});

Route::get('/contacts', [ContactsController::class, 'index']);
Route::post('/contacts', [ContactsController::class, 'store']);
Route::get('/contacts/{id}', [ContactsController::class, 'show']);
Route::put('/contacts/{id}', [ContactsController::class, 'update']);
Route::delete('/contacts/{id}', [ContactsController::class, 'destroy']);


Route::get('/teams', [TeamController::class, 'index']);
Route::post('/teams', [TeamController::class, 'store']);
Route::get('/teams/{id}', [TeamController::class, 'show']);
Route::put('/teams/{id}', [TeamController::class, 'update']);
Route::delete('/teams/{id}', [TeamController::class, 'destroy']);
Route::get('/team/members', [TeamController::class, 'teamMembers']);


Route::get('/tasks', [TasksController::class, 'index']);
Route::post('/tasks', [TasksController::class, 'store']);
Route::get('/tasks/{id}', [TasksController::class, 'show']);
Route::put('/tasks/{id}', [TasksController::class, 'update']);
Route::delete('/tasks/{id}', [TasksController::class, 'destroy']);

Route::get('/leads', [LeadsController::class, 'index']);
Route::post('/leads', [LeadsController::class, 'store']);
Route::get('/leads/{id}', [LeadsController::class, 'show']);
Route::put('/leads/{id}', [LeadsController::class, 'update']);
Route::delete('/leads/{id}', [LeadsController::class, 'destroy']);

Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);
