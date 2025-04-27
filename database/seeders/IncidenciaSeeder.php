<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incidencia;
use App\Models\Tincidencia;
use App\Models\Socio;
use Faker\Factory as Faker;

class IncidenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 25 incidencias aleatorias
        Incidencia::factory()->count(25)->create();
    }
}
