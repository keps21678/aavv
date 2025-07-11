<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGastosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            $table->string('numero')->unique();
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->text('descripcion')->nullable(); // Nuevo campo
            $table->decimal('importe', 10, 2);
            $table->foreignId('estado_id')->constrained('estados')->onDelete('cascade');
            $table->softDeletes(); // Añadir soporte para Soft Deletes            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
}
