<?php

use App\Http\Controllers\ComputerController;
use App\Http\Controllers\WakeComputerController;
use App\Http\Controllers\PingComputerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //
});

Route::get('/', function () {
    return to_route('computers.index');
});

Route::resource('computers', ComputerController::class)
        ->only(['index']);

Route::post('/computers/{computer}/wake', WakeComputerController::class)->name('computers.wake');
Route::post('/computers/{computer}/ping', PingComputerController::class)->name('computers.ping');

