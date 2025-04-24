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
            'proveedor_id' => Proveedor::query()->exists() 
                ? Proveedor::query()->inRandomOrder()->first()->id 
                : throw new \Exception('No existen proveedores en la base de datos.'),
            'numero' => $this->faker->unique()->numerify('FAC-#####'),
            'fecha_emision' => $this->faker->date(),
            'fecha_vencimiento' => $this->faker->dateTimeBetween('now', '+30 days'),
            'descripcion' => $this->faker->sentence(), // Nuevo campo
            'importe' => $this->faker->randomFloat(2, 100, 10000),
            'estado' => $this->faker->randomElement(['pendiente', 'pagada', 'vencida']),
        ];
    }
}
