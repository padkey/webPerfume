<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----------- SEO ------->
    <meta name="description" content="{{$metaDes}}">
    <meta name="author" content="">
    <meta name="keyword" content="{{$metaKeywords}}">
    <meta name="robots" content="INDEX,FOLLOW">
    <link rel="canonical" href="{{$urlCanonical}}">
    <!--------- END SEO --------->

    <title>{{$metaTitle}}</title>
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet"> <!-- sweetalert -->

    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="index.html"><img src="{{('public/frontend/images/logo.png')}}" alt="" /></a>
                    </div>
                    <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                USA
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canada</a></li>
                                <li><a href="#">UK</a></li>
                            </ul>
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                DOLLAR
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Canadian Dollar</a></li>
                                <li><a href="#">Pound</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-star"></i> Wishlist</a></li>
                            <li><a href="{{URL::to('/showCart')}}"><i class="fa fa-shopping-cart"></i> Cart</a></li>
                            <li><a href="{{URL::to('/showCartAjax')}}"><i class="fa fa-shopping-cart"></i> Cart</a></li>
                            <?php
                                $customerId = Session::get('customerId');
                                $customerName = Session::get('customerName');
                                if($customerId){ ?>
                            <li><a href="{{URL::to('/loginCheckout')}}"><i class="fa fa-user"></i> {{$customerName}}</a></li>
                            <li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Checkout</a></li>
                            <li><a href="{{URL::to('/logoutCheckout')}}"><i class="fa fa-lock"></i> Logout</a></li>
                                <?php }else{  ?>
                            <li><a href="{{URL::to('/loginCheckout')}}"><i class="fa fa-lock"></i> Login</a></li>
                                <?php } ?>




                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{URL::to('/home')}}" class="active">Home</a></li>
                            <li class="dropdown"><a href="#">Products<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="shop.html">Products</a></li>

                                </ul>
                            </li>
                            <li class="dropdown"><a href="#">News<i class="fa fa-angle-down"></i></a>

                            </li>
                            <li><a href="404.html">Cart</a></li>
                            <li><a href="contact-us.html">Contact(liên hệ)</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <form action="{{URL::to('/search')}}" method="POST">
                        {{ csrf_field() }}
                    <div class="search_box pull-right">
                        <input type="text" name="keywords_submit" placeholder="Search product"/>
                        <input type="submit" name="searchItem" value="Search" class="btn btn-primary btn-sm" style="margin-top: 0px;color: black">
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->

<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                @yield('imageHome')

            </div>
        </div>
    </div>
</section><!--/slider-->

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Category</h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                    @foreach($categoryProduct as $key => $category)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><a href="{{URL::to('/categoryProduct/'.$category->category_id)}}">{{$category->category_name}}</a></h4>
                            </div>
                        </div>
                        @endforeach
                    </div><!--/category-products-->

                    <div class="brands_products"><!--brands_products-->
                        <h2>Brands</h2>
                        <div class="brands-name">
                            <ul class="nav nav-pills nav-stacked">
                                @foreach($brandProduct as $key => $brand)
                                <li><a href="{{URL::to('/brandProduct/'.$brand->brand_id)}}"> {{$brand->brand_name}}</a></li>
                                    @endforeach
                            </ul>
                        </div>
                    </div><!--/brands_products-->



                </div>
            </div>

            <div class="col-sm-9 padding-right">



                    @yield('content')





            </div>
        </div>
    </div>
</section>

<footer id="footer"><!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="companyinfo">
                        <h2><span>e</span>-shopper</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{('public/frontend/images/iframe1.png')}}" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{('public/frontend/images/iframe2.png')}}" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{('public/frontend/images/iframe3.png')}}" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <a href="#">
                                <div class="iframe-img">
                                    <img src="{{('public/frontend/images/iframe4.png')}}" alt="" />
                                </div>
                                <div class="overlay-icon">
                                    <i class="fa fa-play-circle-o"></i>
                                </div>
                            </a>
                            <p>Circle of Hands</p>
                            <h2>24 DEC 2014</h2>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="address">
                        <img src="{{('public/frontend/images/map.png')}}" alt="" />
                        <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Service</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Online Help</a></li>
                            <li><a href="#">Contact Us</a></li>
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Change Location</a></li>
                            <li><a href="#">FAQ’s</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Quock Shop</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">T-Shirt</a></li>
                            <li><a href="#">Mens</a></li>
                            <li><a href="#">Womens</a></li>
                            <li><a href="#">Gift Cards</a></li>
                            <li><a href="#">Shoes</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Policies</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Privecy Policy</a></li>
                            <li><a href="#">Refund Policy</a></li>
                            <li><a href="#">Billing System</a></li>
                            <li><a href="#">Ticket System</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#">Company Information</a></li>
                            <li><a href="#">Careers</a></li>
                            <li><a href="#">Store Location</a></li>
                            <li><a href="#">Affillate Program</a></li>
                            <li><a href="#">Copyright</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <h2>About Shopper</h2>
                        <form action="#" class="searchform">
                            <input type="text" placeholder="Your email address" />
                            <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                            <p>Get the most recent updates from <br />our site and be updated your self...</p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
                <p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
            </div>
        </div>
    </div>

</footer><!--/Footer-->



<script src="{{asset('public/frontend/js/jquery.js')}}"></script>
<script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{asset('public/frontend/js/price-range.js')}}"></script>
<script src="{{asset('public/frontend/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{asset('public/frontend/js/main.js')}}"></script>
<script src="{{asset('public/frontend/js/sweetalert.min.js')}}"></script> <!-- sweet Alear -->
{{--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>--}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.add-to-cart').click(function (){
            var id = $(this).data('id');
            var cartProductId = $('.cartProductId-'+id).val();
            var cartProductName = $('.cartProductName-'+id).val();
            var cartProductQty = $('.cartProductQty-'+id).val();
            var cartProductImage = $('.cartProductImage-'+id).val();
            var cartProductPrice = $('.cartProductPrice-'+id).val();
            var _token = $('input[name="_token"]').val();
           // alert(token)
           $.ajax({
               url: '{{url('/addToCartAjax')}}',
               method:'POST',
               data:{
                   cartProductId:cartProductId,
                   cartProductName:cartProductName,
                   cartProductQty:cartProductQty,
                   cartProductImage:cartProductImage,
                   cartProductPrice:cartProductPrice,
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
                       icon:'success'
                       }).then((confirm) => {
                       if (confirm) {
                           window.location.href = "{{url('/showCartAjax')}}";
                       }
                   });

               },
           })
        });

    });
</script>
<script type="text/javascript">
    $(document).ready(function (){
       $('.send_order').click(function(){
            var shippingEmail = $('.shippingEmail').val();
            var shippingAddress = $('.shippingAddress').val();
            var shippingName = $('.shippingName').val();
            var shippingPhone = $('.shippingPhone').val();
            var shippingNotes = $('.shippingNotes').val();
            var orderFeeship = $('.orderFeeship').val();
            var orderCoupon = $('.orderCoupon').val();
            var shippingMethod = $('.payment_select').val();
           var _token = $('input[name="_token"]').val();

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
                           data:{
                               shippingEmail:shippingEmail,
                               shippingAddress:shippingAddress,
                               shippingName:shippingName,
                               shippingNotes:shippingNotes,
                               shippingPhone:shippingPhone,
                               orderCoupon:orderCoupon,
                               orderFeeship:orderFeeship,
                               shippingMethod:shippingMethod,
                               _token:_token
                           },
                           success:function(data){
                               swal("You already order successfully", {
                                   icon: "success",
                               });

                           },

                       });
                       //khi ajax chạy xong thì ta cho 5 giây sau load lại trang
                       window.setTimeout(function(){ location.reload()},3000); // 3 giây thì nó reset lại trang
                   }
               });

                  /*
                   */
       });
    });
</script>
<script type="text/javascript">
    $(document).ready(function (){
        $('.calculate_delivery').click(function (){
            var cityId = $('#city').val();
            var provinceId = $('#province').val();
           var wardsId = $('#wards').val();
            var _token = $('input[name="_token"]').val();
            //kiểm tra người dùng nhập đủ trường chưa
            if(cityId =='' && provinceId == '' && wardsId == ''){
                alert("please fill in the full address");
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
                            location.reload();
                    }
                });
            }

        });


        $('.choose').change(function(){
            //lấy id, trong id chứa tên table ta cần select
            var action = $(this).attr('id');
            //value sẽ chứa id của table
            var id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
            if(action == 'city'){
                result = 'province';
            }else{
                result = 'wards';
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


<!-- captcha -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- end captcha -->

<!-- đoạn script dùng để chạy nút share facebook -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v11.0&appId=496390685040946&autoLogAppEvents=1" nonce="roizusOm"></script>
<!-- end script share facebook -->

</body>
</html>
