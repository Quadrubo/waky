<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ModelHasRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all();
        $user = User::where('email', 'admin@admin.admin')->first();

        if (App::environment(['local', 'staging'])) {
            foreach ($roles as $role) {
                if (DB::table('model_has_roles')->where('role_id', $role->id)->where('model_id', $user->id)->count() == 0) {
                    DB::table('model_has_roles')->insert([
                        'role_id' => $role->id,
                        'model_type' => 'App\Models\User',
                        'model_id' => $user->id,
                    ]);
                }
            }
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
