<?php
namespace App\Actions;

use App\Jobs\ShutdownComputer;
use App\Models\Computer;
use App\Models\Habit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Spatie\Ssh\Ssh;

class ShutdownComputerAction
{
    public function execute(Computer $computer)
    {
        if (!Auth::check()) {
            // flash()->overlay('Sie müssen angemeldet sein um die Warteliste zu benutzen.', 'Fehler')->error();
            return back();
        }

        if (!Auth::user()->canShutdownComputer($computer)) {
            return back();
        }

        if (!$computer->ssh_user || !$computer->ssh_shutdown_command) {
            return back();
        }

        if ($computer->sSHKey()->count() == 0) {
            return back();
        }

        ShutdownComputer::dispatch($computer, Auth::user());
    }
}
