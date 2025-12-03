<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    // Solo permitir acceso a admins (protección extra)
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth()->check() && auth()->user()->role === 'admin') {
                return $next($request);
            }
            return redirect('/'); // Si no es admin, fuera.
        });
    }

    /**
     * Muestra la lista de clientes.
     */
    public function index()
    {
        // Filtramos solo los que tienen rol 'cliente'
        $clientes = User::where('role', 'cliente')->get();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Muestra el formulario para crear un cliente nuevo.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guarda el cliente en la BD.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cliente', // Forzamos el rol cliente
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    /**
     * Muestra el formulario para editar.
     */
    public function edit($id)
    {
        $cliente = User::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualiza los datos del cliente.
     */
    public function update(Request $request, $id)
    {
        $cliente = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$cliente->id,
        ]);

        $cliente->name = $request->name;
        $cliente->email = $request->email;
        
        // Solo cambiamos la contraseña si escribieron una nueva
        if ($request->filled('password')) {
            $cliente->password = Hash::make($request->password);
        }

        $cliente->save();

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado.');
    }

    /**
     * Elimina al cliente.
     */
    public function destroy($id)
    {
        $cliente = User::findOrFail($id);
        $cliente->delete();

        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado.');
    }
}