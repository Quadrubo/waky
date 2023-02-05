<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerifyUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:verify {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify the email address of a user';

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

        $user->email_verified_at = Carbon::now();

        $user->save();

        $this->info("The email address of the user (id: {$user->id}, email: {$user->email}) was verified!");

        return Command::SUCCESS;
    }
}
