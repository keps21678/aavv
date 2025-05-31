<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'nombre' => 'Consentimiento',
            'descripcion' => 'Consentimiento para el tratamiento de datos personales.',
            'color' => '#007bff', // Azul
        ]);

        Category::create([
            'nombre' => 'Aviso',
            'descripcion' => 'Aviso de privacidad.',
            'color' => '#ffc107', // Amarillo
        ]);

        Category::create([
            'nombre' => 'Revocación',
            'descripcion' => 'Revocación del consentimiento.',
            'color' => '#dc3545', // Rojo
        ]);
    }
}
