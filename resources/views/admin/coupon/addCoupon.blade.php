@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Coupon
                </header>
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">',$message,'</span>';
                    Session::put('message',null);
                }
                ?>
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="POST" action="{{URL::to('/saveCoupon')}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Coupon name</label>
                                <input type="text" class="form-control"name="couponName" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Coupon code</label>
                                <input type="text" class="form-control"name="couponCode" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Quantity code</label>
                                <input type="text" class="form-control"name="couponTime" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"> Feature code </label>
                                <select name="couponCondition" class="form-control input-sm m-bot15">
                                    <option value="0" selected>--- Choose ---</option>
                                    <option value="1">Discount By %</option>
                                    <option value="2">Discount By Money</option>
                                </select>                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Enter % or money discount</label>
                                <input type="text" class="form-control"name="couponNumber" id="exampleInputEmail1" >
                            </div>

                            <button type="submit" name="addCoupon" class="btn btn-info">Add coupon</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
