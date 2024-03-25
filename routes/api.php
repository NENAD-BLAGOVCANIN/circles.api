<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactsController;

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

