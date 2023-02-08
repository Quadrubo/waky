<?php

namespace App\Http\Controllers;

use App\Actions\ShutdownComputerAction;
use App\Models\Computer;
use Illuminate\Http\Request;

class ShutdownComputerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Computer $computer, ShutdownComputerAction $shutdownComputerAction)
    {
        $shutdownComputerAction->execute($computer);
    }
}
