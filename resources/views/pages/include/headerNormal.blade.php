<!-- Header -->
<header class="header-v4">
    <!-- Header Normal -->
    <div class="container-menu-desktop" style="   height: 85px;">


        <div class="wrap-menu-desktop how-shadow1" style="top: 0px;">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="{{url('/home')}}" class="logo">
                    <img src="{{url('public/frontend2/images/icons/logo-01.png')}}" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu">
                            <a href="{{url('/home')}}">Home</a>
                        </li>

                        <li>
                            <a href="#">Shop</a>
                            <ul class="sub-menu">
                                @foreach($categoryProduct as $key => $category)
                                    <li><a href="{{url('/productsByCategory/'.$category->category_slug)}}">{{$category->category_name}}</a></li>
                                @endforeach
                            </ul>
                        </li>

                        <li class="label1" data-label1="hot">
                            <a href="shoping-cart.html">Features</a>
                        </li>

                        <li>
                            <a href="{{url('/home')}}">Blog</a>
                            <ul class="sub-menu">
                                @foreach($allCategoryPost as $key => $catePost)
                                    <li><a href="{{url('/listPostByCate/'.$catePost->category_post_slug)}}">{{$catePost->category_post_name}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                        <li>
                            <a href="{{url('/listVideo')}}">Video Review</a>
                        </li>
                        <li>
                            <a href="{{url('/showContact')}}">Contact</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" id="showCartQty"  data-notify="0">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>

                    <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="0">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </a>


                    @if(Session::get('customerId'))
                        <div>

                            <ul class="main-menu">
                                <li>
                                    <a href="" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11" ><i class="zmdi zmdi-account" style="font-size: 20px"></i>
                                        <span style="font-size: 17px">{{Session::get('customerName')}}</span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li><a href="{{url('/profileCustomer')}}">Profile</a></li>
                                        <li><a href="{{url('/orderHistory/0')}}">Order history</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <a href="{{url('/logoutCustomer')}}" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                            <span style="font-size: 17px">Logout</span>
                        </a>

                    @else
                        <div>
                            <a href="" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11" data-toggle="modal" data-target="#modalLogin"><i class="zmdi zmdi-account"></i>
                                <span style="font-size: 17px">Login</span>
                            </a>
                        </div>

                    @endif


                </div>


                <!-- Modal LOGIN-->
                <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <!--Content-->
                        <div class="modal-content form-elegant">
                            <!--Header-->
                            <div class="modal-header text-center">
                                <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel"><strong>Login</strong></h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!--Body-->
                            <div class="modal-body mx-4">
                                <!--Body-->
                                <form action = "{{URL::to('/customerLogin')}}" method="POST" id="myForm">
                                    @csrf
                                    <div class="md-form mb-5">
                                        <label>Your email</label>
                                        <input type="email" name="emailAccount" class="form-control">
                                    </div>

                                    <div class="md-form pb-3">
                                        <label>Your password</label>
                                        <input type="password" class="form-control" name="passwordAccount">

                                        <p class="font-small blue-text d-flex justify-content-end">
                                            Forgot <a href="#" class="blue-text ml-1">Password?</a>
                                        </p>

                                    </div>

                                    <div class="text-center mb-3">
                                        <button type="submit" class="btn blue-gradient btn-block btn-rounded z-depth-1a">Login</button>
                                    </div>

                                </form>


                                <p class="font-small dark-grey-text text-right d-flex justify-content-center mb-3 pt-2">
                                    or login with:</p>

                                <div class="row my-3 d-flex justify-content-center">
                                    <!--Facebook-->
                                    <button type="button" class="btn btn-white btn-rounded mr-md-3 z-depth-1a"><i class="fa fa-facebook text-center"></i></button>
                                    <!--Twitter-->
                                    <button type="button" class="btn btn-white btn-rounded mr-md-3 z-depth-1a"><i class="fa fa-twitter"></i></button>
                                    <!--Google +-->
                                    <button type="button" class="btn btn-white btn-rounded z-depth-1a"><i class="fa fa-google"></i></button>
                                </div>
                            </div>
                            <!--Footer-->
                            <div class="modal-footer mx-5 pt-3 mb-1">
                                <p class="font-small grey-text d-flex justify-content-end">Not a member? <a href="#" class="blue-text ml-1">
                                        Login</a></p>
                            </div>
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
                <!-- END Modal LOGIN -->
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="2">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

            <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    Free shipping for standard order over $100
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        Help & FAQs
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        My Account
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        EN
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        USD
                    </a>
                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li>
                <a href="index.html">Home</a>
                <ul class="sub-menu-m">
                    <li><a href="index.html">Homepage 1</a></li>
                    <li><a href="home-02.html">Homepage 2</a></li>
                    <li><a href="home-03.html">Homepage 3</a></li>
                </ul>
                <span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
            </li>

            <li>
                <a href="product.html">Shop</a>
            </li>

            <li>
                <a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
            </li>

            <li>
                <a href="blog.html">Blog</a>
            </li>

            <li>
                <a href="about.html">About</a>
            </li>

            <li>
                <a href="contact.html">Contact</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>
