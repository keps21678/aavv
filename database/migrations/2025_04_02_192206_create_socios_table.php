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
        Schema::create('socios', function (Blueprint $table) {
            $table->id();
            $table->integer('nsocio')->unique();
            $table->string('empresa')->default(0);
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('dni')->unique();
            $table->string('telefono');
            $table->string('movil');
            $table->string('email')->unique();
            $table->string('calle');
            $table->string('portal');
            $table->string('piso');
            $table->string('letra');
            $table->string('codigo_postal');
            $table->string('poblacion');
            $table->string('provincia');
            $table->string('persona_contacto')->nullable();
            $table->boolean('domiciliacion')->default(0);
            $table->string('iban', 512)->unique();
            $table->string('titular')->nullable();
            $table->string('dni_titular')->nullable();
            $table->unsignedBigInteger('tsocio_id');
            $table->foreign('tsocio_id')->references('id')->on('tsocios');
            $table->unsignedBigInteger('cuota_id');
            $table->foreign('cuota_id')->references('id')->on('cuotas');
            $table->boolean('baja')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socios');
    }
};
