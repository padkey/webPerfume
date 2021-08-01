@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Update Category
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
                        <form role="form" method="POST" action="{{URL::to('/updateSlider')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{$editSlider->slider_id}}" name="sliderId">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slider name</label>
                                <input type="text" class="form-control"name="sliderName" id="exampleInputEmail1" value="{{$editSlider->slider_name}}">
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="sliderImage" id="exampleInputEmail1">
                                <img src="{{URL::to('/public/uploads/sliders/'.$editSlider->slider_image)}}" alt="" width="150px">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description Slider</label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control" name="sliderDes">{{$editSlider->slider_des}}
                                </textarea>
                            </div>


                            <button type="submit" name="updateBrandProduct" class="btn btn-info">Update category</button>
                        </form>
                    </div>


                </div>
            </section>

        </div>

    </div>
@endsection
