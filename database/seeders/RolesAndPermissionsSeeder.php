<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createRoleWithPermissions('super_admin', 'Super Administrador', [
            'user' => ['edit', 'list', 'create', 'delete'],
            'permission' => ['edit', 'list', 'create', 'delete'],
            'role' => ['edit', 'list', 'create', 'delete'],
            'assessment' => ['edit', 'list', 'create', 'delete'],
        ]);

        $this->createRoleWithPermissions('admin', 'Administrador', [
            'user' => ['edit', 'list', 'create', 'delete'],
            'assessment' => ['edit', 'list', 'create', 'delete'],
        ]);

        $this->createRoleWithPermissions('teacher', 'Professor', [
            'user' => ['list'],
            'assessment' => ['edit', 'list', 'create', 'delete'],
        ]);

        $this->createRoleWithPermissions('student', 'Aluno', [
            'user' => ['list'],
        ]);
    }

    protected function createRoleWithPermissions(string $roleName, string $titleName, array $permissions)
    {
        $role = Role::updateOrCreate(['name' => $roleName], ['title' => $titleName]);

        $permissionModels = collect();

        foreach ($permissions as $model => $actions) {
            $newPermissionModels = collect($actions)->map(function ($action) use ($model) {
                return Permission::updateOrCreate(['name' => "{$model}_{$action}"]);
            });

            $permissionModels = $permissionModels->merge($newPermissionModels);
        }

        $role->syncPermissions($permissionModels->pluck('name')->toArray());
    }
}
