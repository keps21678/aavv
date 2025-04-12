<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TSocio;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cuota>
 */
class CuotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'tsocio_id' => TSocio::query()->inRandomOrder()->first()?->id ?? 1, // Selecciona un TSocio existente o usa un ID predeterminado
            'anyo' => $this->faker->year,
            'cantidad' => $this->faker->numberBetween(1, 50),
        ];
    }
}
