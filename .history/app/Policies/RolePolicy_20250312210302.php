<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermission('roles.view');
    }
    
    public function view(User $user, Role $role)
    {
        return $user->hasPermission('roles.view');
    }
    
    public function create(User $user)
    {
        return $user->hasPermission('roles.create');
    }
    
    public function update(User $user, Role $role)
    {
        return $user->hasPermission('roles.update');
    }
    
    public function delete(User $user, Role $role)
    {
        return $user->hasPermission('roles.delete');
    }
}