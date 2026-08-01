<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class rrhhController extends Controller
{
    public function index()
    {
        // Obtener todo el personal registrado
        $employees = User::latest()->get();

        return view('rrhh.index', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string',
            'dni' => 'required|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'dni' => $request->dni,
            'status' => 'Activo',
            'password' => bcrypt('12345678'), // Contraseña temporal
        ]);

        return redirect()->route('rrhh.index')->with('success', '¡Empleado registrado con éxito!');
    }
}