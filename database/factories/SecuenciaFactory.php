<?php

namespace Database\Factories;

use App\Models\Ecosistema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Secuencia>
 */
class SecuenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ecosistema_id' => Ecosistema::factory(),
            'nombre' => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraph(),
            'activa' => $this->faker->boolean(80), // 80% chance true
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the secuencia is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'activa' => true,
        ]);
    }

    /**
     * Indicate that the secuencia is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'activa' => false,
        ]);
    }
}
