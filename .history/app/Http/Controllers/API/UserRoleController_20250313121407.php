<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AuditService;

class UserRoleController extends Controller
{
    protected $auditService;
    
    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }
    
    public function index(User $user)
    {
        return response()->json($user->roles);
    }
    
    public function store(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required|array',
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