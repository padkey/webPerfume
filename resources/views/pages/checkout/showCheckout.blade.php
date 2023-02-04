

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
    <div class="bg0 p-t-75 p-b-85" >
        @csrf
        <div class="container" style="max-width: 1320px">
            @if(session()->has('message'))
                <div class="alert alert-success" style="margin-left: 64px;margin-right: 370px">
                    {!! session()->get('message') !!}
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger">
                    {!!session()->get('error')!!}
                </div>
            @endif
            <div class="row">
                <div class="col-sm-10 col-lg-7 col-xl-9 {{--m-lr-auto--}} m-b-50 " >
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            1. Delivery address
                        </h4>




                      <div class="row m-b-30 bor12 p-b-25 ">
                          @if(Session::get('shippingInfo'))
                              @php $shippingInfo = Session::get('shippingInfo') @endphp
                          <div class="col-xl-4">
                                <div>
                                    Name: {{$shippingInfo['fullName']}}
                              </div>
                              <div>
                                  Phone : {{$shippingInfo['phone']}}
                              </div>
                          </div>
                          <div class="col-xl-6">
                                 <div> {{$shippingInfo['addressDetails']}}. </div>
                              <div>" {{$shippingInfo['ward']}} - {{$shippingInfo['district']}} - {{$shippingInfo['province']}} "</div>
                          </div>

                              <div class="col-xl-2 m-auto">
                                  <a href="" data-toggle="modal" data-target="#modalInfo">Change Information</a>
                              </div>
                              <input type="hidden" value="{{$shippingInfo['fullName']}}" class="shippingEmail" />
                              <input type="hidden" value="{{$shippingInfo['fullName']}}" class="shippingName" />
                              <input type="hidden" value="{{$shippingInfo['addressDetails']}}" class="shippingAddress"/>
                              <input type="hidden" value="{{$shippingInfo['phone']}}" class="shippingPhone"/>
                          @else
                              <div class="col-xl-10">
                                  <h5 style="color: #e34949">Add a Shipping Address , please !</h5>
                              </div>
                              <div class="col-xl-2 m-auto">
                                  <a href="" data-toggle="modal" data-target="#modalInfo">Add Information</a>
                              </div>
                              @endif



                       <style> #modalInfo{z-index: 9999;}</style>
                          <!-- Modal SHIPPING INFO -->
                                               {{-- form trong form sẽ không được nó chỉ hiện 1 form ở ngoài thôi--}}
                              <div class="modal fade" id="modalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                  <!--Content-->
                                  <div class="modal-content form-elegant">
                                      <!--Header-->
                                      <div class="modal-header text-center">
                                          <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel"><strong>New Address</strong></h3>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <!--Body-->

                                      <div class="modal-body mx-4">
                                          <!--Body-->
                                          <form action = "{{URL::to('/updateShippingInfo')}}" method="POST" >
                                              @csrf
                                                        <div style="display: flex">
                                                            <div class="form__group field  m-all-35">
                                                                <input type="input" class="form__field" placeholder="Name" name="fullName"  value="{{Session::get('customerName')}}" required />
                                                                <label for="name" class="form__label">Full Name</label>
                                                            </div>

                                                            <div class="form__group field  m-all-35">
                                                                <input type="input" class="form__field  cl2" placeholder="Phone" name="phone"  required />
                                                                <label for="name" class="form__label">Phone</label>
                                                            </div>
                                                        </div>
                                                         <div>
                                                        <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-32">
                                                            <select class="js-select2 chooseAddress" id="province" name="provinceId" required>
                                                                <option >Select a city...</option>
                                                                @foreach($allCity as $key => $province)
                                                                    <option value="{{$province->province_id}}">{{$province->province_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="dropDownSelect2"></div>
                                                        </div>
                                                        <div class="rs1-select2 rs2-select2 bor8 bg0 m-tb-32">
                                                            <select class="js-select2 chooseAddress" id="district" name="districtId" required>
                                                                <option value="">Select a province...</option>
                                                            </select>
                                                            <div class="dropDownSelect2"></div>
                                                        </div>
                                                        <div class="rs1-select2 rs2-select2 bor8 bg0 m-t-32 m-b-15">
                                                            <select class="js-select2" id="ward" name="wardId" required>
                                                                <option>Select a ward...</option>
                                                            </select>
                                                            <div class="dropDownSelect2"></div>
                                                        </div>
                                                    </div>


                                              <div class="form__group field m-b-40" style="width: 100%">
                                                  <input type="input" class="form__field  cl2" placeholder="addressDetails" name="addressDetails" required />
                                                  <label for="name" class="form__label">Address Details</label>
                                              </div>

                                              <div class="text-center mb-3">
                                                  <button type="submit" class="btn blue-gradient btn-block btn-rounded z-depth-1a btn-dark">Done</button>
                                              </div>


                                          </form>

                                      </div>

                                      <!--Footer-->
                                      <div class="modal-footer mx-5 pt-3 mb-1">
                                          <p class="font-small grey-text d-flex justify-content-end">Not a member? <a href="#" class="blue-text ml-1">
                                                  Done</a></p>
                                      </div>
                                  </div>
                                  <!--/.Content-->
                              </div>
                          </div>
                          <!-- END Modal SHIPPING INFO  -->


                      </div>

                        <h4 class="mtext-109 cl2 p-b-12">
                            2.Shipping Carrier
                        </h4>
                        <div class="row m-b-55 bor12 p-b-20">
                            @php $feeship = 0 @endphp
                            @if(Session::get('shippingCarrier') && Session::get('chooseShippingCarrier') )
                                @foreach(Session::get('shippingCarrier') as $key => $shippingCarrier)
                                    @if( Session::get('chooseShippingCarrier') == $shippingCarrier['code'])
                                        @php $feeship = $shippingCarrier['feeship']@endphp
                            <div class="col-xl-8">
                                <div class="m-tb-35">
                                    <div> <span class="mtext-109">{{$shippingCarrier['name']}} </span> <span class="m-lr-50"></span></div>
                                    <div>Nhận hàng vào ngày : {{$shippingCarrier['leadtime']}}</div>
                                    <input type="text"  class="stext-104 cl2 plh4 size-119 bor19 p-lr-20 m-r-10 m-t-25 shippingNotes"  placeholder="Notes" style="width: 355px;height: 45px">

                                </div>

                            </div>
                            <div class="col-xl-2">
                                <div class="m-tb-35"><p class="mtext-101 text-success">{{number_format($shippingCarrier['feeship'],0,',','.')}}đ</p></div>
                                <input type="hidden" value="{{$shippingCarrier['feeship']}}" class="orderFeeship">
                                <input type="hidden" value="{{$shippingCarrier['code']}}" class="shippingMethodCode">
                            </div>
                            <div class="col-xl-2">
                               <div class="m-tb-35"><a href="#"  data-toggle="modal" data-target="#modalShippingCarrier" >Change</a></div>
                            </div>
                                    @endif
                                @endforeach

                            @elseif(Session::get('shippingCarrier'))
                                @foreach(Session::get('shippingCarrier') as $key => $shippingCarrier)
                                    @php $feeship = $shippingCarrier['feeship']@endphp
                                        <div class="col-xl-8">
                                            <div class="m-tb-35">
                                                <div> <span class="mtext-109">{{$shippingCarrier['name']}} </span> <span class="m-lr-50"></span></div>
                                                <div>Nhận hàng vào ngày : {{$shippingCarrier['leadtime']}}</div>
                                                <input type="text"  class="stext-104 cl2 plh4 size-119 bor19 p-lr-20 m-r-10 m-t-25 shippingNotes"  placeholder="Notes" style="width: 355px;height: 45px">

                                            </div>

                                        </div>
                                        <div class="col-xl-2">
                                            <div class="m-tb-35"><p>{{number_format($shippingCarrier['feeship'],0,',','.')}}đ</p></div>
                                            <input type="hidden" value="{{$shippingCarrier['feeship']}}" class="orderFeeship">
                                            <input type="hidden" value="{{$shippingCarrier['code']}}" class="shippingMethodCode">
                                        </div>
                                        <div class="col-xl-2">
                                            <div class="m-tb-35"><a href="#"  data-toggle="modal" data-target="#modalShippingCarrier" >Change</a></div>
                                        </div>
                                    @break
                                @endforeach

                            @else
                                <div class="col-xl-8">
                                    <div class="m-tb-35">
                                        <div> <span class="mtext-109">Không có hình thức vận chuyển đến địa chỉ này </span></div>
                                    </div>

                                </div>
                                @endif
                        </div>


                        <style> #modalShippingCarrier{z-index: 9999;}</style>
                        <!-- Modal SHIPPING INFO -->
                        {{-- form trong form sẽ không được nó chỉ hiện 1 form ở ngoài thôi--}}
                        <div class="modal fade" id="modalShippingCarrier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <!--Content-->
                                <div class="modal-content form-elegant">
                                    <!--Header-->
                                    <div class="modal-header text-center">
                                        <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel"><strong>Choose Shipping Carrier</strong></h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <!--Body-->
                                @php
                                    $chooseShippingCarrier ='';
                                    if(Session::get('chooseShippingCarrier')){
                                        $chooseShippingCarrier = Session::get('chooseShippingCarrier');
                                    }
                                 @endphp
                                    <div class="modal-body mx-4">
                                        <!--Body-->
                                        <form action = "{{URL::to('/chooseShippingCarrier')}}" method="POST" >
                                            @csrf
                                            @if(Session::get('shippingCarrier'))
                                                @foreach(Session::get('shippingCarrier') as $key => $shippingCarrier)
                                            <div class="form-check bor12 m-all-35 p-b-35">
                                                <input class="form-check-input" type="radio" name="shippingCode" id="{{$shippingCarrier['code']}}" value="{{$shippingCarrier['code']}}" {{$chooseShippingCarrier == $shippingCarrier['code'] ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{$shippingCarrier['code']}}">
                                                    <span class="mtext-109">{{$shippingCarrier['name']}}</span>  <span class="mtext-110 m-l-35 text-success">{{number_format($shippingCarrier['feeship'],0,',','.')}}đ</span>
                                                   <p>Nhận hàng vào ngày : {{ $shippingCarrier['leadtime'] }}</p>
                                                    <p>Cho phép thanh toán khi nhận hàng</p>
                                                </label>
                                            </div>
                                                @endforeach
                                            @endif


                                            <div class="text-center mb-3">
                                                <button type="submit" class="btn blue-gradient btn-block btn-rounded z-depth-1a btn-dark">done</button>
                                            </div>


                                        </form>

                                    </div>

                                    <!--Footer-->
                                    <div class="modal-footer mx-5 pt-3 mb-1">
                                        <p class="font-small grey-text d-flex justify-content-end">Not a member? <a href="#" class="blue-text ml-1">
                                                Done</a></p>
                                    </div>
                                </div>
                                <!--/.Content-->
                            </div>
                        </div>
                        <!-- END Modal SHIPPING INFO  -->




                        <h4 class="mtext-109 cl2 p-b-10">
                           3. Payment method
                        </h4>
                        <div class="row m-b-55 bor12">
                            <div class="flex-w flex-sb-m p-t-18 p-b-15 p-lr-15-sm ">
                                <div class="flex-w flex-m m-r-20 m-tb-5">
                                    <style>
                                        .activePayment{
                                          border: 3px solid #94f399;
                                        }
                                        .momo {
                                            color: #B53471;
                                            font-size: 18px;
                                            background-color: #B53471;
                                            color: white;
                                            font-size: 18px;
                                        }

                                        .textPayment{
                                            font-family: Poppins-Medium;
                                            font-size: 15px;
                                        }
                            #choosePaymentMethod{
                                display: flex;
                            }
                            #iconCheck{
                                float: right;
                                margin-top: 24px;
                                position: absolute;
                                margin-left: 95px;
                                color: #94f399;
                            }
                                    </style>
                                    <div id="choosePaymentMethod">
                                        <button type="button" class="flex-c-m textPayment  size-112 bg9 bor13 hov-momo p-lr-15 trans-04 pointer m-all-5 momo paymentMethod" style="font-size: 18px">
                                            momo

                                        </button>
                                        <button type="button" class="flex-c-m textPayment cl2 size-112 bg9 bor13 hov-btn3 p-lr-15 trans-04 pointer m-all-5 handCash paymentMethod">
                                            Hand cash
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>




                        <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer sendOrder">
                             Checkout
                        </button>
                    </div>
                </div>

                <div class="col-lg-10 col-xl-3 m-lr-auto m-b-50" id="orderRecap">
                    <div class="m-r--38 m-lr-0-xl bor10 p-lr-15 ">

                        <div class="header-cart-title flex-w flex-sb-m p-b-8">
                                    <span class="mtext-103 cl2">
                                        Order Recap ( tóm tắt đơn hàng)
                                    </span>
                        </div>

                        <div class="header-cart-content flex-w js-pscroll bor12">
                            <ul class="header-cart-wrapitem w-full">
                                @php $subTotal = 0; @endphp
                                @if(Session::get('cart'))
                                    @foreach(Session::get('cart') as $key => $cart)
                                        <li class="header-cart-item flex-w flex-t m-b-12">
                                            <div class="header-cart-item-img" style="margin-right: 38px">
                                                <img src="{{url('public/uploads/products/'.$cart['product_image'])}}" alt="IMG">
                                            </div>

                                            <div class="p-t-8">
                                                <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                                    {{$cart['product_name']}}
                                                </a>

                                                <span class="header-cart-item-info">
								{{$cart['product_qty']}} x {{number_format($cart['product_price'],0,',','.')}}đ
							</span>
                                            </div>
                                        </li>

                                        @php $subTotal += $cart['product_qty']*$cart['product_price']; @endphp
                                    @endforeach
                                @endif
                            </ul>

                            @php
                                $discount = 0;
                              $coupon = Session::get('coupon');
                                if($coupon){
                                    if($coupon['coupon_condition'] == 1){// bằng 1 là giảm theo phần trăm
                                        $discount = ($coupon['coupon_number']*$subTotal)/100;
                                    }else{
                                        $discount = $coupon['coupon_number'];
                                    }
                                }
                            @endphp


                            @if( Session::get('coupon'))
                                @php  $coupon = Session::get('coupon'); @endphp
                                <input type="hidden" class="orderCoupon" value="{{$coupon['coupon_code']}}">
                            @else
                                <input type="hidden" class="orderCoupon" value="no">
                                @endif
                            <div class="w-full">


                            <div class="flex-w flex-t p-b-15 p-t-40">
                                <div class="size-208">
                                    <span class="stext-110  cl2">
                                   Sub total:
                                    </span>
                                </div>
                                <div class="size-209">
                                    <span class="mtext-110  cl2">
                                    {{number_format($subTotal,0,',','.')}}đ
                                    </span>
                                </div>
                            </div>
                                <div class="flex-w flex-t p-b-15">
                                    <div class="size-208">
                                        <span class="stext-110  cl2">
                                              Discount:
                                        </span>
                                    </div>
                                    <div class="size-209">
                                        <span class="mtext-110  cl2">
                                      -   {{number_format($discount,0,',','.')}}đ
                                        </span>
                                    </div>
                                </div>
                                <div class="flex-w flex-t p-b-15">
                                    <div class="size-208">
                                        <span class="stext-110  cl2">
                                             Feeship:
                                        </span>
                                    </div>
                                    <div class="size-209">
                                        <span class="mtext-110  cl2">
                                         +    {{number_format($feeship,0,',','.')}}đ
                                        </span>
                                    </div>
                                </div>


                            </div>
                        </div>


                        @php $total = $subTotal - $discount + $feeship@endphp
                        <div class="flex-w flex-t p-t-20 p-b-33 ">
                            <div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
                            </div>

                            <div class="size-209 p-t-1">
								<span class="mtext-110 cl2">
                                    <input type="hidden" class="orderAmount" value="{{$total}}">
									{{number_format($total,0,',','.')}}đ
								</span>
                            </div>
                        </div>

                        <div class="flex-w flex-sb-m p-t-18 p-b-15 p-lr-15-sm ">
                            <div class="flex-w flex-m m-r-20 m-tb-5">

                                <input type="text"  class="stext-104 cl2 plh4 size-112 bor13 p-lr-20 m-r-10 m-tb-5" id="couponCode"name="couponCode" placeholder="Coupon Code" style="width: 200px">

                                <div class="flex-c-m stext-101 cl2 size-112 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5" style="min-width: 68px">
                                    <button type="button" class="checkCoupon" style="width: 100%;height: 100%">Apply</button>
                                </div>

                            </div>
                        </div>





                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


