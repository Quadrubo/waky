<?php

namespace App\Jobs;

use App\Models\Computer;
use App\Models\User;
use App\Notifications\FlashMessageNotification;
use App\Support\Concerns\InteractsWithBanner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Ssh\Ssh;

class ShutdownComputer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, InteractsWithBanner;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Computer $computer,
        public User $user
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $process = Ssh::create($this->computer->ssh_user, $this->computer->ip_address)
            ->addExtraOption('-o ConnectTimeout=10 -oBatchMode=yes')
            ->disableStrictHostKeyChecking()
            ->usePrivateKey($this->computer->sSHKey()->first()->private_file)
            ->disablePasswordAuthentication()
            ->execute($this->computer->ssh_shutdown_command);

        if ($process->getExitCode() === 255) {
            $this->user->notify(new FlashMessageNotification('Computer not reachable, maybe it is already shut down or the SSH Key is wrong.', 'danger'));

            return;
        }

        if ($process->getExitCode() !== 0) {
            $this->user->notify(new FlashMessageNotification('Computer failed to shutdown,', 'danger'));

            ray($process, $process->getExitCode(), $process->getOutput());

            return;
        }

        $this->user->notify(new FlashMessageNotification('Computer successfully shutdown.', 'success'));
    }
}
