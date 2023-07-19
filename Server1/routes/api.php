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
Route::post('/register',[AuthController::class,'handleRegister']); // 處理註冊
Route::get('/getUserInfo/{email}',[AuthController::class,'handleGetUserInfo']); // 從網址獲取參數，傳遞給資料庫並獲取相對應的資料


// handle ECPay 
Route::post('/order',[AuthController::class,'handleOrder']); 
Route::post('/store',[OrdersController::class,'store']); // 綠界付款成功時ECPay會回傳資料，我們回到【callback】執行所需動作
Route::post('/callback',[OrdersController::class,'callback']); // 綠界付款成功時ECPay會回傳資料，我們回到【callback】執行所需動作
Route::get('/success',[OrdersController::class,'redirectFromECPay']); // 點擊 綠界納的【返回商店】所導向的地方
