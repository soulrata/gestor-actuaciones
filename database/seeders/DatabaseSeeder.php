<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Iniciando seeders...');

        // Crear usuario administrador principal
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario de prueba adicional
        $testUser = User::firstOrCreate(
            ['email' => 'liaomiguel@gmail.com'],
            [
                'name' => 'Miguel Liao',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Usuarios base creados');

        // Ejecutar seeder de permisos, roles y ecosistema base
        $this->call([
            AdminPermissionsSeeder::class,
            RoutePermissionsSeeder::class,
            EcosistemaSeeder::class,
        ]);

        $this->command->info('🎉 Seeders completados exitosamente');
        $this->command->info('');
        $this->command->info('📧 Credenciales de acceso:');
        $this->command->info('   Email: admin@admin.com');
        $this->command->info('   Password: 12345678');
    }
}
