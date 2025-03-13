<?php

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\API\AuthController;
// use App\Http\Controllers\API\RoleController;
// use App\Http\Controllers\API\PermissionController;



// Route::middleware(['api'])->group(function () {
//     Route::post('/login', [AuthController::class, 'login']);
// });
// Route::apiResource('roles', RoleController::class);
// Route::apiResource('permissions', PermissionController::class);

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\AuditController;
use App\Http\Controllers\API\UserRoleController;
use App\Http\Controllers\API\PermissionController;

// Public routes
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = User::with('roles.permissions')->find(Auth::id());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token]);
    }
    return response()->json(['error' => 'Invalid credentials'], 401);
});

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Roles
    Route::apiResource('roles', RoleController::class);
    
    // Permissions
    Route::apiResource('permissions', PermissionController::class);
    
    // User Roles
    Route::get('users/{user}/roles', [UserRoleController::class, 'index']);
    Route::post('users/{user}/roles', [UserRoleController::class, 'store']);
    Route::delete('users/{user}/roles/{role}', [UserRoleController::class, 'destroy']);
    
    // Audit Logs
    Route::get('audit-logs', [AuditController::class, 'index']);
    Route::get('audit-logs/{auditLog}', [AuditController::class, 'show']);
    
    // Protected test route
    Route::middleware(['permission:roles.view'])->get('/protected-roles', function () {
        return response()->json(['message' => 'You have permission to view roles']);
    });
});
