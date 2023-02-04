@extends('frontend_layout')
@section('header')
    @include('pages.include.headerNormal')
    @endsection
@section('content')

    {{--<div class="features_items"><!--features_items-->
        <h2 class="title text-center">Search results</h2>
        @foreach($searchProduct as $key => $product)
            <div class="col-sm-4">
                <a href="{{URL::to('/productDetail/'.$product->product_id)}}">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{('public/uploads/products/'.$product->product_image)}}" alt="" />
                                --}}{{--<img src="{{('public/frontend/images/product1.jpg')}}" alt="" />--}}{{--
                                <h2>{{number_format($product->product_price).' VNĐ'}}</h2>
                                <p>{{$product->product_name}}</p>
                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                            </div>

                        </div>
                        <div class="choose">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist(danh sách mong ước)</a></li>
                                <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare(đối chiếu)</a></li>
                            </ul>
                        </div>
                    </div>
                </a>


            </div>
        @endforeach

    </div><!--features_items-->--}}

@endsection
