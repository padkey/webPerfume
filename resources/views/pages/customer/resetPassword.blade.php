@extends('frontend_layout')
@section('header')
    @include('pages.include.headerNormal')
    @endsection
@section('content')

{{--
    <section id="form"><!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->

                        <h2>Reset Password</h2>
                        <?php
                        $message = Session::get('messageLogin');
                        if($message){
                            echo '<span class="text-alert">', $message ,'</span>';
                            Session::put('messageLogin',null);
                        }

                        ?>

                    </div>
                </div>

            </div>
        </div>
    </section><!--/form-->--}}

<div class="bg0 p-t-150 p-b-150">

    <div class="container">
        <div style="width: 500px; margin: auto;border: 1px solid lightgrey" class="p-3">
            <div style="text-align: center"><h2>Reset password</h2></div>
            <form class="card-form">
                @csrf
                <input type="hidden"  name="email"  value="{{$customerEmail}}" class="emailCustomer"/>
                <div class="md-form p-b-8 input">
                    <input type="password" name="password" class="input-field passwordCustomer" required>
                    <label  class="input-label">Enter your new password</label>
                </div>
                <div class="md-form p-b-8 input">
                    <input type="password" name="repassword" class="input-field repasswordCustomer" required>
                    <label  class="input-label">Repeat your password</label>
                </div>
                <div class="text-center mb-5">
                    <button type="button" class="btn blue-gradient btn-block btn-rounded z-depth-1a updatePasswordCustomer" style="height: 50px">
                        Confirm</button>
                </div>
            </form>
        </div>

    </div>
</div>


@endsection
