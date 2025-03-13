<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user  = Auth::user();
            $user  = User::with('roles.permissions')->find($user->id);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
