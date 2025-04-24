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
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tsocio_id')
                ->constrained('tsocios')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('anyo')->nullable();
            $table->decimal('cantidad', 8, 2)->nullable();
            $table->softDeletes(); // Añadir soporte para Soft Deletes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};
