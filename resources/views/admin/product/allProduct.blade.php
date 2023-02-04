@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Show All Product
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">',$message,'</span>';
                    //cho nó thành nul để reload lại trang k thấy nó nữa
                    Session::put('message',null);
                }
                ?>
                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Product name</th>
                        <th>Gallery</th>
                        <th>Quantity</th>
                        <th>Cost price(giá vốn)</th>
                        <th>Sale price</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allProduct as $key => $product)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{ $product->product_name }}</td>
                            <td><a href="{{URL::to('/addGallery/'.$product->product_id)}}">Add Gallery</a></td>
                            <td>{{ $product->product_quantity }}</td>
                            <td class="money">{{ $product->product_cost }}đ</td>
                            <td class="money">{{ $product->product_price }}đ</td>
                            <td><img src="public/uploads/products/{{ $product->product_image }}" width="90px" ></td>
                            <td>{{ $product->category_name }}</td>
                            <td>{{ $product->brand_name }}</td>
                            <td>{!! $product->product_des !!}  </td>

                            <td>
                                    <span class="text-ellipsis">
                                <?php
                                if( $product->product_status == 1){ ?>
                                   <a href="{{URL::to('/unactiveProduct/'.$product->product_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"> </span></a>
                               <?php }else{  ?>
                                    <a href="{{URL::to('activeProduct/'.$product->product_id)}}"><span class="fa-thumb-styling  fa fa-thumbs-down"> </span></a>
                                <?php } ?>
                                    </span>
                            </td>
                            <td>
                                <a href="{{URL::to('/editProduct/'.$product->product_id)}}" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <a href="{{URL::to('/deleteProduct/'.$product->product_id)}}" onclick="return confirm('Are you sure?')" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-remove text-danger text"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <form action="{{url('import-csv-product')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" accept=".xlsx"><br>
                        <input type="submit" value="Import CSV" name="import_csv" class="btn btn-warning">
                    </form>
                    <form action="{{url('export-csv-product')}}" method="POST">
                        @csrf
                        <input type="submit" value="Export CSV" name="export_csv" class="btn btn-success">
                    </form>

                </table>
            </div>
          {{--  <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </footer>--}}
        </div>
    </div>

@endsection
