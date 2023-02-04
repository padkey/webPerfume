@extends('admin_layout')
@section('admin_content')




    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Show All Video
            </div>
            <div class="row w3-res-tb">


                <div class="col-sm-12">
                    <div class="panel-body">
                        <div class="position-center">
                            <form >
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Video title</label>
                                    <input type="text" class="form-control videoTitle" name="videoTitle" id="slug" onkeyup="ChangeToSlug()" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" class="form-control videoSlug" name="videoSlug" id="convert_slug" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Link</label>
                                    <input type="text" class="form-control videoLink" name="videoLink" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Description</label>
                                    <textarea style="resize:none;" rows="3" type="text" class="form-control videoDes" name="videoDes"> </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Image</label>
                                    <input type="file" class="form-control " id="fileVideoImage"  name="fileVideoImage" >
                                </div>

                                <button type="button" class="btn btn-info addVideo">Add video</button>
                            </form>
                        </div>

                    </div>
                </div>



            </div>
            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if($message){
                    echo '<span class="text-alert">',$message,'</span>';
                    //cho nó thành nul để reload lại trang k thấy nó nữa
                    Session::put('message',null);
                }
                ?>

                    <div id="loadVideo"></div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Video</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end model-->
        </div>
    </div>


@endsection
