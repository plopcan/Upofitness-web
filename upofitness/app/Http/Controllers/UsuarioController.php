<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('usuarios.index', compact('usuarios'));
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

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|string',
        ]);

        if (Auth::guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $user = Auth::guard('web')->user();

            if ($user->role->name === $request->role) {
                return redirect()->route('welcome'); // Redirect to welcome page
            } else {
                Auth::guard('web')->logout();
                return back()->withErrors(['role' => 'El rol no coincide con el usuario.']);
            }
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    public function create()
    {
        return view('auth.register'); // Render the registration form
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $usuario = new Usuario();
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->phone = $request->phone;
        $usuario->role_id = 1; // Default role for non-admin users

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');

            // Save the image in the database
            $image = new Image();
            $image->url = $path;
            $image->save();

            // Assign the image ID to the user
            $usuario->image_id = $image->id;
        }

        $usuario->save();

        return redirect()->route('login')->with('success', 'Usuario registrado exitosamente.');
    }
}
