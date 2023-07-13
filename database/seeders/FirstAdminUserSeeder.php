<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class FirstAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // exit if there are users in the system
        if (User::count() !== 0) {
            return;
        }

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ]);

        $roles = Role::all();

        // give the user full permissions
        foreach ($roles as $role) {
            if (DB::table('model_has_roles')->where('role_id', $role->id)->where('model_id', $user->id)->count() == 0) {
                DB::table('model_has_roles')->insert([
                    'role_id' => $role->id,
                    'model_type' => \App\Models\User::class,
                    'model_id' => $user->id,
                ]);
            }
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
