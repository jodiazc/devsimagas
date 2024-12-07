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
        Schema::create('payment_links', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_liga'); // Tipo de liga
            $table->string('dlectura'); // Lectura del dato
            $table->string('cliente'); // Cliente
            $table->string('pedido'); // Pedido
            $table->decimal('importe', 10, 2); // Importe (con dos decimales)
            $table->string('estaus'); // Estado
            $table->string('fecha_expiracion'); // Fecha de expiración
            $table->string('fecha_elaboracion'); // Fecha de elaboración
            $table->string('insercion_al_modulo'); // Inserción al módulo
            $table->string('transactionId'); // Inserción al módulo
            $table->timestamps(); // Created_at y Updated_at            
        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_links');
    }
};
