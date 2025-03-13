<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    protected $auditService;

    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }

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
    public function index(User $user)
    {
        return response()->json($user->roles);
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
    public function store(Request $request, User $user)
    {
        $request->validate([
            'roles'   => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $beforeState = $user->roles->pluck('id')->toArray();

        $user->roles()->sync($request->roles);

        $afterState = $user->roles->fresh()->pluck('id')->toArray();

        $this->auditService->log(
            'assigned_roles',
            'User',
            $user->id,
            $beforeState,
            $afterState
        );

        return response()->json($user->load('roles'));
    }

    public function destroy(User $user, Role $role)
    {
        $beforeState = $user->roles->pluck('id')->toArray();

        $user->roles()->detach($role);

        $afterState = $user->roles->fresh()->pluck('id')->toArray();

        $this->auditService->log(
            'removed_role',
            'User',
            $user->id,
            $beforeState,
            $afterState
        );

        return response()->json(null, 204);
    }
}
