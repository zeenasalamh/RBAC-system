<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Role",
 *     type="object",
 *     title="Role",
 *     description="Role entity",
 *     required={"id", "name", "slug"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Administrator"),
 *     @OA\Property(property="slug", type="string", example="admin"),
 *     @OA\Property(property="description", type="string", example="Admin role"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)
            ->withPivot('record_conditions')
            ->withTimestamps();
    }
}
