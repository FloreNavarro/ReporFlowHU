<?php



use App\Http\Controllers\StudyController;
use App\Http\Controllers\tecnicoController;
use App\Http\Controllers\RrhhController;
use Illuminate\Support\Facades\Route;

// Rutas del Médico

Route::get('/', [StudyController::class, 'index'])->name('studies.index');
Route::put('/studies/{id}/report', [StudyController::class, 'processReport'])->name('studies.processReport');

// Rutas del Técnico
Route::prefix('tecnico')->name('tecnico.')->group(function () {
Route::get('/', [TecnicoController::class, 'index'])->name('index');
Route::post('/store', [TecnicoController::class, 'store'])->name('store'); 
});



// Rutas de Recursos Humanos


Route::prefix('rrhh')->name('rrhh.')->group(function () {
    // 1. Vista general de secciones / especialidades
    Route::get('/', [RrhhController::class, 'index'])->name('index');

    // 2. Vista de médicos por especialidad (ej: /rrhh/especialidad/Cardiologia)
    Route::get('/especialidad/{specialty}', [RrhhController::class, 'especialidad'])->name('especialidad');

    // 3. Vista de informes realizados por un médico específico
    Route::get('/medico/{id}', [RrhhController::class, 'doctorDetail'])->name('doctor.detail');

    Route::post('/store', [RrhhController::class, 'store'])->name('store');
});