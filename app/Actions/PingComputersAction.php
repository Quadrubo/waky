<?php

namespace App\Actions;

use App\Jobs\PingComputers;
use App\Support\Concerns\InteractsWithBanner;
use Illuminate\Support\Facades\Auth;

class PingComputersAction
{
    use InteractsWithBanner;

    public function execute()
    {
        if (! Auth::check()) {
            flash('You have to be authenticated to ping computers.')->error();

            return back();
        }

        flash('Pinging computers...');

        PingComputers::dispatch();

        return back();
    }
}
