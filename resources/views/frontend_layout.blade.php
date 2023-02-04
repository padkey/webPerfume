<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('public/frontend2/images/icons/favicon.png')}}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/fonts/iconic/css/material-design-iconic-font.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/fonts/linearicons-v1.0.0/icon-font.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/vendor/css-hamburgers/hamburgers.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/vendor/animsition/css/animsition.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/vendor/daterangepicker/daterangepicker.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/vendor/slick/slick.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/vendor/MagnificPopup/magnific-popup.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/vendor/perfect-scrollbar/perfect-scrollbar.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/frontend2/css/main.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/css/app.css')}}">


    <meta name="csrf-token" content="{{csrf_token()}}">  <!--token -->

    <!--===============================================================================================-->
</head>
<body class="animsition">

<!-- Header -->

@yield('header')
<!-- Cart -->
<div class="wrap-header-cart js-panel-cart">
    <div class="s-full js-hide-cart"></div>

    <div class="header-cart flex-col-l p-l-65 p-r-25">
        <div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

            <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                <i class="zmdi zmdi-close"></i>
            </div>
        </div>

        <div class="header-cart-content flex-w js-pscroll">
            <ul class="header-cart-wrapitem w-full">
                @php $subTotal = 0; @endphp
                @if(Session::get('cart'))
                @foreach(Session::get('cart') as $key => $cart)
                <li class="header-cart-item flex-w flex-t m-b-12">
                    <div class="header-cart-item-img">
                        <img src="{{url('public/uploads/products/'.$cart['product_image'])}}" alt="IMG">
                    </div>

                    <div class="header-cart-item-txt p-t-8">
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

            <div class="w-full">
                <div class="header-cart-total w-full p-tb-40">
                    Total: {{number_format($subTotal,0,',','.')}}đ
                </div>

                <div class="header-cart-buttons flex-w w-full">
                    <a href="{{url('/showCart')}}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                        View Cart
                    </a>

                    <a href="#" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10 checkoutPage">
                        Check Out
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Slider -->



<!-- Banner -->
@yield('banner')



<!-- Product -->

@yield('content')

<!-- Footer -->
<footer class="bg3 p-t-75 p-b-32">
    <div class="container" style="max-width: 1320px;">
        <div class="row">
            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    <img width="80%" src="{{url('public/uploads/contact/'.$contact->info_logo)}}" alt="">
                </h4>

                <ul>
                    <li class="p-b-10">
                        <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                            {{$contact->info_slogan}}
                        </a>
                    </li>

                </ul>
            </div>
            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Service
                </h4>

                <ul>
                    @foreach($postFooter as $key => $post)
                    <li class="p-b-10">
                        <a target="_blank" href="{{url('/postDetail/'.$post->post_slug)}}" class="stext-107 cl7 hov-cl1 trans-04">
                            {{$post->post_title}}
                        </a>
                    </li>
                    @endforeach
                </ul>

            </div>



            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    GET IN TOUCH
                </h4>

                <p class="stext-107 cl7 size-201">
                    Any questions? Let us know in store at {{$contact->info_address}} or call us on {{$contact->info_phone}}
                    {!! $contact->info_fanpage !!}
                </p>

                <div class="p-t-27">
                    @foreach($allIcon as $key => $icon)
                    <a href="{{$icon->icon_link}}" target="_blank" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                        <img width="15%" src="public/uploads/icons/{{$icon->icon_image}}" alt="{{$icon->icon_name}}">
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Newsletter
                </h4>

                <form>
                    <div class="wrap-input1 w-full p-b-4">
                        <input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
                        <div class="focus-input1 trans-04"></div>
                    </div>

                    <div class="p-t-18">
                        <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                            Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="p-t-40">
            <div class="flex-c-m flex-w p-b-18">
                <a href="#" class="m-all-1">
                    <img src="{{url('public/frontend2/images/icons/icon-pay-01.png')}}" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="{{url('public/frontend2/images/icons/icon-pay-02.png')}}" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="{{url('public/frontend2/images/icons/icon-pay-03.png')}}" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="{{url('public/frontend2/images/icons/icon-pay-04.png')}}" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="{{url('public/frontend2/images/icons/icon-pay-05.png')}}" alt="ICON-PAY">
                </a>
            </div>

            <p class="stext-107 cl6 txt-center">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a> &amp; distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

            </p>
        </div>
    </div>
</footer>


<!-- Back to top -->
<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
</div>




<!--===============================================================================================-->
<script src="{{asset('public/frontend2/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('public/frontend2/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('public/frontend2/vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('public/frontend2/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('public/frontend2/vendor/select2/select2.min.js')}}"></script>
<script>
    $(".js-select2").each(function(){
        $(this).select2({
            minimumResultsForSearch: 20,
            dropdownParent: $(this).next('.dropDownSelect2')
        });
    })
</script>
<!--===============================================================================================-->
<script src="{{asset('public/frontend2/vendor/daterangepicker/moment.min.js')}}"></script>
<script src="{{asset('public/frontend2/vendor/daterangepicker/daterangepicker.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('public/frontend2/vendor/slick/slick.min.js')}}"></script>
<script src="{{asset('public/frontend2/js/slick-custom.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('public/frontend2/vendor/parallax100/parallax100.js')}}"></script>
<script>
    $('.parallax100').parallax100();
</script>



{{--Quên mật khẩu--}}
<script>
    $(document).on('click','.forgetPassword',function(){
        var emailForget = $('.emailForget').val();

        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:'{{url('/forgetPassword')}}',
            method:'POST',
            data:{emailForget:emailForget,_token:_token},
            success:function(data){
                if(data === '-1'){
                    swal('Error!','This email is not registered!','error');
                }else{
                    swal('Good job!','Check your email to reset password!','success');
                }
            }
        });
    });
</script>
<script>

    $(document).on('click','.updatePasswordCustomer',function(){
        var email = $('.emailCustomer').val();
        var password = $('.passwordCustomer').val();
        var repassword = $('.repasswordCustomer').val();
        var _token = $('input[name="_token"]').val();
        if(password === repassword){
            $.ajax({
                url:'{{url('/updatePasswordReset')}}',
                method:'POST',
                data:{email:email,password:password,_token:_token},
                success:function(data){
                    swal('Good job!','Password reset successful!','success');
                    setTimeout(function (){window.location.href = '/shopperfume/home'},2000);
                }
            });
        }else{
            swal('Error!','Passwords do not match!','error');
        }

    });
</script>

{{--Thay đổi mật khẩu--}}
<script>

    $('.changePassword').click(function (){
       oldPassword = $('.oldPassword').val();
       newPassword = $('.newPassword').val();
       confirmNewPassword = $('.confirmNewPassword').val();

       if(newPassword !== confirmNewPassword){
           swal('Error!','Password dose not match!','error');
           $('.newPassword').css('border-bottom-color','#d21515');
           $('.confirmNewPassword').css('border-bottom-color','#d21515');
          // $('.password').css('color','#d21515');
       }else{
           $('.newPassword').css('border-bottom-color','#2196f3');
           $('.confirmNewPassword').css('border-bottom-color','#2196f3');
           $('.oldPassword').css('border-bottom-color','#2196f3');
           $('.password').css('color','#2196f3');
           $.ajax({
                    url:'{{url('/changePassword')}}',
                    method:'POST',
               headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               data:{oldPassword:oldPassword,newPassword:newPassword,confirmNewPassword:confirmNewPassword},
               success:function (data){
                        if(data == -1){
                            swal('Error!','Incorrect password!','error');
                            $('.oldPassword').css('border-bottom-color','#d21515');
                        }else{
                            swal('Good job!','Profile edit successful!','success');
                            setTimeout(function (){location.reload()},2000);
                        }
               }
           });
       }
    });
</script>
{{--Show password--}}
<script>
    //nếu checkbox có thay đổi thì
    $('.showPassword').change(function (){
        //kiểm tra check hay bõ check
        if(this.checked){
            // thay đổi giá trị của type= text
            $('.oldPassword').attr('type','text');
            $('.newPassword').attr('type','text');
            $('.confirmNewPassword').attr('type','text');
        }else{
            // thay đổi giá trị của type= password
            $('.oldPassword').attr('type','password');
            $('.newPassword').attr('type','password');
            $('.confirmNewPassword').attr('type','password');
        }

    });

</script>
{{--chỉnh sửa thông tin cá nhân--}}
<script>
    $('.editProfileCustomer').click(function (){
        var name = $('.customerName').val();
        var phone = $('.customerPhone').val();
        var address = $('.customerAddress').val();

        var vnf_regex = /((0)+([0-9]{9})\b)/g;// số đầu phải là số 0 và các số sau là số từ 0-9 và có 9 số sau. tổng là 1 số đầu với 9 số sau là 10 số
        if(vnf_regex.test(phone) == false){ //nếu sđt không hợp lệ
            swal('Error!','This phone number is not valid!','error');
            $('.phoneRegister').css('border-bottom-color','#d21515');
            $('.phone').css('color','#d21515');
        }else {
            $.ajax({
                url:'{{url("/editProfileCustomer")}}',
                method:'POST',
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{name:name,phone:phone,address:address},
                success:function (data){
                    swal('Good job!','Profile edit successful!','success');
                        setTimeout(function (){location.reload()},2000);
                }
            })
        }


    })
</script>
{{--Login--}}
<script type="text/javascript">

    $('.customerLogin').click(function (){
        var emailAccount = $('.emailAccount').val();
        var passwordAccount = $('.passwordAccount').val();
            $.ajax({
                url:'{{URL::to("/customerLogin")}}',
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{emailAccount:emailAccount,passwordAccount:passwordAccount},
                success:function (data){
                    if(data === '-1'){
                        swal('Error!','Incorrect email or password!','error');
                    }else{
                        swal('Good job!','','success');
                        setTimeout(function (){location.reload()},2000); // 2 giây nữa sẽ load lại trang
                    }
                }
            })


    });

</script>

{{--Register--}}
<script type="text/javascript">

    $('.customerRegister').click(function (){
            var name = $('.nameRegister').val();
        var phone = $('.phoneRegister').val();
        var email = $('.emailRegister').val();
        var password = $('.passwordRegister').val();
        var repassword = $('.repassword').val();
        var vnf_regex = /((0)+([0-9]{9})\b)/g;// số đầu phải là số 0 và các số sau là số từ 0-9 và có 9 số sau. tổng là 1 số đầu với 9 số sau là 10 số
        if(vnf_regex.test(phone) == false){ //nếu sđt không hợp lệ
            swal('Error!','This phone number is not valid!','error');
            $('.phoneRegister').css('border-bottom-color','#d21515');
            $('.phone').css('color','#d21515');
        }
        else if(password !== repassword){
            swal('Error','Password dose not match!','error');
            $('.passwordRegister').css('border-bottom-color','#d21515');
            $('.repassword').css('border-bottom-color','#d21515');
            $('.password').css('color','#d21515');
        }
        else{
            // cho các ô input trở về màu bth
            $('.passwordRegister').css('border-bottom-color','#2196f3');
            $('.repassword').css('border-bottom-color','#2196f3');
            $('.password').css('color','#2196f3');
            $('.email').css('color','#2196f3');
            $('.emailRegister').css('border-bottom-color','#2196f3');
            $('.phoneRegister').css('border-bottom-color','#2196f3');
            $('.phone').css('color','#2196f3');
            $.ajax({
                url:'{{URL::to("/customerRegister")}}',
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{name:name,phone:phone,email:email,password:password,repassword:repassword},
                success:function (data){
                    if(data == -1){
                        swal('Error!','This email already exists!','error');
                        $('.email').css('color','#d21515');
                        $('.emailRegister').css('border-bottom-color','#d21515');
                    }else if(data == 1){

                        swal('Good job!','Account registered successfully!','success');
                        setTimeout(function (){location.reload()},2000); // 2 giây nữa sẽ load lại trang
                    }
                }
            })
        }
      /*  */


    });

</script>



<script type="text/javascript">
    $(document).ready(function (){
        $('.sendOrder').click(function(){
            var shippingEmail = $('.shippingEmail').val();
            var shippingAddress = $('.shippingAddress').val();
            var shippingName = $('.shippingName').val();
            var shippingPhone = $('.shippingPhone').val();
            var shippingNotes = $('.shippingNotes').val();
            //phí ship và hãng vận chuyển
            var shippingMethodCode = $('.shippingMethodCode').val();
            var orderFeeship = $('.orderFeeship').val();
            var orderCoupon = $('.orderCoupon').val();

            var orderAmount = $('.orderAmount').val();
            var checkMomo = $('.momo').hasClass('activePayment');
            var checkHandCash = $('.handCash').hasClass('activePayment');
            var _token = $('input[name="_token"]').val();
   if(!shippingName || !shippingAddress || !shippingPhone){
       swal('Error','You have not filled shipping information!','error');
   }
   else if(!shippingMethodCode || !orderFeeship){
       swal('Error','Do not have any shipping method!','error');
   }
   else if(!checkMomo && !checkHandCash){
       swal('Error','Choose a payment method,please!','error');
   }
   else{
       if(checkMomo){
           var paymentMethodCode = 'momo';
       }else if(checkHandCash){
           var paymentMethodCode ='handcash';
       }

           swal({
               title: "Order confirmation!",
               text: "Are you sure to order?",
               icon: "info",
               buttons: {
                   cancel:'No',
                   cofirm:'Yes, i am sure'
               },

           }).then((confirm) => {
               if (confirm) {

                   $.ajax({
                       url:'{{URL::to('/confirmOrder')}}',
                       method:'POST',
                       dataType:'JSON',
                       data:{
                           shippingEmail:shippingEmail,
                           shippingAddress:shippingAddress,
                           shippingName:shippingName,
                           shippingNotes:shippingNotes,
                           shippingPhone:shippingPhone,
                           orderCoupon:orderCoupon,
                           orderFeeship:orderFeeship,
                           shippingMethodCode:shippingMethodCode,
                           paymentMethodCode:paymentMethodCode,
                           orderAmount:orderAmount,
                           _token:_token
                       },
                       success:function(data){
                           //nếu thanh toán bằng momo thì
                           if(data['paymentMethodCode'] === 'momo'){
                               swal("momo", {
                                   icon: "success",
                               });

                               $.ajax({
                                   url:'{{URL::to('/paymentByMomo')}}',
                                   method:'POST',
                                   data:{
                                       orderCode:data['orderCode'],
                                       requestId:data['requestId'],
                                       _token:_token
                                   },
                                   success:function(data){
                                        location.href = data;

                                   }});


                           }else if(data['paymentMethodCode'] === 'handcash'){
                               swal("handcash", {
                                   icon: "success",
                               });
                           }

                          /* swal("You already order successfully", {
                               icon: "success",
                           });*/
                       },

                   });
                   //khi ajax chạy xong thì ta cho 5 giây sau load lại trang
                   window.setTimeout(function(){ window.location.href = '/shopperfume/orderHistory/0'},1500); // 1.5 giây thì nó reset lại trang
               }
           });





   }







        });
    });
</script>

<script>
    //check payment method
    var choosePaymentMethod = document.getElementById('choosePaymentMethod');
    var methods = choosePaymentMethod.getElementsByClassName('paymentMethod');
    for( var i = 0 ; i < methods.length ; i++){
        //Thêm sự kiện click vào mỗi button
        methods[i].addEventListener("click",function (){
            // lấy cái button nào hiện tại có class activePayment
            var current = document.getElementsByClassName('activePayment');
            if(current[0]){
                //xóa dòng nào có class là activePayment để thêm mới lại
                current[0].className = current[0].className.replace(' activePayment',''); //replace là hàm thay thế
                //   current[0].innerHTML
                //xóa thẻ div có class là iconCheck
                var checked = document.getElementById('iconCheck');
                checked.remove();
            }
            this.className += " activePayment";
            this.innerHTML = this.innerHTML + '<div id="iconCheck"><i class="fa fa-check"></i></div>';
            //class active vào button vừa click
            // $(this).addClass(' activePayment');
        });
    }

    /*$('.momo').click(function (){
       $(this).toggleClass('activePayment'); // có rồi thì bõ, chưa có thì thêm class
    });
    $('.paypal').click(function (){
        $(this).toggleClass('checkPaypal');
        $('.momo').removeClass('checkMomo');
    })*/
</script>

<script>
    selectShippingCarrier();
    function selectShippingCarrier(){
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:'{{URL('/selectShippingCarrier')}}' ,
            method:'POST',
            data:{
                _token:_token
            },
            success:function (data){

            }
        });

    }

  /*  $('#updateShippingInfo').click(function (){
        var fullName = $('.newName').val();
        var phone = $('.newPhone').val();
        var provinceId =  $('#province').val();
        var wardId =  $('#ward').val();
        var districtId =  $('#district').val();
        var addressDetails = $('.newAddressDetails').val();
        alert(fullName);
        alert(phone);
        alert(addressDetails)

        var _token = $('input[name="_token"]').val();
    /!*   $.ajax({
            url:'{{URL('/updateShippingInfo')}}',
            method:'POST',
           headers:{'X-CSRF-TOKEN': _token},
            data: {fullName:fullName,phone:phone,provinceId:provinceId,wardId:wardId,districtId:districtId,addressDetails:addressDetails},

            success:function(data){
               selectShippingCarrier();
            //settime out để có thể chạy hàm ở trên, không có thì hàm trên k kịp chạy
               setTimeout(function (){ location.reload()} ,100);
            }

        });*!/
    });*/
</script>
<script>
    function ensureloggedin(){
        var _token = $('input[name="_token"]').val();
        var result = 0;
         $.ajax({
            url:'{{URL('/ensureLoggedIn')}}' ,
            method:'POST',
            async: false, // để cái này thì mới return về đúng giá trị
            data:{
                _token:_token
            },
            success:function (data){
                result =data; // data = -1 là chưa loggin
            }
        });
        return result;
    }

        $('.checkoutPage').click(function (){
            //kiểm tra loggin
                    if(ensureloggedin() == -1){
                        $('#modalLogin').modal('show');
                        swal('Error!','You must login to continue!','error')
                    }else{
                        window.location.href = '{{url('/checkout')}}';
                    }
        });

</script>


<script>
    // khi trang web scroll thì sẽ vào hàm myFunction()
    window.onscroll = function() {myFunction()};

    // lấy dòng có id là navbar
    var navbar = document.getElementById("orderRecap");

    // khi kéo xuống thì navber dính vào top:0
    var sticky = navbar.offsetTop; //offsetTop vị trí tọa độ y

    // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {
        if (window.pageYOffset >= sticky) { //khi trang web kéo xuống vượt tọa độ của id navbar thì thêm class sticky
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky"); // không thì remove nó đi
        }
    }
</script>

{{--Delivery feeship--}}
<script type="text/javascript">
    $(document).ready(function (){
        $('#calculateDelivery').click(function (){
            var cityId = $('#city').val();
            var provinceId = $('#province').val();
            var wardsId = $('#wards').val();
            var _token = $('input[name="_token"]').val();
            //kiểm tra người dùng nhập đủ trường chưa
            if(cityId ==''  || provinceId == '' || wardsId == ''){
                swal('Error!','Please fill in the full address!','error')
            }else{
                $.ajax({
                    url:'{{URL('/calculateFeeship')}}' ,
                    method:'POST',
                    data:{
                        cityId:cityId,
                        provinceId:provinceId,
                        wardsId:wardsId,
                        _token:_token
                    },
                    success:function (data){
                        //cho load lại thẻ div tính tiền thanh toán để cập nhật tổng tiền khi thêm feeship
                        setTimeout(function (){location.reload()},1500);
                         swal('Good job!','Updated feeship successfully','success')

                    }
                });
            }

        });


        $('.chooseAddress').change(function(){
            //lấy id, tên id chứa tên table ta cần để truy vấn
            var action = $(this).attr('id');
            //value sẽ chứa id của table
            var id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
            if(action == 'province'){
                result = 'district';
            }else{
                result = 'ward';
            }
            $.ajax({
                url:'{{URL('/selectDeliveryHome')}}',
                method:'POST',
                data:{
                    action:action,
                    id:id,
                    _token:_token
                },
                success:function(data){
                    $('#'+result).html(data);
                }
            });
        });
    });

</script>
{{--Coupon--}}
<script>
    $('.checkCoupon').click(function (){
        var couponCode = $('#couponCode').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:'{{URL('/checkCoupon')}}',
            method:'POST',
            data:{
                couponCode:couponCode,
                _token:_token
            },
            success:function(data){
                if(data == 1){
                    swal('Good job!',' Apply coupon successful!','success');
                    setTimeout(function (){location.reload()},1800);
                }else if(data == -1){
                    swal('Error!','This coupon code used!','error');
                }
                else {
                    swal('Error!','This coupon does not exist or expire!','error');
                }
            }


        });
    })
</script>
{{--Cart--}}
<script type="text/javascript">
    showCartQty();
    function showCartQty(){
        $.ajax({
           url:'{{url('/showCartQty')}}',
           method:'GET',
           success:function (data){

                document.getElementById('showCartQty').setAttribute('data-notify',data);

           }
        });
    }

    $(document).on('click','.add-to-cart',function (){
        var id = $(this).data('id');
        var cartProductId = $('.cartProductId-'+id).val();
        var cartProductName = $('.cartProductName-'+id).val();
        var cartProductQty = $('.cartProductQty-'+id).val();
        var qtyProductInStock = $('.qtyProductInStock-'+id).val();
        var cartProductImage = $('.cartProductImage-'+id).val();
        var cartProductPrice = $('.cartProductPrice-'+id).val();

        var _token = $('input[name="_token"]').val();
        //  alert(qtyProductInventory)
        //nếu số lượng khách đặt lớn hơn số lượng hàng trong kho thì không cho đặt
        // so sánh sản phẩm phải ép kiểu int mới so sánh được , ta xài hàm parseInt()
        if(parseInt(qtyProductInStock) == 0){
            swal({
                title: "Error",
                text: "Sản phẩm này đã hết !",
                icon:'error',
            })
        }
        else if(parseInt(cartProductQty) > parseInt(qtyProductInStock)){
            swal({
                title: "Error",
                text: "Sản phẩm chỉ còn " + qtyProductInventory + " chai",
                icon:'error',
            });
        } else{
            $.ajax({
                url: '{{url('/addToCartAjax')}}',
                method:'POST',
                data:{
                    cartProductId:cartProductId,
                    cartProductName:cartProductName,
                    cartProductQty:cartProductQty,
                    cartProductImage:cartProductImage,
                    cartProductPrice:cartProductPrice,
                    qtyProductInStock:qtyProductInStock,
                    _token:_token
                },
                success:function (data){
                    swal({
                        title: "Đã thêm sản phẩm vào giỏ hàng",
                        text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                        buttons: {
                            cancel: 'xem tiếp',
                            confirm:'đi đến giỏ hàng'
                        },
                        icon:'success',
                    }).then((confirm) => {
                        if (confirm) {
                            window.location.href = "{{url('/showCart')}}";
                        }
                    });
                    showCartQty();
                    //showCartMenu();
                    $('.header-cart-content').load(location.href + ' .header-cart-content');
                },
            });
        }

    });
</script>


{{--Category Tab--}}
<script src="{{asset('resources/js/frontend/category/categoryTab.js')}}"></script>


<script>
    $(document).on('click','.cancelOrder',function (){
        var orderCode = $(this).data('order_code');
        var reason = $('#reason-'+orderCode).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url:'{{url('/cancelOrder')}}',
            method:'POST',
            data:{orderCode:orderCode,reason:reason,_token:_token},
            success:function(data){
                swal('Good job!',' Order cancelled successfully!','success');
                setTimeout(function (){location.reload()},1500)
            }
        });
    });
</script>


<script>
    $(document).on('click','.sort',function(){
        //lấy category slug hiện tại đang active
        categorySlug = $('.how-active1').data('category_slug');
        sortBy = $(this).data('sort_by');
      //chuyển đến đường dẫn này
             var   urlSort = 'productsByCategory/'+categorySlug+'?sortBy='+sortBy;
          window.location.href = '/shopperfume/'+urlSort;

    })
    //comment
    $(document).ready(function (){
        loadComment();
        function loadComment(){
            var productId = $('.commentProductId').val();

            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:'{{URL::to('/loadComment')}}',
                method:'POST',
                data:{productId:productId,_token:_token},
                success:function(data){
                    $('#showComment').html(data);
                }
            })
        }

        $(document).on('click','.sendComment',function(){
            var commentName = $('.commentName').val();
            var commentContent = $('.commentContent').val();
            var productId = $('.commentProductId').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:'{{url('/sendComment')}}',
                method:'POST',
                data:{commentName:commentName,commentContent:commentContent,productId:productId,_token:_token},
                success:function(data){
                    loadComment();
                    swal('Good job!','Comment is pending approval !','success');
                    //cho value ô comment và tên người dùng lại là rông
                    $('.commentContent').val('');
                    $('.commentName').val('');
                    //cho xuất hiện thêm thông báo lỡ người dùng chưa đọc kĩ cái alert
                    $('.notifyComment').html('<p style="color: #3c763d">Your comment is pending approval! </p>');
                    $('.notifyComment').fadeOut(5000); // 5 giây dòng thông báo sẽ biến mất
                }
            });
        });
    })
</script>


<script>
    $(document).ready(function(){
        $(document).on('click','.watchVideo',function (){
            var videoId = $(this).data('id');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:'{{url('/watchVideo')}}',
                method:'POST',
                dataType:"JSON",
                data:{videoId:videoId,_token:_token},
                success:function (data){
                    $('#videoTitle').html(data.videoTitle);
                    $('#videoLink').html(data.videoLink)
                }
            });
        });
    });
</script>




<!--===============================================================================================-->
<script src="{{asset('public/frontend2/vendor/MagnificPopup/jquery.magnific-popup.min.js')}}"></script>
<script>
    $(document).ajaxComplete(function(event,request,settings)
    {
        $('.gallery-lb').each(function() {
            $(this).magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery:{enabled:true}
            });
        });
    });

    //loadMore Products
    $('#loadMoreButton').click(function(){
        alert('dd');
    });



</script>


{{--SHOW Modal --}}
<script>
    function load_js()
    {
        var head= document.getElementsByTagName('body')[0];
        var script= document.createElement('script');
        script.src= 'http://localhost:8080/shopperfume/public/frontend2/js/slick-custom.js';
        head.appendChild(script);
    }
    function load_js3()
    {
        var head= document.getElementsByTagName('body')[0];
        var script= document.createElement('script');
        script.src= 'http://localhost:8080/shopperfume/public/frontend2/vendor/slick/slick.min.js';
        head.appendChild(script);
    }


    function showModal1(productName,productId){
        $('.js-modal'+productId).addClass('show-modal1');
    }
    function offModal1(productId){
        $('.js-modal'+productId).removeClass('show-modal1');
    }
</script>


<!--===============================================================================================
<script src="{{asset('public/frontend2/vendor/isotope/isotope.pkgd.min.js')}}"></script>-->
<!--===============================================================================================-->
<script src="{{asset('public/frontend2/vendor/sweetalert/sweetalert.min.js')}}"></script>
<script>
    $('.js-addwish-b2').on('click', function(e){
        e.preventDefault();
    });

    $('.js-addwish-b2').each(function(){
        var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
        $(this).on('click', function(){
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-b2');
            $(this).off('click');
        });
    });

    $('.js-addwish-detail').each(function(){
        var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

        $(this).on('click', function(){
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass('js-addedwish-detail');
            $(this).off('click');
        });
    });

    /*---------------------------------------------*/

    $('.js-addcart-detail').each(function(){
        var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
        $(this).on('click', function(){
            swal(nameProduct, "is added to cart !", "success");
        });
    });

</script>
<!--===============================================================================================-->
<script src="{{asset('public/frontend2/vendor/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script>
    $('.js-pscroll').each(function(){
        $(this).css('position','relative');
        $(this).css('overflow','hidden');
        var ps = new PerfectScrollbar(this, {
            wheelSpeed: 1,
            scrollingThreshold: 1000,
            wheelPropagation: false,
        });

        $(window).on('resize', function(){
            ps.update();
        })
    });
</script>
<!--===============================================================================================-->
<script src="{{asset('public/frontend2/js/main.js')}}"></script>

</body>
</html>
