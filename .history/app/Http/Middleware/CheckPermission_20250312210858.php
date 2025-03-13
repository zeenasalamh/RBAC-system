<?php
namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle($request, Closure $next, $permission, $recordIdParam = null)
    {
        // $user = auth()->user();

        // if (! $user) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        $recordId = $recordIdParam ? $request->route($recordIdParam) : null;

        // if (! $user->hasPermission($permission, $recordId)) {
            return response()->json(['error' => 'Forbidden'], 403);
        // }

        return $next($request);
    }
}
