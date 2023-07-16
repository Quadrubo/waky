<?php

namespace App\Actions;

use App\Jobs\ShutdownComputer;
use App\Models\Computer;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ShutdownComputerAction
{
    public function execute(Computer $computer)
    {
        if (! Auth::check()) {
            Notification::make()
                ->title('You have to be authenticated to shutdown a computer.')
                ->danger()
                ->send();

            return back();
        }

        if (! $computer->canBeShutdownBy(Auth::user())) {
            if (! Auth::user()->can('shutdown_computer')) {
                Notification::make()
                    ->title('You are not authorized to shutdown this computer.')
                    ->danger()
                    ->send();

                return back();
            }

            if ($computer->isInUse()) {
                Notification::make()
                    ->title('The computer can not shutdown because it is still in use.')
                    ->danger()
                    ->send();

                return back();
            }

            Notification::make()
                ->title('The computer can not shutdown. Are you authorized to do this?')
                ->danger()
                ->send();

            return back();
        }

        if (! $computer->ssh_user || ! $computer->ssh_shutdown_command) {
            Notification::make()
                ->title('The computer can not shutdown. SSH configuration is missing.')
                ->danger()
                ->send();

            return back();
        }

        if ($computer->sSHKey()->count() == 0) {
            Notification::make()
                ->title('The computer can not shutdown. SSH key is missing.')
                ->danger()
                ->send();

            return back();
        }

        Notification::make()
            ->title('Shutting down computer...')
            ->icon('heroicon-o-information-circle')
            // TODO: get this working
            // ->iconColor('blue')
            ->send();

        ShutdownComputer::dispatch($computer, Auth::user());

        return back();
    }
}
