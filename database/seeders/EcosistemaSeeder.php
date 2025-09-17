<?php

namespace Database\Seeders;

use App\Models\Ecosistema;
use Illuminate\Database\Seeder;

class EcosistemaSeeder extends Seeder
{
    public function run(): void
    {
        Ecosistema::firstOrCreate([
            'nombre' => 'DNSEEPPS',
        ], [
            'descripcion' => 'Ecosistema base creado por el kickstart',
        ]);
    }
}
