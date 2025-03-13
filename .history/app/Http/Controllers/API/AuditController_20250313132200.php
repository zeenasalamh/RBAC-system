<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="List all roles",
     *     tags={"Roles"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of roles",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Role"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user');
        if ($request->has('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        if ($request->has('entity_id')) {
            $query->where('entity_id', $request->entity_id);
        }

        if ($request->has('action')) {
            $query->where('action', $request->action);
        }

        return response()->json($query->latest()->paginate(15));
    }

    /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Create a new role",
     *     tags={"Roles"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "slug"},
     *             @OA\Property(property="name", type="string", example="Admin"),
     *             @OA\Property(property="slug", type="string", example="admin"),
     *             @OA\Property(property="description", type="string", example="Administrator Role")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Role created"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function show(AuditLog $auditLog)
    {
        return response()->json($auditLog->load('user'));
    }
}
