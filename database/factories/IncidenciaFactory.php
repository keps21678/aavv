<?php

namespace Database\Factories;

use App\Models\Socio;
use App\Models\Tincidencia;
use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incidencia>
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
            'socio_id' => Socio::all()->random()->id, // Selecciona un Socio existente de forma aleatoria
            'tincidencia_id' => Tincidencia::all()->random()->id, // Selecciona un tipo de incidencia existente de forma aleatoria
            'descripcion' => $this->faker->sentence, // Genera una descripción aleatoria
            'fecha_incidencia' => $this->faker->dateTimeBetween('-6 months', 'yesterday'), // Fecha aleatoria en los últimos 6 meses
            'estado_id' => Estado::query()->inRandomOrder()->first()->id, // Selecciona un Estado existente de forma aleatoria            
        ];
    }
}
