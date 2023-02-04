@extends('admin_layout')
@section('admin_content')

    <style>
        ul.listReply li{
            list-style:none;
            color: #117cff;
            margin: 5px 40px;
        }
    </style>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Show All Brand
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
                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>Pending approval(chờ phê duyệt)</th>
                        <th>Sender's name</th>
                        <th>Content</th>
                        <th>Date sent</th>
                        <th>Product</th>
                        <th>Management</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($allComment as $key => $comment)
                        @if($comment->comment_parent == 0)  {{--chỉ hiện những comment của người dùng, comment của admin thì dùng vòng lặp phía dưới để khớp với từng comment--}}
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>
                            <span class="text-ellipsis">
                                @if($comment->comment_status == 0)
                                    {{--data-status="1" để qua update luôn khỏi if else--}}
                                    <button type="button" class="btn btn-danger btn-sm btnApproval" data-status="1" data-id="{{$comment->comment_id}}">
                                        Not approved yet</button>
                                @else
                                    <button type="button" class="btn btn-info btn-sm btnApproval"  data-status="0" data-id="{{$comment->comment_id}}">
                                        Approved by admin</button>
                                @endif
                                </span>
                            </td>
                            <td>{{ $comment->comment_name }}</td>
                            <td>
                                {{ $comment->comment_content }}
                                <ul class="listReply"> <b style="color: #0a9c0c;margin: 10px 20px">Reply : </b>
                                    @foreach($commentReply as $key => $reply)
                                        @if($reply->comment_parent == $comment->comment_id)
                                            <li>Admin : {{$reply->comment_content}}</li>
                                        @endif
                                    @endforeach
                                </ul>
                                {{--nếu comment chưa được duyệt thì hiện bảng text còn duyệt rồi thì k hiện--}}
                                @if($comment->comment_status == 0)
                                <br> <textarea class="form-control replyContent-{{$comment->comment_id}}"  rows="2"></textarea>
                                <br><button class="btn btn-default btnReplyComment" data-comment_id="{{$comment->comment_id}}" data-product_id="{{$comment->product_id}}">Reply To Comment</button>
                                    @endif
                            </td>
                            <td>{{$comment->comment_date}}</td>
                            {{--target="_blank" để click vào đường link nó sẽ mở tab mới cho mình --}}
                            <td><a href="{{url('/productDetail/'.$comment->product->product_slug)}}" target="_blank">{{ $comment->product->product_name }}</a></td>

                            <td>
                                <a href="{{URL::to('/editComment/'.$comment->comment_id)}}" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <a href="{{URL::to('/deleteComment/'.$comment->comment_id)}}" onclick="return confirm('Are you sure?')" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-remove text-danger text"></i>
                                </a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
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
