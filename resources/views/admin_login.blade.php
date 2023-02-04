<!DOCTYPE html>
<head>
    <title>Page Admin Web</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
    <!-- font CSS -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
    <link href="{{asset('public/backend/css/font-awesome.css')}}" rel="stylesheet">
    <!-- //font-awesome icons -->
    <script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
</head>
<body>
<div class="log-w3">
    <div class="w3layouts-main">
        <h2>Login</h2>
        <?php
        $message = Session::get('message');
        //nếu cố message thì hiển thị và cho nó null lại, để lần sau load lại k hiện ra nữa
        if($message){
           echo '<span class="text-alert">',$message,'</span>' ;
           Session::put('message',null);
        }
        ?>
        <form action="{{URL::to('/adminDashboard')}}" method="post">
            {{ csrf_field() }}
            @foreach($errors->all() as $values)
                {{$values}}
                <br>
            @endforeach
            <input type="text" class="ggg" name="adminEmail" placeholder="enter your email" >
            <input type="password" class="ggg" name="adminPassword" placeholder="enter your password" >
            <span><input type="checkbox" />Remember Me</span>
            <h6><a href="#">Forgot Password?</a></h6>
            <div class="clearfix"></div>

            <input type="submit" value="Sign In" name="login">

            <br/>
        </form>
        <div class="g-recaptcha" data-sitekey="{{env('CAPTCHA_KEY')}}"></div> {{--captcha--}}
        @if($errors->has('g-recaptcha-response'))
            <span class="invalid-feedback" style="display:block">
	                    <strong>{{$errors->first('g-recaptcha-response')}}</strong>
                </span>
        @endif
       <p><a href="{{URL::to('/loginFacebook')}}">Login facebook</a>
           <a href="{{URL::to('/loginGoogle')}}">Login google</a></p>

       <p><a href="{{URL::to('/registerAuth')}}">Register Auth</a>
        <a href="{{URL::to('/loginAuth')}}">Login Auth</a>
       </p>

    </div>
</div>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{asset('public/backend/js/flot-chart/excanvas.min.js')}}"></script><![endif]-->
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>
<!-- captcha -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
