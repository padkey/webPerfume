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

    <!----------- SHARE FACEBOOK  --------->
    <meta property="og:url" content="{{$urlCanonical}}">
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{$metaTitle}}">
    <meta property="og:description" content="{{$metaDes}}">
    <meta property="og:image" content="{{$shareImage}}">     <!----------- hình ảnh tiêu đề khi mình share người dùng sẽ thấy cái hình, bấm vào thì mới vào web  --------->
    <!----------- END SHARE FACEBOOK  --------->
    <title>{{$metaTitle}}</title>
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet"> <!-- sweetalert -->

    {{--Gallery  để làm image productDetail--}}
    <link href="{{asset('public/frontend/css/lightgallery.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/lightslider.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettify.css')}}" rel="stylesheet">
    {{--End Gallery--}}
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{url('/public/uploads/contact/'.$contact->info_logo)}}">    <!--logo title-->


    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">

    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">


    <!--token -->
    <meta name="csrf-token" content="{{csrf_token()}}">

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
                     {{--   <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        </ul>--}}
                        <ul class="nav navbar-nav" style="display: inline">
                            @foreach($allIcon as $key => $icon)
                            <li><a href="{{$icon->icon_link}}" target="_blank" alt="{{$icon->icon_name}}"><img style="margin: 2px" width="25px" height="25px"  src="{{url('/public/uploads/icons/'.$icon->icon_image)}}" alt=""></a></li>
                            @endforeach
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
                                @lang('lang.language')
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="{{url('/lang/en')}}">Tiếng Anh</a></li>
                                <li><a href="{{url('/lang/vi')}}">Việt Nam</a></li>
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
                            <style>
                                span.badges{
                                    background-color: red;
                                    padding: 5px;
                                    border-radius: 10px;
                                    color: white;
                                    font-weight: bold;

                                }
                                    ul.showCartMenu{
                                        padding: 0px;
                                        display: none;
                                        position: absolute;
                                        z-index: 999999;
                                        margin-top: 20px;
                                        background-color: whitesmoke;
                                    }
                                ul.showCartMenu li{
                                    border-bottom: 1px  solid black;
                                    padding: 10px;

                                }
                                ul.showCartMenu li img{
                                    width: 50px;
                                }
                                li.hoverCart:hover .showCartMenu{
                                    display: block;
                                }
                            </style>
                            <li style="position:relative;display: inline-grid" class="hoverCart">
                                <a href="{{url('/showCartAjax')}}">
                                    <i class="fa fa-shopping-cart"></i>
                                    Cart  <span class="showCartQty"></span>

                                </a>
                                <ul class="showCartMenu">

                                </ul>
                            </li>





                            <?php
                                $customerId = Session::get('customerId');
                                $customerName = Session::get('customerName');

                                if($customerId){ ?>
                            <li class="dropdown">
                                <a href="{{URL::to('/orderHistory')}}">
                                    <img width="15%" src="{{Session::get('customerPicture')}}" alt="">
                                    {{$customerName}}
                                </a>
                                <ul role="menu" class="sub-menu">
                                    <li ><a href="">Profile</a></li>
                                    <li ><a href="{{URL::to('/orderHistory')}}">Order History</a></li>
                                </ul>
                            </li>
                            <li><a href="{{URL::to('/orderHistory')}}"><i class="fa fa-history"></i> History</a></li>
                            <li><a href="{{URL::to('/logoutCustomer')}}"><i class="fa fa-lock"></i> Logout</a></li>
                                <?php }else{  ?>
                            <li><a href="{{URL::to('/loginPage')}}"><i class="fa fa-lock"></i> Login</a></li>
                                <?php } ?>




                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom" id="navbar"><!--header-bottom-->
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
                        <ul class="nav navbar-nav collapse navbar-collapse" >
                           {{-- khi thay đổi ngôn ngữ thì ta dùng hàm @lang('lang.home') để đổi từ tiếng anh sang tiếng việt--}}
                            <li><a href="{{URL::to('/home')}}" class="active">@lang('lang.home')</a></li>

                            <li class="hoverCart"><a href="{{url('/showCartAjax')}}">
                                    Cart  <span class="showCartQty"></span>
                                </a>
                                <ul class="showCartMenu" style="margin: 0px"></ul>
                            </li>


                            <li class="dropdown"><a href="#">Products<i class="fa fa-angle-down"></i></a>


                                <ul role="menu" class="sub-menu">
                                    @foreach($categoryProduct as $key => $category)
                                        @if($category->category_parent ==0 )
                                    <li class="dropdown"><a href="">{{$category->category_name}}</a>

                                                @foreach($categoryProduct as $key2 => $subCategory)
                                                    @if($subCategory->category_parent == $category->category_id)
                                                <ul >
                                                            <li class="dropdown"><a href="">{{$subCategory->category_name}}</a></li>
                                                </ul>
                                                    @endif
                                                @endforeach

                                    </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>



                            <li class="dropdown"><a href="#">@lang('lang.blogs')<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    @foreach($allCategoryPost as $key => $categoryPost)
                                    <li><a href="{{URL::to('/listPostByCate/'.$categoryPost->category_post_slug)}}">{{$categoryPost->category_post_name}}</a></li>
                                        @endforeach
                                </ul>
                            </li>



                            <li><a href="{{url('/listVideo')}}">Video Review Perfume</a></li>
                            <li><a href="{{url('/showContact')}}">@lang('lang.contact')</a></li>


                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    {{--tắt gợi ý sẵn có bằng autocomplete="off"--}}
                    <form action="{{URL::to('/search')}}" autocomplete="off" method="POST">
                              @csrf
                            <div class="search_box" >
                                <input style="width:70%;float: left" type="text" name="keywords" id="keywords" placeholder="Search product"/>
                                <div id="listSearchResults"></div>
                                <input type="submit" name="searchItem" value="Search" class="btn btn-primary btn-sm" style="margin-top: 0px;color: black;width: 100px">
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

                @yield('slider')

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
                            @if($category->category_parent == 0)
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordian" href="#categoryParent-{{$category->category_id}}">
                                         <span class="badge pull-right" ><i class="fa fa-plus"></i></span>
                                        {{$category->category_name}}
                                    </a>
                                </h4>
                            </div>
                            <div id="categoryParent-{{$category->category_id}}" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <ul>
                                        @foreach($categoryProduct as $key2 => $subCategory)
                                            @if($subCategory->category_parent == $category->category_id)
                                        <li><a href="{{URL::to('/productsByCategory/'.$subCategory->category_slug)}}">{{$subCategory->category_name}}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                            @endif
                        @endforeach

                    </div><!--/category-products-->

                    <div class="brands_products"><!--brands_products-->
                        <h2>Brands</h2>
                        <div class="brands-name">
                            <ul class="nav nav-pills nav-stacked">
                                @foreach($brandProduct as $key => $brand)
                                <li><a href="{{URL::to('/productsByBrand/'.$brand->brand_slug)}}"> {{$brand->brand_name}}</a></li>
                                    @endforeach
                            </ul>
                        </div>
                    </div><!--/brands_products-->

                    <div class="brands_products"><!--Wishlist-->
                        <h2>Wishlist</h2>
                        <div class="brands-name">
                            <style>
                                .row_wishlist p{
                                    margin: 3px;
                                }
                                .row_wishlist{
                                    height: 400px;
                                    overflow: auto; /*chỉ hiện thị thanh cuộn khi vượt quá*/
                                }
                            </style>
                            <div class="row_wishlist">

                            </div>
                        </div>
                    </div><!--Wishlist-->

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
                        <h2><img width="100%" src="{{url('/public/uploads/contact/'.$contact->info_logo)}}" alt=""></h2>
                        <p>{{$contact->info_slogan}}</p>
                    </div>
                </div>
                <div class="col-sm-7">

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
                            @foreach($postFooter as $key => $post)
                            <li><a target ="_blank" href="{{url('/postDetail/'.$post->post_slug)}}">{{$post->post_title}} </a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="single-widget">
                        <h2>Information Shop</h2>
                        <ul class="nav nav-pills nav-stacked">
                            {!! $contact->info_contact !!}
                        </ul>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>Fanpage</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li>{!! $contact->info_fanpage !!}</li>

                        </ul>
                    </div>
                </div>

                <div class="col-sm-3 ">
                    <div class="single-widget">
                        <h2>Đăng ký email</h2>
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
                <p class="pull-left">Copyright © 2021 Shoperfume Inc. All rights reserved.</p>
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

{{--Gallery  để làm image productDetail--}}
<script src="{{asset('public/frontend/js/lightgallery-all.min.js')}}"></script>
<script src="{{asset('public/frontend/js/lightslider.js')}}"></script>
<script src="{{asset('public/frontend/js/prettify.js')}}"></script>

{{--xếp hạng--}}
<script src="{{asset('resources/js/frontend/rating/rating.js')}}"></script>
{{--Category Tab--}}
<script src="{{asset('resources/js/frontend/category/categoryTab.js')}}"></script>
{{--Wishlist--}}
<script src="{{asset('resources/js/frontend/product/wishlist.js')}}"></script>
{{--Sort : phân loại--}}
<script src="{{asset('resources/js/frontend/sort/arrangeProducts.js')}}"></script>

{{--PAYPAL--}}
<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
    // khi trang web scroll thì sẽ vào hàm myFunction()
    window.onscroll = function() {myFunction()};

    // lấy dòng có id là navbar
    var navbar = document.getElementById("navbar");

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
                    swal('Good job!','Check your email to reset password!','success');
                    setTimeout(function (){location.reload()},1500)
            }
        });
    });
</script>
<script>
    var usd = $('#vndToUsd').val();
    paypal.Button.render({
        // Configure environment
        env: 'sandbox',
        client: {
            sandbox: 'AREak5kftVT1vp5j5OhyqVF6OH8emywP4sxEZo1Ist9GRitz66f3kELU8B8gJ4Y1bHmcQNr5ByDPjeGs',
            production: 'demo_production_client_id'
        },
        // Customize button (optional)
        locale: 'en_US',
        style: {
            size: 'small', // nhỏ
            color: 'gold', // màu vàng
            shape: 'pill', // bo tròn nút
        },

        // Enable Pay Now checkout flow (optional)
        commit: true,

        // Set up a payment
        payment: function(data, actions) {
            return actions.payment.create({
                transactions: [{
                    amount: {
                        total: usd,
                        currency: 'USD'
                    }
                }]
            });
        },
        // Execute the payment
        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                // Show a confirmation message to the buyer
                window.alert('Thank you for your purchase!');
            });
        }
    }, '#paypal-button');

</script>




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


<script>
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

      $(function(){
          $('#quickView').on('show.bs.modal', function (e) {
             // alert("show modal")
              $(window).resize();
              $(window).resize();
          });

    })


</script>

<script>
    //quickview
    $(document).on('click','.quickViewProduct',function (){

                var productId = $(this).data('id');
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:'{{url('/quickViewProduct')}}',
                    method:'POST',
                    dataType:'JSON',
                    data:{productId:productId,_token:_token},
                    success:function(data){
                        $('#quickViewProductName').html(data['product_name']);
                        $('#imageGallery').html(data['gallery']);
                        $('#quickViewProductPrice').html(data['product_price']);
                        $('#quickViewProductDes').html(data['product_des']);
                        $('#quickViewProductValue').html(data['quickViewProductValue']);
                        $('#btnAddToCart').html(data['btnAddToCart']);
                        $('#inputProductQty').html(data['inputProductQty']);
                    }
                })

    });
</script>


<script>
    //ghi người dùng nhập dữ liệu vào input có id là keywords
    $('#keywords').keyup(function (){
            var value = $(this).val();
            var _token = $('input[name="_token"]').val();
            if(value != ''){
                $.ajax({
                    url:'{{url('/autocomplete')}}',
                    method:'POST',
                    data:{value:value,_token:_token},
                    success:function(data){
                        //hiển thị gợi ý từ khóa cho người dungf
                        $('#searchResult').fadeIn(data); //cho hiện gợi ý
                        $('#listSearchResults').html(data);
                    }
                });
            }else{
                $('#listSearchResults').fadeOut(); //tắt gợi ý
            }
    });

    // nếu người dùng click vào dòng kết quả tìm kiếm thì
    $(document).on('click','.searchResult',function (){
       // cho ô input băng cái dòng vừa click
        $('#keywords').val($(this).text());
        //và cho list kết quả tìm kiếm ẩn đi
        $('#listSearchResults').fadeOut();
    });
</script>
<script>
    $(document).ready(function(){
       $(document).on('click','.watchVideo',function (){
                var videoId = $(this).data('id');
                $.ajax({
                    url:'{{url('/watchVideo')}}',
                    method:'POST',
                    headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                    dataType:"JSON",
                    data:{videoId},
                    success:function (data){
                            $('#videoTitle').html(data.videoTitle);
                            $('#videoLink').html(data.videoLink)
                    }
                });
       });
    });
</script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#imageGallery').lightSlider({
            gallery:true, // hiển thị mấy hình nhỏ bên dưới hình lớn
            item:1, //1 hình được hiển thị lớn , còn lại nhỏ
            loop:true, // lặp , có nghĩa là tới hình cuối bấm > thì sẽ quay về hình đầu, false thì tới hình cuối sẽ đứng luôn
            thumbItem:3, // số hình nhỏ được hiển thị
            slideMargin:2,
            enableDrag: true, // khi bấm chuyển hình sẽ có hiệu ứng nổi
            currentPagerPosition:'left',
            auto:true,
            loop:true,
            pauseOnHover: true,
            onSliderLoad: function(el) {
                el.lightGallery({
                    selector: '#imageGallery .lslide'
                });
            }
        });

    });
</script>
{{--End Gallery--}}


<script type="text/javascript">
    showCartQty();
    showCartMenu();
        function showCartQty(){
            $.ajax({
                url: "{{url('/showCartQty')}}",
                method:'GET',
                success:function (data){
                    $('.showCartQty').html(data);
                },
            });
        }
    function showCartMenu(){
        $.ajax({
            url: "{{url('/showCartMenu')}}",
            method:'GET',
            success:function (data){
                $('.showCartMenu').html(data);
            },
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
                                window.location.href = "{{url('/showCartAjax')}}";
                            }
                        });
                        showCartQty();
                        showCartMenu();
                    },
                });
            }

        });

       function addToCart(productId){
           var id = productId;
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
                               window.location.href = "{{url('/showCartAjax')}}";
                           }
                       });
                       showCartQty();
                       showCartMenu();
                   },
               });
           }
       }
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
                       window.setTimeout(function(){ window.location.href = '/shopperfume/orderHistory'},2000); // 3 giây thì nó reset lại trang
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
