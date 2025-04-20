<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cuota;

class CuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Cuota::factory()->create([
            'tsocio_id' => '1',
            'anyo' => '2025',
            'cantidad' => '11.00',
        ]);
        Cuota::factory()->create([
            'tsocio_id' => '2',
            'anyo' => '2025',
            'cantidad' => '12.00',
        ]);
        Cuota::factory()->create([
            'tsocio_id' => '3',
            'anyo' => '2025',
            'cantidad' => '13.00',
        ]);
        Cuota::factory()->create([
            'tsocio_id' => '4',
            'anyo' => '2025',
            'cantidad' => '14.00',
        ]);
    }
}
