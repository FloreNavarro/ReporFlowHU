<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Universitario - Portal Clínico</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar Navigation (Menú Lateral de Figma) -->
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-white border-end min-vh-100">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-3 text-dark">
                <h4 class="fw-bold my-3 text-primary">Hospital<br><small class="text-secondary fs-6">Universitario</small></h4>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                    <li class="nav-item w-100 mb-2">
                        <a href="#" class="nav-link active bg-warning text-dark fw-bold">
                            <i class="bi bi-file-earmark-medical"></i> Solicitudes (Pendientes)
                        </a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="#" class="nav-link text-dark">
                            <i class="bi bi-folder2-open"></i> Mis Informes
                        </a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="#" class="nav-link text-dark">
                            <i class="bi bi-graph-up"></i> Mi Rendimiento
                        </a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="#" class="nav-link text-dark">
                            <i class="bi bi-trash"></i> Papelera
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col py-3 bg-light">
            <!-- Topbar (Buscador y Perfil) -->
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <div class="w-50">
                    <input type="text" class="form-control rounded-pill" placeholder="Buscar paciente o ID estudio...">
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold">Lucas (Dr. Neumonología)</span>
                    <i class="bi bi-person-circle fs-3 text-secondary"></i>
                </div>
            </div>

            <!-- Tabla de Estudios Pendientes -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-secondary">Solicitudes de Estudios Pendientes</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID Estudio</th>
                                <th>Paciente</th>
                                <th>Tipo de Estudio</th>
                                <th>Fecha/Hora</th>
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
                                    <td>{{ $study->created_at->format('d/m/Y - H:i') }}</td>
                                    <td>{{ $study->technician_name }}</td>
                                    <td>
                                        <span class="badge bg-info text-dark">{{ $study->status }}</span>
                                    </td>
                                    <td>
                                        <!-- Botón para abrir el Modal de Informe Médico -->
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $study->id }}">
                                            Informar
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <!-- MODAL FIGMA: VISTA MÉDICA INFORME -->
                                        <div class="modal fade" id="reportModal-{{ $study->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-secondary text-white">
                                                        <div>
                                                            <h5 class="modal-title mb-0">Hospital Universitario</h5>
                                                            <small>Solicitó: {{ $study->technician_name }}</small>
                                                        </div>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('studies.updateReport', $study->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <!-- Lado Izquierdo: Visualizador de Imagen / Estudio -->
                                                                <div class="col-md-6 border-end">
                                                                    <div class="bg-dark text-white d-flex align-items-center justify-content-center rounded p-4" style="height: 220px;">
                                                                        <h5 class="text-center">Estudio: {{ $study->study_type }}</h5>
                                                                    </div>
                                                                </div>

                                                                <!-- Lado Derecho: Formulario para redactar Informe -->
                                                                <div class="col-md-6">
                                                                    <label class="form-label fw-bold">Redactar informe médico:</label>
                                                                    <textarea name="report" class="form-control" rows="7" placeholder="Realice el informe correspondiente al estudio..." required>{{ $study->report }}</textarea>
                                                                </div>
                                                            </div>

                                                            <!-- Datos del Paciente al pie del modal -->
                                                            <div class="row mt-3 pt-2 border-top">
                                                                <div class="col-12 text-muted small">
                                                                    <strong>Paciente:</strong> {{ $study->patient->first_name }} {{ $study->patient->last_name }} | 
                                                                    <strong>Años:</strong> {{ $study->patient->age ?? 'N/A' }} | 
                                                                    <strong>Razón de la visita:</strong> {{ $study->visit_reason ?? 'No especificada' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Eliminar</button>
                                                            <button type="submit" class="btn btn-success">Guardar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- FIN MODAL -->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">No hay estudios pendientes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>