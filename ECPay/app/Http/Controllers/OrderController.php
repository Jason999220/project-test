<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;
use Ecpay\Sdk\Services\CheckMacValueService;
use Ecpay\Sdk\Response\VerifiedArrayResponse;

class OrderController extends Controller
{
    function order(Request $request)
    {
        require __DIR__ . '../../../../vendor/autoload.php';

        $factory = new Factory([
            'hashKey' => '5294y06JbISpM5x9',
            'hashIv' => 'v77hoKGq4kWxNNIS',
        ]);
        $autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

        $input = [
            'MerchantID' => $request['MerchantID'],
            'MerchantTradeNo' => $request['MerchantTradeNo'].time(),
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'PaymentType' => 'aio',
            'TotalAmount' => $request['TotalAmount'],
            'TradeDesc' => UrlService::ecpayUrlEncode($request['TradeDesc']),
            'ItemName' => $request['ItemName'],
            'ChoosePayment' => 'Credit',
            'EncryptType' => 1,

            
            'ReturnURL' => 'https://04b6-116-241-203-205.ngrok-free.app/callback',
            'ClientBackURL' => 'https://04b6-116-241-203-205.ngrok-free.app/callback',
        ];

        // 綠界測試用網址
        $action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';
        // 綠界正式用網址
        // $action = 'https://payment.ecpay.com.tw/Cashier/AioCheckOut/V5';
        echo $autoSubmitFormService->generate($input, $action);
    }

    function callback(Request $request)
    {
        // 請參考 example/Payment/GetCheckoutResponse.php 範例開發
        require __DIR__ . '../../../../vendor/autoload.php';

        $factory = new Factory([
                'hashKey' => '5294y06JbISpM5x9',
                'hashIv' => 'v77hoKGq4kWxNNIS',
            ]);
        $checkoutResponse = $factory->create(VerifiedArrayResponse::class);

        $_POST = [
                'MerchantID' => '2000132',
                'MerchantTradeNo' => 'WPLL4E341E122DB44D62',
                'PaymentDate' => '2019/05/09 00:01:21',
                'PaymentType' => 'Credit_CreditCard',
                'PaymentTypeChargeFee' => '1',
                'RtnCode' => '1',
                'RtnMsg' => '交易成功',
                'SimulatePaid' => '0',
                'TradeAmt' => '500',
                'TradeDate' => '2019/05/09 00:00:18',
                'TradeNo' => '1905090000188278',
                'CheckMacValue' => '59B085BAEC4269DC1182D48DEF106B431055D95622EB285DECD400337144C698',
            ];

        var_dump($checkoutResponse->get($_POST));
    }
}
