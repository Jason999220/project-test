<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    //修改大頭照
    public function uploadPhoto(Request $request)
    {
        if ($request->hasFile('photo')) {
            // 處理上傳圖片
            $image = $request->file('photo');
            $filename = $image->getClientOriginalName();
            $uploadPic = Storage::disk('public')->put($filename, file_get_contents($image->getRealPath()));
            $photoURL = Storage::disk('public')->url($filename);
        } else {
            // 使用默認圖片
            $filename = '/uploads/images.jpg';
            $photoURL = Storage::disk('public')->url($filename);
        }

        $userID = auth()->user()->id;

        DB::statement("CALL changePhoto(?, ?, @result)", [$userID, $filename, $photoURL]);

        $result = DB::select("SELECT @result AS result")[0]->result;

        return response()->json(['result' => $result, 'url' => $photoURL], 200);
    }


    // 修改姓名
    public function updateUser($myUserName, $myUserID)
    {
        try {
            $result = DB::select('CALL newUserName(?, ?)', [$myUserName, $myUserID]);

            return response()->json(['result' => '修改姓名成功']);
        } catch (\Exception $e) {
            return response()->json(['result' => '修改姓名失败']);
        }
    }

    //修改電話
    public function updatePhone($myuserID, $myphone)
    {
        try {
            DB::select("CALL newphone(?, ?)", [$myuserID, $myphone]);

            return response()->json(['result' => '修改電話成功']);
        } catch (\Exception $e) {
            return response()->json(['result' => '修改電話失败']);
        }
    }


    // 修改信箱
    public function updateEmail($myuserID, $myemail)
    {
        try {
            DB::select("CALL changeEmail(?, ?)", [$myuserID, $myemail]);

            return response()->json(['result' => '修改信箱成功']);
        } catch (\Exception $e) {
            return response()->json(['result' => '修改信箱失败']);
        }
    }



    // 更新作品集
    public function updatePortfolio($myuserID, $myportfolio)
    {
        try {
            $result = DB::select("CALL newPortfolio(?, ?)", [$myuserID, $myportfolio]);

            $resultMessage = $result[0]->result;

            return response()->json(['result' => $resultMessage]);
        } catch (\Exception $e) {
            return response()->json(['result' => '更新作品集失败']);
        }
    }


    // 更新擅長工具
    public function updateSkills(Request $request)
    {
        $myuserID = $request->input('myuserID');
        $mysoftwore = $request->input('mysoftwore');

        DB::select("CALL newSoftwore(?, ?)", [$myuserID, $mysoftwore]);

        $result = DB::select("SELECT CASE
                                WHEN (SELECT COUNT(*) FROM myresume WHERE userID = ?) = 1 THEN '更新擅長工具成功'
                                ELSE '新增擅長工具成功'
                              END AS result", [$myuserID])[0]->result;

        return response()->json(['result' => $result]);
    }
    // 更新專長
}