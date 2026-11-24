<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Escribe tu correo electrónico.',
            'email.email' => 'Escribe un correo válido, por ejemplo nombre@correo.com.',
            'password.required' => 'Escribe tu contraseña.',
        ]);

        if (!Auth::attempt($credenciales)) {
            return back()
                ->withErrors(['email' => 'El correo o la contraseña son incorrectos.'])
                ->onlyInput('email');
        }

        // Nuevo ID de sesión tras autenticarse (previene session fixation)
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Destruye solo la sesión de este usuario y renueva el token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}