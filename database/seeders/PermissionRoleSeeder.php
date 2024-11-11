<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Seeder ini digunakan untuk mendefinisikan hak akses/permissions
 * apa saja yang dimiliki oleh users
 */
class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();

        $adminPermissions = $permissions;
        Role::findOrFail(1)->permissions()->sync($adminPermissions->pluck('id'));

        $ignoredPrefixes = [
            'user_create', 'user_delete', 'user_restore',
            'role_', 'permission_', 'lecturer_create', 'lecturer_destroy',
            'dance_create', 'dance_update', 'dance_delete',
            'dance_type_create', 'dance_type_update', 'dance_type_delete',
            'dance_part_create', 'dance_part_update', 'dance_part_delete',
            'dance_cloth_create', 'dance_cloth_update', 'dance_cloth_delete',
            'dance_move_create', 'dance_move_update', 'dance_move_delete',
        ];

        $lecturerPermissions = $this->filterPermissions($permissions, $ignoredPrefixes);
        Role::findOrFail(2)->permissions()->sync($lecturerPermissions->pluck('id'));

        $ignoredPrefixes = [
            'user_', 'role_', 'permission_', 'lecturer_',
            'dance_create', 'dance_update', 'dance_delete',
            'dance_type_create', 'dance_type_update', 'dance_type_delete',
            'dance_part_create', 'dance_part_update', 'dance_part_delete',
            'dance_cloth_create', 'dance_cloth_update', 'dance_cloth_delete',
            'dance_move_create', 'dance_move_update', 'dance_move_delete',
            'student_create', 'student_delete', 'student_edit',
        ];

        $studentPermissions = $this->filterPermissions($permissions, $ignoredPrefixes);
        Role::findOrFail(3)->permissions()->sync($studentPermissions->pluck('id'));
    }

    private function filterPermissions($permissions, $ignoredPrefixes)
    {
        return $permissions->filter(function ($permission) use ($ignoredPrefixes) {
            return !collect($ignoredPrefixes)->contains(function ($prefix) use ($permission) {
                return str_starts_with($permission->name, $prefix);
            });
        });
    }
}
