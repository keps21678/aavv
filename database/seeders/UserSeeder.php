<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::factory()->create([
            'name' => 'Kepa Aburto',
            'email' => 'keps21678@hotmail.com',
            'password' => bcrypt('12345678'),
        ]);

        User::factory()->create([
            'name' => 'Kepa Viewer',
            'email' => 'keps21678@hotmail.eus',
            'password' => bcrypt('12345678'),
        ]);

        User::factory(3)->create();
    }
}
