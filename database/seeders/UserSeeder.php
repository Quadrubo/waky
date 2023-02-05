<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class = User::class;

        $fields = ['email'];

        $data = [];

        $testUsers = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.admin',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('admin123'),
            ],
            [
                'name' => 'user',
                'email' => 'user@user.user',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('user1234'),
            ],
        ];

        if (App::environment(['local', 'staging', 'testing'])) {
            $data = array_merge($data, $testUsers);
        }

        $this->call(GeneralSeeder::class, true, ['class' => $class, 'fields' => $fields, 'data' => $data, 'hasRelationships' => false, 'addTimestamps' => true]);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
