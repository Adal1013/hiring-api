<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
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
        $roleNames = Role::pluck('name')->toArray();
        return [
            'username' => $this->faker->userName,
            'password' => bcrypt('hiring'),
            'is_active' => 1,
            'role' => $this->faker->randomElement($roleNames)
        ];
    }

    /**
     * @return Factory
     */
    public function configure(): Factory
    {
        return $this->afterCreating(function (User $user) {
            $user->assignRole($user->role);
        });
    }
}
