<?php



use App\Http\Controllers\StudyController;
use App\Http\Controllers\tecnicoController;
use Illuminate\Support\Facades\Route;

// Rutas del Médico

Route::get('/', [StudyController::class, 'index'])->name('studies.index');
Route::put('/studies/{id}/report', [StudyController::class, 'processReport'])->name('studies.processReport');

// Rutas del Técnico
Route::prefix('tecnico')->name('technician.')->group(function () {
Route::get('/', [TecnicoController::class, 'index'])->name('index');
Route::post('/store', [TecnicoController::class, 'store'])->name('store'); 
});