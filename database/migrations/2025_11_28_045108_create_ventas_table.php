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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            // Relacionamos la venta con el usuario que la compró
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Fecha y Estado
            $table->dateTime('fecha_venta');
            $table->string('estado')->default('pendiente'); // pendiente, pagado, enviado
            
            // Total a pagar
            $table->decimal('total', 10, 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
