<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Auditable;
class User extends Authenticatable
{
    // Add relationship methods
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasPermission($permission, $recordId = null)
    {
        // Check if user has the permission through any of their roles
        foreach ($this->roles as $role) {
            foreach ($role->permissions as $perm) {
                if ($perm->slug === $permission) {
                    // If not record-level, or no specific record requested, permission granted
                    if (! $perm->record_level || $recordId === null) {
                        return true;
                    }

                    // For record-level permissions, check conditions
                    $conditions = json_decode($perm->pivot->record_conditions, true);
                    if ($this->checkRecordConditions($conditions, $recordId, $perm->resource)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function checkRecordConditions($conditions, $recordId, $resource)
    {
        // Implement logic to check record-level conditions
        // This will vary based on your specific requirements
        // ...

        return false;
    }
}

 