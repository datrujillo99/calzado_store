<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calzados', function (Blueprint $table) {
            $table->id();

            // 1. CONEXIÓN CON CATEGORÍA (¡Importante!)
            $table->foreignId('categoria_id')->constrained('categorias');

            // 2. DATOS DEL ZAPATO
            $table->string('modelo');
            $table->string('marca');
            $table->integer('talla');
            $table->string('color');
            $table->decimal('precio', 10, 2);

            // 3. EXTRAS PROFESIONALES
            $table->integer('stock');             // Cantidad disponible
            $table->string('imagen')->nullable(); // Nombre del archivo de foto
            $table->text('descripcion')->nullable(); // Detalles largos

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calzados');
    }
};