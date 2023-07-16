<?php

namespace App\Actions;

use App\Events\ComputerReachableStatusUpdated;
use App\Jobs\PingComputer;
use App\Models\Computer;
use Filament\Notifications\Notification;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Throwable;

class PingComputersAction
{
    public function execute()
    {
        if (! Auth::check()) {
            Notification::make()
                ->title('You have to be authenticated to ping computers.')
                ->danger()
                ->send();

            return back();
        }

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

        Notification::make()
            ->title('Pinging computers...')
            ->icon('heroicon-o-information-circle')
            // TODO: get this working
            // ->iconColor('blue')
            ->send();
    }
}
