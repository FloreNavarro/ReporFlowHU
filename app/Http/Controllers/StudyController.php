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
}
