@extends('frontend_layout')

@section('header')
    @include('pages.include.headerHome')
@endsection
@section('banner')
    @include('pages.include.banner') {{--bỏ slider qua file khác cho gọn--}}
@endsection


@section('content')
    <section class="bg0 p-t-23 p-b-140">

    <div class="container">

    <div class="p-b-10">
        <h3 class="ltext-103 cl5">
            Product Overview
        </h3>
    </div>

    <div class="flex-w flex-sb-m p-b-52">
        <div class="flex-w flex-l-m filter-tope-group m-tb-10">
            <form>
              {{--  how-active1 là cái template này viết js luôn cho mình rồ, khi click nó sẽ tự động chuyển how-active1--}}
                @csrf
                @php $i = 1;@endphp
                @foreach($categoryTabs as $key => $category)
                    <button type="button" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{$i==1 ?'how-active1' : ''}} categoryTab" data-id="{{$category->category_id}}" data-category_slug="{{$category->category_slug}}">
                        {{$category->category_name}}
                    </button>
                    @php $i++;@endphp
                @endforeach
            </form>

        </div>

        <div class="flex-w flex-c-m m-tb-10">
            <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                Filter
            </div>

            <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                Search
            </div>
        </div>

        <!-- Search product -->
        <div class="dis-none panel-search w-full p-t-10 p-b-15">
            <div class="bor8 dis-flex p-l-15">
                <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>

                <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Search">
            </div>
        </div>

        <!-- Filter -->
        <div class="dis-none panel-filter w-full p-t-10">
            <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                <div class="filter-col1 p-r-15 p-b-27">
                    <div class="mtext-102 cl2 p-b-15">
                        Sort By
                    </div>

                    <ul>
                        <li class="p-b-6">
                            <a href="#" class="filter-link stext-106 trans-04 sort {{--filter-link-active--}}" data-sort_by="none">
                                Default
                            </a>
                        </li>

                        <li class="p-b-6" >
                            <a href="#" class="filter-link stext-106 trans-04 sort"  data-sort_by="tangDan">
                                Price: Low to High
                            </a>

                        </li>

                        <li class="p-b-6" >
                            <a href="#" class="filter-link stext-106 trans-04 sort" data-sort_by="giamDan">
                                Price: High to Low
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="filter-col2 p-r-15 p-b-27">
                    <div class="mtext-102 cl2 p-b-15">
                        Price
                    </div>

                    <ul>
                        <li class="p-b-6">
                            <a href="#" class="filter-link stext-106 trans-04">
                                All
                            </a>
                        </li>

                        <li class="p-b-6">
                            <a href="{{url('/productsByCategory?sortBy=tangDan')}}" class="filter-link stext-106 trans-04">
                                $0.00 - $50.00
                            </a>

                        </li>


                    </ul>
                </div>

            </div>
        </div>
    </div>



    <div  id="productsByTab" >

    </div>





    </div>


    </section>
    <!-- Pagination -->




    <!-- Modal1 -->

@endsection
