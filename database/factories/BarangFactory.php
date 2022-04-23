<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kode' => strtoupper(\Str::random(2)),
            'nama' => $this->faker->word(),
            'jumlah' => rand(10,60),
            'kondisi' => rand(0,1)
        ];
    }
}
