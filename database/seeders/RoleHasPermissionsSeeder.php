<?php

namespace Database\Seeders;

use App\Actions\FieldArrayDiffAction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleHasPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(FieldArrayDiffAction $fieldArrayDiffAction)
    {
        // Admin
        $role = Role::where('name', 'admin')->firstOrFail();
        $permissions = Permission::all();
        $fields = ['permission_id', 'role_id'];

        $existingData = json_decode(DB::table('role_has_permissions')->select($fields)->get()->toJson(), true);
        $data = [];

        foreach ($permissions as $permission) {
            array_push($data, ['permission_id' => $permission->id, 'role_id' => $role->id]);
        }

        $data = $fieldArrayDiffAction->execute($data, $existingData, $fields);

        DB::table('role_has_permissions')->insert($data);

        // User
        $role = Role::where('name', 'user')->firstOrFail();
        $permissions = [
            'wake_computer',
            'use_computer',
            'shutdown_computer',
        ];

        $permissions = Permission::whereIn('name', $permissions)->get();
        $fields = ['permission_id', 'role_id'];

        $existingData = json_decode(DB::table('role_has_permissions')->select($fields)->get()->toJson(), true);
        $data = [];

        foreach ($permissions as $permission) {
            array_push($data, ['permission_id' => $permission->id, 'role_id' => $role->id]);
        }

        $data = (new FieldArrayDiffAction())->execute($data, $existingData, $fields);

        DB::table('role_has_permissions')->insert($data);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
