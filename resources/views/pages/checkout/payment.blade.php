@extends('layout')
@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{URL::to('/')}}">Home</a></li>
                    <li class="active">Cart Pay</li>
                </ol>
            </div>



            <div class="review-payment">
                <h2>Review(ôn tập) & Payment</h2>
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
            <div class="payment-options">
                <h4 style="margin: 40px 0px;font-size: 20px">Chosose payment method</h4>
                <form action="{{URL::to('/orderPlace')}}" method="POST">
                    {{csrf_field()}}
                <span>
						<label><input name="paymentOption" value="1" type="checkbox"> Direct Bank Transfer(chuyển tiền qua ngân hàng)</label>
                </span>
                <span>
						<label><input  name="paymentOption" value="2" type="checkbox"> Check Payment</label>
                </span>
                <span>
						<label><input  name="paymentOption" value="3" type="checkbox"> Paypal</label>
                </span>
                    <input type="submit" value="done" name="sendOrderPlace" class="btn btn-primary">
                </form>
            </div>
        </div>
    </section> <!--/#cart_items-->

@endsection
