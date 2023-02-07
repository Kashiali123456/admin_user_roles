<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
        
            'name' => $this->faker->name,
            'contact_no' => $this->faker->randomNumber,
            'designation' => $this->faker->shuffle,
            'profile' => $this->faker->shuffle,
            'department' => $this->faker->shuffle,
            'job_type' => $this->faker->shuffle,
            'email' => $this->faker->unique()->safeEmail,
            'joining_date' => $this->faker->shuffle,
            // 'status' => $this->faker->int,
 
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
