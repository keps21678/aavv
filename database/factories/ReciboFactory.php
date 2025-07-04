<?php

namespace Database\Factories;

use App\Models\Recibo;
use App\Models\Socio;
use App\Models\TSocio; 
use App\Models\Cuota;
use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReciboFactory extends Factory
{
    protected $model = Recibo::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'socio_id' => Socio::inRandomOrder()->first()->id, // Selecciona un socio existente aleatoriamente
            'tsocio_id' => TSocio::inRandomOrder()->first()->id, // Selecciona un socio existente aleatoriamente
            'cuota_id' => Cuota::inRandomOrder()->first()->id, // Selecciona una cuota existente aleatoriamente            
            'recibo_numero' => $this->faker->unique()->numerify('REC-#####'), // Número de recibo único
            'fecha_emision' => $this->faker->dateTimeBetween('-1 year', 'now'), // Fecha de emisión en el último año
            'fecha_vencimiento' => $this->faker->optional()->dateTimeBetween('now', '+1 year'), // Fecha de vencimiento opcional
            'estado_id' => Estado::inRandomOrder()->first()->id, // Selecciona un estado existente aleatoriamente
            'descripcion' => $this->faker->sentence(), // Descripción aleatoria
        ];
    }
}
