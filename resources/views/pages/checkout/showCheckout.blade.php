@extends('layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/')}}">Home</a></li>
                    <li class="active">Cart Checkout</li>
                </ol>
            </div>



            <div class="register-req">
                <p>Please use Register And Checkout to easily get access to your order history, or use Checkout as Guest</p>
            </div><!--/register-req-->

            <div class="shopper-informations">
                <div class="row">

                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p> Enter Bill Information</p>
                            <div class="form-one">
                                <form>
                                   @csrf
                                    <input type="text" placeholder="Email" class="shippingEmail" name="shippingEmail">
                                    <input type="text" placeholder="Your name" class="shippingName" name="shippingName">
                                    <input type="text" placeholder="Address" class="shippingAddress" name="shippingAddress">
                                    <input type="text" placeholder="Phone" class="shippingPhone" name="shippingPhone">
                                    <textarea name="shippingNotes" class="shippingNotes" cols="30" rows="5" placeholder="Note  your order"></textarea>

                                    @if(Session::get('feeship'))
                                        <input type="hidden" name="orderFeeship" value="{{Session::get('feeship')}}" class="orderFeeship">
                                    @else
                                        <input type="hidden" name="orderFeeship" value="20000" class="orderFeeship">
                                    @endif
                                   @if(Session::get('coupon'))
                                       @foreach(Session::get('coupon') as $key => $cou)
                                        <input type="hidden" name="orderCoupon" value="{{$cou['coupon_code']}}" class="orderCoupon">
                                        @endforeach
                                    @else
                                        <input type="hidden" name="orderCoupon" value="no" class="orderCoupon">
                                    @endif
                                    <div class="">
                                        <div class="form-group">
                                            <label for=""> Choose payment method </label>
                                            <select name="" id="" class="form-control payment_select">
                                                <option selected>-----Choose payment method -----</option>
                                                <option value="0">Direct bank transfer</option>
                                                <option value="1">Hand Cash</option>
                                                <option value="2"></option>
                                            </select>
                                        </div>

                                    </div>
                                    <input type="button" value="Checkout" class="btn btn-primary btn-sm send_order">
                                </form>

                                <form>
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputFile">City</label>
                                        <select name="city" id="city"class="form-control input-sm m-bot15 choose">
                                            <option selected>---Choose city---</option>
                                            @foreach($allCity as $key => $city)
                                                <option value="{{$city->matp}}">{{ $city->name_thanhpho}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Province</label>
                                        <select name="province" id="province"class="form-control input-sm m-bot15 choose">
                                            <option selected>---Choose province---</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Wards</label>
                                        <select name="wards" id="wards" class="form-control input-sm m-bot15 ">
                                            <option selected>---Choose wards---</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Transport fee</label>
                                        <input type="text" class="form-control fee-ship"name="feeShip" id="exampleInputEmail1" >
                                    </div>
                                    <input type="button" value="Calculate feeship" name="calculate" class="btn btn-info calculate_delivery">

                                </form>

                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 clearfix">
                        <div class="table-responsive cart_info">

                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{session()->get('message')}}
                                </div>
                            @elseif(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{session()->get('error')}}
                                </div>
                            @endif
                            <table class="table table-condensed">

                                {{csrf_field()}}

                                <thead>
                                <tr class="cart_menu">
                                    <td class="image">Item</td>
                                    <td class="description"></td>
                                    <td class="price">Price</td>
                                    <td class="quantity">Quantity</td>
                                    <td class="total">Total</td>
                                    <td></td>
                                </tr>
                                </thead>
                                @if(Session::get('cart'))
                                    <form action="{{URL('/updateCart')}}" method="POST">
                                        @csrf
                                        <tbody>

                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach(Session::get('cart') as  $key =>$cart)
                                            @php
                                                $subTotal = $cart['product_price'] * $cart['product_qty'];
                                                 $total = $total  + $subTotal;
                                            @endphp
                                            <tr>
                                                <td class="cart_product">
                                                    <a href="">
                                                        <img src="{{URL::to('public/uploads/products/'.$cart['product_image'] )}}" alt="" width="100px" />
                                                    </a>
                                                </td>
                                                <td class="cart_description">
                                                    <h4><a href=""></a> {{ $cart['product_name'] }}</h4>
                                                    <p>Web ID: 1089772</p>
                                                </td>
                                                <td class="cart_price">
                                                    <p>{{number_format($cart['product_price'],0,',','.')}} đ</p>
                                                </td>
                                                <td class="cart_quantity">
                                                    <div class="cart_quantity_button">

                                                        <input class="cart_quantity_input" type="number" name="quantityCart[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" autocomplete="off" size="2" min="1">
                                                        <input type="hidden" value="" name="rowIdCart" class="form-control">
                                                    </div>
                                                </td>
                                                <td class="cart_total">
                                                    <p class="cart_total_price">
                                                        {{number_format($subTotal,0,',','.')}} đ
                                                    </p>
                                                </td>
                                                <td class="cart_delete">
                                                    <a class="cart_quantity_delete" href="{{URL::to('/delProduct/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                <button type="submit" value="" class="btn btn-primary">Update</button>
                                            </td>
                                            <td>
                                                <a class="btn btn-default check_out" href="{{URL::to('/deleteAllProduct')}}">Delete all product</a>
                                                @if(Session::get('coupon'))
                                                    <a  class="btn btn-default check_out" href="{{URL::to('/deleteCouponCode')}}">Delete Coupon Code</a>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>

                                                <li>Cart Sub Total <span>{{number_format($total,0,',','.')}}đ</span></li>


                                                <li>

                                                    @if(Session::get('coupon'))
                                                        @foreach(Session::get('coupon') as $key => $cou)
                                                            @if($cou['coupon_condition'] == 1)
                                                                Coupon code : {{$cou['coupon_number']}}%
                                                                @php
                                                                    $totalCoupon = ($total * $cou['coupon_number'])/100;
                                                                    echo '<p><li> Total discount : '.number_format($totalCoupon,0,',','.').'đ </li></p>';
                                                                @endphp

                                                            @else
                                                                @php $totalCoupon = ($cou['coupon_number']);@endphp
                                                                Coupon code : {{number_format($cou['coupon_number'],0,',','.')}}đ
                                                            {{--    <p><li>Total discount : {{number_format($total-$cou['coupon_number'],0,',','.')}}đ</li></p>--}}
                                                @endif

                                                @endforeach
                                                @endif

                                                </li>

                                                @if(Session::get('feeship'))

                                                    <li><a class="cart_quantity_delete" href="{{URL::to('/delFeeship')}}"><i class="fa fa-times"></i></a>
                                                        Shipping Cost (phí vận chuyển) : <span>{{number_format(Session::get('feeship'),0,',','.')}}đ</span></li>
                                                @php $totalAfterFee = $total + Session::get('feeship'); @endphp
                                                @else
                                                    <li><a class="cart_quantity_delete" href=""><i class="fa fa-times"></i></a>
                                                        Shipping Cost (phí vận chuyển) : <span>{{number_format(20000,0,',','.')}}đ</span></li>
                                                    @php $totalAfterFee = $total + 20000; @endphp
                                                @endif
                                                <li>Total :
                                                    @php
                                                        $totalAfter=0;
                                                                if(Session::get('feeship') && !Session::get('coupon')){
                                                                        $totalAfter = $totalAfterFee;
                                                                    }
                                                                    elseif(!Session::get('feeship') && Session::get('coupon')){
                                                                        $totalAfter = $total - $totalCoupon;
                                                                    }
                                                                    elseif (Session::get('feeship') && Session::get('coupon')){
                                                                            $totalAfter = ($total - $totalCoupon) + Session::get('feeship');
                                                                    }
                                                                    elseif (!Session::get('feeship') && !Session::get('coupon')){
                                                                                $totalAfter = $total;
                                                                    }
                                                                echo number_format($totalAfter,0,',','.')."đ";
                                                    @endphp

                                                </li>
                                                <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Check Out</a>

                                            </td>

                                        </tr>
                                        </tbody>
                                    </form>
                                    <tr>
                                        <td>
                                            <form action="{{URL::to('/checkCoupon')}}" method="POST">
                                                @csrf
                                                <input type="text" class="form-control" name="couponCode" placeholder="Enter Coupon...">
                                                <br>
                                                <button type="submit" class="btn btn-default check_out"  name="checkCoupon"> check coupon</button>

                                            </form>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="5"> <center>Please add some product to cart</center></td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="review-payment">
                <h2>Review(ôn tập) & Payment</h2>
            </div>

            <div class="table-responsive cart_info">

            </div>
            <div class="payment-options">
					<span>
						<label><input type="checkbox"> Direct Bank Transfer</label>
					</span>
                <span>
						<label><input type="checkbox"> Check Payment</label>
					</span>
                <span>
						<label><input type="checkbox"> Paypal</label>
					</span>
            </div>
        </div>
    </section> <!--/#cart_items-->

@endsection
