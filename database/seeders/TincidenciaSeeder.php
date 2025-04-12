<?php

namespace Database\Seeders;

use App\Models\Tincidencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TincidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         //
         Tincidencia::factory()->create([
            'nombre' => 'Alta',
            'descripcion' => 'Alta como socio/a',
        ]);
        Tincidencia::factory()->create([
            'nombre' => 'Baja',
            'descripcion' => 'Baja como socio/a',
        ]);
        Tincidencia::factory()->create([
            'nombre' => 'Modificación',
            'descripcion' => 'Modificación de los datos del socio/a',
        ]);
        Tincidencia::factory()->create([
            'nombre' => 'Observaciones',
            'descripcion' => 'Observaciones sobre el socio',
        ]);
        Tincidencia::factory()->create([
            'nombre' => 'Otros',
            'descripcion' => 'Otras incidencias',
        ]);
    }
}
