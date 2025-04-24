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
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')
                ->constrained('socios')
                ->onDelete('cascade');
            $table->foreignId('tincidencia_id')
                ->constrained('tincidencias')
                ->onDelete('cascade');
            $table->text('descripcion');
            $table->date('fecha_incidencia');
            $table->softDeletes(); // Añadir soporte para Soft Deletes  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};
