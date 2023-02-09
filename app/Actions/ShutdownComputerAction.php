<?php

namespace App\Actions;

use App\Jobs\ShutdownComputer;
use App\Models\Computer;
use Illuminate\Support\Facades\Auth;

class ShutdownComputerAction
{
    public function execute(Computer $computer)
    {
        if (! Auth::check()) {
            flash('You have to be authenticated to shutdown a computer.')->error();

            return back();
        }

        if (! $computer->canBeShutdownBy(Auth::user())) {
            if (! Auth::user()->can('shutdown_computer')) {
                flash('You are not authorized to shutdown this computer.')->error();

                return back();
            }

            if ($computer->isInUse()) {
                flash('The computer can not shutdown because it is still in use.')->error();

                return back();
            }

            flash('The computer can not shutdown. Are you authorized to do this?')->error();

            return back();
        }

        if (! $computer->ssh_user || ! $computer->ssh_shutdown_command) {
            flash('The computer can not shutdown. SSH configuration is missing.')->error();

            return back();
        }

        if ($computer->sSHKey()->count() == 0) {
            flash('The computer can not shutdown. SSH key is missing.')->error();

            return back();
        }

        flash('Shutting down computer...');

        ShutdownComputer::dispatch($computer, Auth::user());

        return back();
    }
}
