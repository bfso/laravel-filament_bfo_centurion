<?php

namespace Database\Factories;

use App\Models\MapField;
use Illuminate\Database\Eloquent\Factories\Factory;

class MapFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MapField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'x' => 0,
            'y' => 0,
            'z' => 0,
        ];
    }
}
