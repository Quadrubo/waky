<?php

namespace App\Actions;

use App\Models\Computer;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class UnuseComputerAction
{
    public function execute(Computer $computer)
    {
        if (! Auth::check()) {
            Notification::make()
                ->title('You have to be authenticated to use a computer.')
                ->danger()
                ->send();

            return back();
        }

        if (! $computer->canBeUnusedBy(Auth::user())) {
            Notification::make()
                ->title('You are not authorized to use a computer.')
                ->danger()
                ->send();

            return back();
        }

        $usersCountBefore = $computer->users()->count();

        $computer->users()->detach(Auth::user());

        $usersCountAfter = $computer->users()->count();

        (new SendComputerNotificationAction)->execute($computer, $usersCountBefore, $usersCountAfter);
    }
}
