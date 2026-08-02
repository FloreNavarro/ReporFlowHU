<?php


namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Study extends Model
{
    use SoftDeletes; // Habilita la papelera de reciclaje

    protected $fillable = [
        'code',
        'patient_id',
        'study_type',
        'visit_reason',
        'technician_name',
        'status',
        'image_path',
        'report', // <-- Permitir guardado masivo
        'deletion_reason',
    ];

    // Un estudio pertenece a un paciente
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}