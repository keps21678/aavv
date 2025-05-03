<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gasto;

class GastoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generar 3 gastos utilizando el factory
        Gasto::factory(3)->create();
    }
}
