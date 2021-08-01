@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Create Category
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
                    <form role="form" method="POST" action="{{URL::to('/saveCategoryProduct')}}">
                        <div class="form-group">
                            {{ csrf_field() }}
                            <label for="exampleInputEmail1">Category name</label>
                            <input type="text" class="form-control"name="categoryName" id="exampleInputEmail1" >
                        </div>
                        <div class="form-group">
                            {{ csrf_field() }}
                            <label for="exampleInputEmail1">Slug</label>
                            <input type="text" class="form-control"name="categorySlug" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Description Category</label>
                            <textarea style="resize:none;" rows="5" type="text" class="form-control" id="ckeditor7" name="categoryDes" > </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Keywords</label>
                            <textarea style="resize:none;" rows="5" type="text" class="form-control" id="ckeditor2" name="metaKeywords"> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Status</label>
                            <select name="categoryStatus" class="form-control input-sm m-bot15">
                                <option value="1">Enable</option>
                                <option value="0">Disable</option>
                            </select>
                        </div>

                        <button type="submit" name="addCategoryProduct" class="btn btn-info">Add category</button>
                    </form>
                </div>

            </div>
        </section>

    </div>

</div>
@endsection
