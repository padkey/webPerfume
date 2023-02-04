@extends('frontend_layout')
@section('header')
    @include('pages.include.headerNormal')
@endsection
@section('content')
    <style>
        ul.postRelated li{
            list-style-type:disc;
            font-size: 17px;
            padding: 6px;
        }
        ul.postRelated li a{
            color: black;
        }
        .posts ul li a{
            color: black;
            text-decoration: none;
        }
    </style>

    {{--phải cấu hình đường dẫn lại mới share được , không cấu hình thì share không ra trang này, hoặc bị lỗi--}}
    <div class="fb-share-button" data-href="{{$urlCanonical}}" data-layout="button" data-size="large">
        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$urlCanonical}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">
            Chia sẻ
        </a>
    </div>



    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{url('/home')}}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="{{url('/listPostByCate/'.$postDetail->catePost->category_post_slug)}}" class="stext-109 cl8 hov-cl1 trans-04">
                {{$postDetail->catePost->category_post_name}}
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
				{{$postDetail->post_title}}
			</span>
        </div>
    </div>


    <!-- Content page -->
    <section class="bg0 p-t-52 p-b-20">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-9 p-b-80">
                    <div class="p-r-45 p-r-0-lg">
                        <!--  -->
                        <div class="wrap-pic-w how-pos5-parent">
                            <img src="{{url('public/uploads/posts/'.$postDetail->post_image)}}" alt="IMG-BLOG">

                            <div class="flex-col-c-m size-123 bg9 how-pos5">
								<span class="ltext-107 cl2 txt-center">
									22
								</span>

                                <span class="stext-109 cl3 txt-center">
									Jan 2018
								</span>
                            </div>
                        </div>

                        <div class="p-t-32">
							<span class="flex-w flex-m stext-111 cl2 p-b-19">
								<span>
									<span class="cl4">By</span> Admin
									<span class="cl12 m-l-4 m-r-6">|</span>
								</span>

								<span>
									22 Jan, 2018
									<span class="cl12 m-l-4 m-r-6">|</span>
								</span>

								<span>
									StreetStyle, Fashion, Couple
									<span class="cl12 m-l-4 m-r-6">|</span>
								</span>

								<span>
									8 Comments
								</span>
							</span>

                            <h4 class="ltext-109 cl2 p-b-28">
                                {{$postDetail->post_title}}
                            </h4>

                            <p class="stext-117 cl6 p-b-26">
                                    {!!$postDetail->post_content !!}
                            </p>

                        </div>

                        <div class="flex-w flex-t p-t-16">
							<span class="size-216 stext-116 cl8 p-t-4">
								Tags
							</span>

                            <div class="flex-w size-217">
                                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Streetstyle
                                </a>

                                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Crafts
                                </a>
                            </div>
                        </div>

                        <!--  -->
                        <div class="p-t-40">
                            <h5 class="mtext-113 cl2 p-b-12">
                                Leave a Comment
                            </h5>

                            <p class="stext-107 cl6 p-b-40">
                                Your email address will not be published. Required fields are marked *
                            </p>

                            <form>
                                <div class="bor19 m-b-20">
                                    <textarea class="stext-111 cl2 plh3 size-124 p-lr-18 p-tb-15" name="cmt" placeholder="Comment..."></textarea>
                                </div>

                                <div class="bor19 size-218 m-b-20">
                                    <input class="stext-111 cl2 plh3 size-116 p-lr-18" type="text" name="name" placeholder="Name *">
                                </div>

                                <div class="bor19 size-218 m-b-20">
                                    <input class="stext-111 cl2 plh3 size-116 p-lr-18" type="text" name="email" placeholder="Email *">
                                </div>

                                <div class="bor19 size-218 m-b-30">
                                    <input class="stext-111 cl2 plh3 size-116 p-lr-18" type="text" name="web" placeholder="Website">
                                </div>

                                <button class="flex-c-m stext-101 cl0 size-125 bg3 bor2 hov-btn3 p-lr-15 trans-04">
                                    Post Comment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3 p-b-80">
                    <div class="side-menu">
                        <div class="bor17 of-hidden pos-relative">
                            <input class="stext-103 cl2 plh4 size-116 p-l-28 p-r-55" type="text" name="search" placeholder="Search">

                            <button class="flex-c-m size-122 ab-t-r fs-18 cl4 hov-cl1 trans-04">
                                <i class="zmdi zmdi-search"></i>
                            </button>
                        </div>

                        <div class="p-t-55">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Categories
                            </h4>

                            <ul>
                                @foreach($allCategoryPost as $key => $catePost)
                                <li class="bor18">
                                    <a href="{{url('/listPostByCate/'.$catePost->category_post_slug)}}" class="dis-block stext-115 cl6 hov-cl1 trans-04 p-tb-8 p-lr-4">
                                        {{$catePost->category_post_name}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="p-t-65">
                            <h4 class="mtext-112 cl2 p-b-33">
                                Featured Products
                            </h4>

                            <ul>
                                <li class="flex-w flex-t p-b-30">
                                    <a href="#" class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                        <img src="images/product-min-01.jpg" alt="PRODUCT">
                                    </a>

                                    <div class="size-215 flex-col-t p-t-8">
                                        <a href="#" class="stext-116 cl8 hov-cl1 trans-04">
                                            White Shirt With Pleat Detail Back
                                        </a>

                                        <span class="stext-116 cl6 p-t-20">
											$19.00
										</span>
                                    </div>
                                </li>

                                <li class="flex-w flex-t p-b-30">
                                    <a href="#" class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                        <img src="images/product-min-02.jpg" alt="PRODUCT">
                                    </a>

                                    <div class="size-215 flex-col-t p-t-8">
                                        <a href="#" class="stext-116 cl8 hov-cl1 trans-04">
                                            Converse All Star Hi Black Canvas
                                        </a>

                                        <span class="stext-116 cl6 p-t-20">
											$39.00
										</span>
                                    </div>
                                </li>

                                <li class="flex-w flex-t p-b-30">
                                    <a href="#" class="wrao-pic-w size-214 hov-ovelay1 m-r-20">
                                        <img src="images/product-min-03.jpg" alt="PRODUCT">
                                    </a>

                                    <div class="size-215 flex-col-t p-t-8">
                                        <a href="#" class="stext-116 cl8 hov-cl1 trans-04">
                                            Nixon Porter Leather Watch In Tan
                                        </a>

                                        <span class="stext-116 cl6 p-t-20">
											$17.00
										</span>
                                    </div>
                                </li>
                            </ul>
                        </div>



                        <div class="p-t-50">
                            <h4 class="mtext-112 cl2 p-b-27">
                                Tags
                            </h4>

                            <div class="flex-w m-r--5">
                                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Fashion
                                </a>

                                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Lifestyle
                                </a>

                                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Denim
                                </a>

                                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Streetstyle
                                </a>

                                <a href="#" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                    Crafts
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Related Post -->
    <section class="sec-relate-product bg0 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Related posts
                </h3>
            </div>

            <ul class="postRelated">
                @foreach( $postRelated as $key => $post)
                    <div class="row" style="margin: 15px 20px">
                        <div class="col-md-2">
                            <img  width="100%" src="{{url('public/uploads/posts/'.$post->post_image)}}" alt="IMG-PRODUCT">
                        </div>
                        <div class="col-md-9">
                            <h5 style="margin: 15px 0px">
                                <a href="{{URL::to('/postDetail/'.$post->post_slug)}}"> {{$post->post_title}}</a>
                            </h5>

                            <p>{{$post->post_des}}</p>


                            <div class="flex-w flex-sb-m p-t-18">
									<span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
										<span>
											<span class="cl4">By</span> Admin
											<span class="cl12 m-l-4 m-r-6">|</span>
										</span>

										<span>
											StreetStyle, Fashion, Couple
											<span class="cl12 m-l-4 m-r-6">|</span>
										</span>

										<span>
											8 Comments
										</span>
									</span>

                                <a href="{{url('/postDetail/'.$post->post_slug)}}" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                    Continue Reading

                                    <i class="fa fa-long-arrow-right m-l-9"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="row" style="margin: 15px 20px">
                        <div class="col-md-2">
                            <img  width="100%" src="{{url('public/uploads/posts/'.$post->post_image)}}" alt="IMG-PRODUCT">
                        </div>
                        <div class="col-md-9">
                            <h5 style="margin: 15px 0px">
                                <a href="{{URL::to('/postDetail/'.$post->post_slug)}}"> {{$post->post_title}}</a>
                            </h5>

                            <p>{{$post->post_des}}</p>


                            <div class="flex-w flex-sb-m p-t-18">
									<span class="flex-w flex-m stext-111 cl2 p-r-30 m-tb-10">
										<span>
											<span class="cl4">By</span> Admin
											<span class="cl12 m-l-4 m-r-6">|</span>
										</span>

										<span>
											StreetStyle, Fashion, Couple
											<span class="cl12 m-l-4 m-r-6">|</span>
										</span>

										<span>
											8 Comments
										</span>
									</span>

                                <a href="{{url('/postDetail/'.$post->post_slug)}}" class="stext-101 cl2 hov-cl1 trans-04 m-tb-10">
                                    Continue Reading

                                    <i class="fa fa-long-arrow-right m-l-9"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </ul>


        </div>
    </section>
@endsection
{{--<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        $('header').addClass('header-v4');
        $('.wrap-menu-desktop').addClass('how-shadow1');
    });

</script>--}}
