<?php

namespace App\Console\Commands;

use App\Events\ComputerReachableStatusUpdated;
use App\Jobs\PingComputer;
use App\Models\Computer;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Throwable;

class PingComputers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'computers:ping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ping all computers.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $batchArray = [];

        $computers = Computer::all();

        foreach ($computers as $computer) {
            array_push($batchArray, new PingComputer($computer));
        }

        $batch = Bus::batch($batchArray)
        ->then(function (Batch $batch) {
            // All jobs completed successfully...
            ComputerReachableStatusUpdated::dispatch();
        })->catch(function (Batch $batch, Throwable $e) {
            // First batch job failure detected...
        })->finally(function (Batch $batch) {
            // The batch has finished executing...
        })->dispatch();

        return Command::SUCCESS;
    }
}
