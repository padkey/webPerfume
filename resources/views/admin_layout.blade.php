<!DOCTYPE html>
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
    <!-- font CSS -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
    <link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/backend/css/morris.css')}}" type="text/css"/>
    <!-- calendar -->
    <link rel="stylesheet" href="{{asset('public/backend/css/monthly.cs')}}s">
    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
    <script src="{{asset('public/backend/js/raphael-min.js')}}"></script>
    <script src="{{asset('public/backend/js/morris.js')}}"></script>
</head>
<body>
<section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
        <!--logo start-->
        <div class="brand">
            <a href="{{URL::to('/dashboard')}}" class="logo">
                VISITORS
            </a>
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
        </div>
        <!--logo end-->
    <div class="top-nav clearfix">
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">
                <li>
                    <input type="text" class="form-control search" placeholder=" Search">
                </li>
                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img alt="" src="{{asset('public/backend/images/admin.jpg')}}">
                        <span class="adminName"><?php
                                $adminName = Session::get('adminName');
                                if($adminName){
                                    echo $adminName;
                                }
                            ?></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                        <li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i> Log Out</a></li>
                    </ul>
                </li>
                <!-- user login dropdown end -->

            </ul>
            <!--search & user info end-->
        </div>

    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        <div id="sidebar" class="nav-collapse">
            <!-- sidebar menu start-->
            <div class="leftside-navigation">
                <ul class="sidebar-menu" id="nav-accordion" >
                    <li>
                        <a class="active" href="{{URL::to('/dashboard')}}">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Banner</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allSlider')}}">Show slider</a></li>
                            <li><a href="{{URL::to('/addSlider')}}">Create slider</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Order</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/manageOrder')}}">Order management</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Coupon</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allCoupon')}}">Show Coupon</a></li>
                            <li><a href="{{URL::to('/addCoupon')}}">Create coupon </a></li>

                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Delivery</span>
                        </a>
                        <ul class="sub">
                            {{--<li><a href="{{URL::to('/showDelivery')}}">Show delivery</a></li>--}}
                            <li><a href="{{URL::to('/addDelivery')}}">Create delivery </a></li>

                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>List categpoy</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allCategoryProduct')}}">Show category product</a></li>
                            <li><a href="{{URL::to('/addCategoryProduct')}}">Create category product</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>List brand</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allBrandProduct')}}">Show brand</a></li>
                            <li><a href="{{URL::to('/addBrandProduct')}}">Create brand</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>List product</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allProduct')}}">Show product</a></li>
                            <li><a href="{{URL::to('/addProduct')}}">Create product</a></li>
                        </ul>
                    </li>

                    </li>

                </ul>            </div>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
    <!--main content start-->

    <section id="main-content">
        <section class="wrapper">
          @yield("admin_content")
        </section>
        <!-- footer -->
        <div class="footer">
            <div class="wthree-copyright">
                <p>© 2017 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
            </div>
        </div>
        <!-- / footer -->
    </section>
    <!--main content end-->
</section>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.j')}}s"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{asset('public/backend/js/flot-chart/excanvas.min.js')}}"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">
    $.validate({

    });
</script>
<script>
        CKEDITOR.replace('ckeditor1');
        CKEDITOR.replace('ckeditor2');
        CKEDITOR.replace('ckeditor3');
        CKEDITOR.replace('ckeditor4');
        CKEDITOR.replace('ckeditor5');
        CKEDITOR.replace('ckeditor6');
        CKEDITOR.replace('ckeditor7');
        CKEDITOR.replace('ckeditor8');
        CKEDITOR.replace('ckeditor9');
        CKEDITOR.replace('ckeditor10');

</script>
<script type="text/javascript">
    $('.updateQtyOrder').click(function(){
            var productId = $(this).data('product_id');
        // so lắp id vào class order_qty_ để lấy số lượng
            var productQty = $('.qty_product_order_'+productId).val();
            // lấy order_code để cập nhật số lượng sản phẩm trong đó
            var orderCode = $('.order_code').val();


        var _token = $('input[name="_token"]').val();
           $.ajax({
               url:'{{URL::to('/updateQtyProductOrder')}}',
               method:'POST',
               data:{productId:productId,productQty:productQty,orderCode:orderCode,_token:_token},
               success:function(data){

                   swal({
                       title:'Goob job!',
                       text:'Order Details updated successfully',
                       icon:'success',
                   });
                  window.setTimeout(function(){location.reload()},3000);

               }
           })
    })
</script>
<script type="text/javascript">
    //cập nhật trạng thái đơn hàng và số lượng tồn kho
    $('.orderDetails').change(function (){
            //lấy val
        var orderStatus =$(this).val();
        //lấy idorder ở mấy dòng select , children là mấy option ở trong select , :selected là lấy cái dòng nào được chọn
        var orderId = $(this).children(":selected").attr('id');

        var _token = $('input[name="_token"]').val();

        // lấy product inventory để so sánh điều kiện thêm số lượng
  //      var qtyProductInventory = $('.qty_product_inventory_'+ productId);

        //lấy ra số lượng của mỗi product , trong order có nhiều sản phẩm nên ta phải each xong push vào mảng
        productQty = [];
        $('input[name="product_sales_quantity"]').each(function(){
            //push nó vào mảng
                    productQty.push($(this).val());
        });
        productId  = [];
        $('input[name="order_product_id"]').each(function(){
             productId.push($(this).val());
        })
        //kiểm tra từng sản phẩm trong đơn hàng có số lượng <= số lượng sản phẩm tổn kho của sản phẩm đó không
        j = 0;
        for(i=0;i<productId.length;i++){
            //number of product in stock
            var qtyProductInventory = $('.qty_product_inventory_'+ productId[i]).val();
            //number of product in order
            //phải chuyển thành kiểu int mới so sánh được , lưu ý lưu ý
            var qtyProductOrder = $('.qty_product_order_'+ productId[i]).val();
            if(parseInt(qtyProductInventory) < parseInt(qtyProductOrder)){
                j++
               // alert('The number of product in the order must be less than the number of products in stock !');
                $('.warning-qty-product-'+ productId[i]).css('background','firebrick');
            }
        }
        // j = 0 có nghĩa là không có sản phẩm nào vượt quá số lượng trong kho , thì ta sẽ thực hiện update
               if(j==0){
                   $.ajax({
                       url:'{{URL::to('/updateInventory')}}',
                       method:"POST",
                       data:{orderStatus:orderStatus,orderId:orderId,productQty:productQty,productId:productId,_token:_token},
                       success:function(data){

                           swal({
                               title:'Goob Job ',
                               text:'Update order status successfully.',
                               icon:'success',
                           });
                           window.setTimeout(function(){ location.reload();},3000);
                       }
                   });
               }else{
                   swal('Error!','The number of product in the order must be less than the number of product in stock!','error')
               }
   /*     */
    });

</script>
<script type="text/javascript">
    $(document).ready(function (){
        //phải gọi hàm thì nó mới chạy nha
        fetch_delivery();
        //hàm lấy dữ liệu ra bằng ajax
        function fetch_delivery(){
            var _token = $('input[name="_token"]').val();

                $.ajax({
                   url:'{{URL('/selectFeeship')}}',
                   method:'POST',
                   data:{
                       _token:_token,
                   },
                   success:function(data){
                      $("#loadDelivery").html(data);

                   }
                });
        };

        $(document).on('blur','.fee_feeship_edit',function (){
                var feeshipId = $(this).data('feeship_id'); // lấy id của dòng mình blur
                var feeshipValue = $(this).text(); // lấy tiền bằng cách lấy đoạn text trong dòng đó
                 var _token = $('input[name="_token"]').val();
                 $.ajax({
                     url:'{{URL('/updateFeeship')}}',
                     method:'POST',
                     data:{
                         feeshipId:feeshipId,
                         feeshipValue:feeshipValue,
                         _token:_token,
                     },
                     success:function(data){
                            fetch_delivery();
                     }
                 })
        });


  //      $('.fee_feeship_edit').on('blur',function(){

      //  });


        $('.addDelivery').click(function(){
            var city = $("#city").val();
            var province = $("#province").val();
            var wards = $("#wards").val();
            var feeShip = $('.fee-ship').val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url:'{{URL('/saveDelivery')}}',
                method:"POST",
                data:{
                    city:city,
                    province:province,
                    wards:wards,
                    feeShip:feeShip,
                    _token:_token
                },
                success:function(data){
                   // alert("insert delivery successfully");
                    //hiển thị ra màn hình cái dữ liệu mình mới thêm luôn
                    fetch_delivery();
                }
            })
        });

        $('.choose').change(function (){
                var action = $(this).attr('id'); // lấy id của dòng có class là choose
               var id = $(this).val();
               var _token = $('input[name="_token"]').val(); // token lấy tạm ở form login admin

            //nếu action ='city' thì cho result = 'province' không phải thì cho bằng words
            var result = '';

            if(action=='city'){
                result='province';
            }else{
                result='wards';
            }
             $.ajax({
                 url:'{{URL('/selectDelivery')}}',
                 method:'POST',
                 data:{
                   action:action,
                     id:id,
                     _token:_token,
                 },
                 success:function (data){
                     $('#'+ result).html(data);
                 },

             }

             );

        })
    });
</script>
<!-- morris JavaScript -->
<script>
    $(document).ready(function() {
        //BOX BUTTON SHOW AND CLOSE
        jQuery('.small-graph-box').hover(function() {
            jQuery(this).find('.box-button').fadeIn('fast');
        }, function() {
            jQuery(this).find('.box-button').fadeOut('fast');
        });
        jQuery('.small-graph-box .box-close').click(function() {
            jQuery(this).closest('.small-graph-box').fadeOut(200);
            return false;
        });

        //CHARTS
        function gd(year, day, month) {
            return new Date(year, month - 1, day).getTime();
        }

        graphArea2 = Morris.Area({
            element: 'hero-area',
            padding: 10,
            behaveLikeLine: true,
            gridEnabled: false,
            gridLineColor: '#dddddd',
            axes: true,
            resize: true,
            smooth:true,
            pointSize: 0,
            lineWidth: 0,
            fillOpacity:0.85,
            data: [
                {period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
                {period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
                {period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
                {period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
                {period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
                {period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
                {period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
                {period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
                {period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},

            ],
            lineColors:['#eb6f6f','#926383','#eb6f6f'],
            xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
            pointSize: 2,
            hideHover: 'auto',
            resize: true
        });


    });
</script>
<!-- calendar -->
<script type="text/javascript" src="{{asset('public/backend/js/monthly.js')}}"></script>
<script type="text/javascript">
    $(window).load( function() {

        $('#mycalendar').monthly({
            mode: 'event',

        });

        $('#mycalendar2').monthly({
            mode: 'picker',
            target: '#mytarget',
            setWidth: '250px',
            startHidden: true,
            showTrigger: '#mytarget',
            stylePast: true,
            disablePast: true
        });

        switch(window.location.protocol) {
            case 'http:':
            case 'https:':
                // running on a server, should be good.
                break;
            case 'file:':
                alert('Just a heads-up, events will not work when run locally.');
        }

    });
</script>
<!-- //calendar -->
</body>
</html>
