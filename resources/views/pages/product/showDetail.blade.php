@extends('layout')
@section('content')
    <div class="features_items"><!--features_items-->
       {{-- like share--}}
        <div>
            <div class="fb-share-button" data-href="{{$urlCanonical}}"
                 data-layout="button_count" data-size="small">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$urlCanonical}}&amp;src=sdkpreparse"
                   class="fb-xfbml-parse-ignore">Chia sẻ</a>
            </div>
            <div class="fb-like" data-href="{{$urlCanonical}}"
                 data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false" >
            </div>
        </div>
        {{--End like share--}}

        {{-- breadcrumb--}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="background: none">
                <li class="breadcrumb-item"><a href="{{url('/home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{url('/productsByCategory/'.$categorySlug)}}">{{$categoryName}}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$metaTitle}}</li>
            </ol>
        </nav>
        {{-- END breadcrumb--}}

    @foreach($productDetail as $key => $product)
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <style>
            li.active{
                border:3px solid #3790b3;
            }
            .tags{
                background: #0f74a8;
                color: whitesmoke;
                border-radius:3px ;
                margin: 3px;
                height: auto;
            }
        </style>

        <ul id="imageGallery">
            @foreach($gallery as $key => $gal)
            {{-- hình nhỏ--}}<li data-thumb="{{URL::to('public/uploads/gallery/'.$gal->gallery_image)}}" data-src="{{URL::to('public/uploads/gallery/'.$gal->gallery_image)}}"> {{--data-src khi click ào sẽ đổi thành hình lớn--}}
           {{-- hình lớn chính--}}<img width="100%" src="{{URL::to('public/uploads/gallery/'.$gal->gallery_image)}}"  alt="{{$gal->gallery_name}}"/> {{--alt là mô tả hình ảnh để google hiểu cho nó chuẩn seo--}}
            </li>
            @endforeach

        </ul>


    </div>
    <div class="col-sm-7">

        <div class="product-information"><!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$product->product_name}}</h2>
            <p>Product ID: {{$product->product_id}}</p>
            <img src="images/product-details/rating.png" alt="" />
            <form>
               @csrf
               <span>
                    <span>{{number_format($product->product_price).' VNĐ'}}</span>
                    <label>Quantity:</label>
                    <input name="quantity" class="cartProductQty-{{$product->product_id}}" type="number" min="1" value="1" />
                   <input type="hidden" class="qtyProductInStock-{{$product->product_id}}" value="{{$product->product_quantity}}" />
                   <input type="hidden" class="cartProductId-{{$product->product_id}}" value="{{$product->product_id}}">
                    <input type="hidden" class="cartProductName-{{$product->product_id}}" value="{{$product->product_name}}">
                    <input type="hidden" class="cartProductImage-{{$product->product_id}}" value="{{$product->product_image}}">
                    <input type="hidden" class="cartProductPrice-{{$product->product_id}}" value="{{$product->product_price}}">
                    <button type="button" class="btn btn-default cart add-to-cart" name="addToCart" data-id="{{$product->product_id}}">
                        <i class="fa fa-shopping-cart"></i>
                        Add to cart
                    </button>
                </span>
            </form>
            <p><b>Availability(trạng thái):</b> {{$product->product_quantity > 0 ? 'In Stock(còn hàng)' :'Out Stock'}}</p>
            <p><b>Condition (tình trạng):</b> New</p>
            <p><b>Brand:</b> {{$product->brand_name}}</p>
            <p><b>Category:</b> {{$product->category_name}}</p>
            <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
            <fieldset>
                <legend>Tags</legend>
                <p><i class="fa fa-tags"> </i>
                        @php
                        $tags = $product->product_tags;
                        $tags = explode(',',$tags);
                        @endphp
                        @foreach($tags as $key =>$tag)
                            {{--hàm str_slug sẽ thêm dầu - giữa các chữ  cho đẹp--}}
                            <a href="{{url('/tag/'.str_slug($tag))}}" class="tags" >{{$tag}}</a>
                        @endforeach

                </p>
            </fieldset>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->

<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li ><a href="#details" data-toggle="tab">Content</a></li>
            <li><a href="#companyprofile" data-toggle="tab">Desription</a></li>
            <li class="active"><a href="#reviews" data-toggle="tab">Reviews (5)</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade " id="details" >
          <p>{!! $product->product_content !!}</p>

        </div>

        <div class="tab-pane fade" id="companyprofile" >
           <p>{!! $product->product_des !!}</p>

        </div>

        <style>
            .styleComment{
                background: #fffafa;
                margin-top: 30px;
                border-radius: 20px;
                border: 1px solid silver;
            }
            .styleComment img{
                margin: 8px;
                width: 100%;
            }
            .styleReply img{
                margin: 8px;
                width: 80%;
            }
            .styleReply{
                background: #ddeadd;
                margin: 5px 50px;
                border-radius: 20px;
                border: 1px solid silver;
            }
                    </style>

        <div class="tab-pane fade active in" id="reviews" >
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user"></i>Admin</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                </ul>
                <form>
                   @csrf
                    <input type="hidden" class="commentProductId" value="{{$productDetail[0]->product_id}}">
                    <div id="showComment"></div>

                </form>
                <h3>Write your comment</h3>
                <ul class="list-inline rating" title="Average Rating"> {{--title là tiêu đề bình thường thôi, k có j hết--}}
                    @for($count =1;$count <=5;$count++) {{--lặp ra 5 sao--}}
                            @php
                                if($count <= $rating){//nếu bé hơn thì cho hiển thị sao màu vàng
                                        $color = '#ffcc00';
                                    }else{  //lớn hơn thì cho màu xám
                                        $color ='#ccc';
                                  }


                            @endphp
                    <li title="Star Rating"
                        id="{{$productDetail[0]->product_id}}-{{$count}}"
                        data-index ="{{$count}}"  {{--khi mình click sao thứ 2 sao thì $count ở đây là 2, mỗi li mang một thứ tự sao là count--}}
                        data-product_id="{{$productDetail[0]->product_id}}"
                        data-rating ="{{$rating}}" {{--số trung bình cộng hiện tại--}}
                        class="rating"
                        style="cursor:pointer;font-size: 30px;color:{{$color}}"> {{--cursor:pointer khi hover nó sẽ hiện con trỏ chuột thành cái tay--}}
                        &#9733;
                    </li>

                    @endfor
                </ul>

                <form>
                    <input type="text" placeholder="Your Name" class="form-control commentName"/>
                    <textarea name="commentContent" class="commentContent" placeholder="Write a comment" ></textarea>

                    <button type="button" class="btn btn-default pull-right sendComment">
                        Submit
                    </button>
                    <div class="notifyComment"></div>
                    <b>Rating: </b> <img src="{{url('public/frontend/images/rating.png')}}" alt="" />
                </form>
            </div>
        </div>

    </div>
</div><!--/category-tab-->
    @endforeach
<div class="recommended_items"><!--recommended_items mục được đề xuất-->
    <h2 class="title text-center">related items</h2>

    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="item active">
                @foreach($productRelated as $key => $product)
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{URL::to('public/uploads/products/'.$product->product_image)}}" alt="" />
                                <h2>{{number_format($product->product_price).' VNĐ'}}</h2>
                                <p>{{$product->product_name}}</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>


            </div>
        </div>
        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
            <i class="fa fa-angle-left"></i>
        </a>
        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
</div><!--/recommended_items-->


        {{--comment facebook
        <div class="fb-comments" data-href="http://localhost:8080/shopperfume/categoryProduct/6" data-width="" data-numposts="20"></div>
        <div class="fb-page" data-href="https://www.facebook.com/Du-Ca-&#x110;akmil-1005331139581419/" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true"><blockquote cite="https://www.facebook.com/Du-Ca-&#x110;akmil-1005331139581419/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/Du-Ca-&#x110;akmil-1005331139581419/">Du Ca Đakmil</a></blockquote></div>
--}}
    @endsection
