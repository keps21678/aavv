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
            'cantidad' => '10.00',
        ]);
    }
}
