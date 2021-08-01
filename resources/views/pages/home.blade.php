@extends('layout')

@section('imageHome')
    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
            <li data-target="#slider-carousel" data-slide-to="1"></li>
            <li data-target="#slider-carousel" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner">
            @php $i=0; @endphp
            @foreach($allSlider as $key => $slider)

            <div class="item {{$i == 0 ?'active' : ''}}">

                <div class="col-sm-12">
                    {{--thẻ alt là để hiển thị mô tả, để google hiểu về cái hình ảnh này để làm j --}}
                    <img alt="{{$slider->slider_des}}"src="{{('public/uploads/sliders/'.$slider->slider_image)}}"   width="100%" height="300px" class="img img-responsive" />
                </div>
            </div>
                @php $i=1; @endphp
            @endforeach

        </div>

        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
@endsection


@section('content')

<div class="features_items"><!--features_items-->
    <h2 class="title text-center">New products</h2>
    @foreach($newProducts as $key => $product)
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
                            <img src="{{('public/uploads/products/'.$product->product_image)}}" alt="" />
                            <h2>{{number_format($product->product_price).' VNĐ'}}</h2>
                            <p>{{$product->product_name}}</p>
                        </a>
                {{-- data-id là dùng để lấy những cái dữ liệu thuộc cái id của product hiện tại click vào,
                không có thì nó sẽ lấy product đầu hoặc cuối--}}
                        <button type="button" class="btn btn-default add-to-cart" name="addToCart" data-id="{{$product->product_id}}">Add to cart</button>
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
