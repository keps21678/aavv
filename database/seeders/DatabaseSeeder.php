<?php

namespace Database\Seeders;

use App\Models\Category;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(TincidenciaSeeder::class);        
        
        $this->call(TSocioSeeder::class);

        $this->call(CuotaSeeder::class);        

        $this->call(RoleSeeder::class);

        $this->call(UserSeeder::class);

        $this->call(SocioSeeder::class);

        $this->call(IncidenciaSeeder::class);

        Category::factory(15)->create();
    }
}
