<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Requests\StoreRoleRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *      title="RBAC API Documentation",
 *      version="1.0.0",
 *      description="Role-Based Access Control API Documentation",
 * )
 */

 
class RoleController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Role::class);
        return RoleResource::collection(Role::with('permissions')->get());
    }
    
    /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Create a new role",
     *     @OA\RequestBody(required=true),
     *     @OA\Response(response=201, description="Role created")
     * )
     */
    public function store(StoreRoleRequest $request)
    {
        $this->authorize('create', Role::class);
        
        $role = Role::create($request->validated());
        
        if ($request->has('permissions')) {
            $permissionData = [];
            foreach ($request->permissions as $permission) {
                $permissionData[$permission['id']] = [
                    'record_conditions' => $permission['record_conditions'] ?? null,
                ];
            }
            $role->permissions()->attach($permissionData);
        }
        
        return new RoleResource($role->load('permissions'));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
