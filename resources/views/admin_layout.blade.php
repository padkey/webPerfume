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
    <link rel="stylesheet" href="{{asset('public/backend/css/monthly.cs')}}">
    <link rel="shortcut icon" href="{{url('/public/uploads/contact/'.$contact->info_logo)}}">    <!--logo title-->

    <!-- //calendar -->
    <!-- //font-awesome icons -->
    <script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
    <script src="{{asset('public/backend/js/raphael-min.js')}}"></script>
    <script src="{{asset('public/backend/js/morris.js')}}"></script>


    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">   {{--chức năng search--}}
    <link rel="stylesheet" href="{{asset('public/backend/css/bootstrap-tagsinput.css')}}">  {{--  tags--}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">   {{--  Chart--}}

    <meta name="csrf-token" content="{{csrf_token()}}">  <!--token -->
</head>
<body>
<section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix">
        <!--logo start-->
        <div class="brand">

            <a href="{{URL::to('/dashboard')}}" class="logo">
                Perfume
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
                                $adminName = Auth::user()->admin_name;
                                if($adminName){
                                    echo $adminName;
                                }
                            ?></span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                        <li><a href="{{URL::to('/logoutAuth')}}"><i class="fa fa-key"></i> Log Out</a></li>
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
                            <i class="fa fa-info"></i>
                            <span>Information Website</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/infoManagement')}}">Information management</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-sliders"></i>
                            <span>Slider</span>
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
                            <i class="fa fa-gift"></i>
                            <span>Coupon</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allCoupon')}}">Show Coupon</a></li>
                            <li><a href="{{URL::to('/addCoupon')}}">Create coupon </a></li>

                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-truck"></i>
                            <span>Delivery</span>
                        </a>
                        <ul class="sub">
                            {{--<li><a href="{{URL::to('/showDelivery')}}">Show delivery</a></li>--}}
                            <li><a href="{{URL::to('/addDelivery')}}">Create delivery </a></li>

                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-th"></i>
                            <span>Category Product</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allCategoryProduct')}}">Show category product</a></li>
                            <li><a href="{{URL::to('/addCategoryProduct')}}">Create category product</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-list-ul"></i>
                            <span>Category Post</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allCategoryPost')}}">Show category post</a></li>
                            <li><a href="{{URL::to('/addCategoryPost')}}">Create category post</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-th"></i>
                            <span>Brand</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allBrandProduct')}}">Show brand</a></li>
                            <li><a href="{{URL::to('/addBrandProduct')}}">Create brand</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-product-hunt"></i>
                            <span>Product</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allProduct')}}">Show product</a></li>
                            <li><a href="{{URL::to('/addProduct')}}">Create product</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-file-text"></i>
                            <span>Post</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allPost')}}">Show Post</a></li>
                            <li><a href="{{URL::to('/addPost')}}">Create Post</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-video-camera"></i>
                            <span>Video</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allVideo')}}">Show Video</a></li>
                        </ul>
                    </li>
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-comments-o"></i>
                            <span>Comment</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/allComment')}}">Show Comment</a></li>
                        </ul>
                    </li>

                    </li>
                    @hasRole(['admin','author'])
                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-users"></i>
                            <span>User</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/users')}}">User management</a></li>
                            <li><a href="{{URL::to('/addUser')}}">Create user</a></li>
                        </ul>
                    </li>
                    @endhasRole

                    @hasImpersonate
                    <li>
                        <a class="active" href="{{URL::to('/destroyImpersonate')}}">
                            <span>Stop Impersonation</span>
                        </a>
                    </li>
                    @endhasImpersonate


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
<script src="{{asset('public/backend/js/scripts.js')}}"></script>

<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{asset('public/backend/js/flot-chart/excanvas.min.js')}}"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.79/jquery.form-validator.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
{{--tags--}}
<script src="{{asset('public/backend/js/bootstrap-tagsinput.min.js')}}"></script>

<script src="{{asset('resources/js/admin/comment/approval.js')}}"></script>
<script src="{{asset('resources/js/admin/comment/replyComment.js')}}"></script>

<script src="{{asset('public/backend/js/simple.money.format.js')}}"></script>
<script>
    $('.money').simpleMoneyFormat();

</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>{{--chart--}}
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>{{--chart--}}


<script type="text/javascript">
    $.validate({

    });
</script>
 {{--chức năng sắp xếp category_order--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script> {{--jqurey--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>{{--jqurey có chức hàm sortable() để sắp xếp--}}
{{--sắp xếp category --}}
<script src="{{asset('resources/js/admin/category/categoryOrder.js')}}"></script>
{{--Statistical--}}
<script src="{{asset('resources/js/admin/statistical/statistical.js')}}"></script>

{{--chức năng search từ khóa--}}
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
</script>
{{--END Search từ khóa--}}



<script type="text/javascript">

    function ChangeToSlug()
    {
        var slug;

        //Lấy text từ thẻ input title
        slug = document.getElementById("slug").value;
        slug = slug.toLowerCase();
        //Đổi ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        //Xóa các ký tự đặt biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        //Đổi khoảng trắng thành ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
        //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        //Xóa các ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        //In slug ra textbox có id “slug”
        document.getElementById('convert_slug').value = slug;
    }

</script>

<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
    var options = {
        filebrowserImageBrowseUrl: 'laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: 'laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: 'laravel-filemanager?type=Files',
        filebrowserUploadUrl: 'laravel-filemanager/upload?type=Files&_token='
    };
</script>
<script>
    CKEDITOR.replace('myEditor', options);
</script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>
<script>
    $('textarea.myEditor').ckeditor(options);
</script>



<script>
    $(document).ready(function (){

        loadIcon();
        function loadIcon(){
            $.ajax({
               url:'{{url('/loadIcon')}}',
               method:'POST',
               headers:{
                   'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
               },
                success:function (data){
                   $('#loadIcon').html(data);
                }
            });
        }

        $(document).on('click','.addIcon',(function (){

            var iconName = $('#iconName').val();
            var iconLink = $('#iconLink').val();
           var formData = new FormData();
        formData.append('iconName',iconName);
        formData.append('iconLink',iconLink);
        formData.append('iconImage',document.getElementById('iconImage').files[0]);
            $.ajax({
           url:'{{url('/saveIcon')}}',
           method:'POST',
           headers:{
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           },
            data:formData,
            contentType:false,
            cache:false,
            processData:false,
            success:function (data){
               swal('Good Job!','Inserted icon successfully!','success');
               loadIcon();
                 $('#iconName').val('');
                $('#iconLink').val('');
                $('#iconImage').val('');
            }

        });
        }));



        $(document).on('click','.deleleIcon',(function (){
            var iconId = $(this).data('id');
            $.ajax({
                url:'{{url('/deleteIcon')}}',
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{iconId},
                success:function (data){
                    swal('Good Job!','Deleted icon successfully!','success');
                    loadIcon();
                }

            });
        }));

    })
</script>

<script>
    $(document).ready(function (){
        loadVideo();
        function loadVideo(){
            $.ajax({
                url:'{{URL::to('/selectVideo')}}',
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(data){
                    $('#loadVideo').html(data);

                }
            });
        }

        //add video

        $(document).on('click','.addVideo',function (){
          var videoTitle = $('.videoTitle').val();
            var videoSlug = $('.videoSlug').val();
            var videoLink = $('.videoLink').val();
            var videoDes = $('.videoDes').val();
            formData = new FormData();
            formData.append("fileVideoImage",document.getElementById("fileVideoImage").files[0]);

            formData.append("videoTitle",videoTitle);
            formData.append("videoSlug",videoSlug);
            formData.append("videoLink",videoLink);
            formData.append("videoDes",videoDes);
           $.ajax({
               url:'{{URL::to('/saveVideo')}}',
               method:'POST',
               headers:{
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               data:formData,
               contentType:false,// phải thêm 3 dòng này không là lỗi
               cache:false,
               processData:false,

               success:function(data){
                 loadVideo();
                   swal({
                       title:'Good job!',
                       text:'Added video successfully.',
                       icon:'success'
                   });
               }
           });
        });

        //delete video
        $(document).on('click','.deleteVideo',function (){
            var videoId = $(this).data('id');
            swal({
                title:'Are you sure!',
                text:'You will not be able to recover this video!',
                icon:'info',
                buttons:true
            }).then((confirm)=>{
                if(confirm){
                    $.ajax({
                        url:'{{URL::to('/deleteVideo')}}',
                        method:'POST',
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:{videoId:videoId},
                        success:function(data){
                            loadVideo();
                            swal({
                                title:'Good job!',
                                text:'Deleted video successfully.',
                                icon:'success'
                            });
                        }
                    });
                }
            });

        });


        //edit video
        $(document).on('blur','.editVideo',function(){
               //videoId là video mình cần sửa
                 var videoId = $(this).data('id');
                //action chứa cột mình cần sửa
                var action = $(this).data('action');
                //giá trị mình mới nhập là giá trị mới cho cột trên
                 var value = $(this).text();
            swal({
                title:'Are you sure?',
                text:'Are you sure to change the '+ action +'?',
                icon:'info',
                buttons:true
            }).then((confirm)=>{
                if(confirm){
                    $.ajax({
                        url:'{{URL::to('/updateVideo')}}',
                        method:'POST',
                        headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                        data:{videoId:videoId,action:action,value:value} ,
                        success:function (data){
                            loadVideo();
                            swal({
                                title:'Good job!',
                                text:'Updated '+ action +' successfully.',
                                icon:'success'
                            })
                        }
                    });
                }
            })


        });

        //edit image video
        //ban đầu bắt sự kiện change của class chứa file image
        $(document).on('change','.editVideoImage',function (){
            var videoId = $(this).data('id');
            var formData = new FormData();
            //nhớ .files[0] không có cái này k lấy được hình
            //trong input trong thêm 1 cái id fileIamge-(videoId) để lấy được file image riêng biệt của mỗi video
            formData.append('fileVideoImage',document.getElementById("fileImage-"+videoId).files[0]);
            formData.append('videoId',videoId);

            $.ajax({
                url:'{{URL::to('/updateVideoImage')}}',
                method:"POST",
                headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                data:formData,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data){
                    loadVideo();
                    swal({
                        title:'Good job!',
                        text:'Updated image successfully.',
                        icon:'success'
                    })
                }
            });
        });


    });


</script>


<script type="text/javascript">
    $(document).ready(function (){
        loadGallery();
        function loadGallery(){
          var  productId = $('.productId').val();
           var _token = $('input[name="_token"]').val();
           $.ajax({
              url:'{{URL::to('/selectGallery')}}',
              method:"post",
              data:{productId:productId,_token:_token},
               success:function(data){
                        $('#galleryLoad').html(data);
               }
           });
        }

        //kiểm tra xem file ảnh có lỗi theo yêu cầu của mình không
        $('#file').change(function (){
            var files = $(this)[0].files;
            var error = 0 ;
            //nếu files nhiều hơn 5 hình
            if(files.length > 5){
                error++;
                swal({
                    title:'Error!',
                    text:'Can only upload up to five image!.',
                    icon:'error'
                })

            }else if(files.length == ''){
                error++;
                swal({
                    title:'Error!',
                    text:'You must add image!',
                    icon:'error'
                })
            }else if(files.size > 2000000){
                error++;
                swal({
                    title:'Error!',
                    text:'Image file must not be larger than 2MB!',
                    icon:'error'
                })
            }
            //nếu file không có 3 lỗi trên thì không làm j hết, nếu có lỗi thì thông báo raqua cái id
            if(error == 0){

            }else{
                //cho cái điền hình trở về rỗng
                $('#file').val('');

            }
        });


        //edit Name Gallery
        $(document).on('blur','.editNameGallery',function(){
            var galleryId = $(this).data('id');
            var _token = $('input[name="_token"]').val();
            var galleryName = $(this).text();
            $.ajax({
               url:'{{URL::to('/editNameGallery')}}',
               method:'POST',
               data:{galleryId:galleryId,galleryName:galleryName,_token:_token},
                success:function(data){
                   loadGallery();
                   swal({
                       title:'Good job!',
                       text:'Updated name gallery successfully.',
                       icon:'success'
                   })

                }
            });

        });
        //deleteGallery
        $(document).on('click','.deleteGallery',function(){
                var galleryId = $(this).data('id');
            var _token = $('input[name="_token"]').val();
            swal({
                title:'Are you sure?',
                text:'You will not be able to recover this gallery!.',
                icon:'info',
                buttons:true,
            }).then((confirm)=>{
                if(confirm){
                    $.ajax({
                        url:'{{URL::to('/deleteGallery')}}',
                        method:'post',
                        data:{galleryId:galleryId,_token:_token},
                        success:function (data){
                            loadGallery();
                            swal({
                                title:'Good job!',
                                text:'Deleted gallery successfully.',
                                icon:'success'
                            })
                        }
                    })
                }
            })

        });


        //update Gallary
        $(document).on('change','.fileImage',function(){
            var galleryId = $(this).data('id');
            var form_Data = new FormData();
            form_Data.append('file',document.getElementById('file-'+ galleryId).files[0]);
            form_Data.append('galleryId',galleryId);
            var _token = $('input[name="_token"]').val();

                    $.ajax({
                        url:'{{URL::to('/updateGallery')}}',
                        method:'POST',
                        headers:{
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data:form_Data,
                        contentType:false,
                        cache:false,
                        processData:false,
                        success:function (data){
                            loadGallery();
                            swal({
                                title:'Good job!',
                                text:'Updated gallery successfully.',
                                icon:'success'
                            })

                        }
                    })


        });

    });
</script>
<script type="text/javascript">

        CKEDITOR.replace('ckeditor1',{
            // dòng này để upload ảnh từ máy tính
            filebrowserImageUploadUrl : '{{url("uploadsCkeditor?_token=".csrf_token()) }}',
            filebrowserBrowseUploadUrl : "{{url('fileBrowser?_token='.csrf_token()) }}",
            filebrowserUploadMethod:'form'

        });
        CKEDITOR.replace('ckeditor2');
        CKEDITOR.replace('ckeditor3',{

            filebrowserImageUploadUrl : '{{url("uploadsCkeditor?_token=".csrf_token()) }}',
            filebrowserBrowseUploadUrl : "{{url('fileBrowser?_token='.csrf_token()) }}",
            filebrowserUploadMethod:'form'
        });
        CKEDITOR.replace('ckeditor4');
        CKEDITOR.replace('ckeditor5');
        CKEDITOR.replace('ckeditor6');
        CKEDITOR.replace('ckeditor7');
        CKEDITOR.replace('ckeditor8');
        CKEDITOR.replace('ckeditor9');
        CKEDITOR.replace('ckeditor10',{
            // dòng này để upload ảnh từ máy tính
            filebrowserImageUploadUrl : "{{ url('uploads-ckeditor?_token='.csrf_token()) }}",
            filebrowserBrowseUrl : "{{ url('file-browser?_token='.csrf_token()) }}",
            filebrowserUploadMethod: 'form'

        });
        CKEDITOR.replace('ckeditor11',{
            filebrowserImageUploadUrl : "{{ url('uploads-ckeditor?_token='.csrf_token()) }}",
            filebrowserBrowseUrl : "{{ url('file-browser?_token='.csrf_token()) }}",
            filebrowserUploadMethod: 'form'
        });

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
        //lấy tiền giảm giá để gửi mail
        var totalDiscount = $('.totalDiscount').val();
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
                $('.warning-qty-product-'+ productId[i]).css('background','firebrick');
            }
        }
        // j = 0 có nghĩa là không có sản phẩm nào vượt quá số lượng trong kho , thì ta sẽ thực hiện update
               if(j==0){
                   $.ajax({
                       url:'{{URL::to('/updateInventory')}}',
                       method:"POST",
                       data:{totalDiscount:totalDiscount,orderStatus:orderStatus,orderId:orderId,productQty:productQty,productId:productId,_token:_token},
                       success:function(data){

                           swal({
                               title:'Good Job ',
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
