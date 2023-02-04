<?php

namespace Database\Seeders;
use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       Roles::truncate(); // khi phát hiện csdl thì nó sẽ xóa tất cả dữ liệu trong tbl_roles này, và thêm những dữ liệu mới ở dưới

        Roles::create(['name'=>'admin']); // col name của tbl_roles = admin
        Roles::create(['name'=>'author']); //author có nghĩa là quyền biên tập
        Roles::create(['name'=>'user']);
    }
}
