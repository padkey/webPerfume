@extends('layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/')}}">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <?php
                $content = Cart::Content();

                ?>
                <table class="table table-condensed">
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
                    <tbody>
                    @foreach($content as  $value)
                    <tr>
                        <td class="cart_product">
                            <a href="">
                                <img src="{{URL::to('public/uploads/products/'.$value->options->image)}}" alt="" width="100px" />
                            </a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$value->name}}</a></h4>
                            <p>Web ID: 1089772</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($value->price).' VNĐ'}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">

                                <form action="{{URL::to('/updateQuantityCart')}}" method="POST">
                                    {{csrf_field()}}
                                    <input class="cart_quantity_input" type="text" name="quantityCart" value="{{$value->qty}}" autocomplete="off" size="2">
                                    <input type="hidden" value="{{$value->rowId}}" name="rowIdCart" class="form-control">
                                    <input type="submit" value="Update" class="btn btn-default btn-sm">
                                </form>

                            </div>
                        </td>
                        <td class="cart_total">
                            <p class="cart_total_price">
                                <?php
                                $subtotal = $value->price * $value->qty;
                                echo number_format($subtotal)." VNĐ";
                                ?>
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/deleteToCart/'.$value->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->
    <section id="do_action">
        <div class="container">

                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li>Cart Sub Total <span>{{Cart::priceTotal(0).' VNĐ'}}</span></li>
                            <li>Eco Tax (thuế)<span>{{Cart::tax(0).' VNĐ'}}</span></li>
                            <li>Shipping Cost (phí vận chuyển)<span>Free</span></li>
                            <li>Total <span>{{Cart::total(0).' VNĐ'}}</span></li>
                        </ul>
                       {{-- <a class="btn btn-default update" href="">Update</a>--}}

                        <?php
                        $customerId = Session::get('customerId');
                        if($customerId){ ?>
                        <a class="btn btn-default check_out" href="{{URL::to('/checkout')}}">Check Out</a>
                        <?php }else{ ?>
                        <a class="btn btn-default check_out" href="{{URL::to('/loginCheckout')}}">Check Out</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#do_action-->
    @endsection
