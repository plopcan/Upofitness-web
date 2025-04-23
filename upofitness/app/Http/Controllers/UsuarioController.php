<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'image_id' => 'nullable|exists:images,id',
        ]);

        Usuario::create($request->all());

        return redirect()->route('usuarios.index')->with('success', 'Usuario created successfully.');
    }

    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'image_id' => 'nullable|exists:images,id',
        ]);

        $usuario->update($request->all());

        return redirect()->route('usuarios.index')->with('success', 'Usuario updated successfully.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario deleted successfully.');
    }

    // Nuevo método para manejar el inicio de sesión
    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Simulación de autenticación
        $usuario = Usuario::where('email', $request->email)->where('password', $request->password)->first();

        if ($usuario) {
            if ($usuario->role->name === $request->role) {
                // Establecer la variable de sesión con el ID del usuario
                session(['usuario_id' => $usuario->id]);

                if ($request->role === 'usuario') {
                    return redirect()->route('usuario');
                } elseif ($request->role === 'administrador') {
                    return redirect()->route('admin');
                }
            } else {
                return back()->withErrors(['role' => 'El rol no coincide con el usuario.']);
            }
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }
}
