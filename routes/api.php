<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->get('/globals',[AuthController::class,'globals']);

//Job
Route::get('/jobs',[JobController::class,'list']);
Route::middleware('auth:sanctum','role:employer')->group(function(){
    Route::post('/employer/jobs',[JobController::class,'create']);
    Route::get('/employer/jobs',[JobController::class,'employerView']);
});
Route::middleware('auth:sanctum','role:admin')->group(function(){
    Route::patch('/admin/jobs/{id}',[JobController::class,'update']);
});
