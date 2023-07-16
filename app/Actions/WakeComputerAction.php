<?php

namespace App\Actions;

use App\Models\Computer;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class WakeComputerAction
{
    public function execute(Computer $computer)
    {
        if (! Auth::check()) {
            Notification::make()
                ->title('You have to be authenticated to wake a computer.')
                ->danger()
                ->send();

            return back();
        }

        if (! $computer->canBeWokenUpBy(Auth::user())) {
            Notification::make()
                ->title('You are not authorized to wake this computer.')
                ->danger()
                ->send();

            return back();
        }

        $result = $computer->wake();

        if ($result['result'] == 'OK') {
            Notification::make()
                ->title('Computer is waking up...')
                ->body($result['message'])
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('An error occured')
                ->body($result['message'])
                ->danger()
                ->send();
        }
    }
}
