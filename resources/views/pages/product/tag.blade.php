@extends('layout')
@section('content')

    <div class="features_items"><!--features_items-->


            <h2 class="title text-center">{{$metaDes}}</h2>

        @foreach($productByTag as $key => $product)

            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <form>
                                @csrf
                                <input type="hidden" class="cartProductId-{{$product->product_id}}" value="{{$product->product_id}}">
                                <input type="hidden" class="cartProductName-{{$product->product_id}}" value="{{$product->product_name}}">
                                <input type="hidden" class="cartProductImage-{{$product->product_id}}" value="{{$product->product_image}}">
                                <input type="hidden" class="cartProductPrice-{{$product->product_id}}" value="{{$product->product_price}}">
                                <input type="hidden" class="cartProductQty-{{$product->product_id}}" value="1">
                                <a href="{{URL::to('/productDetail/'.$product->product_slug)}}">
                                    <img src="{{URL::to('public/uploads/products/'.$product->product_image)}}" alt="" />
                                    <h2>{{number_format($product->product_price).' VNĐ'}}</h2>
                                    <p>{{$product->product_name}}</p>
                                </a>
                                <button data-id="{{$product->product_id}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </form>
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

        @endforeach
    </div><!--features_items-->
@endsection
