<?php
use App\Http\Controllers\API\AuditController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserRoleController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user  = User::with('roles.permissions')->find(Auth::id());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user]);
    }
    return response()->json(['error' => 'Invalid credentials'], 401);
})->name('login');

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Roles
    Route::apiResource('roles', RoleController::class)->middleware(function ($request, $next) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    });

    // Permissions
    Route::apiResource('permissions', PermissionController::class)->middleware(function ($request, $next) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    });

    // User Roles
    Route::get('users/{user}/roles', [UserRoleController::class, 'index'])->middleware(function ($request, $next) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    });

    Route::post('users/{user}/roles', [UserRoleController::class, 'store'])->middleware(function ($request, $next) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    });

    Route::delete('users/{user}/roles/{role}', [UserRoleController::class, 'destroy'])->middleware(function ($request, $next) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    });

    // Audit Logs
    Route::get('audit-logs', [AuditController::class, 'index'])->middleware(function ($request, $next) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    });

    Route::get('audit-logs/{auditLog}', [AuditController::class, 'show'])->middleware(function ($request, $next) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    });

    // Protected test route with permission check
    Route::middleware(['permission:roles.view'])->get('/protected-roles', function () {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return response()->json(['message' => 'You have permission to view roles']);
    });
});
