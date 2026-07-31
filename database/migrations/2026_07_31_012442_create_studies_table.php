<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('studies', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique(); // ej: DUP-2026-06-001
        $table->foreignId('patient_id')->constrained()->onDelete('cascade'); // Relación con paciente
        $table->string('study_type'); // Tipo de estudio (ej: Radiografía de tórax)
        $table->text('visit_reason')->nullable(); // Razón de la visita
        $table->string('technician_name'); // ej: Tec. Luis Pérez
        $table->string('status')->default('Nuevo'); // Estado (Nuevo, En revisión, etc.)
        $table->string('image_path')->nullable(); // Ruta de la imagen subida
        $table->text('deletion_reason')->nullable(); // Para el modal de razón de eliminación
        $table->softDeletes(); // Requerido para la Papelera de reciclaje
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('studies');
    }
};
