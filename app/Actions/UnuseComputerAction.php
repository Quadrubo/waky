<?php

namespace App\Actions;

use App\Models\Computer;
use Illuminate\Support\Facades\Auth;

class UnuseComputerAction
{
    public function execute(Computer $computer)
    {
        if (! Auth::check()) {
            flash('You have to be authenticated to use a computer.')->error();

            return back();
        }

        if (! $computer->canBeUnusedBy(Auth::user())) {
            flash('You are not authorized to use a computer.')->error();

            return back();
        }

        $usersCountBefore = $computer->users()->count();

        $computer->users()->detach(Auth::user());

        $usersCountAfter = $computer->users()->count();

        (new SendComputerNotificationAction)->execute($computer, $usersCountBefore, $usersCountAfter);
    }
}
