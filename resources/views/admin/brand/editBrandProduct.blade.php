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
                            <form role="form" method="POST" action="{{URL::to('/updateBrandProduct/'.$editBrandProduct->brand_id)}}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Brand name</label>
                                    <input type="text" class="form-control"name="brandName" id="slug" onkeyup="ChangeToSlug()" value="{{$editBrandProduct->brand_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" class="form-control"name="brandSlug" id="convert_slug" value="{{$editBrandProduct->brand_slug}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Keywords</label>
                                    <input type="text" class="form-control"name="metaKeywords" id="exampleInputEmail1" value="{{$editBrandProduct->meta_keywords}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Description Brand</label>
                                    <textarea style="resize:none;" rows="5" type="text" class="form-control" id="ckeditor6" name="brandDes">{{$editBrandProduct->brand_des}}
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
