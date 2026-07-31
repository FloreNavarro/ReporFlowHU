<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReportFlow - Gestión de Estudios</title>

    <!-- Bootstrap 5 (Librería externa) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- TU ARCHIVO CSS SEPARADO -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">

<div class="container py-4">
    <!-- Contenido HTML de la vista -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📋 Gestión de Estudios Médicos</h2>
        <button class="btn btn-primary">+ Nuevo Estudio</button>
    </div>

    <div class="card custom-card">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-custom-header">
                    <tr>
                        <th>Código</th>
                        <th>Paciente</th>
                        <th>Estudio</th>
                        <th>Técnico</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studies as $study)
                        <tr>
                            <td><strong>{{ $study->code }}</strong></td>
                            <td>{{ $study->patient->first_name }} {{ $study->patient->last_name }}</td>
                            <td>{{ $study->study_type }}</td>
                            <td>{{ $study->technician_name }}</td>
                            <td>
                                <span class="badge bg-info text-dark">{{ $study->status }}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal-{{ $study->id }}">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No hay estudios registrados aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>