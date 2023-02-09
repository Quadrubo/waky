<?php

namespace App\Actions;

use App\Models\Computer;
use Illuminate\Support\Facades\Auth;

class UseComputerAction
{
    public function execute(Computer $computer)
    {
        if (! Auth::check()) {
            flash('You have to be authenticated to use a computer.')->error();

            return back();
        }

        if (! $computer->canBeUsedBy(Auth::user())) {
            flash('You are not authorized to use a computer.')->error();

            return back();
        }

        $usersCountBefore = $computer->users()->count();

        $computer->users()->attach(Auth::user());

        $usersCountAfter = $computer->users()->count();

        (new SendComputerNotificationAction)->execute($computer, $usersCountBefore, $usersCountAfter);
    }
}
