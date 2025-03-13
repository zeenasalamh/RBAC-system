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


Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user  = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    return response()->json(['error' => 'Invalid credentials'], 401);
});