<?php

declare(strict_types=1);

use App\Http\Controllers\SumMachineController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(TokenController::class)->group(function (): void {
    Route::post('/token', 'generate')->name('token.generate');
});

Route::middleware(['token'])->group(function (): void {
    Route::controller(SumMachineController::class)->group(function (): void {
        Route::post('/number', 'addNumber')->name('number.add');
        Route::delete('/number', 'removeLastNumber')->name('number.remove');
        Route::get('/sum', 'getSum')->name('sum');
    });
});
