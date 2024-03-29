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

            <a href="{{url('/productsByCategory/'.$categorySlug)}}" class="stext-109 cl8 hov-cl1 trans-04">
                {{$categoryName}}
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
				{{$metaTitle}}
			</span>
        </div>
    </div>


    <!-- Product Detail -->
    @foreach($productDetail as $key => $product)
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                            <div class="slick3 gallery-lb">
                                @foreach($gallery as $key => $gal)
                                <div class="item-slick3" data-thumb="{{url('/public/uploads/gallery/'.$gal->gallery_image)}}">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="{{url('/public/uploads/gallery/'.$gal->gallery_image)}}" alt="{{$product->product_name}}">

                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{url('/public/uploads/gallery/'.$gal->gallery_image)}}">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">


                        <input type="hidden" class="qtyProductInStock-{{$product->product_id}}" value="{{$product->product_quantity}}" />
                        <input type="hidden" class="cartProductId-{{$product->product_id}}" value="{{$product->product_id}}">
                        <input type="hidden" class="cartProductName-{{$product->product_id}}" value="{{$product->product_name}}">
                        <input type="hidden" class="cartProductImage-{{$product->product_id}}" value="{{$product->product_image}}">
                        <input type="hidden" class="cartProductPrice-{{$product->product_id}}" value="{{$product->product_price}}">


                        <h4 class="mtext-105 cl2 js-name-detail p-b-40" style="font-size: 45px">
                            {{$product->product_name}}
                        </h4>

                        <span class="mtext-106 cl2" style="font-size:25px">
							{{number_format($product->product_price,0,',','.')}}đ
						</span>

                            <div class="flex-w  p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product cartProductQty-{{$product->product_id}}" type="number" name="num-product" value="1">


                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>
                                    </div>
                                    <div class="showCartQty" data-notify="0"></div>
                                    <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 add-to-cart" data-id="{{$product->product_id}}">
                                        Add to cart
                                    </button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#description" role="tab">Description</a>
                        </li>
                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#content" role="tab">Content</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#reviews" role="tab">Reviews (1)</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show " id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {{$product->product_des}}
                                </p>
                            </div>
                        </div>
                        <!-- - -->
                        <div class="tab-pane fade show " id="content" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {!! $product->product_content !!}
                                </p>
                            </div>
                        </div>
                        <!-- - -->


                        <!-- - -->
                        <div class="tab-pane fade show active" id="reviews" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <div class="p-b-30 m-lr-15-sm">
                                        <!-- Review -->
                                        <form>
                                            @csrf
                                            <input type="hidden" class="commentProductId" value="{{$productDetail[0]->product_id}}">
                                            <div id="showComment"></div>
                                        </form>


                                        <!-- Add review -->
                                        <form class="w-full">

                                            <h5 class="mtext-108 cl2 p-b-7">
                                                Add a review
                                            </h5>

                                            <p class="stext-102 cl6">
                                                Your email address will not be published. Required fields are marked *
                                            </p>

                                            <div class="flex-w flex-m p-t-50 p-b-23">
												<span class="stext-102 cl3 m-r-16">
													Your Rating
												</span>

                                                <span class="wrap-rating fs-18 cl11 pointer">
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<input class="dis-none" type="number" name="rating">
												</span>
                                            </div>

                                            <div class="row p-b-25">
                                                <div class="col-12 p-b-5">
                                                    <label class="stext-102 cl3" for="review">Your review</label>
                                                    <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review"></textarea>
                                                </div>

                                                <div class="col-sm-6 p-b-5">
                                                    <label class="stext-102 cl3" for="name">Name</label>
                                                    <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text" name="name">
                                                </div>

                                                <div class="col-sm-6 p-b-5">
                                                    <label class="stext-102 cl3" for="email">Email</label>
                                                    <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="text" name="email">
                                                </div>
                                            </div>

                                            <button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                Submit
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
			<span class="stext-107 cl6 p-lr-25">
				SKU: JAK-01
			</span>

            <span class="stext-107 cl6 p-lr-25">
				Categories: Jacket, Men
			</span>
        </div>
    </section>
    @endforeach

    <!-- Related Products -->
    <section class="sec-relate-product bg0 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Related Products
                </h3>
            </div>

            <!-- Slide2 -->
            <div class="wrap-slick2">
                <div class="slick2">
                    @foreach($productRelated as $key => $productRela)
                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img height="300px" src="{{url('public/uploads/products/'.$productRela->product_image)}}" alt="IMG-PRODUCT">

                                <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                    Quick View
                                </a>
                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="{{url('/productDetail/'.$productRela->product_slug)}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{$productRela->product_name}}
                                    </a>

                                    <span class="stext-105 cl3">
										 {{number_format($productRela->product_price,0,',','.')}}đ
									</span>
                                </div>

                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                        <img class="icon-heart1 dis-block trans-04" src="{{url('/public/frontend2/images/icons/icon-heart-01.png')}}" alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{url('/public/frontend2/images/icons/icon-heart-02.png')}}" alt="ICON">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>



                    @endforeach

                </div>
            </div>
        </div>
    </section>



    {{--<script>
        document.addEventListener("DOMContentLoaded", function(event) {
            $('header').addClass('header-v4');
            $('.wrap-menu-desktop').addClass('how-shadow1');
        });

    </script>--}}
@endsection
