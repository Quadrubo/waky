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
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Computer $computer)
    {
        $this->computer = $computer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {            
        $process = Ssh::create($this->computer->ssh_user, $this->computer->ip_address)
            ->addExtraOption('-o ConnectTimeout=10')
            ->disableStrictHostKeyChecking()
            ->usePrivateKey($this->computer->sSHKey()->first()->private_file)
            ->execute($this->computer->ssh_shutdown_command);

        // if ($process->getExitCode() !== 0) {
        //     // TODO: error
        //     dd($process, $process->getExitCode(), $process->getOutput());
        //     return back();
        // }
    }
}
