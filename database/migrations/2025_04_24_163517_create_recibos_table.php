<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Estado;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();            
            $table->foreignId('socio_id')->constrained('socios')->onDelete('cascade'); // Relación con socios            
            $table->foreignId('tsocio_id')->constrained('socios')->onDelete('cascade'); // Relación con socios 
            $table->foreignId('cuota_id')->constrained('cuotas')->onDelete('cascade'); // Relación con cuotas           
            $table->string('recibo_numero')->unique()->nullable(); // Número de recibo único
            $table->date('fecha_emision'); // Fecha de emisión
            $table->date('fecha_vencimiento')->nullable(); // Fecha de vencimiento
            $table->foreignId('estado_id')->nullable()->constrained('estados')->onDelete('set null'); // Relación con estados
            $table->text('descripcion')->nullable(); // Descripción opcional
            $table->timestamps();
            $table->softDeletes(); // Para soporte de eliminación lógica
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibos');
    }
};
