<?php

namespace App\Http\Controllers;

use App\Actions\WakeComputerAction;
use App\Models\Computer;
use App\Support\Concerns\InteractsWithBanner;
use Illuminate\Http\Request;

class WakeComputerController extends Controller
{
    use InteractsWithBanner;

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Computer $computer, WakeComputerAction $wakeComputerAction)
    {
        $wakeComputerAction->execute($computer);
    }
}
