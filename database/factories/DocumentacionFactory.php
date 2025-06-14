<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Estado;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Documentacion>
 */
class DocumentacionFactory extends Factory
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
            'categoria_id' => Categoria::query()->inRandomOrder()->first()->id, // Selecciona un Estado existente de forma aleatoria
            'descripcion' => $this->faker->sentence(),
            'fecha_firma' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'archivo' => $this->faker->word() . '.pdf',
            'nombre_archivo' => $this->faker->word() . '.pdf',
            'estado_id' => Estado::query()->inRandomOrder()->first()->id, // Selecciona un Estado existente de forma aleatoria
            'observaciones' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
