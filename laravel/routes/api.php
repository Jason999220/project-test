<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CasesController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//UserController
Route::post('signup', [UserController::class, 'signup']);
Route::post('login', [UserController::class, 'login'])->name('login');
Route::middleware('auth:sanctum')->post('logout', [UserController::class, 'logout']);




//InformationController
// prefix是前綴，域名/api/upload-photo
Route::group(['prefix' => 'api'], function () {
    Route::post('upload-photo', [InformationController::class, 'uploadPhoto']);
    Route::post('update-user/{myUserName}/{myUserID}', [InformationController::class, 'updateUser']);
    Route::post('update-phone/{myuserID}/{myphone}', [InformationController::class, 'updatePhone']);
    Route::post('update-email/{myuserID}/{myemail}', [InformationController::class, 'updateEmail']);
    Route::post('update-portfolio/{myuserID}/{myportfolio}', [InformationController::class, 'updatePortfolio']);
    Route::post('update-skills', [InformationController::class, 'updateSkills']);
});

// CasesController
Route::post('cases/insert', [CasesController::class, 'insertCase']);
Route::get('cases/search', [CasesController::class, 'selectCases']);
Route::get('cases', [CasesController::class, 'getCases']);
Route::post('cases/checkstatus', [CaseController::class, 'checkStatus']);








// 綠界
// Route::post('/payment/pay', [PaymentController::class, 'payByECPay']);
Route::post('payment/pay', [PaymentController::class, 'payByECPay']);

