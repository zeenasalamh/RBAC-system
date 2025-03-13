<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;



Route::middleware(['api'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});