<?php

namespace App\Http\Controllers;

use App\Actions\PingComputersAction;

class PingComputersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PingComputersAction $pingComputersAction)
    {
        $pingComputersAction->execute();
    }
}
