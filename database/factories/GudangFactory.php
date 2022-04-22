<?php

namespace Database\Factories;

use App\Models\Gudang;
use Illuminate\Database\Eloquent\Factories\Factory;

class GudangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gudang::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kode' => strtoupper(\Str::random(2)),
            'nama' => ucfirst($this->faker->word()),
            'catatan' => $this->faker->realText(100)
        ];
    }
}
