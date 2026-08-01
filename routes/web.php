<?php



use App\Http\Controllers\StudyController;
use App\Http\Controllers\tecnicoController;
use Illuminate\Support\Facades\Route;

// Rutas del Médico

Route::get('/', [StudyController::class, 'index'])->name('studies.index');
Route::put('/studies/{id}/report', [StudyController::class, 'processReport'])->name('studies.processReport');
