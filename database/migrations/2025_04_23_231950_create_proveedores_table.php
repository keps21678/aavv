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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nif', 512)->unique(); // NIF único
            $table->string('nombre', 512); // Nombre del proveedor
            $table->string('telefono', 512)->nullable(); // Teléfono
            $table->string('email', 512)->nullable(); // Email
            $table->string('calle', 512)->nullable(); // Calle
            $table->string('portal', 512)->nullable(); // Número de portal
            $table->string('piso', 512)->nullable(); // Piso
            $table->string('letra', 512)->nullable(); // Letra del piso
            $table->string('codigo_postal', 512)->nullable(); // Código postal
            $table->string('poblacion', 512)->nullable(); // Población
            $table->string('provincia', 512)->nullable(); // Provincia
            $table->string('persona_contacto', 512)->nullable(); // Persona de contacto
            $table->boolean('domiciliacion')->default(false); // Domiciliación
            $table->text('iban', 512)->nullable(); // IBAN (encriptado)
            $table->string('titular', 512)->nullable(); // Nuevo campo
            $table->string('dni_titular', 512)->nullable(); // Nuevo campo
            $table->softDeletes(); // Añadir soporte para Soft Deletes  
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
