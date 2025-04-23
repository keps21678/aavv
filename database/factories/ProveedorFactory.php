<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProveedorFactory extends Factory
{
    /**
     * El modelo asociado con este factory.
     *
     * @var string
     */
    protected $model = Proveedor::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nif' => strtoupper(Str::random(9)),
            'nombre' => $this->faker->company,
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'calle' => $this->faker->streetName,
            'portal' => $this->faker->buildingNumber,
            'piso' => $this->faker->numberBetween(1, 10),
            'letra' => $this->faker->randomLetter,
            'codigo_postal' => $this->faker->postcode,
            'poblacion' => $this->faker->city,
            'provincia' => $this->faker->state,
            'persona_contacto' => $this->faker->name,
            'domiciliacion' => $this->faker->boolean,
            'iban' => $this->faker->iban('ES'),
            'titular' => $this->faker->name, // Nuevo campo
            'dni_titular' => $this->generateDni(), // Nuevo campo
        ];
    }

    /**
     * Genera un DNI válido.
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
