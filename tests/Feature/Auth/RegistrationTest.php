<?php

use Livewire\Volt\Volt;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $admin = \App\Models\User::factory()->create();
    $admin->assignRole('admin');
    $this->actingAs($admin);

    $response = $this->get('/admin/users/create');
    $response->assertStatus(200);
});

test('new users can be register', function () {
    $admin = \App\Models\User::factory()->create([
        'password' => bcrypt('password'),
    ]);
    $admin->assignRole('admin');
    $this->actingAs($admin);

    $response = $this->post('/admin/users', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'roles' => ['viewer'],
    ]);

    $response->assertRedirect('/'); // Ajusta aquí si la redirección es a la home
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'name' => 'Test User',
    ]);
});
