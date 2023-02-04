@extends('frontend_layout')
@section('header')
    @include('pages.include.headerNormal')
@endsection
@section('content')
    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('{{url('public/frontend2/images/bg-02.jpg')}}');">
        <h2 class="ltext-105 cl0 txt-center">
            VIDEO LIST
        </h2>
    </section>


    <div class="bg0 m-t-23 p-b-140">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">

                <div class="flex-w flex-c-m m-tb-10">
                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Search
                    </div>
                </div>
                <!-- Search Video -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <div class="bor8 dis-flex p-l-15">
                        <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                            <i class="zmdi zmdi-search"></i>
                        </button>

                        <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Search">
                    </div>
                </div>

            </div>

            <div class="row isotope-grid">
                @foreach($allVideo as $key => $video)
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img height="300px" src="{{url('/public/uploads/videos/'.$video->video_image)}}" alt=" {{$video->video_name}}">

                                <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 watchVideo"
                                   data-toggle="modal" data-target="#videoModel" data-id="{{$video->video_id}}">
                                    Watch video
                                </a>

                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{$video->video_title}}
                                    </a>


                                </div>

                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                        <img class="icon-heart1 dis-block trans-04" src="{{url('/public/frontend2/images/icons/icon-heart-01.png')}}" alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{url('/public/frontend2/images/icons/icon-heart-02.png')}}" alt="ICON">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!--Paginate -->
            <div class="flex-c-m flex-w w-full p-t-38">
                {{$allVideo->links('vendor.pagination.bootstrap-4')}}
            </div>
        </div>
    </div>



   <style>
        .modal {
            text-align: center;
            z-index: 9999;
        }

        @media screen and (min-width: 900px) {
            .modal:before {
                display: inline-block;
                vertical-align: middle;
                content: " ";
                height: 100%;
            }
        }
        .modal-body{
            padding: 0;
        }
        .modal-content{
            background-color: black;
            color: whitesmoke;
        }
        .modal-footer,.modal-header{
         border: 0;
        }

        .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }
    </style>

    <!-- Modal -->
    <div class="modal fade" id="videoModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="videoTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="videoLink"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-info" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


@endsection
