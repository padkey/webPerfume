<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Roles;
use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    //phân quyền
    public function run()
    {
        //

        Admin::truncate(); // xóa tất cả dữ liệu trong tbl_admin
      //  Admin::factory()->count(10)->create();
        DB::table('admin_roles')->truncate();
        $adminRoles = Roles::where('name','admin')->first(); // vào tbl_roles lấy hàng dữ liệu có name = admin
        $authorRoles = Roles::where('name','author')->first();
        $userRoles = Roles::where('name','user')->first();

        //tạo dữ liệu cho  tbl_admin bằng lệnh
        $admin = Admin::create([
           'admin_name' =>'Nguyễn Xuân Lý',
            'admin_email'=>'admin@gmail.com',
            'admin_phone'=>'012345678',
            'admin_password'=>md5('123456'),
        ]);
        $author = Admin::create([
           'admin_name'=>'Trần Ngọc Ánh',
           'admin_email'=>'author@gmail.com',
           'admin_phone'=>'0968658176',
           'admin_password'=>md5('1') ,
        ]);
        $user = Admin::create([
           'admin_name'=>'Lý Víp Pro',
           'admin_email'=>'user@gmail.com',
           'admin_phone'=>'0123456',
           'admin_password'=>md5('1'),
        ]);

        $admin->roles()->attach($adminRoles); // $admin->roles() , roles() là hàm mình đã viết trong models admin, attach($adminRoles) là gắn quyền mình truy vấn phía trên vào
        $author->roles()->attach($authorRoles); // hàm roles() là hàm mình đã tạo trong models admin, attach($authorRoles) là gắn cho $author cái quền author mình truy vấn phía trên
        $user->roles()->attach($userRoles);//hàm roles là hàm mình đã tạo trong models admin, attach(userRoles) là gắn cho @user cái quyền mình đã truy vấn phía trên


        \App\Models\Admin::factory()->count(10)->create();
    }
}
