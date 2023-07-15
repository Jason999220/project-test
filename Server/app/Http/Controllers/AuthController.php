<?php
// AuthController.php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // /api/register
    // 註冊帳戶
    function handleRegister(Request $request)
    {
        // get 前端輸入的資訊
        $email = $request->input('email');
        $userName = $request->input('userName');
        $password = $request->input('password');

        // call signUp (email, userName, pwd)
        $result = DB::select("call signUp('$email', '$userName', '$password')");

        // return 給前端
        return  $result ;
    }

    // /api/getUserInfo
    // 取得個人資料
    function handleGetUserInfo($email)
    {
        // call getUserInfo (email)
        $result = DB::select("call getUserInfo('$email')");

        // return 給前端
        return $result;
    }
}