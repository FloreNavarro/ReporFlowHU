<?php



use App\Http\Controllers\StudyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudyController::class, 'index'])->name('studies.index');
Route::put('/studies/{id}/report', [StudyController::class, 'processReport'])->name('studies.processReport');
