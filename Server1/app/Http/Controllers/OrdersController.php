<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use \ECPay_PaymentMethod as ECPayMethod; // 參考IThome 問題=> 與PSR4有關

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Orders::all();
        return view('orders', compact('orders'));
    }
    public function new()
    {
        $oldCart = session()->has('cart') ? session()->get('cart') : null;
        $cart = new Cart($oldCart);
        return view('order',[
            'books'=> $cart->items,
            'totalPrice'=> $cart->totalPrice,
            'totalQty'=>$cart->totalQty]);
    }

    public function store(Request $request)
    {
        $name = $request->input('item');
        // $MerchantTradeNo = $request->input('itemNO');
        // $des = $request->input('des');
        // $price = $request->input('price');
        // request()->validate([
        //     'name' => 'required',
        //     'email' => 'required',
        // ]);
        // $cart = session()->get('cart');
        // $uuid_temp = str_replace("-", "",substr(Str::uuid()->toString(), 0,18));
        // $order = Orders::create([
        //     'name' => request('name'),
        //     'email' => request('email'),
        //     'cart' => serialize($cart),
        //     'uuid' => $uuid_temp
        //     ]);

        // session()->flash('success', 'Order success!');
        try {
            $obj = new ECPay_AllInOne();
            return($obj); // 綠界SDK建立的物件

            //服務參數
            $obj->ServiceURL  = "https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5";   //服務位置
            $obj->HashKey     = '5294y06JbISpM5x9' ;                                           //測試用Hashkey，請自行帶入ECPay提供的HashKey
            $obj->HashIV      = 'v77hoKGq4kWxNNIS' ;                                           //測試用HashIV，請自行帶入ECPay提供的HashIV
            $obj->MerchantID  = '2000132';                                                     //測試用MerchantID，請自行帶入ECPay提供的MerchantID
            $obj->EncryptType = '1';                                                           //CheckMacValue加密類型，請固定填入1，使用SHA256加密
            //基本參數(請依系統規劃自行調整)
            // 網址都要轉成【ngrok】不可以用 【localhost】，綠界不支援
            $MerchantTradeNo = $uuid_temp ;
            $obj->Send['ReturnURL']         = "https://74fa25d4.ngrok.io/callback" ;    //付款完成通知回傳的網址
            $obj->Send['PeriodReturnURL']         = " https://74fa25d4.ngrok.io/callback" ;    //付款完成通知回傳的網址
            $obj->Send['ClientBackURL'] = " https://74fa25d4.ngrok.io/success" ;    //付款完成通知回傳的網址
            $obj->Send['MerchantTradeNo']   = '$MerchantTradeNo';                          //訂單編號
            $obj->Send['MerchantTradeDate'] = date('Y/m/d H:i:s');                       //交易時間
            $obj->Send['TotalAmount']       = '200';                                      //交易金額
            $obj->Send['TradeDesc']         = 'good' ;                          //交易描述
            $obj->Send['ChoosePayment']     = ECPayMethod::Credit ;              //付款方式:Credit
            $obj->Send['IgnorePayment']     = ECPayMethod::GooglePay ;           //不使用付款方式:GooglePay
            //訂單的商品資料
            array_push($obj->Send['Items'], array('Name' => request('name'), 'Price' => $cart->totalPrice,
            'Currency' => "元", 'Quantity' => (int) "1", 'URL' => "dedwed"));
            return($obj); // 綠界SDK建立的物件
            session()->forget('cart');
            $obj->CheckOut();
        } catch (Exception $e) {
            return($e); // 綠界SDK建立的物件

            echo $e->getMessage();
        }
    }

    // 處理付款完成後，用綠界回傳給 Server 的參數
    public function callback()
    {
           // dd(request());
        $order = Order::where('no', '=', request('MerchantTradeNo'))->firstOrFail();
        // 正常來說不太可能出現支付了一筆不存在的訂單，這個判斷只是增加系統健壯性
        if (!$order) {
            return 'fail';
        }
        // 如果這筆訂單的狀態已經是已支付
        if ($order->paid_at) {
            return 'success';
        }
        if (request('RtnCode') == '1') { // RtnCode=1表示付款成功
            $order->update([
                'paid_at' => Carbon::now(), // 支付時間
                'payment_method' => 'ecpay', // 支付方式
                'payment_no' => request('MerchantTradeNo'), // 綠界訂單編號
            ]);
            echo '1|OK'; // 系統收到綠界回傳結果，正確回應1|OK
        }
    }


    // 處理付款之後導向的地方 => 按【返回商店】會導向的地方
    public function redirectFromECpay () {
        session()->flash('success', 'Order success!');
        return redirect('/');
    }
}

// 付款成功的request
// {
//     "CustomField1":null,
//     "CustomField2":null,
//     "CustomField3":null,
//     "CustomField4":null,
//     "MerchantID":"2000132",
//     "MerchantTradeNo":"Test1576073816",
//     "PaymentDate":"2019\/12\/11 22:17:57",
//     "PaymentType":"Credit_CreditCard",
//     "PaymentTypeChargeFee":"1",
//     "RtnCode":"1",
//     "RtnMsg":"\u4ea4\u6613\u6210\u529f",
//     "SimulatePaid":"0",
//     "StoreID":null,
//     "TradeAmt":"50",
//     "TradeDate":"2019\/12\/11 22:16:56",
//     "TradeNo":"1912112216567583",
//     "CheckMacValue":"6F42BE6F208E15FD08C189345D0973D0787983E3753CE670E105173A994F9AE2"
//  }