<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Cliente;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticado correctamente
            return response()->json(['success' => true, 'user' => Auth::user()]);
        }

        return response()->json(['success' => false, 'message' => 'Credenciales inválidas'], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'email' => 'required|email|unique:users|unique:clientes,email',
            'telefono' => 'required|string',
            'direccion' => 'required|string',
            'dni' => 'required|string|unique:clientes,dni',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:M,F,Otro',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        // 1. Crear usuario
        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. Crear cliente
        Cliente::create([
            'user_id' => $user->id, // Relacionar con la tabla users
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'dni' => $request->dni,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'estado' => 'activo',
            'comentarios' => '',
            'password' => bcrypt($request->password), // si usás login separado para cliente
        ]);


        Auth::login($user);

        return response()->json(['success' => true, 'user' => $user]);
    }


    public function logout()
    {
        Auth::logout();
        return response()->json(['success' => true]);
    }
}
