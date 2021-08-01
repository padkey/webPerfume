@extends('layout')
@section('content')

    @foreach($productDetail as $key => $product)
<div class="product-details"><!--product-details-->
    <div class="col-sm-5">
        <div class="view-product">
            <img src="{{URL::to('public/uploads/products/'.$product->product_image)}}" alt="" />
            <h3>ZOOM</h3>
        </div>
        <div id="similar-product" class="carousel slide" data-ride="carousel">

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <a href=""><img src="{{URL::to('public/frontend/images/similar1.jpg')}}" alt=""></a>
                    <a href=""><img src="{{URL::to('public/frontend/images/similar2.jpg')}}" alt=""></a>
                    <a href=""><img src="{{URL::to('public/frontend/images/similar3.jpg')}}" alt=""></a>
                </div>
                <div class="item">
                    <a href=""><img src="{{URL::to('public/frontend/images/similar1.jpg')}}" alt=""></a>
                    <a href=""><img src="{{URL::to('public/frontend/images/similar2.jpg')}}" alt=""></a>
                    <a href=""><img src="{{URL::to('public/frontend/images/similar3.jpg')}}" alt=""></a>
                </div>
                <div class="item">
                    <a href=""><img src="{{URL::to('public/frontend/images/similar1.jpg')}}" alt=""></a>
                    <a href=""><img src="{{URL::to('public/frontend/images/similar2.jpg')}}" alt=""></a>
                    <a href=""><img src="{{URL::to('public/frontend/images/similar3.jpg')}}" alt=""></a>
                </div>

            </div>

            <!-- Controls -->
            <a class="left item-control" href="#similar-product" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right item-control" href="#similar-product" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>

    </div>
    <div class="col-sm-7">
        <div class="product-information"><!--/product-information-->
            <img src="images/product-details/new.jpg" class="newarrival" alt="" />
            <h2>{{$product->product_name}}</h2>
            <p>Product ID: {{$product->product_id}}</p>
            <img src="images/product-details/rating.png" alt="" />
            <form action="{{URL::to('/saveCart/')}}" method="POST">
                {{ csrf_field() }}
                               <span>
									<span>{{number_format($product->product_price).' VNĐ'}}</span>
									<label>Quantity:</label>
									<input name="quantity" type="number" min="1" value="1" />
                                   <input type="hidden" name="productId" value="{{$product->product_id}} " />
									<button type="submit" class="btn btn-fefault cart">
										<i class="fa fa-shopping-cart"></i>
										Add to cart
									</button>
								</span>
            </form>
            <p><b>Availability(trạng thái):</b> In Stock(còn hàng)</p>
            <p><b>Condition (tình trạng):</b> New</p>
            <p><b>Brand:</b> {{$product->brand_name}}</p>
            <p><b>Category:</b> {{$product->category_name}}</p>
            <a href=""><img src="images/product-details/share.png" class="share img-responsive"  alt="" /></a>
        </div><!--/product-information-->
    </div>
</div><!--/product-details-->

<div class="category-tab shop-details-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Content</a></li>
            <li><a href="#companyprofile" data-toggle="tab">Desription</a></li>
            <li ><a href="#reviews" data-toggle="tab">Reviews (5)</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="details" >
          <p>{!! $product->product_content !!}</p>

        </div>

        <div class="tab-pane fade" id="companyprofile" >
           <p>{!! $product->product_des !!}</p>

        </div>



        <div class="tab-pane fade" id="reviews" >
            <div class="col-sm-12">
                <ul>
                    <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                    <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                    <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <p><b>Write Your Review</b></p>

                <form action="#">
										<span>
											<input type="text" placeholder="Your Name"/>
											<input type="email" placeholder="Email Address"/>
										</span>
                    <textarea name="" ></textarea>
                    <b>Rating: </b> <img src="images/product-details/rating.png" alt="" />
                    <button type="button" class="btn btn-default pull-right">
                        Submit
                    </button>
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
            <div class="item">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="{{URL::to('public/frontend/images/recommend1.jpg')}}" alt="" />
                                <h2>$56</h2>
                                <p>Easy Polo Black Edition</p>
                                <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                            </div>
                        </div>
                    </div>
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

    @endsection
