<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
</head>

<body>
    <form method="post">
        @csrf
        <label for="MerchantID">特店編號: </label>
        <input type="text" id="MerchantID" name="MerchantID">
        <span>Ex.2000132，10個數字以內</span><br>
        <label for="MerchantTradeNo">訂單編號: </label>
        <input type="text" id="MerchantTradeNo" name="MerchantTradeNo">
        <span>Ex.'Test'，需要英數字大小寫混合，我有加time()，數字部分自動產生</span><br>
        <label for="TotalAmount">交易金額: </label>
        <input type="text" id="TotalAmount" name="TotalAmount">
        <span>Ex.100，帶整數，不可有小數點</span><br>
        <label for="TradeDesc">交易描述: </label>
        <input type="text" id="TradeDesc" name="TradeDesc">
        <span>Ex.交易描述範例，請勿帶入特殊字元</span><br>
        <label for="ItemName">商品名稱: </label>
        <input type="text" id="ItemName" name="ItemName">
        <span>Ex.範例商品一批 100 TWD x 1</span>
        <br><br>
        <button type="submit">Submit</button>
    </form>
</body>

</html>