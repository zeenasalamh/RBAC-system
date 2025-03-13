<?php

namespace App\Models;

use Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory,Auditable;

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