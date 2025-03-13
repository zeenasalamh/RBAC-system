<?php
use App\Http\Controllers\API\AuditController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserRoleController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::apiResource('roles', RoleController::class);

Route::get('/debug-routes', function () {
    return Route::getRoutes()->getRoutesByMethod();
});

// Public routes
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user  = User::with('roles.permissions')->find(Auth::id());
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token]);
    }
    return response()->json(['error' => 'Invalid credentials'], 401);
})->name('login');

// Protected routes
// Route::middleware(['auth:sanctum'])->group(function () {


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
// });
