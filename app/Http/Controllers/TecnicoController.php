<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Study;
use Illuminate\Http\Request;

class TecnicoController extends Controller
{
    public function index()
    {
        $studies = Study::with('patient')->latest()->get();
        $patients = Patient::all();
        
        // Retorna la vista de la carpeta 'tecnico'
        return view('tecnico.index', compact('studies', 'patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'      => 'required|exists:patients,id',
            'study_type'      => 'required|string',
            'visit_reason'    => 'nullable|string',
            'technician_name' => 'required|string',
        ]);

        $code = 'EST-' . date('Y') . '-' . rand(100, 999);

        Study::create([
            'code'            => $code,
            'patient_id'      => $request->patient_id,
            'study_type'      => $request->study_type,
            'visit_reason'    => $request->visit_reason,
            'technician_name' => $request->technician_name,
            'status'          => 'Nuevo',
        ]);

        return redirect()->back()->with('success', '¡Estudio cargado con éxito y disponible para el médico!');
    }
}