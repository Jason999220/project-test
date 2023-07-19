<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    // 註冊
    public function signup(Request $request)
    {
        // get 前端輸入的資訊
        // $email = $request->input('email');
        // $userName = $request->input('userName');
        // $password = $request->input('password');
        $validatedData = $request->validate([
            'userName' => 'required|string',
            // 'email' => 'required|string|unique:users|email',
            'email' => 'required|string|email',
            'password' => 'required|string'
            //  'password' => 'required|string|confirmed' 此範例沒有 confirmed 所以報422，前端有判斷所以可以省略
        ]);

        // 轉成變數
        $userName = $validatedData['userName'];
        $email = $validatedData['email'];
        $password = $validatedData['password'];

        // Check if email already exists
        $emailExists = DB::select("SELECT COUNT(*) AS count FROM users WHERE email = ?", [$email])[0]->count;
        if ($emailExists) {
            return response()->json(['message' => 'Email has already registered', 'state' => '400']);
        }

        // use hash password
        $hashPassword = bcrypt($password);
        // Insert new user
        // DB::insert("INSERT INTO users (userName, email, hashpassword) VALUES (?, ?, ?)", [$userName, $email, $hashPassword]);
        $result = DB::select("call signUp('$userName', '$email', '$hashPassword')");
        // return $result];
        return response()->json(['result' => $result, 'state' => '200']);

        // return response()->json(['result' => '註冊成功'], 201);
    }

    // 登錄
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $email = $fields['email'];
        $password = $fields['password'];

        $result = DB::select("CALL your_procedure_name(?, ?, @mytoken)", [$email, $password]);

        // 获取存储过程中设置的令牌值
        $tokenResult = DB::select("SELECT @mytoken AS token")[0]->token;

        if ($result[0]->result == '登入成功') {
            $response = [
                'result' => $result[0]->result,
                'token' => $tokenResult
            ];
        } else {
            $response = [
                'result' => $result[0]->result,
                'token' => null
            ];
        }

        return response($response, 201);
    }


    // 登出
    public function logout(Request $request)
    {
        $user = $request->user();
        $token = $user->currentAccessToken();

        // 调用存储过程
        DB::select("CALL your_procedure_name(?, @result)", [$token->id]);

        // 获取存储过程中设置的结果值
        $result = DB::select("SELECT @result AS result")[0]->result;

        return [
            'message' => $result
        ];
    }
}
