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
        Schema::create('lopds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('socio_id');           // Relación con el socio
            $table->unsignedBigInteger('category_id');        // Tipo de documento (consentimiento, aviso, etc.)
            $table->string('descripcion')->nullable();        // Descripción breve
            $table->date('fecha_firma')->nullable();          // Fecha de firma
            $table->string('archivo')->nullable();            // Ruta o nombre del archivo
            $table->unsignedBigInteger('estado_id');          // Estado del documento
            $table->text('observaciones')->nullable();        // Observaciones adicionales
            $table->softDeletes();
            $table->timestamps();

            // Relaciones (ajusta los nombres de las tablas si es necesario)
            $table->foreign('socio_id')->references('id')->on('socios')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lopds');
    }
};
