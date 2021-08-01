@extends('layout')
@section('content')

    <div class="features_items"><!--features_items-->
<div>
    <div class="fb-share-button" data-href="http://localhost:8080/shopperfume/home"
         data-layout="button_count" data-size="small">
        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$urlCanonical}}&amp;src=sdkpreparse"
           class="fb-xfbml-parse-ignore">Chia sẻ</a>
    </div>
    <div class="fb-like" data-href="{{$urlCanonical}}"
         data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false" >
    </div>
</div>



        @foreach($categoryName as $key => $category)
        <h2 class="title text-center">{{$category->category_name}}</h2>
        @endforeach
        @foreach($productsByCategory as $key => $product)

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
                                <a href="{{URL::to('/productDetail/'.$product->product_id)}}">
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
        <div class="fb-comments" data-href="http://localhost:8080/shopperfume/categoryProduct/6" data-width="" data-numposts="20"></div>
        <div class="fb-page" data-href="https://www.facebook.com/Du-Ca-&#x110;akmil-1005331139581419/" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Du-Ca-&#x110;akmil-1005331139581419/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Du-Ca-&#x110;akmil-1005331139581419/">Du Ca Đakmil</a></blockquote></div>
    </div><!--features_items-->
    @endsection
