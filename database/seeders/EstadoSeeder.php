<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estado;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Estado::factory()->create([
            'nombre' => 'Pagado',
            'descripcion' => 'Pagado.',
        ]);
        Estado::factory()->create([
            'nombre' => 'Pendiente',
            'descripcion' => 'Pendiente de pago.',
        ]);
        Estado::factory()->create([
            'nombre' => 'Anulado',
            'descripcion' => 'Anulado.',
        ]);
        Estado::factory()->create([
            'nombre' => 'Rechazado',
            'descripcion' => 'Rechazado.',
        ]);
        Estado::factory()->create([
            'nombre' => 'Devuelto',
            'descripcion' => 'Devuelto.',
        ]);
        Estado::factory()->create([
            'nombre' => 'Vencido',
            'descripcion' => 'Vencido.',
        ]);
        Estado::factory()->create([
            'nombre' => 'Reclamado',
            'descripcion' => 'Reclamado.',
        ]);
        Estado::factory()->create([
            'nombre' => 'Recuperado',
            'descripcion' => 'Recuperado.',
        ]);        
    }
}
