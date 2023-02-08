<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;
use App\Models\Computer;
use App\Models\User;
use App\Notifications\ShutdownComputerFeedback;
use App\Support\Concerns\InteractsWithBanner;
use ErrorException;
use Spatie\Ssh\Ssh;

class ShutdownComputer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, InteractsWithBanner;

    /**
     * The computer instance.
     *
     * @var \App\Models\Computer
     */
    public $computer;

    /**
     * The user that dispatched the job.
     * 
     * @var \App\Models\User
     */
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Computer $computer, User $user)
    {
        $this->computer = $computer;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {       
        $this->user->notify(new ShutdownComputerFeedback('Shutting down computer...', 'info'));
     
        $process = Ssh::create($this->computer->ssh_user, $this->computer->ip_address)
            ->addExtraOption('-o ConnectTimeout=10')
            ->disableStrictHostKeyChecking()
            ->usePrivateKey($this->computer->sSHKey()->first()->private_file)
            ->disablePasswordAuthentication()
            ->execute($this->computer->ssh_shutdown_command);

        if ($process->getExitCode() === 255) {
            $this->user->notify(new ShutdownComputerFeedback('Computer not reachable, maybe it is already shut down.', 'danger'));

            return;
        }

        if ($process->getExitCode() !== 0) {
            $this->user->notify(new ShutdownComputerFeedback('Computer failed to shutdown,', 'danger'));

            ray($process, $process->getExitCode(), $process->getOutput());

            return;
        }

        $this->user->notify(new ShutdownComputerFeedback('Computer successfully shutdown.', 'success'));
    }
}
