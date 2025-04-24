<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estado>
 */
class EstadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->unique()->word(), // Genera un nombre único
            'descripcion' => $this->faker->sentence(), // Genera una descripción aleatoria
            'color' => $this->faker->hexColor(), // Genera un color hexadecimal aleatorio
            'icono' => $this->faker->word(), // Genera un icono aleatorio
        ];
    }
}
