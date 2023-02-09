<?php

namespace App\Http\Controllers;

use App\Actions\SendComputerNotificationAction;
use App\Actions\UnuseComputerAction;
use App\Actions\UseComputerAction;
use App\Models\Computer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UseComputerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Computer $computer, UseComputerAction $useComputerAction, UnuseComputerAction $unuseComputerAction)
    {
        if ($computer->users->contains(Auth::user())) {
            $unuseComputerAction->execute($computer);

            return;
        }

        $useComputerAction->execute($computer);
    }
}
