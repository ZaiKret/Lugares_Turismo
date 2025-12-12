<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Mostrar formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Registrar usuario
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email'=> 'required|email:rfc,dns|unique:users,email',
        'password'=> 'required|string|min:6|confirmed',
    ], [
        'name.required' => 'El nombre es obligatorio.',
        'name.string' => 'El nombre debe ser un texto válido.',
        'name.max' => 'El nombre no puede tener más de 255 caracteres.',
        
        'email.required' => 'El correo electrónico es obligatorio.',
        'email.email' => 'El correo electrónico debe ser válido.',
        'email.unique' => 'Este correo ya está registrado.',
        
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
    ]);

    User::create([
        'name'=> $request->name,
        'email'=> $request->email,
        'password'=> Hash::make($request->password),
    ]);

    return redirect()->route('login')->with('success', 'Registro exitoso. Por favor inicia sesión.');
}


    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ], [
        'email.required' => 'El correo es obligatorio.',
        'email.email' => 'Debe ingresar un correo válido.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
    ]);

    $credentials = $request->only('email', 'password');

    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();
        // Redirigir a provincias
        return redirect()->route('provincias.index')->with('success', 'Has iniciado sesión correctamente.');
    }

    return back()->withErrors([
        'email' => 'Correo o contraseña incorrectos.',
    ])->onlyInput('email');
}


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
