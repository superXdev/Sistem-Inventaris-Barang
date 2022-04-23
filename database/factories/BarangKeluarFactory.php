<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BarangKeluarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'penerima' => $this->faker->name(), 
            'berat' => rand(1,3),
            'harga' => rand(10000, 50000), 
            'jumlah' => rand(5, 20)
        ];
    }
}
