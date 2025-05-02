<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Image;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.manage', compact('usuarios'));
    }

    public function edit(Usuario $usuario = null)
    {
        $usuario = $usuario ?? Auth::user(); // Use the authenticated user if no specific user is provided
        return view('usuarios.edit-profile', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario = null)
    {
        $usuario = $usuario ?? Auth::user(); 

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'phone' => 'nullable|string|max:15',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;

        if ($request->hasFile('image')) {
            if ($usuario->image && Storage::disk('public')->exists($usuario->image->url)) {
                Storage::disk('public')->delete($usuario->image->url);
            }

            $path = $request->file('image')->store('profile_images', 'public');
            $image = new Image();
            $image->url = $path;
            $image->save();

            $usuario->image_id = $image->id;
        }

        $usuario->save();

        return redirect()->route('profile.edit')->with('success', 'Perfil actualizado correctamente.');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('admin.manage')->with('success', 'Usuario deleted successfully.');
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
        return view('auth.register');
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
        $usuario->role_id = 1;

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

    public function show(Usuario $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    public function adminEdit(Usuario $usuario)
    {
        $roles = Role::all();
        return view('admin.edit-user', compact('usuario', 'roles'));
    }

    public function adminUpdate(Request $request, Usuario $usuario)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->id,
            'phone' => 'nullable|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->phone = $request->phone;
        $usuario->role_id = $request->role_id;

        if ($request->hasFile('image')) {
            if ($usuario->image && Storage::disk('public')->exists($usuario->image->url)) {
                Storage::disk('public')->delete($usuario->image->url);
            }

            $path = $request->file('image')->store('profile_images', 'public');
            $image = new Image();
            $image->url = $path;
            $image->save();

            $usuario->image_id = $image->id;
        }

        $usuario->save();

        return redirect()->route('usuarios.manage')->with('success', 'Usuario actualizado correctamente.');
    }
}
