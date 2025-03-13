<?php
namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['name' => 'View Roles', 'slug' => 'roles.view', 'resource' => 'roles', 'action' => 'read'],
            ['name' => 'Create Roles', 'slug' => 'roles.create', 'resource' => 'roles', 'action' => 'create'],
            ['name' => 'Edit Roles', 'slug' => 'roles.edit', 'resource' => 'roles', 'action' => 'update'],
            ['name' => 'Delete Roles', 'slug' => 'roles.delete', 'resource' => 'roles', 'action' => 'delete'],

            ['name' => 'View Permissions', 'slug' => 'permissions.view', 'resource' => 'permissions', 'action' => 'read'],
            ['name' => 'Create Permissions', 'slug' => 'permissions.create', 'resource' => 'permissions', 'action' => 'create'],
            ['name' => 'Edit Permissions', 'slug' => 'permissions.edit', 'resource' => 'permissions', 'action' => 'update'],
            ['name' => 'Delete Permissions', 'slug' => 'permissions.delete', 'resource' => 'permissions', 'action' => 'delete'],

            ['name' => 'View Users', 'slug' => 'users.view', 'resource' => 'users', 'action' => 'read'],
            ['name' => 'Edit User Roles', 'slug' => 'users.roles.edit', 'resource' => 'users', 'action' => 'update'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $adminRole = Role::create([
            'name'        => 'Administrator',
            'slug'        => 'admin',
            'description' => 'System administrator with all permissions',
        ]);

        // Attach all permissions to admin role
        $adminRole->permissions()->attach(Permission::all());

        // Create admin user
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Assign admin role to admin user
        $admin->roles()->attach($adminRole);
    }
}
