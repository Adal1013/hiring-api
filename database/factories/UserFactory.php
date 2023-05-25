<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $roleIds = Role::pluck('id')->toArray();
        return [
            'username' => $this->faker->userName,
            'password' => bcrypt('hiring'),
            'is_active' => 1,
            'role_id' => $this->faker->randomElement($roleIds)
        ];
    }
}
