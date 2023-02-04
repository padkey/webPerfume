<header>
    <!-- Header Home -->
    <div class="container-menu-desktop">

        <div class="wrap-menu-desktop">
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

                        <li class="label1" data-label1="hot">
                            <a href="#">Shop</a>
                            <ul class="sub-menu">
                                @foreach($categoryProduct as $key => $category)
                                    <li><a href="{{url('/productsByCategory/'.$category->category_slug)}}">{{$category->category_name}}</a></li>
                                @endforeach
                            </ul>
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
                    <!--  Search -->
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    <!-- Modal Search -->
                    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
                        <div class="container-search-header">
                            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                                <img src="{{url('public/frontend2/images/icons/icon-close2.png')}}" alt="CLOSE">
                            </button>

                            <form class="wrap-search-header flex-w p-l-15" action="{{URL::to('/search')}}" method="POST">
                                @csrf
                                <button class="flex-c-m trans-04" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                                <input class="plh3" type="text" name="keywords" id="keywords" placeholder="Search...">
                            </form>
                        </div>
                    </div>





                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" id="showCartQty" data-notify="0">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>

                    <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="0">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </a>


                    @if(Session::get('customerId'))
                        <div>

                            <ul class="main-menu">
                                <li>
                                    <a href="" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11" >
                                        <i class="zmdi zmdi-account" style="font-size: 20px"></i>
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
                        <div class="row">
                            <a href="" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-59 p-r-11"  data-toggle="modal" data-target="#modalRegister"  style="border-right: 1px solid #333333 ">
                                <span style="font-size: 17px">Register</span></a>
                            <hr>
                            <a href="" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-lr-11" data-toggle="modal" data-target="#modalLogin">
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
                            <div class="modal-header text-center" style="padding-bottom: 0px">
                                <h1 class="modal-title w-100 dark-grey-text font-weight-bold mt-lg-5" id="myModalLabel"><strong>Login</strong></h1>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!--Body-->
                            <div class="modal-body mx-4" >
                                <!--Body-->
                                <form  class="card-form" autocomplete="off">
                                    @csrf

                                    <div class="md-form mb-5 input">
                                        <input type="email" name="emailAccount" class="input-field emailAccount"  required>
                                        <label  class="input-label">Your email</label>
                                    </div>

                                    <div class="md-form input">
                                        <input type="password" class="input-field passwordAccount" name="passwordAccount"  required>
                                        <label  class="input-label">Your password</label>
                                    </div>

                                    <div class="text-center mb-5">
                                        <p class="font-small blue-text d-flex justify-content-end">
                                            Forgot <a href="#" class="blue-text ml-1" data-toggle="modal" data-target="#forgetPassword">Password?</a>
                                        </p>
                                    </div>
                                    <div class="text-center mb-3">
                                        <button type="button" class="btn blue-gradient btn-block btn-rounded z-depth-1a customerLogin" style="height: 50px">
                                            Login</button>
                                    </div>

                                </form>


                                <p class="font-small dark-grey-text text-right d-flex justify-content-center mb-3 pt-2">
                                    or login with:</p>

                                <div class="row my-3 d-flex justify-content-center">
                                    <!--Facebook-->
                                    <button type="button" class="btn btn-white btn-rounded mr-md-3 z-depth-1a btn-sigin"><i class="fa fa-facebook text-center"></i></button>
                                    <!--Twitter-->
                                    <button type="button" class="btn btn-white btn-rounded mr-md-3 z-depth-1a btn-sigin"><i class="fa fa-twitter"></i></button>
                                    <!--Google +-->
                                    <button type="button" class="btn btn-white btn-rounded z-depth-1a btn-sigin"><i class="fa fa-google"></i></button>
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


                {{--MODal Forget password--}}
                <div class="modal fade" id="forgetPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content form-elegant">
                            <div class="modal-header">
                                <h1 class="modal-title w-100 dark-grey-text font-weight-bold mt-lg-5" ><strong>Forget Password!</strong></h1>

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div>
                                <div  class="card-form">
                                        <div class="md-form mb-5 input">
                                            <input type="email" name="emailForget" class="input-field emailForget"  required>
                                            <label  class="input-label">Enter Your email</label>
                                        </div>
                                    <button type="button" class="btn btn-info forgetPassword" style="margin: 20px 0px;float: right">Confirm</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Modal REGISTER-->
                <div class="modal fade" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <!--Content-->
                        <div class="modal-content form-elegant">
                            <!--Header-->
                            <div class="modal-header text-center" style="padding-bottom: 0px">
                                <h2 class="modal-title w-100 dark-grey-text font-weight-bold mt-lg-5" id="myModalLabel"><strong>Register</strong></h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <!--Body-->
                            <div class="modal-body mx-4" >
                                <!--Body-->
                                <form class="card-form">
                                    @csrf
                                    <div class="md-form p-b-8 input">
                                        <input type="text" name="nameRegister" class="input-field nameRegister" required>
                                        <label  class="input-label">Your name</label>
                                    </div>
                                    <div class="md-form p-b-8 input">
                                        <input type="text" name="phoneRegister" class="input-field phoneRegister"  required>
                                        <label  class="input-label phone">Phone</label>
                                    </div>
                                    <div class="md-form p-b-8  input">
                                        <input type="email" name="emailRegister" class="input-field emailRegister"  required>
                                        <label  class="input-label email">Your email</label>
                                    </div>

                                    <div class="md-form p-b-8 input">
                                        <input type="password"  name="passwordRegister" class="input-field passwordRegister" required>
                                        <label  class="input-label password">Password</label>
                                    </div>
                                    <div class="md-form p-b-45 input">
                                        <input type="password" name="repassword" class="input-field repassword"   required>
                                        <label  class="input-label password">Re-password</label>
                                    </div>
                                    <div class="text-center mb-5">
                                        <button type="button" class="btn blue-gradient btn-block btn-rounded z-depth-1a customerRegister" style="height: 50px">
                                            Register</button>
                                    </div>
                                </form>


                            </div>
                            <!--Footer-->
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
                <!-- END Modal REGISTER -->

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

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" id="showCartQty" data-notify="2">
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
        <ul class="main-menu-m">
            <li>
                <a href="index.html">Home</a>
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
                <a href="contact.html">Contact</a>
            </li>
        </ul>
    </div>


</header>
