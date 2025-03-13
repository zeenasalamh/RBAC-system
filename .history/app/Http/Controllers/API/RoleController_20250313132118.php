<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
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

    public function index()
    {
        $roles = Role::with('permissions')->get();
        return response()->json($roles);
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

    public function store(Request $request)
    {
        $request->validate([
            'name'                            => 'required|string|max:255|unique:roles',
            'description'                     => 'nullable|string',
            'permissions'                     => 'nullable|array',
            'permissions.*.id'                => 'required|exists:permissions,id',
            'permissions.*.record_conditions' => 'nullable|json',
        ]);

        $role = Role::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        if ($request->has('permissions')) {
            $permissionData = [];
            foreach ($request->permissions as $permission) {
                $permissionData[$permission['id']] = [
                    'record_conditions' => $permission['record_conditions'] ?? null,
                ];
            }
            $role->permissions()->attach($permissionData);
        }

        return response()->json($role->load('permissions'), 201);
    }

    public function show(Role $role)
    {
        return response()->json($role->load('permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'                            => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description'                     => 'nullable|string',
            'permissions'                     => 'nullable|array',
            'permissions.*.id'                => 'required|exists:permissions,id',
            'permissions.*.record_conditions' => 'nullable|json',
        ]);

        $role->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->name),
            'description' => $request->description,
        ]);

        if ($request->has('permissions')) {
            $permissionData = [];
            foreach ($request->permissions as $permission) {
                $permissionData[$permission['id']] = [
                    'record_conditions' => $permission['record_conditions'] ?? null,
                ];
            }
            $role->permissions()->sync($permissionData);
        }

        return response()->json($role->load('permissions'));
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(null, 204);
    }
}
