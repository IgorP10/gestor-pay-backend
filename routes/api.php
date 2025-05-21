<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RecurringChargeController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'me']);
    Route::apiResource('organizations', OrganizationController::class);
    Route::post('/organizations/{id}/share', [OrganizationController::class, 'share']);
    Route::apiResource('charges', ChargeController::class);
    Route::get('/dashboard/summary', [DashboardController::class, 'summary']);
    Route::apiResource('recurring-charges', RecurringChargeController::class);
});
