<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'resource', 
        'action', 
        'record_level'
    ];
    
    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('record_conditions')
            ->withTimestamps();
    }
}