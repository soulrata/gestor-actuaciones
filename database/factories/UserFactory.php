<?php

namespace Database\Factories;

use App\Models\Ecosistema;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'ecosistema_id' => Ecosistema::factory(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the user should not have an ecosistema assigned.
     */
    public function withoutEcosistema(): static
    {
        return $this->state(fn (array $attributes) => [
            'ecosistema_id' => null,
        ]);
    }

    /**
     * Indicate that the user should be assigned to a specific ecosistema.
     */
    public function forEcosistema($ecosistema): static
    {
        return $this->state(fn (array $attributes) => [
            'ecosistema_id' => is_object($ecosistema) ? $ecosistema->id : $ecosistema,
        ]);
    }
}
