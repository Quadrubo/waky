<?php

namespace App\Http\Controllers;

use App\Jobs\PingComputer;
use App\Models\Computer;
use Illuminate\Http\Request;

class PingComputerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Computer $computer)
    {
        PingComputer::dispatch($computer);
    }
}
