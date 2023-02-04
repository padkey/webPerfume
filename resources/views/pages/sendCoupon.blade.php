<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial;
        }

        .coupon {
            border: 5px dotted #bbb;
            width: 80%;
            border-radius: 15px;
            margin: 0 auto;
            max-width: 600px;
        }

        .container {
            padding: 2px 16px;
            background-color: #f1f1f1;
        }

        .promo {
            background: #ccc;
            padding: 3px;
        }

        .expire {
            color: red;
        }
    </style>
</head>
<body>

<div class="coupon">
    <div class="container">
        <h3>Perfume Shop</h3>
    </div>
    <div class="container" style="background-color:white">
        <h1 >Thank you</h1>
        <p>Shop có chương trình giảm giá @if($coupon->coupon_condition == 1)
                {{$coupon->coupon_number}}%
            @else
                {{number_format($coupon->coupon_number,0,',','.')}}đ
            @endif cho người may mắn nhận được tin nhắn này</p>
        <p>Hiện tại chỉ còn : {{$coupon->coupon_quantity}} mã </p>

    </div>
    <div class="container">
        <p>Mã giảm giá: <span class="promo">{{$coupon->coupon_code}}</span></p>
        <p class="expire">Mã áp dụng từ ngày : {{$coupon->coupon_date_start}} đến {{$coupon->coupon_date_end}}</p>
    </div>
</div>

</body>
</html>
