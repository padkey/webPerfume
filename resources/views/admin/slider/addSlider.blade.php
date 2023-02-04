@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Slider
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
                        <form role="form" method="POST" action="{{URL::to('/saveSlider')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slider name</label>
                                <input type="text" class="form-control"name="sliderName" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Image</label>
                                <input type="file" class="form-control"name="sliderImage" id="exampleInputEmail1" accept="video/mp4,video/x-m4v,video/*">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <input type="text" class="form-control"name="sliderDes" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Status</label>
                                <select name="sliderStatus" class="form-control input-sm m-bot15">
                                    <option value="1">Enable</option>
                                    <option value="0">Disable</option>
                                </select>
                            </div>

                            <button type="submit" name="addCategoryProduct" class="btn btn-info">Add Slider</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
