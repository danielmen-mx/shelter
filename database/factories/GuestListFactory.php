<?php

namespace Database\Factories;

use App\Models\GuestList;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuestList>
 */
class GuestListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GuestList::class;

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
            'tickets' => rand(1, 9)
        ];
    }
}
