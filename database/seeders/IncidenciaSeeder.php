<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incidencia;

class IncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Incidencia::factory()->create([
            'socio_id' => '1',
            'tincidencia_id' => '1',
            'descripcion' => 'Incidencia de prueba',
            'fecha_incidencia' => now(),
        ]);
    }
}
