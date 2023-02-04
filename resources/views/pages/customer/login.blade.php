@extends('layout')
@section('content')
    <style>
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
        ul li a img{
            width: 10%;
            margin: 10px 20px;
        }
        ul li{
            display: inline; /*hiển thị danh sách theo kiểu hàng*/
        }
    </style>

    <section id="form"><!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->

                        <h2>Login to your account</h2>
                        <?php
                        $message = Session::get('messageLogin');
                        if($message){
                            echo '<span class="text-alert">', $message ,'</span>';
                            Session::put('messageLogin',null);
                        }

                        ?>
                        <form action="{{URL::to('/customerLogin')}}" method="POST">
                            {{csrf_field()}}
                            <input type="email" placeholder="enter your email" name="emailAccount" />
                            <input type="password" placeholder="enter your password" name="passwordAccount" />
                            <span>
								<input type="checkbox" class="checkbox">
								Keep me signed in
							</span>
                            <button type="button" data-toggle="modal" data-target="#forgetPassword">Forget password!</button>
                            <button type="submit" class="btn btn-default">Login</button>
                            <ul>
                                <li><a href="{{url('loginCustomerFB')}}"><img src="{{url('/public/frontend/images/fb.png')}}" alt="Đăng nhập bằng facebook"></a></li>
                                <li><a href="{{url('loginCustomerGG')}}"><img src="{{url('/public/frontend/images/gg.png')}}" alt="Đăng nhập bằng google"></a></li>
                            </ul>
                        </form>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">OR</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>New User Signup!</h2>
                        <?php
                        $message = Session::get('message');
                        if($message){
                            echo '<span class="text-alert">', $message ,'</span>';
                            Session::put('message',null);
                        }

                        ?>
                        <form action="{{URL::to('/addCustomer')}}" method="POST">
                            {{csrf_field()}}

                            <input type="text" placeholder="Name" name="name"/>
                            <input type="email" name="email" placeholder="Email Address"/>
                            <input type="password" name="password" placeholder="Password"/>
                            <input type="text" name="phone" placeholder="Enter your phone"/>
                            <button type="submit" class="btn btn-default">Signup</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->



    <div class="modal fade" id="forgetPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Forget Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div>
                    <form action="">
                        @csrf
                        <div>
                            <label for="">Enter your email</label>
                            <input type="email" name="email" class="form-control emailForget">
                        </div>
                        <button type="button" class="btn btn-info forgetPassword" style="margin: 20px 0px">Confirm</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
