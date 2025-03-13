<?PHP

// routes/api.php

use Log;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\AuditController;
use App\Http\Controllers\API\UserRoleController;
use App\Http\Controllers\API\PermissionController;

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

});

// Protected route example
Route::middleware(['auth:sanctum', 'permission:roles.view'])->get('/protected-roles', function () {
    return response()->json(['message' => 'You have permission to view roles']);
});

 

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    try {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // Debug info
            Log::info('User found: ' . $user->id);
            Log::info('User class: ' . get_class($user));
            
            try {
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json(['token' => $token]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => 'Token creation failed',
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ], 500);
            }
        }
        
        return response()->json(['error' => 'Invalid credentials'], 401);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Login process failed',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});
