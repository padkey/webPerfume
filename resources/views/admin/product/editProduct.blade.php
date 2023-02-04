@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Edit Product
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
                        @foreach($editProduct as $key => $product)
                        <form role="form" method="POST" action="{{URL::to('/updateProduct/'.$product->product_id)}}" enctype="multipart/form-data">
                           @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product name</label>
                                <input type="text" class="form-control"name="productName" id="slug" onkeyup="ChangeToSlug()" value="{{$product->product_name}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text" class="form-control"name="productSlug" id="convert_slug" value="{{$product->product_slug}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Quantity</label>
                                <input type="text" class="form-control"name="productQty" value="{{$product->product_quantity}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Cost price</label>
                                <input type="text" class="form-control money"name="productCost" value="{{$product->product_cost}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sale price</label>
                                <input type="text" class="form-control money"name="productPrice" value="{{$product->product_price}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product image</label>
                                <input type="file" class="form-control"name="productImage">
                                <img src="{{URL::to('public/uploads/products/'.$product->product_image)}}" width="100px">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Content product</label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control" id="ckeditor3" name="productContent" >{{$product->product_content}}

                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description product</label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control" name="productDes" >{{$product->product_des}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Category</label>
                                <select name="categoryId" class="form-control input-sm m-bot15" value="">
                                    @foreach($categoryProduct as $key => $category)
                                        @if($category->category_id == $product->category_id)
                                        <option value="{{$category->category_id}}" selected>{{$category->category_name}}</option>
                                        @else
                                            <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                                    @endif
                                        @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">Brand</label>
                                <select name="brandId" class="form-control input-sm m-bot15" value="">
                                    @foreach($brandProduct as $key => $brand)
                                        @if($brand->brand_id == $product->brand_id)
                                        <option value="{{$brand->brand_id}}" selected>{{ $brand->brand_name }} </option>
                                        @else
                                            <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Tags</label>
                                <input type="text" data-role="tagsinput" name="productTags" value="{{$product->product_tags}}">
                            </div>


                            <button type="submit" name="addProduct" class="btn btn-info">Update product</button>
                        </form>
                            @endforeach
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
