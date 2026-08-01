<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Study; // O tu modelo de estudios/informes

class RrhhController extends Controller
{
    // Vista 1: Tarjetas de Especialidades
    public function index()
    {
        // Secciones disponibles
        $specialties = ['Cardiología', 'Neumonología'];
        
        return view('rrhh.index', compact('specialties'));
    }

    // Vista 2: Tabla de Médicos de la Especialidad seleccionada
    public function specialty($specialty)
    {
        // Médicos que pertenecen a esta especialidad
        $doctors = User::where('role', 'Médico')
                       ->where('specialty', $specialty)
                       ->withCount('studies') // Cuenta la cantidad de informes realizados
                       ->get();

        return view('rrhh.specialty', compact('doctors', 'specialty'));
    }

    // Vista 3: Informes detallados realizados por un Médico
    public function doctorDetail($id)
    {
        $doctor = User::findOrFail($id);
        
        // Estudios o informes realizados por este médico
        $studies = Study::where('doctor_id', $doctor->id)
                        ->with('patient')
                        ->latest()
                        ->get();

        return view('rrhh.doctor_detail', compact('doctor', 'studies'));
    }
}
