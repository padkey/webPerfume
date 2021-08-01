@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Create Product
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
                        <form role="form" method="POST" action="{{URL::to('/saveProduct')}}" enctype="multipart/form-data">
                            <div class="form-group">
                                {{ csrf_field() }}
                                <label for="exampleInputEmail1">Product name</label>
                                <input type="text" class="form-control"name="productName" id="exampleInputEmail1" placeholder="Enter product">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Quantity</label>
                                <input type="text" class="form-control"name="productQty"
                                       data-validation="length" data-validation-length="min3">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product price</label>
                                <input type="text" class="form-control"name="productPrice"
                                       data-validation="length" data-validation-length="min3">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product image</label>
                                <input type="file" class="form-control"name="productImage" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Content product</label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control" id="ckeditor1" name="productContent" placeholder="Content product"> </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description product</label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control" id="ckeditor2" name="productDes" placeholder="Description product"> </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Keywords</label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control"  name="productDes" placeholder="Description product"> </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Category</label>
                                <select name="categoryId" class="form-control input-sm m-bot15">
                                    @foreach($categoryProduct as $key => $category)
                                    <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Brand</label>
                                <select name="brandId" class="form-control input-sm m-bot15">
                                    @foreach($brandProduct as $key => $brand)
                                    <option value="{{$brand->brand_id}}">{{ $brand->brand_name }} </option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Status</label>
                                <select name="productStatus" class="form-control input-sm m-bot15">
                                    <option value="1">Enable</option>
                                    <option value="0">Disable</option>
                                </select>
                            </div>

                            <button type="submit" name="addProduct" class="btn btn-info">Add product</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
