<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class = Permission::class;

        $fields = ['name', 'guard_name'];

        $data = [
            [
                'name' => 'access_filament',
                'guard_name' => 'web',
            ],
            [
                'name' => 'wake_computer',
                'guard_name' => 'web',
            ],
            [
                'name' => 'use_computer',
                'guard_name' => 'web',
            ],
            [
                'name' => 'shutdown_computer',
                'guard_name' => 'web',
            ],
        ];

        $cruds = ['view_any', 'view', 'create', 'update', 'delete', 'delete_any', 'restore', 'restore_any', 'force_delete', 'force_delete_any'];
        $attributes = [
            'user',
            'permission',
            'role',
            // -----
            'computer',
            'ssh_key',
        ];

        foreach ($cruds as $crud) {
            foreach ($attributes as $attribute) {
                array_push($data,
                    [
                        'name' => $crud.'_'.$attribute,
                        'guard_name' => 'web',
                    ]
                );
            }
        }

        $this->call(GeneralSeeder::class, true, ['class' => $class, 'fields' => $fields, 'data' => $data, 'hasRelationships' => false, 'addTimestamps' => true]);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
