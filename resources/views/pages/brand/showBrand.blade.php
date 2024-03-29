@extends('layout')
@section('content')
    <div class="features_items"><!--features_items-->
        @foreach($brandName as $key => $brand)
        <h2 class="title text-center">{{$brand->brand_name}}</h2>
        @endforeach
        @foreach($productsByBrand as $key => $product)
            <a href="{{URL::to('/productDetail/'.$product->product_slug)}}">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{URL::to('public/uploads/products/'.$product->product_image)}}" alt="" />
                                {{--<img src="{{('public/frontend/images/product1.jpg')}}" alt="" />--}}
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
                </div>
            </a>

        @endforeach
    </div>

@endsection
