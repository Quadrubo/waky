<?php

namespace App\Actions;

use App\Models\Computer;
use Illuminate\Support\Facades\Auth;

class UseComputerAction
{
    public function execute(Computer $computer)
    {
        if (! Auth::check()) {
            // flash()->overlay('Sie müssen angemeldet sein um die Warteliste zu benutzen.', 'Fehler')->error();
            return back();
        }

        if (! $computer->canBeUsedBy(Auth::user())) {
            return back();
        }

        $usersCountBefore = $computer->users()->count();

        $computer->users()->attach(Auth::user());

        $usersCountAfter = $computer->users()->count();

        (new SendComputerNotificationAction)->execute($computer, $usersCountBefore, $usersCountAfter);
    }
}
