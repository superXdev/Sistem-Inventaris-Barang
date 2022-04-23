<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BarangMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'berat' => rand(1, 5), 
            'harga' => rand(10000, 50000),
            'jumlah' => rand(10, 100)
        ];
    }
}
