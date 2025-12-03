<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * MÉTODO PERSONALIZADO: Redirección según el Rol
     * Reemplaza a la variable $redirectTo
     */
    protected function redirectTo()
    {
        // Si el usuario es Administrador -> Panel de Control
        if (auth()->user()->role == 'admin') {
            return '/admin';
        }

        // Si es Cliente (o cualquier otro) -> Tienda de Zapatos
        return '/calzados';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}