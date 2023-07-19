<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 測試是否可用API
Route::get('/test',function(Request $request){
    echo('OK');
    die();
});

//UserController
Route::post('/signup', [UserController::class, 'signup']);
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);