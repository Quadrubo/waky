<?php

namespace App\Actions;

use App\Models\Computer;
use Illuminate\Support\Facades\Auth;

class UnuseComputerAction
{
    public function execute(Computer $computer)
    {
        if (! Auth::check()) {
            // flash()->overlay('Sie müssen angemeldet sein um die Warteliste zu benutzen.', 'Fehler')->error();
            return back();
        }

        if (! $computer->canBeUnusedBy(Auth::user())) {
            return back();
        }

        $usersCountBefore = $computer->users()->count();

        $computer->users()->detach(Auth::user());

        $usersCountAfter = $computer->users()->count();

        (new SendComputerNotificationAction)->execute($computer, $usersCountBefore, $usersCountAfter);
    }
}
