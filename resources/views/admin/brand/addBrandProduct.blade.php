@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Brand
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
                        <form role="form" method="POST" action="{{URL::to('/saveBrandProduct')}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Brand name</label>
                                <input type="text" class="form-control"name="brandName" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Brand Slug</label>
                                <input type="text" class="form-control"name="brandSlug" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Keywords</label>
                                <input type="text" class="form-control"name="metaKeywords" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description Brand</label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control" id="ckeditor5" name="brandDes" placeholder="Description brand"> </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Status</label>
                                <select name="brandStatus" class="form-control input-sm m-bot15">
                                    <option value="1">Enable</option>
                                    <option value="0">Disable</option>
                                </select>
                            </div>

                            <button type="submit" name="addCategoryProduct" class="btn btn-info">Add brand</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
