@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Show All Brand product
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
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
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <th>User name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Password</th>
                        <th>Admin</th>
                        <th>Author</th>
                        <th>User</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admin as $key => $user)
                        <form action="{{URL::to('/assignRoles')}}" method="POST">
                            @csrf
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$user->admin_name}}</td>
                            <td>{{$user->admin_email}} <input type="hidden" name="adminEmail" value="{{$user->admin_email}}"></td>
                            <td>{{$user->admin_phone}}</td>
                            <td>{{$user->admin_password}}</td>
                            <input type="hidden" name="adminId" value="{{$user->admin_id}}">
                            <td><input type="checkbox" name="adminRole" {{$user->hasRole('admin') ? 'checked' : ''}}></td>
                            <td><input type="checkbox" name="authorRole" {{$user->hasRole('author') ? 'checked' : ''}}></td>
                            <td><input type="checkbox" name="userRole" {{$user->hasRole('user') ? 'checked' : ''}}></td>
                            <td>
                                <input type="submit" value="Assign Roles" class="btn btn-sm btn-success">

                                <a href="{{URL::to('/deleteUserRoles/'.$user->admin_id)}}" class="btn btn-sm btn-danger" style="margin-top: 5px;width: 92px">
                                    Delete user
                                </a>
                                <a href="{{URL::to('/impersonate/'.$user->admin_id)}}" class="btn btn-sm btn-info" style="margin-top: 5px;width: 92px">
                                    Impersonate
                                </a>
                            </td>
                        </tr>

                        </form>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {!! $admin->links() !!}
                            {{--<li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>--}}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>

@endsection
