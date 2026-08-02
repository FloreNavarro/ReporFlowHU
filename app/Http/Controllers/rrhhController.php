<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Study;
use Illuminate\Http\Request;

class RrhhController extends Controller
{
    // Vista 1: Tarjetas de Especialidades
    public function index()
    {
        $specialties = ['Cardiología', 'Neumonología'];
        $employees = User::all();

        return view('rrhh.index', compact('specialties', 'employees'));
    }

    // Vista 2: Tabla de Médicos por Especialidad
    public function especialidad($specialty)
    {
        $doctors = User::where('role', 'Médico')
            ->where('especialidad', $specialty)
            ->withCount('studies')
            ->get();

        return view('rrhh.especialidad', [
            'doctors' => $doctors,
            'especialidad' => $specialty
        ]);
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