@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Update Post
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
                        <form role="form" method="POST" action="{{URL::to('/updatePost')}}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{$editPost->post_id}}" name="postId">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" class="form-control"name="postTitle" id="slug" onkeyup="ChangesToSlug()" value="{{$editPost->post_title}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" class="form-control"name="postSlug" id="convert_slug" value="{{$editPost->post_slug}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Content </label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control" id="ckeditor6" name="postContent">{{$editPost->post_content}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description </label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control" id="ckeditor6" name="postDes">{{$editPost->post_des}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta Description</label>
                                <input type="text" class="form-control"name="metaDes"value="{{$editPost->post_meta_des}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Keywords</label>
                                <input type="text" class="form-control"name="metaKeywords"  value="{{$editPost->post_meta_keywords}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Image</label>
                                <input type="file" class="form-control"name="postImage">
                                <img src="{{asset('public/uploads/posts/'.$editPost->post_image)}}" width="100px">
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Belong to category</label>
                                <select name="categoryPostId" class="form-control input-sm m-bot15" >
                                    @foreach($allCategoryPost as $key => $categoryPost)
                                    <option value="{{$categoryPost->category_post_id}}" {{$editPost->cate_post_id == $categoryPost->category_post_id ? 'selected' : ''}}>{{$categoryPost->category_post_name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            <button type="submit" name="updateBrandProduct" class="btn btn-info">Update post</button>
                        </form>
                    </div>


                </div>
            </section>

        </div>

    </div>
@endsection
