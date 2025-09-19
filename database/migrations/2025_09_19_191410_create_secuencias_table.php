<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('secuencias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->boolean('activa')->default(true);
            $table->foreignId('ecosistema_id')->constrained('ecosistemas')->cascadeOnDelete();
            $table->timestamps();

            // Índices
            $table->unique(['nombre', 'ecosistema_id']); // Nombre único por ecosistema
            $table->index(['ecosistema_id', 'activa']); // Para filtros comunes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('secuencias');
    }
};
