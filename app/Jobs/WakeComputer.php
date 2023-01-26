<?php

namespace App\Jobs;

use App\Models\Computer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use \Diegonz\PHPWakeOnLan\PHPWakeOnLan;
use App\Support\Concerns\InteractsWithBanner;

class WakeComputer implements ShouldQueue
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
        $macAddress = [$this->computer->mac_address];

        try {
            $phpWakeOnLan = new PHPWakeOnLan();
            $result = $phpWakeOnLan->wake($macAddress);

            if ($result['result'] == "OK") {
                $this->banner($result['message']);
            } else {
                $this->banner($result['message'], 'danger');
            }
            
        } catch (Exception $e) {
            $this->banner($e->getMessage(), 'danger');
        }
    }
}
