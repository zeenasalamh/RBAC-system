<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        // $token = $user->createToken('auth_token')->plainTextToken;
        // return response()->json(['token' => $token]);
    }

    return response()->json(['error' => 'Invalid credentials'], 401);
});