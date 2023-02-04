@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Show All Coupon
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    {{--<select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>--}}

                    <a href="{{url('/sendCoupon')}}" class="btn btn-info">Send coupon to Vip Customers</a>

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
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Coupon name</th>
                        <th>Date start</th>
                        <th>Date end</th>
                        <th>Code</th>
                        <th>Time</th>
                        <th>Condition</th>
                        <th>Number discount</th>
                        <th>Status</th>
                        <th>Expiry(hạn sử dụng)</th>
                        <th>Send Coupon</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allCoupon as $key => $coupon)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{ $coupon->coupon_name }}</td>
                            <td>{{$coupon->coupon_date_start}}</td>
                            <td>{{$coupon->coupon_date_end}}</td>
                            <td>{{ $coupon->coupon_code }}</td>
                            <td>{{ $coupon->coupon_quantity }}</td>
                            <td>
                                @if($coupon->coupon_condition == 1)
                                 <p>Discount by % </p>
                                @else
                                <p>Discount by money</p>
                                    @endif
                            </td>
                            <td>
                                @if($coupon->coupon_condition == 1)
                                    <p> {{ $coupon->coupon_number }}% </p>
                                @else
                                    <p> {{ number_format($coupon->coupon_number,0,',','.') }} đ</p>
                                @endif


                            </td>
                            <td>
                                @if($coupon->coupon_status == 1)
                                    <a href="{{url('/unactiveCoupon/'.$coupon->coupon_id)}}" style="color: #00aa00"> active</a>
                                @else
                                    <a href="{{url('/activeCoupon/'.$coupon->coupon_id)}}" style="color: red"> inactive</a>

                                @endif
                            </td>
                           <td>
                               {{--strtotime hàm dung so sánh ngày--}}
                               @if(strtotime($coupon->coupon_date_end) >= strtotime($today))
                                   <p style="color: #00aa00">unexpired(chưa hết hạn)</p>
                               @else
                                   <p style="color: red">expired(hết hạn)</p>
                               @endif
                           </td>
                            <td>
                                <a href="{{URL::to('/deleteCoupon/'.$coupon->coupon_id)}}" onclick="return confirm('Are you sure?')" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-remove text-danger text"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{url('/sendCouponNormal/'.$coupon->coupon_id)}}" class="btn btn-default btn-sm" style="width: 160px">Send to normal Customers</a>
                                <a href="{{url('/sendCouponVip/'.$coupon->coupon_id)}}" class="btn btn-info  btn-sm" style="width: 160px">Send to vip Customers</a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>

@endsection
