@extends('layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/updCart')}}">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
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

                          {{--  <li>Eco Tax (thuế)<span></span></li>
                            <li>Shipping Cost (phí vận chuyển)<span>Free</span></li>--}}
                            <li>

                                    @if(Session::get('coupon'))
                                        @foreach(Session::get('coupon') as $key => $cou)
                                            @if($cou['coupon_condition'] == 1)
                                            Coupon code : {{$cou['coupon_number']}}%
                                                @php
                                                    $totalCoupon = ($total * $cou['coupon_number'])/100;
                                                    echo '<p> Total discount : '.number_format($totalCoupon,0,',','.').'đ</p>';
                                                @endphp
                                                <p>Total {{number_format($total - $totalCoupon,0,',','.')}}đ</p>
                                             @else
                                                Coupon code : {{number_format($cou['coupon_number'],0,',','.')}}đ
                                                <p><li>Total {{number_format($total-$cou['coupon_number'],0,',','.')}}đ</li></p>
                                             @endif

                                    @endforeach
                                  @endif

                            </li>
                            <li>Total <span></span></li>
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
    </section> <!--/#cart_items-->
    <section id="do_action">
        <div class="container">

            <div class="col-sm-6">
                <div class="total_area">
                    <ul>

                    </ul>
                    {{-- <a class="btn btn-default update" href="">Update</a>--}}





                </div>
            </div>
        </div>
        </div>
    </section><!--/#do_action-->
@endsection
