@extends('frontend_layout')
@section('header')
    @include('pages.include.headerNormal')
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{url('/home')}}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
				Shopping Cart
			</span>
        </div>
    </div>


    <!-- Shopping Cart -->
    <form class="bg0 p-t-75 p-b-85" action="{{url('/updateCart')}}" method="POST">
        @csrf
        <div class="container" >
            @if(session()->has('message'))
                <div class="alert alert-success" style="margin-left: 25px;margin-right: 40px">
                    {!! session()->get('message') !!}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {!!session()->get('error')!!}
                </div>
            @endif
            <div class="row">

                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Product</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Price</th>
                                    <th class="column-4" style="text-align: center;">Quantity</th>
                                    <th class="column-5">Total</th>
                                    <th class="column-1" style="padding: 0"></th>
                                </tr>
                                @php $subTotal = 0; $totalPayment =0;@endphp
                                @if(Session::get('cart'))
                                    @foreach(Session::get('cart') as $key => $cart)
                                <tr class="table_row">
                                    <td class="column-1">
                                        <div class="how-itemcart1">
                                            <img src="{{url('/public/uploads/products/'.$cart['product_image'])}}" alt="IMG">
                                        </div>
                                    </td>
                                    <td class="column-2">{{$cart['product_name']}}</td>
                                    <td class="column-3">{{number_format($cart['product_price'],0,',','.')}}đ</td>
                                    <td class="column-4">
                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product qtyCart" type="number" name="qtyOfProductInCart[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}">

                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-4" style="text-align: center">
                                        {{number_format($cart['product_price']*$cart['product_qty'],0,',','.')}}đ

                                    </td>

                                    <td class="column-1" style="font-size: 25px;padding-left: 0px;text-align: center;">
                                        <a href="{{url('/delProduct/'.$cart['session_id'])}}"><i class="fa fa-times-circle" style="margin-right: 10px"></i></a>
                                    </td>
                                </tr>
                                        @php $subTotal += $cart['product_price']*$cart['product_qty'] @endphp
                                    @endforeach
                                @else

                                @endif

                            </table>
                        </div>

                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <div class="flex-w flex-m m-r-20 m-tb-5">

                                <input type="text"  class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" id="couponCode"name="couponCode" placeholder="Coupon Code">

                                <div class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                    <button type="button" class="checkCoupon" style="width: 100%;height: 100%">Apply coupon</button>
                                </div>

                            </div>

                            <div class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10" >
                                 <button type="submit" style="width: 100%;height: 100%">Update Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50 " >
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Cart Totals
                        </h4>

                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
                            </div>

                            <div class="size-209">
								<span class="mtext-110 cl2">
									{{number_format($subTotal,0,',','.')}}đ
								</span>
                            </div>
                        </div>





                    @php  $discount = 0; @endphp
                        @if(Session::get('coupon'))

                            @php


                                    $coupon = Session::get('coupon');
                                    if($coupon['coupon_condition'] == 1){ // bằng 1 là giảm theo % của tổng giá đơn hàng
                                        $discount = ( $coupon['coupon_number'] * $subTotal )/100;
                                    }else{
                                        $discount = $coupon['coupon_number'];
                                    }
                            @endphp
                        <div class="flex-w flex-t p-t-15">
                            <div class="size-208">
								<span class="stext-110 cl2">
									Discount :
								</span>
                            </div>

                            <div class="size-209">
								<span class="mtext-110 cl2">
                                -     {{number_format($discount,0,',','.')}}đ
                                    <a  href="{{URL::to('/deleteCouponCode')}}"><i class="fa fa-times-circle"></i></a>

								</span>
                            </div>
                        </div>
                        @endif
                        @php $totalPayment = $subTotal + Session::get('feeship') - $discount @endphp
                        <div class="flex-w flex-t p-t-20 p-b-33">
                            <div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
                            </div>

                            <div class="size-209 p-t-1">
								<span class="mtext-110 cl2">
									{{number_format($totalPayment,0,',','.')}}đ
								</span>
                            </div>
                        </div>


                            <a href="#" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer checkoutPage">
                                Proceed to Checkout
                            </a>

                    </div>
                </div>
            </div>
        </div>
    </form>
    @endsection
