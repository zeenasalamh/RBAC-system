<?PHP

// routes/api.php


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\AuditController;
use App\Http\Controllers\API\UserRoleController;
use App\Http\Controllers\API\PermissionController;


Route::get('/test', function() {
    return ['message' => 'API is working'];
});