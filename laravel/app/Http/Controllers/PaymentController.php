<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ECPay_AllInOne;

class PaymentController extends Controller
{
    // 只有計算 CheckMacValue 這個值之後附加到表單再送到綠界，送出之後的所有錯誤綠界都會清楚的回應
    public function checkout(Request $request)
    {
        $obj = new ECPay_AllInOne();

        // 服務參數
        $obj->ServiceURL = $request->input('ServiceURL');
        $obj->HashKey = $request->input('HashKey');
        $obj->HashIV = $request->input('HashIV');
        $obj->MerchantID = $request->input('MerchantID');

        // 設定訂單資料
        $obj->Send['MerchantTradeNo'] = $request->input('MerchantTradeNo');
        $obj->Send['MerchantTradeDate'] = $request->input('MerchantTradeDate');
        $obj->Send['PaymentType'] = $request->input('PaymentType');
        $obj->Send['TotalAmount'] = (int) $request->input('TotalAmount');
        $obj->Send['TradeDesc'] = $request->input('TradeDesc');
        $obj->Send['ReturnURL'] = $request->input('ReturnURL');
        $obj->Send['ChoosePayment'] = $request->input('ChoosePayment');
        $obj->Send['CreditInstallment'] = $request->input('CreditInstallment');

        // 訂單的商品資料
        $item = [
            'Name' => 'aaa',
            'Price' => 100,
            'Currency' => '元',
            'Quantity' => (int) '1',
        ];
        array_push($obj->Send['Items'], $item);

        // 產生訂單(auto submit至ECPay)
        $Response = $obj->CheckOutString();

        return view('checkout', ['response' => $Response]);
    }

    public function handleECPayCallback(Request $request)
    {
        $postData = $request->all();
        $string = print_r($postData, true);
        file_put_contents('/tmp/ECPay.txt', $string, FILE_APPEND);

        define('ECPay_MerchantID', '2000132');
        define('ECPay_HashKey', '5294y06JbISpM5x9');
        define('ECPay_HashIV', 'v77hoKGq4kWxNNIS');

        // 重新整理回傳參數。
        $arParameters = $postData;
        $arFeedback = [];
        foreach ($arParameters as $key => $value) {
            if ($key != 'CheckMacValue') {
                if ($key == 'PaymentType') {
                    $value = str_replace('_CVS', '', $value);
                    $value = str_replace('_BARCODE', '', $value);
                    $value = str_replace('_CreditCard', '', $value);
                }
                if ($key == 'PeriodType') {
                    $value = str_replace('Y', 'Year', $value);
                    $value = str_replace('M', 'Month', $value);
                    $value = str_replace('D', 'Day', $value);
                }
                $arFeedback[$key] = $value;
            }
        }

        // 計算出 CheckMacValue
        $CheckMacValue = ECPay_CheckMacValue::generate($arParameters, ECPay_HashKey, ECPay_HashIV);

        // 必須要支付成功並且驗證碼正確
        if ($postData['RtnCode'] == '1' && $CheckMacValue == $postData['CheckMacValue']) {
            // 要處理的程式放在這裡，例如將線上服務啟用、更新訂單資料庫付款資訊等
        }

        // 回應綠界
        return response('1|OK');
    }
}
