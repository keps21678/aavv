<?php

namespace Database\Factories;

use App\Models\Socio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\incidencia>
 */
class IncidenciaFactory extends Factory
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
            'socio_id' => Socio::all()->unique('id')->random()->id, // Selecciona un Socio existente de forma aleatoria y único
            'tincidencia_id' => \App\Models\Tincidencia::all()->random()->id, // Selecciona un tipo de incidencia existente de forma aleatoria
            'descripcion' => $this->faker->sentence,
            'fecha_incidencia' => $this->faker->dateTimeBetween('-6 months', 'yesterday'),
        ];
    }
}
