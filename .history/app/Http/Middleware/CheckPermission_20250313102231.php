<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission, $recordIdParam = null)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        // Eager load roles and their permissions
        $user->load('roles.permissions');
        
        $recordId = $recordIdParam ? $request->route($recordIdParam) : null;
        
        if (!$user->hasPermission($permission, $recordId)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        
        return $next($request);
    }
}