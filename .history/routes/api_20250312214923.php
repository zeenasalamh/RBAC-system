<?PHP

// routes/api.php

use Illuminate\Routing\Route;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserRoleController;
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
