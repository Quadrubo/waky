<?php

namespace App\Http\Controllers;

use App\Jobs\PingComputers;

class PingComputerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        PingComputers::dispatch();
    }
}
