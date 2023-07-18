<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    // 註冊
    public function signup(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
    
        $email = $validatedData['email'];
    
        // Check if email already exists
        $emailExists = DB::select("SELECT COUNT(*) AS count FROM users WHERE email = ?", [$email])[0]->count;
    
        if ($emailExists) {
            return response()->json(['result' => '帳號重複'], 400);
        }
    
        // Insert new user
        $userName = $validatedData['name'];
        $hashPassword = bcrypt($validatedData['password']);
    
        DB::insert("INSERT INTO users (userName, email, hashpassword) VALUES (?, ?, ?)", [$userName, $email, $hashPassword]);
    
        return response()->json(['result' => '註冊成功'], 201);
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
