<?php
// api.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// http://localhost/laravel/apiTest/public/api/register 可與前端交互

Route::get('/hello',function(Request $request){
    echo('hello');
    die();
});

// 建立API ，利用Controller 接收並處理前端資訊
Route::post('/register',[AuthController::class,'handleRegister']);