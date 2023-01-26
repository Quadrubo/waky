<?php

namespace App\Http\Controllers;

use App\Jobs\WakeComputer;
use App\Models\Computer;
use Illuminate\Http\Request;

class WakeComputerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Computer $computer)
    {
        WakeComputer::dispatch($computer);
    }
}
