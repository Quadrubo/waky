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
            // flash()->overlay('Sie müssen angemeldet sein um die Warteliste zu benutzen.', 'Fehler')->error();
            return back();
        }

        if (! $computer->canBeWokenUpBy(Auth::user())) {
            return back();
        }

        $result = $computer->wake();

        if ($result['result'] == 'OK') {
            $this->banner($result['message']);
        } else {
            $this->banner($result['message'], 'danger');
        }
    }
}
