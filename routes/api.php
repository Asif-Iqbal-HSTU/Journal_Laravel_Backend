<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyjobController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaperController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/jobs', [MyjobController::class, 'store']);
Route::get('/jobs', [MyjobController::class, 'index']);
Route::get('/jobs/{id}', [MyjobController::class, 'show']);
Route::put('/jobs/{id}', [MyjobController::class, 'update']); // Update job
Route::delete('/jobs/{id}', [MyjobController::class, 'destroy']); // Delete job

Route::get('/roles', [SignupController::class, 'roles']);
Route::get('/classifications', [PaperController::class, 'classifications']);
Route::post('/signup', [SignupController::class, 'store']);
// routes/api.php
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);


Route::get('/currentUser', [LoginController::class, 'getCurrentUser']);



Route::post('/submitPaper', [PaperController::class, 'store']);

Route::post('/papers', [PaperController::class, 'store']);
Route::get('/papers', [PaperController::class, 'getAllPapers']);
// Route::get('/papers/{u_id}', [PaperController::class, 'getPapersOfCurrentUser']);

Route::get('/papers/{user_id}', [PaperController::class, 'getPapersOfUser']);

Route::get('/paper/{id}', [PaperController::class, 'getPaperById']);




