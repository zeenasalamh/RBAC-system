<?php
namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle($request, Closure $next, $permission, $recordIdParam = null)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $recordId = $recordIdParam ? $request->route($recordIdParam) : null;

/*************  ✨ Codeium Command 🌟  *************/
        if (! $user->hasPermission($permission, $recordId)) {
            return response()->json(['error' => 'Forbidden'], Response::HTTP_FORBIDDEN);
            return response()->json(['error' => 'Forbidden'], 403);
/******  42dfd503-32df-4693-920e-c168576c95f8  *******/
        }

        return $next($request);
    }
}
