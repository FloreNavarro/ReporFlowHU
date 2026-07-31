<?php

namespace App\Http\Controllers;

use App\Models\Study;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function index()
    {
        // Trae los estudios con los datos de sus pacientes
        $studies = Study::with('patient')->latest()->get();

        return view('studies.index', compact('studies'));
    }

    // Guardar el informe escrito por el médico
    public function updateReport(Request $request, $id)
    {
        $request->validate([
            'report' => 'required|string',
        ]);

        $study = Study::findOrFail($id);
        $study->update([
            'report' => $request->report,
            'status' => 'Informado', // Cambia el estado automáticamente
        ]);

        return redirect()->back()->with('success', 'El informe se ha guardado correctamente.');
    }
}
