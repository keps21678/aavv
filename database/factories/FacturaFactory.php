<?php

namespace Database\Factories;

use App\Models\Factura;
use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

class FacturaFactory extends Factory
{
    /**
     * El modelo asociado con este factory.
     *
     * @var string
     */
    protected $model = Factura::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'proveedor_id' => Proveedor::factory(), // Relación con un proveedor
            'numero' => $this->faker->unique()->numerify('FAC-#####'), // Número de factura único
            'fecha_emision' => $this->faker->date(),
            'fecha_vencimiento' => $this->faker->dateTimeBetween('now', '+30 days'),
            'importe' => $this->faker->randomFloat(2, 100, 10000), // Importe entre 100 y 10,000
            'estado' => $this->faker->randomElement(['pendiente', 'pagada', 'vencida']), // Estado de la factura
        ];
    }
}
