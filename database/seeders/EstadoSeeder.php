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

    /* Nomenclatura Incial de los iconos es la de heroicons */

    public function run(): void
    {
        //
        Estado::factory()->create([
            'nombre' => 'Pagado',
            'descripcion' => 'Pagado.',
            'color' => '#006400', // Verde oscuro mate
            'icono' => 'check', // Icono de verificación
        ]);
        Estado::factory()->create([
            'nombre' => 'Pendiente',
            'descripcion' => 'Pendiente de pago.',
            'color' => '#FFD700', // Amarillo mate
            'icono' => 'clock', // Icono de reloj
        ]);
        Estado::factory()->create([
            'nombre' => 'Anulado',
            'descripcion' => 'Anulado.',
            'color' => '#FF0000', // Rojo
            'icono' => 'ban', // Icono de prohibido
        ]);
        Estado::factory()->create([
            'nombre' => 'Rechazado',
            'descripcion' => 'Rechazado.',
            'color' => '#FF0000', // Rojo
            'icono' => 'times', // Icono de cruz
        ]);
        Estado::factory()->create([
            'nombre' => 'Devuelto',
            'descripcion' => 'Devuelto.',
            'color' => '#FFA500', // Naranja
            'icono' => 'undo', // Icono de deshacer
        ]);
        Estado::factory()->create([
            'nombre' => 'Vencido',
            'descripcion' => 'Vencido.',
            'color' => '#FF4500', // Naranja oscuro
            'icono' => 'exclamation-triangle', // Icono de advertencia
        ]);
        Estado::factory()->create([
            'nombre' => 'Reclamado',
            'descripcion' => 'Reclamado.',
            'color' => '#0000FF', // Azul
            'icono' => 'question', // Icono de pregunta
        ]);
        Estado::factory()->create([
            'nombre' => 'Recuperado',
            'descripcion' => 'Recuperado.',
            'color' => '#008000', // Verde oscuro
            'icono' => 'check-circle', // Icono de círculo de verificación
        ]);        
    }
}
