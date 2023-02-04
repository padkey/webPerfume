@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Create User
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
                        <form role="form" method="POST" action="{{URL::to('/saveUser')}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">User name</label>
                                <input type="text" class="form-control"name="adminName" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Password</label>
                                <input type="text" class="form-control"name="adminPassword" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="text" class="form-control"name="adminEmail" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Phone</label>
                                <input type="text" class="form-control"name="adminPhone" id="exampleInputEmail1" >
                            </div>



                            <button type="submit" name="addUser" class="btn btn-info">Add user</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
