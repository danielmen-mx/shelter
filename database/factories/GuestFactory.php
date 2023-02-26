<?php

namespace Database\Factories;

use App\Models\Guest;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guest>
 */
class GuestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Guest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => Str::slug($this->faker->firstName),
            'second_name' => Str::slug($this->faker->firstName),
            'first_last_name' => Str::slug($this->faker->lastName),
            'second_last_name' => Str::slug($this->faker->lastName),
            'assistance' => $this->faker->randomElement([true, false])
        ];
    }
}
