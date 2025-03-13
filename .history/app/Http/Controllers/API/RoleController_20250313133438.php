<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
public function store(Request $request)

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*.id' => 'required|exists:permissions,id',
            'permissions.*.record_conditions' => 'nullable|json',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        if ($request->has('permissions')) {
            $permissionData = [];
            foreach ($request->permissions as $permission) {
                $permissionData[$permission['id']] = [
                    'record_conditions' => $permission['record_conditions'] ?? null,
                ];
            }
            $role->permissions()->attach($permissionData);
        }

        return response()->json($role->load('permissions'), 201);
    }

    public function show(Role $role)
    {
        return response()->json($role->load('permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*.id' => 'required|exists:permissions,id',
            'permissions.*.record_conditions' => 'nullable|json',
        ]);

        $role->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        if ($request->has('permissions')) {
            $permissionData = [];
            foreach ($request->permissions as $permission) {
                $permissionData[$permission['id']] = [
                    'record_conditions' => $permission['record_conditions'] ?? null,
                ];
            }
            $role->permissions()->sync($permissionData);
        }

        return response()->json($role->load('permissions'));
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(null, 204);
    }
}