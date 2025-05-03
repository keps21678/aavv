<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Proveedor;
use App\Models\Estado;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ingreso>
 */
class IngresoFactory extends Factory
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
            'proveedor_id' => Proveedor::query()->exists() 
                ? Proveedor::query()->inRandomOrder()->first()->id 
                : throw new \Exception('No existen proveedores en la base de datos.'),
            'numero' => $this->faker->unique()->numerify('ING-#####'),
            'fecha_emision' => $this->faker->date(),
            'fecha_vencimiento' => $this->faker->dateTimeBetween('now', '+30 days'),
            'descripcion' => $this->faker->sentence(), // Nuevo campo
            'importe' => $this->faker->randomFloat(2, 10, 100),
            'estado_id' => Estado::query()->inRandomOrder()->first()->id, // Selecciona un Estado existente de forma aleatoria
        ];
    }
}
