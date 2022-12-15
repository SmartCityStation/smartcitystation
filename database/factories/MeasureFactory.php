<?php

namespace Database\Factories\Frontend;

use App\Models\Frontend\Measure;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeasureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Measure::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->word,
        'hour' => $this->faker->word,
        'data' => $this->faker->word,
        'device_id' => $this->faker->randomDigitNotNull,
        'data_variable_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
