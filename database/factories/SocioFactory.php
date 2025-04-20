<?php

namespace Database\Factories;

use App\Models\TSocio;
use App\Models\Cuota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Socio>
 */
class SocioFactory extends Factory
{
    private static $nsocioCounter = 1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nsocio' => self::$nsocioCounter++,
            'empresa' => $this->faker->company,
            'nombre' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName . ' ' . $this->faker->lastName,
            'dni' => $this->generateDni(),
            'telefono' => $this->faker->phoneNumber,
            'movil' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'calle' => $this->faker->streetName,
            'portal' => $this->faker->buildingNumber,
            'piso' => $this->faker->numberBetween(1, 10),
            'letra' => $this->faker->randomLetter,
            'codigo_postal' => $this->faker->postcode,
            'poblacion' => $this->faker->city,
            'provincia' => $this->faker->state,
            'persona_contacto' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'domiciliacion' => $this->faker->boolean,
            'iban' => $this->faker->iban('ES'),
            'titular' => $this->faker->firstName,
            'dni_titular' => $this->generateDni(),
            'tsocio_id' => TSocio::query()->inRandomOrder()->first()?->id ?? 1, // Selecciona un TSocio existente o usa un ID predeterminado
            'cuota_id' => Cuota::query()->inRandomOrder()->first()?->id ?? 1,
            'baja' => $this->faker->boolean,
        ];
    }

    /**
     * Generate a valid DNI.
     *
     * @return string
     */
    private function generateDni(): string
    {
        $numbers = str_pad((string)random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $letter = $letters[$numbers % 23];
        return $numbers . $letter;
    }
    // /**
    //  * Configure the factory.
    //  *
    //  * @return $this
    //  */
    // public function configure(): static
    // {
    //     return $this->afterCreating(function (Socio $socio) {
    //         if (Socio::count() > 0) {
    //             $socio->assignRole('viewer');
    //             return;
    //         } else if (Socio::count() === 0) {
    //             $socio->assignRole('viewer');
    //             return;
    //         }
    //     });
    // }
}
