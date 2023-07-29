<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('order');
});

Route::get('/callback', function () {
    return view('callback');
});

Route::post('/', [OrderController::class, 'order']);
Route::get('/callback', [OrderController::class, 'callback']);