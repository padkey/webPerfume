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
                            <form role="form" method="POST" action="{{URL::to('/updateCategoryPost')}}">
                                @csrf
                                <input type="hidden" value="{{$categoryPost->category_post_id}}" name="categoryId">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Category post name</label>
                                    <input type="text" class="form-control"name="categoryName" id="slug" onkeyup="ChangeToSlug()" value="{{$categoryPost->category_post_name}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" class="form-control"name="categorySlug" id="convert_slug" value="{{$categoryPost->category_post_slug}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Description Category post</label>
                                    <textarea style="resize:none;" rows="3" type="text" class="form-control"  name="categoryDes">{{$categoryPost->category_post_des}}
                                </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Keywords</label>
                                    <textarea style="resize:none;" rows="3" type="text" class="form-control"  name="metaKeywords">{{$categoryPost->meta_keywords}} </textarea>
                                </div>

                                <button type="submit" name="updateCategoryProduct" class="btn btn-info">Update category post</button>
                            </form>
                        </div>

                </div>
            </section>

        </div>

    </div>
@endsection
