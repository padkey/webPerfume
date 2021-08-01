@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Login information
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">',$message,'</span>';
                    //cho nó thành nul để reload lại trang k thấy nó nữa
                    Session::put('message',null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>

                        <th>Customer name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>

                        <td>{{$customer->customer_name}}</td>

                        <td>{{$customer->customer_phone}}</td>
                      <td>{{$customer->customer_email}}</td>
                        <td>
                            <a href="{{URL::to('/viewOrder/')}}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o text-success text-active"></i>
                            </a>
                            <a href="{{URL::to('/deleteOrder/')}}" onclick="return confirm('Are you sure?')" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-remove text-danger text"></i>
                            </a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <br><br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Shipping information
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">',$message,'</span>';
                    //cho nó thành nul để reload lại trang k thấy nó nữa
                    Session::put('message',null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>Customer name</th>
                        <th>Adress</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Notes</th>
                        <th>shipping method</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td>{{$shipping->shipping_name}}</td>
                        <td>{{$shipping->shipping_address}}</td>
                        <td>{{$shipping->shipping_phone}}</td>
                        <td>{{$shipping->shipping_email}}</td>
                        <td>{{$shipping->shipping_notes}}</td>
                        <td>
                            @if($shipping->shipping_method ==0 )
                                tranfer bank
                            @elseif($shipping->shipping_method ==1)
                                hand cash
                                @elseif($shipping->shipping_method ==2)
                            @endif
                        </td>
                        <td>
                            <a href="{{URL::to('/viewOrder/')}}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o text-success text-active"></i>
                            </a>
                            <a href="{{URL::to('/deleteOrder/')}}" onclick="return confirm('Are you sure?')" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-remove text-danger text"></i>
                            </a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <br><br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Show All Order Detail
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">',$message,'</span>';
                    //cho nó thành nul để reload lại trang k thấy nó nữa
                    Session::put('message',null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>

                        <th></th>
                        <th>Product name</th>
                        <th>Inventory quantity</th>
                        <th>Coupon code</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total price</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $total = 0; $i =1; @endphp
                    @foreach($orderDetails as $key => $detail)
                        @php $subTotal = $detail->product_sales_quantity*$detail->product_price;
                              $total +=  $subTotal;

                        @endphp
                        <tr class="warning-qty-product-{{$detail->product_id}}">


                            <td>{{$i++}}</td>
                            <td>{{$detail->product_name}}</td>
                            <td>{{$detail->product->product_quantity}}</td>
                            <td>
                                @if($detail->product_coupon != 'no')
                                    {{$detail->product_coupon}}
                                @else
                                    Code does not apply
                                @endif
                            </td>
                            <td>
                                <input type="number"  {{$orderStatus == 2 ? 'disabled' : ''}} min="1" name="product_sales_quantity" class="qty_product_order_{{$detail->product_id}}" value="{{$detail->product_sales_quantity}}" >
                                <input type="hidden" name="order_code" class="order_code"  value="{{$detail->order_code}}">
                                <input type="hidden" name="qty_product_inventory" class="qty_product_inventory_{{$detail->product_id}}" value="{{$detail->product->product_quantity}}" >
                                <input type="hidden" name="order_product_id" class="order_product_id" value="{{$detail->product_id}}">
                                @if($orderStatus != 2) {{--nếu orderStatus = 2 có nghĩa là đơn hàng đó đã được gửi, nên không cho cập nhật số lượng nữa--}}
                                <button class="btn btn-default updateQtyOrder" name="updateQtyOrder" data-product_id="{{$detail->product_id}}">Update</button>

                                @endif
                            </td>
                            <td>{{number_format($detail->product_price,0,',','.')}}đ</td>
                            <td>{{number_format($subTotal,0,',','.')}}đ</td>
                            <td>
                                <a href="{{URL::to('/viewOrder/')}}" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <a href="{{URL::to('/deleteOrder/')}}" onclick="return confirm('Are you sure?')" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-remove text-danger text"></i>
                                </a>
                            </td>
                        </tr>
              @endforeach

                    <tr><td>
                            <p>Total price in order : {{number_format($total,0,',','.')}}đ</p>
                            @php
                                $totalCoupon = 0;
                                $totalAfterCoupon = 0;

                                if($couponCondition == 1){
                                            $totalCoupon = ($total * $couponNumber)/100;
                                           //   $totalCoupon= $total - $totalAfterCoupon ;
                                        }else{
                                      $totalCoupon = $couponNumber;
                                        }
                                @endphp

                            <p>Total discount : {{number_format($totalCoupon,0,',','.')}}đ</p>
                            <p>Feeship : {{number_format($detail->product_feeship,0,',','.')}}đ</p>
                            <p>Total payment : {{number_format($total - $totalCoupon -  $detail->product_feeship,0,',','.')}}đ</p>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2">
                            <form >
                                @csrf
                                @foreach($order as $key => $ord)
                                <select name="" id="" class="form-control orderDetails">
                                    <option value="">----Choose----</option>
                                    <option id="{{$ord->order_id}}" value="1" {{$ord->order_status==1 ? 'selected' : '' }}>No process</option>
                                    <option id="{{$ord->order_id}}" value="2" {{$ord->order_status==2 ? 'selected' : '' }}>Delivered</option>
                                    <option id="{{$ord->order_id}}" value="3" {{$ord->order_status==3 ? 'selected' : '' }}>Custody(tạm giữ)</option>
                                </select>
                                @endforeach
                            </form>

                        </td>
                    </tr>
                    </tbody>
                </table>
                    {{--target="_blank" là khi click vào cho ra một tab mới--}}
                    <a target="_blank" href="{{URL::to('/printOrder/'.$detail->order_code)}}">Print order</a>
            </div>

        </div>
    </div>

@endsection
