<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Study;

class StudySeeder extends Seeder
{
    public function run(): void
    {
        // Paciente 1
        $patient1 = Patient::create([
            'first_name' => 'Facundo',
            'last_name'  => 'Rus',
            'dni'        => '40123456',
            'age'        => 25,
        ]);

        Study::create([
            'code'            => 'RX-2026-001',
            'patient_id'      => $patient1->id,
            'study_type'      => 'Radiografía de tórax',
            'visit_reason'    => 'Sospecha de neumonía / Control',
            'technician_name' => 'Tec. Luis Pérez',
            'status'          => 'Nuevo',
        ]);

        // Paciente 2
        $patient2 = Patient::create([
            'first_name' => 'María',
            'last_name'  => 'Gómez',
            'dni'        => '35987654',
            'age'        => 38,
        ]);

        Study::create([
            'code'            => 'TC-2026-042',
            'patient_id'      => $patient2->id,
            'study_type'      => 'Tomografía de tórax',
            'visit_reason'    => 'Evaluación de nódulo pulmonar',
            'technician_name' => 'Tec. Carlos López',
            'status'          => 'Nuevo',
        ]);
    }
}