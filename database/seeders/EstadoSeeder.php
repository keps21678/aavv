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
            'color' => '#006400', // Verde oscuro mate
        ]);
        Estado::factory()->create([
            'nombre' => 'Pendiente',
            'descripcion' => 'Pendiente de pago.',
            'color' => '#FFD700', // Amarillo mate
        ]);
        Estado::factory()->create([
            'nombre' => 'Anulado',
            'descripcion' => 'Anulado.',
            'color' => '#FF0000', // Rojo
        ]);
        Estado::factory()->create([
            'nombre' => 'Rechazado',
            'descripcion' => 'Rechazado.',
            'color' => '#FF0000', // Rojo
        ]);
        Estado::factory()->create([
            'nombre' => 'Devuelto',
            'descripcion' => 'Devuelto.',
            'color' => '#FFA500', // Naranja
        ]);
        Estado::factory()->create([
            'nombre' => 'Vencido',
            'descripcion' => 'Vencido.',
            'color' => '#FF4500', // Naranja oscuro
        ]);
        Estado::factory()->create([
            'nombre' => 'Reclamado',
            'descripcion' => 'Reclamado.',
            'color' => '#0000FF', // Azul
        ]);
        Estado::factory()->create([
            'nombre' => 'Recuperado',
            'descripcion' => 'Recuperado.',
            'color' => '#008000', // Verde oscuro
        ]);
        Estado::factory()->create([
            'nombre' => 'Nuevo',
            'descripcion' => 'Nuevo.',
            'color' => '#008000', // Verde oscuro
        ]);
        Estado::factory()->create([
            'nombre' => 'Asignado',
            'descripcion' => 'Asignado.',
            'color' => '#0000FF', // Verde oscuro
        ]);
        Estado::factory()->create([
            'nombre' => 'Finalizado',
            'descripcion' => 'Finalizado.',
            'color' => '#FFA500', // Verde oscuro
        ]);
        Estado::factory()->create([
            'nombre' => 'Vigente',
            'descripcion' => 'Vigente.',
            'color' => '#008000', // Verde claro
        ]);
        Estado::factory()->create([
            'nombre' => 'Caducado',
            'descripcion' => 'Caducado.',
            'color' => '#FFA500', // Naranja
        ]);
        Estado::factory()->create([
            'nombre' => 'Revocado',
            'descripcion' => 'Revocado.',
            'color' => '#8B0000', // Rojo oscuro
        ]);
    }
}
