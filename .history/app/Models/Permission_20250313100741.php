<?php

namespace App\Models;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'resource', 'action', 'record_level'];
    
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivot('record_conditions')->withTimestamps();
    }
}

