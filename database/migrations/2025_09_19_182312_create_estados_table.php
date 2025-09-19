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
        Schema::create('estados', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', ['Inicio', 'En Proceso', 'Fin']);
            $table->foreignId('ecosistema_id')->constrained('ecosistemas')->onDelete('cascade');
            $table->timestamps();
            
            // Índices
            $table->index(['ecosistema_id', 'tipo']);
            $table->unique(['nombre', 'ecosistema_id']); // Nombre único por ecosistema
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
    }
};
