<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Calzado;
use App\Models\User; // <--- IMPORTANTE: Necesario para crear usuarios
use Illuminate\Support\Facades\Hash; // <--- IMPORTANTE: Para encriptar contraseñas

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. CREACIÓN DE USUARIOS (NUEVO)
        // ==========================================
        
        // Usuario Administrador
        User::create([
            'name' => 'Administrador Principal',
            'email' => 'admin@calzadostore.com',
            'password' => Hash::make('admin123'), // Contraseña: admin123
            'role' => 'admin',
        ]);

        // Usuario Cliente
        User::create([
            'name' => 'Cliente Frecuente',
            'email' => 'cliente@gmail.com',
            'password' => Hash::make('cliente123'), // Contraseña: cliente123
            'role' => 'cliente',
        ]);

        // ==========================================
        // 2. TUS DATOS DE PRODUCTOS (ORIGINAL)
        // ==========================================

        // CREAMOS LAS CATEGORÍAS
        $catDeportivos = Categoria::create([
            'nombre' => 'Deportivos',
            'descripcion' => 'Zapatillas para correr y entrenamiento'
        ]);

        $catFormales = Categoria::create([
            'nombre' => 'Formales',
            'descripcion' => 'Zapatos de cuero y vestir'
        ]);

        // CREAMOS LOS ZAPATOS (Conectados a las categorías)
        
        // Zapatos Deportivos
        Calzado::create([
            'categoria_id' => $catDeportivos->id,
            'modelo' => 'Air Max 90',
            'marca' => 'Nike',
            'talla' => 42,
            'color' => 'Blanco/Rojo',
            'precio' => 120.50,
            'stock' => 50,
            'descripcion' => 'Clásicos zapatos de running con cámara de aire.',
            'imagen' => null
        ]);

        Calzado::create([
            'categoria_id' => $catDeportivos->id,
            'modelo' => 'Ultraboost',
            'marca' => 'Adidas',
            'talla' => 40,
            'color' => 'Negro',
            'precio' => 180.00,
            'stock' => 30,
            'descripcion' => 'Máxima comodidad para largas distancias.',
            'imagen' => null
        ]);

        // Zapatos Formales
        Calzado::create([
            'categoria_id' => $catFormales->id,
            'modelo' => 'Oxford Classic',
            'marca' => 'Clarks',
            'talla' => 41,
            'color' => 'Café',
            'precio' => 89.99,
            'stock' => 15,
            'descripcion' => 'Elegancia para oficina y eventos.',
            'imagen' => null
        ]);
    }
}