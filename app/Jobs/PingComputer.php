<?php

namespace App\Jobs;

use App\Models\Computer;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PingComputer implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        public Computer $computer
    ) {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->batch()->cancelled()) {
            // Determine if the batch has been cancelled...

            return;
        }

        $ipAddress = $this->computer->ip_address;

        $ping = new \JJG\Ping($ipAddress);
        $ping->setTimeout(5);

        $latency = $ping->ping();

        if ($latency !== false) {
            $this->computer->status = 'on';
        } else {
            $this->computer->status = 'off';
        }

        $this->computer->touch('status_updated_at');

        $this->computer->save();
    }
}
