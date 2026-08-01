<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Universitario - Portal Técnico</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Navegación Lateral (Sidebar) -->
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-white border-end min-vh-100">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-3 text-dark">
                <h3 class="fw-bold my-3 text-primary">Hospital<br><small class="text-secondary fs-6">Universitario</small></h3>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100">
                    <li class="nav-item w-100 mb-2">
                        <a href="#" class="nav-link active bg-primary text-white fw-bold">
                            <i class="bi bi-upload"></i> Cargar Estudio
                        </a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="{{ route('studies.index') }}" class="nav-link text-dark">
                            <i class="bi bi-eye"></i> Vista Médico
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Área de Contenido Principal -->
        <div class="col py-3">
            <!-- Barra Superior (Topbar) -->
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <div class="w-50">
                    <input type="text" class="form-control rounded-pill" placeholder="Buscar estudio cargado...">
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold">Luis (Técnico Radiólogo)</span>
                    <i class="bi bi-person-badge fs-3 text-primary"></i>
                </div>
            </div>

            <!-- Alertas de éxito -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Encabezado y Botón de Carga -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-secondary">Estudios Cargados Recientemente</h4>
                <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalCargarEstudio">
                    <i class="bi bi-plus-lg"></i> Cargar Nuevo Estudio
                </button>
            </div>

            <!-- Tabla de Estudios Subidos -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Código</th>
                                <th>Paciente</th>
                                <th>Estudio</th>
                                <th>Fecha/Hora</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studies as $study)
                                <tr>
                                    <td><strong>{{ $study->code }}</strong></td>
                                    <td>{{ $study->patient->first_name }} {{ $study->patient->last_name }}</td>
                                    <td>{{ $study->study_type }}</td>
                                    <td>{{ $study->created_at->format('d/m/Y - H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $study->status == 'Informado' ? 'bg-success' : 'bg-info text-dark' }}">
                                            {{ $study->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No se han cargado estudios aún.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA CARGAR NUEVO ESTUDIO -->
<div class="modal fade" id="modalCargarEstudio" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Cargar Nuevo Estudio</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <!--<form action="{{ route('tecnico.store') }}" method="POST">-->
                <form action="javascript:void(0);">
                @csrf
                <div class="modal-body p-4">
                    <!-- Selección del Paciente -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Paciente</label>
                        <select name="patient_id" class="form-select" required>
                            <option value="" selected disabled>Seleccionar paciente...</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }} (DNI: {{ $patient->dni }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tipo de Estudio -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipo de Estudio</label>
                        <input type="text" name="study_type" class="form-control" placeholder="Ej: Radiografía de tórax, TC de cráneo..." required>
                    </div>

                    <!-- Técnico Responsable -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Técnico Responsable</label>
                        <input type="text" name="technician_name" class="form-control" value="Tec. Luis Pérez" required>
                    </div>

                    <!-- Motivo / Observaciones -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Motivo de la visita / Observaciones</label>
                        <textarea name="visit_reason" class="form-control" rows="3" placeholder="Síntomas o motivo de la consulta..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">Subir Estudio</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>