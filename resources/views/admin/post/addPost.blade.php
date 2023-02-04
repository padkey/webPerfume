@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Post
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
                        <form role="form" method="POST" action="{{URL::to('/savePost')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Post Title</label>
                                <input type="text" class="form-control"name="postTitle" id="slug" onkeyup="ChangeToSlug()">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Post Slug</label>
                                <input type="text" class="form-control"name="postSlug"  id="convert_slug">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Post Content</label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control" id="ckeditor5" name="postContent" placeholder="Description brand"> </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Post Description</label>
                                <textarea style="resize:none;" rows="3" type="text" class="form-control" id="ckeditor5" name="postDes" placeholder="Description brand"> </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Meta description</label>
                                <input type="text" class="form-control"name="metaDes" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">KeyWords</label>
                                <input type="text" class="form-control"name="metaKeywords" id="exampleInputEmail1" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Image</label>
                                <input type="file" class="form-control"name="postImage" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Belong to Category</label>
                                <select name="categoryPostId" class="form-control input-sm m-bot15">
                                    @foreach($allCategoryPost as $key => $categoryPost)
                                    <option value="{{$categoryPost->category_post_id}}">{{$categoryPost->category_post_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Status</label>
                                <select name="postStatus" class="form-control input-sm m-bot15">
                                    <option value="1">Enable</option>
                                    <option value="0">Disable</option>
                                </select>
                            </div>
                            <button type="submit" name="addCategoryProduct" class="btn btn-info">Add Post</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
