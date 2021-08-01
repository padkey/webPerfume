@extends('layout')
@section('content')

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
                        <form action="{{URL::to('/loginCustomer')}}" method="POST">
                            {{csrf_field()}}
                            <input type="email" placeholder="enter your email" name="emailAccount" />
                            <input type="password" placeholder="enter your password" name="passwordAccount" />
                            <span>
								<input type="checkbox" class="checkbox">
								Keep me signed in
							</span>
                            <button type="submit" class="btn btn-default">Login</button>
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
@endsection
