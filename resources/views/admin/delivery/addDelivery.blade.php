@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Delivery
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
                        <form>
                          @csrf
                            <div class="form-group">
                                <label for="exampleInputFile">City</label>
                                <select name="city" id="city"class="form-control input-sm m-bot15 choose">
                                    <option selected>---Choose city---</option>
                                    @foreach($allCity as $key => $city)
                                    <option value="{{$city->matp}}">{{ $city->name_thanhpho}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Province</label>
                                <select name="province" id="province"class="form-control input-sm m-bot15 choose">
                                    <option selected>---Choose province---</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Wards</label>
                                <select name="wards" id="wards" class="form-control input-sm m-bot15 ">
                                    <option selected>---Choose wards---</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Transport fee</label>
                                <input type="text" class="form-control fee-ship"name="feeShip" id="exampleInputEmail1" >
                            </div>

                            <button type="button" name="addDelivery" class="btn btn-info addDelivery">Add delivery</button>
                        </form>
                    </div>
                        <div id="loadDelivery">

                        </div>
                </div>
            </section>

        </div>

    </div>
@endsection
