<?php
namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle($request, Closure $next, $permission, $recordIdParam = null)
    {
/*************  ✨ Codeium Command 🌟  *************/
        $user = \Illuminate\Support\Facades\Auth::user();
        $user = auth()->user();

/******  53d3ae8f-ce26-49ce-944d-67c7120b45e2  *******/
        if (! $user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $recordId = $recordIdParam ? $request->route($recordIdParam) : null;

        if (! $user->hasPermission($permission, $recordId)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
