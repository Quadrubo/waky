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

class PingComputer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        $ipAddress = $this->computer->ip_address;

        // Create an instance of PingCommand
        $command = (new PingCommandBuilder("127.0.0.1"));

        // Pass the PingCommand instance to Ping and run...
        $ping = (new Ping($command))->run();

        dd($ping);
    }
}
