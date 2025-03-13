<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    
    public function index()
    {
        $permissions = Permission::all();
        return response()->json($permissions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'description' => 'nullable|string',
            'resource' => 'nullable|string',
            'action' => 'nullable|string',
            'record_level' => 'boolean',
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'resource' => $request->resource,
            'action' => $request->action,
            'record_level' => $request->record_level ?? false,
        ]);

        return response()->json($permission, 201);
    }

    public function show(Permission $permission)
    {
        return response()->json($permission);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'description' => 'nullable|string',
            'resource' => 'nullable|string',
            'action' => 'nullable|string',
            'record_level' => 'boolean',
        ]);

        $permission->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'resource' => $request->resource,
            'action' => $request->action,
            'record_level' => $request->record_level ?? false,
        ]);

        return response()->json($permission);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(null, 204);
    }
}