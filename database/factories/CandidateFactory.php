<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Candidate>
 */
class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $creator = User::factory()->create();
        $owner = User::factory()->create();
        return [
            'name' => $this->faker->name,
            'source' => $this->faker->text,
            'owner' => $owner->id,
            'created_by' => $creator->id,
        ];
    }
}
