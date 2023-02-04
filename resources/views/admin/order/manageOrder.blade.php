@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Show All Order
            </div>
            <div class="row w3-res-tb">



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
                        <th></th>
                        <th>Order code</th>
                        <th>Order date</th>
                        <th>Order status</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $i=1; @endphp
                    @foreach($allOrder as $key => $order)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$i++;}}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{$order->created_at}}</td>
                         {{--   <td>@if ($order->order_status == 1)
                                     <span class="text-info">New order</span>
                                @elseif ($order->order_status == 2)
                               <span class="text-success">  Done processing </span>
                                @elseif ($order->order_status == 3)
                                    <div class="text-danger">Cancelled</div>
                                    <span>Reason : {{$order->order_destroy}}</span>
                                    @endif
                            </td>--}}
                            <td>{{$order->orderStatus->order_status_name}}</td>

                            <td>
                                <a href="{{URL::to('/viewOrder/'.$order->order_code)}}" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-eye text-success text-active"></i>
                                </a>
                                <a href="{{URL::to('/deleteOrder/'.$order->order_code)}}" onclick="return confirm('Are you sure?')" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-remove text-danger text"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection
