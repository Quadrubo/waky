<?php

namespace App\Actions;

use App\Models\Computer;
use App\Support\Concerns\InteractsWithBanner;
use Illuminate\Support\Facades\Auth;

class WakeComputerAction
{
    use InteractsWithBanner;

    public function execute(Computer $computer)
    {
        if (! Auth::check()) {
            flash('You have to be authenticated to wake a computer.')->error();

            return back();
        }

        if (! $computer->canBeWokenUpBy(Auth::user())) {
            flash('You are not authorized to wake this computer.')->error();

            return back();
        }

        $result = $computer->wake();

        if ($result['result'] == 'OK') {
            flash()->overlay($result['message'], 'Computer is waking up...')->success();
        } else {
            flash()->overlay($result['message'], 'An error occured')->error();
        }
    }
}
