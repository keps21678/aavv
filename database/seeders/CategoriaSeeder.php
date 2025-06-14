<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'nombre' => 'Consentimiento',
            'descripcion' => 'Consentimiento para el tratamiento de datos personales.',
            'color' => '#007bff', // Azul
        ]);

        Categoria::create([
            'nombre' => 'Aviso',
            'descripcion' => 'Aviso de privacidad.',
            'color' => '#ffc107', // Amarillo
        ]);

        Categoria::create([
            'nombre' => 'Revocación',
            'descripcion' => 'Revocación del consentimiento.',
            'color' => '#dc3545', // Rojo
        ]);
        Categoria::create([
            'nombre' => 'Plantilla',
            'descripcion' => 'Plantilla de documentos.',
            'color' => '#28a745', // Verde claro
        ]);
    }
}
