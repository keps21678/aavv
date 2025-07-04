<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), //static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    /**
     * Configure the factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            // Asegura que el rol admin existe antes de asignarlo
            Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
            Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'web']);
            Role::firstOrCreate(['name' => 'viewer', 'guard_name' => 'web']);
            if (User::count() === 1) {
                $user->assignRole('admin');
                return;
            } else if (User::count() === 2) {
                $user->assignRole('admin');
                return;
            } else if (User::count() > 1) {
                $user->assignRole('viewer');
                return;
            }
        });
    }
}
