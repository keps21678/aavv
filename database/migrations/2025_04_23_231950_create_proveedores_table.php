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
            $table->string('nif', 9)->unique(); // NIF único
            $table->string('nombre', 255); // Nombre del proveedor
            $table->string('telefono', 15)->nullable(); // Teléfono
            $table->string('email', 255)->nullable(); // Email
            $table->string('calle', 255)->nullable(); // Calle
            $table->string('portal', 10)->nullable(); // Número de portal
            $table->string('piso', 10)->nullable(); // Piso
            $table->string('letra', 1)->nullable(); // Letra del piso
            $table->string('codigo_postal', 10)->nullable(); // Código postal
            $table->string('poblacion', 255)->nullable(); // Población
            $table->string('provincia', 255)->nullable(); // Provincia
            $table->string('persona_contacto', 255)->nullable(); // Persona de contacto
            $table->boolean('domiciliacion')->default(false); // Domiciliación
            $table->text('iban')->nullable(); // IBAN (encriptado)
            $table->string('titular', 255)->nullable(); // Nuevo campo
            $table->string('dni_titular', 9)->nullable(); // Nuevo campo
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
