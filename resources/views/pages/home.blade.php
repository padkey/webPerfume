@extends('layout')

@section('slider')
    @include('pages.include.slider') {{--bỏ slider qua file khác cho gọn--}}
@endsection


@section('content')
    <style>
        .modal-lg{
            width: 1200px;
        }
        .modal {
            text-align: center;
        }

        @media screen and (min-width: 768px) {
            .modal:before {
                display: inline-block;
                vertical-align: middle;
                content: " ";
                height: 100%;
            }
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }
    </style>

<div class="features_items"><!--features_items-->
    <div class="category-tab"><!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                @php $i=1@endphp {{--cho tab đầu sáng --}}
                @foreach($categoryTabs as $key => $category)
                <li class="categoryTab {{$i == 1 ?'active' : ''}}" data-id="{{$category->category_id}}"><a data-toggle="tab">{{$category->category_name}}</a></li>
                    @php $i++ @endphp
                @endforeach
            </ul>
        </div>
        <div id="productsByTab"></div>

    </div><!--/category-tab-->


    <h2 class="title text-center">New products</h2>
    @foreach($newProducts as $key => $product)
    <div class="col-sm-4">

            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form>
                            @csrf
                            <input type="hidden" id="wishlist" class="cartProductId-{{$product->product_id}}" value="{{$product->product_id}}">
                            <input type="hidden" id="wishlistProductName-{{$product->product_id}}" class="cartProductName-{{$product->product_id}}" value="{{$product->product_name}}">
                            <input type="hidden" class="cartProductImage-{{$product->product_id}}" value="{{$product->product_image}}">
                            <input type="hidden"  class="cartProductPrice-{{$product->product_id}}" value="{{$product->product_price}}">
                            <input type="hidden" class="cartProductQty-{{$product->product_id}}" value="1">
                            <input type="hidden" class="qtyProductInStock-{{$product->product_id}}" value="{{$product->product_quantity}}">
                            <a id="wishlistProductUrl-{{$product->product_id}}" href="{{URL::to('/productDetail/'.$product->product_slug)}}">
                            <img id="wishlistProductImage-{{$product->product_id}}" src="{{url('public/uploads/products/'.$product->product_image)}}" alt="" />
                            <h2 id="wishlistProductPrice-{{$product->product_id}}" >{{number_format($product->product_price).' VNĐ'}}</h2>
                            <p>{{$product->product_name}}</p>

                        </a>
                {{-- data-id là dùng để lấy những cái dữ liệu thuộc cái id của product hiện tại click vào,
                không có thì nó sẽ lấy product đầu hoặc cuối--}}

                             <button type="button" class="btn btn-default add-to-cart" name="addToCart" data-id="{{$product->product_id}}">Add to cart</button>
                            <button type="button" class="btn btn-default quickViewProduct" data-target="#quickView" data-toggle="modal"  data-id="{{$product->product_id}}" style="margin-bottom: 25px">Quick view</button>


                        </form>
                    </div>

                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><button class="btn btn-info btn-sm addToWishlist" data-id="{{$product->product_id}}"> Add to wishlist <i class="fa fa-plus-square"></i></button></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare(đối chiếu)</a></li>
                    </ul>
                </div>
            </div>

    </div>
    @endforeach
    <div>
        <ul class="pagination pagination-sm m-t-none m-b-none">
                {!! $newProducts->links('vendor.pagination.bootstrap-4') !!}
        </ul>
    </div>


</div><!--features_items-->
    <!-- Modal quick view  để ngoài để đỡ phải dính class=single-product-->
    <div class="modal fade" id="quickView" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickViewProductName">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5">
                                    <div  id="quickViewProductGallery">
                                        <ul id="imageGallery">

                                        </ul>
                                    </div>
                            </div>
                            <form>
                                @csrf
                                <div id="quickViewProductValue"></div>
                                <div class="col-md-7">
                                    <h2 class="quickViewProductName"></h2>
                                    <span>
                                        <h2>Price : <span  id="quickViewProductPrice"></span></h2>
                                        <br>
                                        <label>Quantity  </label>
                                        <span id="inputProductQty"></span>
                                        <br>
                                        <h3>Description</h3><p id="quickViewProductDes"></p>
                                        <br>

                                        <div id="btnAddToCart"></div>
                                    </span>
                                </div>
                            </form>


                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

