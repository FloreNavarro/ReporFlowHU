<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Study;

class RrhhController extends Controller
{
    // Vista 1: Tarjetas de Especialidades
    public function index()
    {
       $specialties = ['Cardiología', 'Neumonología'];

    // Obtenemos todos los empleados/usuarios
    $employees = User::all(); // O reemplaza por el modelo que uses para empleados

    return view('rrhh.index', compact('specialties', 'employees'));
    }

    // Vista 2: Tabla de Médicos por Especialidad seleccionada
    public function especialidad($specialty)
    {
        $doctors = User::where('role','Médico')
                       ->where('especialidad', $specialty)
                       ->withCount('studies')
                       ->get();

        return view('rrhh.especialidad', compact('doctors', 'especialidad'));
    }

    // Vista 3: Informes detallados realizados por un Médico
    public function doctorDetail($id)
    {
        $doctor = User::findOrFail($id);

        $studies = Study::where('doctor_id', $doctor->id)
                        ->with('patient')
                        ->latest()
                        ->get();

        return view('rrhh.detalle_doctor', compact('doctor', 'studies'));
    }
}