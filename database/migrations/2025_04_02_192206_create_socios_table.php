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
            $table->string('empresa', 512)->default(0);
            $table->string('nombre', 512);
            $table->string('apellidos', 512);
            $table->string('dni', 512)->unique();
            $table->string('telefono', 512);
            $table->string('movil', 512);
            $table->string('email', 512)->unique();
            $table->string('calle', 512);
            $table->string('portal', 512);
            $table->string('piso', 512);
            $table->string('letra', 512);
            $table->string('codigo_postal');
            $table->string('poblacion');
            $table->string('provincia');
            $table->string('persona_contacto', 512)->nullable();
            $table->boolean('domiciliacion')->default(0);
            $table->string('iban', 512)->unique()->nullable();
            $table->string('titular', 512)->nullable();
            $table->string('dni_titular', 512)->nullable();
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
