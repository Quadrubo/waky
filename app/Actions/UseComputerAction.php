<?php

namespace App\Actions;

use App\Models\Computer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UseComputerAction
{
    public function execute(Computer $computer)
    {
        if (! Auth::check()) {
            // flash()->overlay('Sie müssen angemeldet sein um die Warteliste zu benutzen.', 'Fehler')->error();
            return back();
        }

        // if (!Auth::user()->canShutdownComputer($computer)) {
        //     return back();
        // }

        $usersCountBefore = $computer->users()->count();

        $computer->users()->attach(Auth::user());

        $usersCountAfter = $computer->users()->count();

        (new SendComputerNotificationAction)->execute($computer, $usersCountBefore, $usersCountAfter);
    }
}
