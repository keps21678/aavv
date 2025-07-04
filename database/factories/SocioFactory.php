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
            'iban' => $this->isValidIban($this->faker->iban('ES')) ? $this->faker->iban('ES') : null,
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
    /**
     * Validate the IBAN.
     *
     * @param string $iban
     * @return bool
     */
    private function isValidIban(string $iban): bool
    {
        // Elimina espacios y convierte a mayúsculas
        $iban = strtoupper(str_replace(' ', '', $iban));

        // Verifica la longitud mínima y máxima del IBAN
        if (strlen($iban) < 15 || strlen($iban) > 34) {
            return false;
        }

        // Mueve los primeros 4 caracteres al final
        $iban = substr($iban, 4) . substr($iban, 0, 4);

        // Reemplaza las letras por números (A=10, B=11, ..., Z=35)
        $iban = preg_replace_callback('/[A-Z]/', function ($match) {
            return ord($match[0]) - 55;
        }, $iban);

        // Calcula el módulo 97
        $remainder = intval(substr($iban, 0, 1));
        for ($i = 1, $len = strlen($iban); $i < $len; $i++) {
            $remainder = intval($remainder . $iban[$i]) % 97;
        }

        return $remainder === 1;
    }
}
