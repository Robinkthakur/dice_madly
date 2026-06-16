<?php

namespace Database\Factories;

use App\Models\InterestOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InterestOption>
 */
class InterestOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InterestOption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'category' => $this->faker->randomElement(['Creativity', 'Sports & Fitness', 'Entertainment', 'Food & Drink', 'Travel & Outdoors']),
        ];
    }
}
