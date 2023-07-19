<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CasesController extends Controller
{
    // 提案
    public function insertCase(Request $request)
{
    $myuserID = $request->input('myuserID');
    $mycaseName = $request->input('mycaseName');
    $mybigClassID = $request->input('mybigClassID');
    $myclassID = $request->input('myclassID');
    $mybudget = $request->input('mybudget');
    $mydeadline = $request->input('mydeadline');
    $mycity = $request->input('mycity');
    $mydescription = $request->input('mydescription');
    $mycontactName = $request->input('mycontactName');
    $mycontactPhone = $request->input('mycontactPhone');
    $mycontactTime = $request->input('mycontactTime');
    $mycaseStatus = $request->input('mycaseStatus');
    $myimageA = $request->input('myimageA');
    $myimageB = $request->input('myimageB');
    $myimageC = $request->input('myimageC');
    $myimageD = $request->input('myimageD');
    $myimageE = $request->input('myimageE');

    try {
        DB::select("CALL addMyCase(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$myuserID, $mycaseName, $mybigClassID, $myclassID, $mybudget, $mydeadline, $mycity, $mydescription, $mycontactName, $mycontactPhone, $mycontactTime, $mycaseStatus, $myimageA, $myimageB, $myimageC, $myimageD, $myimageE]);

        if ($mycaseStatus == '草稿') {
            $result = '案件已儲存至草稿';
        } elseif ($mycaseStatus == '刊登中') {
            $result = '案件已刊登';
        }

        return response()->json(['result' => $result]);
    } catch (\Exception $e) {
        return response()->json(['result' => '插入案件失败']);
    }
}

}
