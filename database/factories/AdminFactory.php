<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'admin_name' => $this->faker->name(),
            'admin_email' => $this->faker->unique()->safeEmail(),
            'admin_phone' => '0968658176',
            'admin_password' => 'e10adc3949ba59abbe56e057f20f883e', // password
        ];
    }
    public function configure()
    {
        return $this->afterMaking(function (Admin $admin) {
            //
        })->afterCreating(function (Admin $admin) {
            $roles = Roles::where('name','user')->get(); // mặc định admin mới tạo thì mình cho có là quyền user hết
            $admin->roles()->sync($roles->pluck('id_roles')->toArray()); // pluck method lấy tất cả giá trị cho một column mình chỉ định
        });
    }
}
