<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class GiveRoleToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:give {user} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give a user a rule.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::find($this->argument('user'));

        if (! $user) {
            $user = User::where('email', $this->argument('user'))->first();
        }

        if (! $user) {
            $this->error('Could not find the specified user. Please use the id or the email of the user.');

            return Command::FAILURE;
        }

        $role = Role::find($this->argument('role'));

        if (! $role) {
            $role = Role::where('name', $this->argument('role'))->first();
        }

        if (! $role) {
            $this->error('Could not find the specified role. Please use the id or the name of the role.');
        }

        $user->assignRole($role);

        $user->save();

        $this->info("The role (id: {$role->id}, name: {$role->name}) has been assigned to the user (id: {$user->id}, email: {$user->email})!");

        return Command::SUCCESS;
    }
}
