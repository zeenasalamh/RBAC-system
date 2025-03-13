<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
// Route::middleware(['auth:sanctum', 'permission:roles.view'])->get('/protected-roles', function () {
//     return response()->json(['message' => 'You have permission to view roles']);
// });

// Route::post('/login', function (Request $request) {
//     $credentials = $request->validate([
//         'email'    => 'required|email',
//         'password' => 'required',
//     ]);

//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();
//         $user = User::with('roles.permissions')->find($user->id);

//         $token = $user->createToken('auth_token')->plainTextToken;
//         return response()->json(['token' => $token]);
//     }

//     return response()->json(['error' => 'Invalid credentials'], 401);
// });
