<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use Illuminate\Database\Seeders\RolesTableSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesTableSeeder::class); // cho chạy class này, tạo dữ liệu roles(admin,author,user) cho mình trước
        $this->call(UsersTableSeeder::class);//  xong chạy cái này truy vấn quyền và gắn quền cho account mình muốn
    }
}
