<?php

namespace Database\Factories;

use App\Models\Admin; // sửa user lại thành admin
use App\Models\Roles;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

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

  /* public function afterCreating($admin){
        $roles = Roles::where('name','user')->first(); // mặc định admin mới tạo thì mình cho có là quyền user hết
       $admin->roles()->sync($roles->pluck('id_roles')->toArray());
   }*/

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
