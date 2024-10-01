<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyjobController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/jobs', [MyjobController::class, 'store']);
Route::get('/jobs', [MyjobController::class, 'index']);
Route::get('/jobs/{id}', [MyjobController::class, 'show']);
Route::put('/jobs/{id}', [MyjobController::class, 'update']); // Update job
Route::delete('/jobs/{id}', [MyjobController::class, 'destroy']); // Delete job

Route::get('/roles', [SignupController::class, 'roles']);
Route::post('/signup', [SignupController::class, 'store']);
// routes/api.php
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);


