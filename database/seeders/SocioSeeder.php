<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Socio;
use App\Models\TSocio;

class SocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegúrate de que existan registros en TSocio
        if (TSocio::count() === 0) {
            TSocio::factory()->count(5)->create(); // Crea 5 registros de TSocio si no existen
        }

        // Crea socios asociados a TSocio existentes
        Socio::factory()->count(150)->create();
    }
}
