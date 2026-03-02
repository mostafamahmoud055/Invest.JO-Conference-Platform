<?php

namespace Database\Factories;

use App\Models\Hall;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hall>
 */
class HallFactory extends Factory
{
    protected $model = Hall::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Hall ' . strtoupper(Str::random(3)),
            'capacity' => fake()->numberBetween(50, 500),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
