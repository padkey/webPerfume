@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Show All Category product
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
                    </div>
                </div>
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
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Category name</th>
                        <th>Belong To</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <style>
                        #categoryOrder .ui-state-highlight{  /*style cho cái ô bị di chuyển*/
                            padding: 24px;
                            background-color: #ffc2bc;
                            cursor:move;  /*khi nhấp kéo thì con trỏ chuột được style lại*/
                            margin-top: 12px;
                        }
                    </style>
                    <tbody id="categoryOrder"> {{--sắp xếp--}}
                    @foreach($allCategoryProduct as $key => $category)
                    <tr id="{{$category->category_id}}">
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>{{ $category->category_name }}</td>
                        <td>
                            @if($category->category_parent == 0)
                               <span style="color: #9c3328">-- Parent --</span>
                            @else
                                @foreach($allCategoryProduct as $key2 => $categoryParent)
                                    @if($category->category_parent == $categoryParent->category_id)
                                            <span style="color: green">{{$categoryParent->category_name}}</span>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>{{ $category->category_slug }}</td>
                        <td>
                            <span class="text-ellipsis">
                                <?php
                                if( $category->category_status == 1){ ?>
                                   <a href="{{URL::to('/unactiveCategoryProduct/'.$category->category_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up"> </span></a>
                               <?php }else{  ?>
                                    <a href="{{URL::to('activeCategoryProduct/'.$category->category_id)}}"><span class="fa-thumb-styling  fa fa-thumbs-down"> </span></a>
                                <?php } ?>
                                </span>
                        </td>
                        <td>
                            <a href="{{URL::to('/editCategoryProduct/'.$category->category_id)}}" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-pencil-square-o text-success text-active"></i>
                            </a>
                            <a href="{{URL::to('/deleteCategoryProduct/'.$category->category_id)}}" onclick="return confirm('Are you sure?')" class="active styling-edit" ui-toggle-class="">
                                <i class="fa fa-remove text-danger text"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                  {{--  import data--}}
                    <form action="{{url('import-csv')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" accept=".xlsx"><br>
                        <input type="submit" value="Import file excel" name="import_csv" class="btn btn-warning">
                    </form>
                   {{-- export Data--}}
                    <form action="{{url('export-csv')}}" method="POST">
                        @csrf
                        <input type="submit" value="Export file excel" name="export_csv" class="btn btn-success">
                    </form>
                </table>


            </div>
            <footer class="panel-footer">
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
            </footer>
        </div>
    </div>

@endsection
