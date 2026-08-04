<?php

namespace App\Http\Controllers;

use App\Models\Study;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function index()
    {
        // Traer estudios pendientes
        $studies = Study::with('patient')->latest()->get();
        return view('doctor.index', compact('studies'));
    }

    public function processReport(Request $request, $id)
    {
        $study = Study::findOrFail($id);

        // Si el médico presiona "Rehacer estudio"
        if ($request->action === 'redo') {
            $study->update([
                'status' => 'Rehacer',
                'report' => $request->report
            ]);
            return redirect()->back()->with('warning', 'Se ha solicitado rehacer el estudio.');
        }

        // Si el médico presiona "Guardar y firmar"
        $request->validate(['report' => 'required|string']);
        
        $study->update([
            'report' => $request->report,
            'status' => 'Informado',
        ]);

        return redirect()->back()->with('success', 'El informe se ha guardado y firmado correctamente.');
    }
}
