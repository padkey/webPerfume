@extends('frontend_layout')
@section('header')
    @include('pages.include.headerNormal')
@endsection
@section('content')

    <style>
        @media (max-width: 991px) {
            .ipad-width {
                max-width: 550px;
                margin: 0 auto;
            }

        }

        .user-information {

            margin-right: 30px;
            margin-top: -190px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;


            --borderWidth: 3px;
            background: #1D1F20;
            position: sticky;
            border-radius: var(--borderWidth);
        }

        .form-style-1:after , .user-information:after {
            content: '';
            position: absolute;
            top: calc(-1 * var(--borderWidth));
            left: calc(-1 * var(--borderWidth));
            height: calc(100% + var(--borderWidth) * 2);
            width: calc(100% + var(--borderWidth) * 2);
            background: linear-gradient(60deg, #f79533, #f37055, #ef4e7b, #a166ab, #5073b8, #1098ad, #07b39b, #6fba82);
            border-radius: calc(2 * var(--borderWidth));
            z-index: -1;
            animation: animatedgradient 3s ease alternate infinite;
            background-size: 300% 300%;
        }

        @keyframes animatedgradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }





        @media (max-width: 991px) {
            .user-information {
                margin-right: 0;
                margin-bottom: 60px;
            }
        }
        @media (max-width: 767px) {
            .user-information {
                margin-top: 0;
            }
        }
        .user-information .user-img {
            text-align: center;
            margin-bottom: 30px;
            padding: 30px 0 20px 0;
        }
        .user-information .user-img img {
            margin-bottom: 30px;
        }
        .user-information ul {
            padding: 0 25px;
        }
        .user-information ul li {
            margin-bottom: 15px;
        }
        .user-information ul li a {
            font-family: 'Dosis', sans-serif;
            font-size: 14px;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
        }
        .user-information ul li a:hover {
            color: #dcf836;
        }
        .user-information ul li.active a {
            color: #dcf836;
        }
        .user-information .user-fav {
            border-top: 1px solid #e6e6e6;
            padding: 25px 0;
        }
        .user-information .user-fav p {
            padding-left: 25px;
            padding-bottom: 20px;
            font-size: 17px;
            color: #151515;
        }

        @media (max-width: 767px) {
            .ipad-width2 .topbar-filter p {
                padding-right: 0;
            }
        }

        @media (max-width: 991px) {
            .user-fav-list {
                max-width: 100%;
            }
        }
        @media (max-width: 767px) {
            .user-fav-list .movie-item-style-2 {
                width: 100%;
            }
        }
        .form-style-1{
            margin-bottom: 60px;
            border: 1px solid #e6e6e6;
            padding: 15px;
            background: #FFFFFF;

        }



        .form-style-1 .form-it {
            margin-bottom: 15px;
        }
        .form-style-1 .row{
            margin-bottom: 20px;
            margin-top: 25px;
        }
        .form-style-1 label {
            font-family: 'Dosis', sans-serif;
            font-size: 18px;
            color: #1f1f21;
            font-weight: bold;
            text-transform: none;
            margin-bottom: 10px;
        }
        @media (max-width: 991px) {
            .form-style-1 select {
                margin-bottom: 30px;
            }
        }

        .form-style-1 .form-it {
            margin-bottom: 15px;
        }



    </style>
    <style>
       .user-pro {
            margin-top: 35px;
           width: 59%;
        }
       /*
        .user-pro h3 {
            font-family: 'Dosis', sans-serif;
            font-size: 18px;
            color: black;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 30px;
        }
        .user-pro .user {
            padding-bottom: 30px;
            border-bottom: 1px solid #e6e6e6;
        }
        .user-pro .password {
            padding-top: 30px;
        }*/
        .user-pro input{
            width: 100%;
        }
        .show-password{
            position: absolute;
            right: 0px;
            top: 65%;
            display: none;
            cursor: pointer;
            transform: translateY(-50%);
            font-size: 20px;
            color: #2196f3;
            z-index: 2;
        }
     /*  .password input:valid ~ .show-password{
           display: block;
       }*/
    </style>
    <style>

        @media (max-width: 767px) {
            .user-fav-list .movie-item-style-2 {
                width: 100%;
            }
        }
        .movie_list .movie-item-style-2 img,
        .movie_single .movie-item-style-2 img,
        .userfav_list .movie-item-style-2 img {
            width: 30%;
        }
        @media (max-width: 767px) {
            .movie_list .movie-item-style-2 img,
            .movie_single .movie-item-style-2 img,
            .userfav_list .movie-item-style-2 img {
                width: auto;
            }
        }
        .movie-item-style-2 {
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            overflow: hidden;
            margin-bottom: 30px;
        }
        @media (max-width: 767px) {
            .movie-item-style-2 {
                display: flex;
                flex-direction: column;
            }
        }
        .movie-item-style-2 img {
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            margin-right: 30px;
            -webkit-transition: all 0.5s ease-out;
            -moz-transition: all 0.5s ease-out;
            -o-transition: all 0.5s ease-out;
            transition: all 0.5s ease-out;
        }
        @media (max-width: 767px) {
            .movie-item-style-2 img {
                margin-right: 0;
                margin-bottom: 15px;
            }
        }
        @media (max-width: 767px) {
            .movie-item-style-2 .mv-item-infor {
                max-width: 180px;
                margin: 0 auto;
            }
        }
        .movie-item-style-2 .mv-item-infor h6 {
            margin-bottom: 10px;
        }
        .movie-item-style-2 .mv-item-infor h6 a {
            font-family: 'Dosis', sans-serif;
            font-size: 18px;
            color: black;
            font-weight: bold;
            text-transform: uppercase;
        }
        .movie-item-style-2 .mv-item-infor h6 a span {
            color: #3b3e44;
        }
        .movie-item-style-2 .mv-item-infor .describe {
            padding-bottom: 25px;
            border-bottom: 1px solid #e6e6e6;
            margin-bottom: 25px;
        }
        .movie-item-style-2 .mv-item-infor .run-time span {
            margin-left: 15px;
            margin-right: 15px;
        }
        .movie-item-style-2 .mv-item-infor .rate {
            font-size: 12px;
        }
        .movie-item-style-2 .mv-item-infor .rate i {
            color: #f5b50a;
            font-size: 22px;
            margin-right: 5px;
        }
        .movie-item-style-2 .mv-item-infor .rate span {
            color: #ffffff;
            font-size: 16px;
            font-weight: 400;
        }
        .movie-item-style-2 .mv-item-infor p {
            margin-bottom: 0;
        }
        .movie-item-style-2 .mv-item-infor p a {
            color: #4280bf;
        }
        .movie-item-style-2 .mv-item-infor p a:hover {
            color: #dcf836;
        }
        .movie-item-style-2:hover h6 a {
            color: #dcf836;
        }
        .userrate {
            align-items: flex-start;
            border-bottom: 1px solid #e6e6e6;
            padding-bottom: 30px;
        }
        .userrate img {
            width: 100px;
        }
        @media (max-width: 767px) {
            .userrate img {
                width: 80%;
                margin: 0 auto;
                margin-bottom: 30px;
            }
        }
        .userrate .sm-text {
            background-color: #233a50;
            width: 75px;
            text-align: center;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            margin-top: 15px;
        }
        .userrate h6 {
            font-family: 'Dosis', sans-serif;
            font-size: 14px;
            color: black;

            font-weight: bold;
            text-transform: none;
            margin-bottom: 15px;
        }
        .userrate p.time.sm {
            color: #4280bf;
        }
        .userrate.last {
            border-bottom: 1px transparent;
        }
        input[type=checkbox]
        {
            -webkit-appearance:checkbox;
        }
    </style>
   {{-- <style>
        .topbar-filter {
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            border-top: 1px solid #e6e6e6;
            border-bottom: 1px solid #e6e6e6;
        }
        @media (max-width: 767px) {
            .topbar-filter {
                display: flex;
                flex-direction: column;
                padding: 15px 0;
            }
        }
        .topbar-filter p {
            padding-right: 200px;
            margin-bottom: 0;
        }
        @media (max-width: 991px) {
            .topbar-filter p {
                padding-right: 0;
            }
        }
        .topbar-filter p span {
            color: #4280bf;
        }
        .topbar-filter label,
        .topbar-filter select {
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            color: #abb7c4;
            font-weight: 300;
            text-transform: none;
        }
        .topbar-filter select {
            width: 215px;
            -webkit-appearance: none;
            -moz-appearance: none;
            /* Firefox */
            border-left: 1px solid #e6e6e6;
            border-right: 1px solid #e6e6e6;
            border-top: none;
            border-bottom: none;
            color: #ffffff;
            font-weight: 400;
        }
        @media (max-width: 767px) {
            .topbar-filter select {
                border: 1px solid #e6e6e6;
            }
        }
        .topbar-filter option {
            background-color: #020d18;
        }
        .topbar-filter .list,
        .topbar-filter .grid {
            font-size: 16px;
            color: #abb7c4;
            margin-left: -15px;
        }
        .topbar-filter .list i,
        .topbar-filter .grid i {
            width: 40px;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 35px;
        }
        .topbar-filter .list {
            border-right: 1px solid #e6e6e6;
        }
        @media (max-width: 767px) {
            .topbar-filter .list {
                border: none;
            }
        }
        .topbar-filter .active,
        .topbar-filter i:hover {
            color: #dcf836;
        }
        .topbar-filter .pagination2 {
            padding-left: 100px;
        }
        @media (max-width: 767px) {
            .topbar-filter .pagination2 {
                padding-left: 0;
                margin-top: 15px;
            }
        }
        .topbar-filter .pagination2 span {
            margin-right: 15px;
        }
        .topbar-filter .pagination2 span,
        .topbar-filter .pagination2 a {
            font-family: 'Nunito', sans-serif;
            font-size: 14px;
            color: #abb7c4;
            font-weight: 300;
            text-transform: none;
        }
        .topbar-filter .pagination2 a {
            padding-left: 5px;
            padding-right: 5px;
            color: #4280bf;
        }
        .topbar-filter .pagination2 a.active,
        .topbar-filter .pagination2 a:hover {
            color: #dcf836;
        }
        .topbar-filter.fw p {
            padding-right: 600px;
        }
        @media (max-width: 991px) {
            .topbar-filter.fw p {
                padding-right: 170px;
            }
        }
        @media (max-width: 767px) {
            .topbar-filter.fw p {
                padding-right: 0;
            }
        }
        .topbar-filter.user p {
            padding-right: 300px;
        }
        @media (max-width: 991px) {
            .ipad-width {
                max-width: 550px;
                margin: 0 auto;
            }
            .ipad-width2 {
                max-width: 650px;
                margin: 0 auto;
            }
            .ipad-width2 .topbar-filter p {
                padding-right: 70px;
            }
            .sidebar {
                margin-left: 0;
            }
        }
    </style>--}}

    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{url('public/frontend2/images/bg-02.jpg')}}');margin-bottom: 20px">
        <h2 class="ltext-105 cl0 txt-center">
            <p>{{$customer->customer_name}}</p>
        </h2>
    </section>

<div class="container" style=" min-height: 512px;">
    <div class="row ipad-width">
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="user-information">
                <div class="user-img">
                    <div class="circle">
                        <a href="#"><img src="{{url('/public/frontend2/images/avatar-01.jpg')}}" alt="" ><br></a>
                    </div>

                    <a href="#" class="redbtn">Change avatar</a>
                </div>
                <div class="user-fav">
                    <p>Account Details</p>
                    <ul>
                        <li class="active" ><a href="{{url('/profile')}}">Profile</a></li>
                        <li><a href="{{url('/orderHistory/0')}}">Order history </a></li>
                        <li><a href="userfavoritelist.html">Favorite products</a></li>
                        <li><a href="#">Rated products</a></li>


                    </ul>
                </div>
                <div class="user-fav">
                    <p>Others</p>
                    <ul>
                        <li><a href="#">Change password</a></li>
                        <li><a href="#">Log out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 col-sm-12 col-xs-12">
            <div class="form-style-1">

                <div class="m-4">
                    <h3>01. Profile details</h3>
                    <form action="#" class="user-pro">
                        <div class="md-form">
                            <label >Email Address : {{$customer->customer_email}}</label>
                        </div>
                        <div class="md-form">
                            <div class="input">
                                <input type="text" value="{{$customer->customer_name}}" class="customerName input-field" required>
                                <label class="input-label">Name</label>
                            </div>
                        </div>

                        <div class="md-form">
                            <div class="input">
                                <input type="text" value="{{$customer->customer_phone}}" class="customerPhone input-field" required>
                                <label class="input-label">Phone</label>
                            </div>
                        </div>
                        <div class="md-form">
                            <div class="input">
                                <input type="text" value="{{$customer->customer_address}}"class="customerAddress input-field" required>
                                <label class="input-label">Address</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-dark editProfileCustomer">Save</button>
                            </div>
                        </div>
                    </form>
                </div>

                <hr>
                <div class="m-4">
                    <h4>02. Change password</h4>
                    <form class="user-pro">
                        <div class="md-form">
                            <div class="input password">
                                <input type="password" class="input-field oldPassword" required>
                                <label class="input-label password" >Old Password</label>
                            </div>
                        </div>
                        <div class="md-form">
                            <div class="input password">
                                <input type="password" class="input-field newPassword" required>
                                <label class="input-label password" >New Password</label>
                            </div>
                        </div>
                        <div class="md-form">
                            <div class="input password">
                                <input type="password" class="input-field confirmNewPassword"  required>
                                <label class="input-label password" >Confirm New Password</label>
                            </div>
                        </div>
                        <div class="dis-flex">
                            <input class="showPassword" type="checkbox" name=”vehicle” style="width: 20px;height: 20px;margin-right: 10px">
                            Show password
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <button type="button" class="btn btn-dark changePassword">Change</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

    @endsection
