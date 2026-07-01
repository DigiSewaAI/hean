<?php

use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\Route;

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

// Location endpoints
Route::get('/provinces', [LocationController::class, 'provinces']);
Route::get('/districts/{provinceId}', [LocationController::class, 'districts']);
Route::get('/municipalities/{districtId}', [LocationController::class, 'municipalities']);

