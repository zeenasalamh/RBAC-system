<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
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
        $permissions = Permission::all();
        return response()->json($permissions);
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
            'name'         => 'required|string|max:255|unique:permissions',
            'description'  => 'nullable|string',
            'resource'     => 'nullable|string',
            'action'       => 'nullable|string',
            'record_level' => 'boolean',
        ]);

        $permission = Permission::create([
            'name'         => $request->name,
            'slug'         => Str::slug($request->name),
            'description'  => $request->description,
            'resource'     => $request->resource,
            'action'       => $request->action,
            'record_level' => $request->record_level ?? false,
        ]);

        return response()->json($permission, 201);
    }

    public function show(Permission $permission)
    {
        return response()->json($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name'         => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'description'  => 'nullable|string',
            'resource'     => 'nullable|string',
            'action'       => 'nullable|string',
            'record_level' => 'boolean',
        ]);

        $permission->update([
            'name'         => $request->name,
            'slug'         => Str::slug($request->name),
            'description'  => $request->description,
            'resource'     => $request->resource,
            'action'       => $request->action,
            'record_level' => $request->record_level ?? false,
        ]);

        return response()->json($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(null, 204);
    }
}
