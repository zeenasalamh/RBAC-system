<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
 
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens;
    use HasFactory, Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }
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
        if (empty($conditions)) {
            return false;
        }

        if (isset($conditions['allowed_ids']) && in_array($recordId, $conditions['allowed_ids'])) {
            return true;
        }

        if (isset($conditions['owner_only']) && $conditions['owner_only']) {
        }

        return false;
    }

    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }
}
