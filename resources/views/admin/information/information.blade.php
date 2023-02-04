@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Information Website
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
                        <form role="form" method="POST" action="{{URL::to('/updateContact')}}" enctype="multipart/form-data">
                            @csrf
                           {{-- // contact thì chỉ có một, nên ta không tạo mới, nếu không tồn lại contact thì ta cho nó thành rỗng--}}
                            <input type="hidden" name="infoId" value="{{$contact ? $contact->info_id : ''}}">

                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" name="infoAddress" value="{{$contact ? $contact->info_address : ''}}">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="infoPhone" value="{{$contact ? $contact->info_phone : ''}}">
                            </div>
                            <div class="form-group">
                              {{--  Không được làm kiểu ckedit vì mình chèn html , vào ckedit khi lấy giá trị ra nó sẽ không đúng nữa--}}
                                <label>Map position</label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control"  name="infoMap" >
                                {{$contact ? $contact->info_map : ''}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                {{--  Không được làm kiểu ckedit vì mình chèn html , vào ckedit khi lấy giá trị ra nó sẽ không đúng nữa--}}
                                <label>Fanpage</label>
                                <textarea style="resize:none;" rows="5" type="text" class="form-control"  name="infoFanpage" >
                                {{$contact? $contact->info_fanpage : ''}}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label>Slogan(khẩu hiệu)</label>
                                <input type="text" class="form-control"name="infoSlogan" value="{{$contact ? $contact->info_slogan : ''}}">
                            </div>
                            <div class="form-group">
                                <label>Logo website</label>
                                <input type="file" class="form-control"name="InfoLogo" >
                                <img src="{{url('public/uploads/contact/'.($contact ? $contact->info_logo : '') )}}" alt="" width="100px">
                            </div>


                            <button type="submit" name="updateContact" class="btn btn-info">Update Information Website</button>
                        </form>
                    </div>

                </div>
            </section>
            <section class="panel">
                <header class="panel-heading">
                    Icons Social
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
                        <form>
                            @csrf
                            <div class="form-group">
                                <label>Icon name</label>
                                <input type="text" class="form-control"name="iconName" id="iconName">
                            </div>
                            <div class="form-group">
                                <label>Icon Link</label>
                                <input type="text" class="form-control" name="iconLink" id="iconLink">
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" name="iconImage"  id="iconImage">
                            </div>

                            <button type="button" name="addIcon" class="btn btn-info addIcon">Add icon</button>
                        </form>
                    </div>
                    <div class="position-center">
                        <div id="loadIcon"></div>
                    </div>
                </div>
            </section>
        </div>

    </div>
@endsection
