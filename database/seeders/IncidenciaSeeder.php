<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incidencia;
use App\Models\Tincidencia;
use App\Models\Socio;

class IncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener un ID válido de la tabla tincidencias
        $tincidenciaId = Tincidencia::inRandomOrder()->value('id');

        // Obtener un ID válido de la tabla socios
        $socioId = Socio::inRandomOrder()->value('id');

        // Crear una incidencia con un tipo de incidencia y socio válidos
        Incidencia::factory()->create([
            'socio_id' => $socioId,
            'tincidencia_id' => $tincidenciaId,
            'descripcion' => 'Incidencia de prueba',
            'fecha_incidencia' => now(),
        ]);
    }
}
