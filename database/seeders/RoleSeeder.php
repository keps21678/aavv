<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsRole::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        ModelsRole::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        ModelsRole::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);
        //
        // $Roles = [
        //     'admin',
        //     'editor',
        //     'viewer',
        // ];
        // foreach ($Roles as $role) {
        //     ModelsRole::create([
        //         'name' => $role,
        //     ]);
        // };
        $Permissions = [
            'delete',
            'update',
            'create',
            'read',
        ];
        foreach ($Permissions as $permission) {
            ModelsPermission::create([
                'name' => $permission,
            ]);
        };
        ModelsRole::findByName('admin')->givePermissionTo(ModelsPermission::all());
        ModelsRole::findByName('editor')->givePermissionTo(['create', 'update', 'read']);
        ModelsRole::findByName('viewer')->givePermissionTo(['read']);
    }
}
