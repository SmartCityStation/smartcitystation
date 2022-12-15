<?php

namespace Database\Factories\Backend;

use App\Models\Backend\LocationDevice;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationDeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LocationDevice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->word,
        'installation_date' => $this->faker->word,
        'installation_hour' => $this->faker->word,
        'remove_date' => $this->faker->word,
        'remove_hour' => $this->faker->word,
        'latitude' => $this->faker->word,
        'length' => $this->faker->word,
        'device_id' => $this->faker->randomDigitNotNull,
        'area_id' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
