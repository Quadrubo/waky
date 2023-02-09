<?php

use App\Http\Controllers\ComputerController;
use App\Http\Controllers\PingComputerController;
use App\Http\Controllers\ShutdownComputerController;
use App\Http\Controllers\UseComputerController;
use App\Http\Controllers\WakeComputerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', function () {
        return to_route('computers.index');
    });

    Route::resource('computers', ComputerController::class)
            ->only(['index']);

    Route::post('/computers/{computer}/wake', WakeComputerController::class)->name('computers.wake');
    Route::post('/computers/{computer}/shutdown', ShutdownComputerController::class)->name('computers.shutdown');
    Route::post('/computers/ping', PingComputerController::class)->name('computers.ping');
    Route::post('/computers/{computer}/use', UseComputerController::class)->name('computers.use');
});
