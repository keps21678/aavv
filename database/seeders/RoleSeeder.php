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
        $permissions = [
            'delete',
            'update',
            'create',
            'read',
        ];
        foreach ($permissions as $permission) {
            ModelsPermission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
        $admin = ModelsRole::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $editor = ModelsRole::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
        $viewer = ModelsRole::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);
        $admin->givePermissionTo(ModelsPermission::all());
        $editor->givePermissionTo(['create', 'update', 'read']);
        $viewer->givePermissionTo(['read']);
    }
}
