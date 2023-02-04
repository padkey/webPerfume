@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Gallery
                </header>
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">',$message,'</span>';
                    Session::put('message',null);
                }
                ?>

                <form action="{{url('/saveGallery')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="productId" value="{{$productId}}" class="productId">
                    <div class="row">
                        <div class="col-sm-3" align="right">

                        </div>
                        <div class="col-sm-6">
                            <input id="file" class="form-control" type="file" name="file[]" accept="image/*" multiple>
                            {{--multiple cho phép  nhập nhiều hình ảnh vào--}}
                            <span id="error" class="alert-danger"></span>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-info">Upload</button>
                        </div>
                    </div>
                </form>


                <div class="panel-body">
                    <form>
                        @csrf
                    <input type="hidden" name="productId" value="{{$productId}}" class="productId">
                    <div id="galleryLoad">

                    </div>
                    </form>
                </div>


            </section>
        </div>

    </div>
@endsection
