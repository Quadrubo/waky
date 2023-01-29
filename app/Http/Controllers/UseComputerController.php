<?php

namespace App\Http\Controllers;

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
    public function __invoke(Computer $computer)
    {
        if ($computer->users->contains(Auth::user())) {
            $computer->users()->detach(Auth::user());
            return;
        }

        $computer->users()->attach(Auth::user());
    }
}
