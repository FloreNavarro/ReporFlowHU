<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Universitario - Portal Clínico</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar Navigation -->
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-white border-end min-vh-100">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-3 text-dark">
                <h3 class="fw-bold my-3 text-primary">Hospital<br><small class="text-secondary fs-6">Universitario</small></h3>
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
        <div class="col py-3">
            <!-- Topbar -->
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <div class="w-50">
                    <input type="text" class="form-control rounded-pill" placeholder="Buscar paciente o ID estudio...">
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold">Lucas (Dr. Neumonología)</span>
                    <i class="bi bi-person-circle fs-3 text-secondary"></i>
                </div>
            </div>

            <!-- Alertas de estado -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show">{{ session('warning') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif

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
                                        <span class="badge {{ $study->status == 'Informado' ? 'bg-success' : ($study->status == 'Rehacer' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                                            {{ $study->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- BOTÓN INFORMAR -->
                                        <button class="btn btn-sm btn-danger px-3 fw-bold" data-bs-toggle="modal" data-bs-target="#reportModal-{{ $study->id }}">
                                            Informar
                                        </button>

                                        <!-- MODAL FIGMA: INFORME MÉDICO -->
                                        <div class="modal fade" id="reportModal-{{ $study->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">
                                                    <!-- Cabecera del Modal -->
                                                    <div class="modal-header bg-secondary text-white py-2">
                                                        <div>
                                                            <h5 class="modal-title mb-0 fw-bold">Hospital Universitario</h5>
                                                            <small class="text-light">Subido: {{ $study->technician_name }}</small>
                                                        </div>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form action="{{ route('studies.processReport', $study->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        
                                                        <div class="modal-body p-4 bg-light">
                                                            <!-- Fila Superior: Visualizador + Datos del Paciente -->
                                                            <div class="row g-3 mb-3">
                                                                <!-- Visualizador del Estudio -->
                                                                <div class="col-md-7">
                                                                    <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center p-4 text-center shadow-sm" style="min-height: 180px; background-color: #a39594 !important;">
                                                                        <h4 class="fw-bold text-dark">Estudio: {{ $study->study_type }}</h4>
                                                                    </div>
                                                                </div>
                                                                <!-- Datos Paciente -->
                                                                <div class="col-md-5 d-flex flex-column justify-content-center">
                                                                    <p class="mb-1"><strong>Paciente:</strong> {{ $study->patient->first_name }} {{ $study->patient->last_name }}</p>
                                                                    <p class="mb-1"><strong>Años:</strong> {{ $study->patient->age ?? '25' }}</p>
                                                                    <p class="mb-0"><strong>Razón de la visita:</strong> {{ $study->visit_reason ?? 'Control de rutina...' }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Campo Texto Informe Radiológico -->
                                                            <div class="mb-2">
                                                                <label class="form-label fw-bold text-secondary small">INFORME RADIOLÓGICO</label>
                                                                <textarea name="report" class="form-control border-primary shadow-sm" rows="5" placeholder="• Silueta cardiovascular: De características normales...&#10;• Estructura ósea: Sin alteraciones...&#10;• Conclusión: Estudio radiográfico sin hallazgos patológicos...">{{ $study->report }}</textarea>
                                                            </div>
                                                        </div>

                                                        <!-- Pie del Modal: Botones exactamente como en Figma -->
                                                        <div class="modal-footer d-flex justify-content-between bg-white">
                                                            <!-- Botón Rehacer (Naranja) -->
                                                            <button type="submit" name="action" value="redo" class="btn btn-warning text-white fw-bold px-4">
                                                                Rehacer
                                                            </button>

                                                            <div>
                                                                <!-- Botón Cancelar (Rojo) -->
                                                                <button type="button" class="btn btn-danger text-white fw-bold px-4 me-2" data-bs-dismiss="modal">
                                                                    Cancelar
                                                                </button>

                                                                <!-- Botón Guardar y Firmar (Verde) -->
                                                                <button type="submit" name="action" value="save" class="btn btn-success text-white fw-bold px-4">
                                                                    Guardar y firmar
                                                                </button>
                                                            </div>
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
                                    <td colspan="7" class="text-center py-4 text-muted">No hay estudios pendientes.</td>
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