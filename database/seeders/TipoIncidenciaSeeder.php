<?php

namespace Database\Seeders;

use App\Models\TipoIncidencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoIncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        TipoIncidencia::factory()->create([
            'nombre' => 'Alta',
            'descripcion' => 'Alta como socio/a',
        ]);
        TipoIncidencia::factory()->create([
            'nombre' => 'Baja',
            'descripcion' => 'Baja como socio/a',
        ]);
        TipoIncidencia::factory()->create([
            'nombre' => 'Modificación',
            'descripcion' => 'Modificación de los datos del socio/a',
        ]);
        TipoIncidencia::factory()->create([
            'nombre' => 'Observaciones',
            'descripcion' => 'Observaciones sobre el socio',
        ]);
        TipoIncidencia::factory()->create([
            'nombre' => 'Otros',
            'descripcion' => 'Otras incidencias',
        ]);
    }
}
