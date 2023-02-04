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
                    @foreach($editCategoryProduct as $key => $category)
                    <div class="position-center">
                        <form role="form" method="POST" action="{{URL::to('/updateCategoryProduct/'.$category->category_id)}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Category name</label>
                                <input type="text" class="form-control"name="categoryName" id="slug" onkeyup="ChangeToSlug()" value="{{$category->category_name}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Belong To The Category</label>
                                <select name="categoryParent" class="form-control input-sm m-bot15">
                                    <option value="0">Parent</option>
                                    @foreach($allCategoryParent as $key => $categoryParent)
                                        <option value="{{$categoryParent->category_id}}" {{$category->category_parent == $categoryParent->category_id ? 'selected' : ''}}>{{$categoryParent->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" class="form-control"name="categorySlug" id="convert_slug" value="{{$category->category_slug}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description Category</label>
                                <textarea style="resize:none;" rows="3" type="text" class="form-control"  name="categoryDes">{{$category->category_des}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Keywords</label>
                                <textarea style="resize:none;" rows="3" type="text" class="form-control"  name="metaKeywords">{{$category->meta_keywords}} </textarea>
                            </div>

                            <button type="submit" name="updateCategoryProduct" class="btn btn-info">Update category</button>
                        </form>
                    </div>
                        @endforeach

                </div>
            </section>

        </div>

    </div>
@endsection
