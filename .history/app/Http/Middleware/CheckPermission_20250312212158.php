<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission, $recordIdParam = null)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $recordId = $recordIdParam ? $request->route($recordIdParam) : null;
        
        if (!$user->hasPermission($permission, $recordId)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        
        return $next($request);
    }
}
