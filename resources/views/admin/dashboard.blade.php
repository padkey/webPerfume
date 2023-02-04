@extends('admin_layout')
@section('admin_content')
    <style>
        .table tr td{
            background-color: #363535;
        }
        .title_statistical{
            color: black;margin: 20px
        }
        ul.listViews li{
            list-style-type:decimal;
            color: #f5f5f5;
            margin: 5px;
        }
        ul.listViews li a{
            color: #f5f5f5;
        }
        ul.listViews li a:hover{
            color: #ffcc00;
        }
    </style>
        <center><h3>Sales statistical</h3></center>
        <div class="row" style="margin-top: 20px">
        <form >
            @csrf
            <div class="col-md-3">
                <p>From date</p>
                <input type="datetime-local" class="form-control fromDate" >
            </div>
            <div class="col-md-3">
                <p>To date</p>
                <input type="datetime-local" class="form-control toDate">
            </div>
            <div class="col-md-3" style="margin-top: 20px">
                <button type="button" id="btnStatistical" class="btn btn-info">Statistical</button>
            </div>
            <div class="col-md-3">
                <p>Filter By (lọc theo)</p>
                <select   class="form-control filterByChoose">
                    <option selected>---- Choose ----</option>
                    <option value="7Days">7 days ago(7 ngày quaa)</option>
                    <option value="thisMonth">This month (tháng này)</option>
                    <option value="lastMonth">Last month (tháng trước)</option>
                    <option value="365Days">1 year ago(một năm qua)</option>
                </select>
            </div>
        </form>
            <div class="col-md-12">
                <div id="chart" style="height: 300px"></div>
            </div>

    </div>
    <div class="row">

        <center><h3 class="title_statistical">Access statistics</h3></center>
        <div class="col-md-12" >
            <table class="table table-bordered" style="background-color: #1f1e1e">
                <thead>
                <tr>

                    <th scope="col">Online</th>
                    <th scope="col">Total this month</th>
                    <th scope="col">Total last month</th>
                    <th scope="col">Total 1 year</th>
                    <th scope="col">Total visitors</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td >{{$visitorsCurrent->count()}}</td>
                    <td>{{$visitorsThisMonth}}</td>
                    <td>{{$visitorsLastMonth}}</td>
                    <td>{{$visitorsOneYear}}</td>
                    <td>{{$visitorsTotal}}</td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <center><h4 class="title_statistical">Total statictis of products,posts,orders,customers</h4></center>
            <div id="donut">

                <input type="hidden" class="totalProducts" value="{{$products}}">
                <input type="hidden" class="totalPosts" value="{{$posts}}">
                <input type="hidden" class="totalCustomers" value="{{$customers}}">
                <input type="hidden" class="totalOrders" value="{{$orders}}">
            </div>
        </div>
        <div class="col-md-4">
            <center><h4 class="title_statistical">Most viewed posts (bài viết được xem nhiều nhât)</h4></center>
            <ul class="listViews">
                @foreach($postViews as $key => $post)
                <li><a  target="_blank" href="{{url('/postDetail/'.$post->post_slug)}}">{{$post->post_title}} |
                    <span style="color: black">{{$post->post_views}}</span></a></li>
                    @endforeach
            </ul>
        </div>
        <div class="col-md-4">
            <center><h4 class="title_statistical">Most viewed products</h4></center>
            <ul class="listViews" >
                @foreach($productViews as $key => $product)
                    <li ><a target="_blank" href="{{url('/productDetail/'.$product->product_slug)}}">{{$product->product_name}} |
                            <span style="color: black">{{$product->product_views}}</span></a></li>
                    @endforeach
            </ul>
        </div>

    </div>
@endsection
