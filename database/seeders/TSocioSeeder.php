<?php

namespace Database\Seeders;

use App\Models\TSocio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TSocioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        TSocio::factory()->create([
            'nombre' => 'Individual',
            'descripcion' => 'Socio',
        ]);
        TSocio::factory()->create([
            'nombre' => 'Familiar',
            'descripcion' => 'Socio de tipo familiar',
        ]);
        TSocio::factory()->create([
            'nombre' => 'Comunidad',
            'descripcion' => 'El socio es una comunidad',
        ]);
        TSocio::factory()->create([
            'nombre' => 'Colaborador',
            'descripcion' => 'Es un socio y un colaborador en actividades/eventos',
        ]);
        TSocio::factory()->create([
            'nombre' => 'Artea',
            'descripcion' => 'Socio especial, centro comercial Artea',
        ]);
    }
}
