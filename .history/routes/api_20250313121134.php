<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\PermissionController;



Route::middleware(['api'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});
Route::apiResource('roles', RoleController::class);
Route::apiResource('permissions', PermissionController::class);