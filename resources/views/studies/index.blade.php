<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Universitario - Worklist</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Archivo CSS Externo -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar Navigation -->
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-white border-end min-vh-100">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-3 text-dark">
                <h3 class="fw-bold my-3 text-primary">Hospital<br><small class="text-secondary fs-6">Universitario</small></h3>
                
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100">
                    <li class="nav-item w-100 mb-2">
                        <a href="#" class="nav-link active bg-warning text-dark fw-bold">
                            Worklist (Pendientes)
                        </a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="#" class="nav-link text-dark">Mis Informes</a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="#" class="nav-link text-dark">Mi Rendimiento</a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="#" class="nav-link text-dark">Papelera</a>
                    </li>
                    <li class="nav-item w-100 mt-4">
                        <a href="{{ route('tecnico.index') }}" class="nav-link text-primary border border-primary text-center rounded">
                            Portal Técnico
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col py-3 px-4">
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

            <!-- Header -->
            <h4 class="fw-bold text-secondary mb-3">Worklist (Pendientes)</h4>

            <!-- Tabla de Estudios -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">ID Estudio</th>
                                <th>Paciente</th>
                                <th>Tipo de Estudio</th>
                                <th>Fecha/Hora</th>
                                <th>Técnico</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studies as $study)
                                <tr>
                                    <td class="ps-3"><strong>{{ $study->code }}</strong></td>
                                    <td>{{ $study->patient->first_name ?? 'Facundo' }} {{ $study->patient->last_name ?? 'Rus' }}</td>
                                    <td>{{ $study->study_type }}</td>
                                    <td>{{ $study->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $study->technician_name }}</td>
                                    <td>
                                        <span class="badge bg-warning text-dark">{{ $study->status }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm fw-bold px-3" data-bs-toggle="modal" data-bs-target="#modalReport{{ $study->id }}">
                                            Informar
                                        </button>
                                    </td>
                                </tr>

                               <!-- MODAL ESTILO CORTEX / CARGAR ESTUDIO -->
<div class="modal fade" id="modalReport{{ $study->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content modal-content-clean">
            
            <!-- Encabezado Azul -->
            <div class="modal-header modal-header-blue d-flex justify-content-between align-items-center">
                <h5 class="modal-title fw-bold m-0">Informe Radiológico - {{ $study->code }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="#" method="POST">
                @csrf
                <!-- Cuerpo del Modal -->
                <div class="modal-body p-4 bg-white">
                    
                    <!-- Ficha Superior: 2 Columnas -->
                    <div class="row g-3 mb-3">
                        <!-- Estudio / Visualizador -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark mb-1">Estudio Realizado</label>
                            <div class="card-info-light p-3 d-flex align-items-center gap-3">
                                <i class="bi bi-file-earmark-medical fs-1 text-primary"></i>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">{{ $study->study_type }}</h6>
                                    <small class="text-muted">Subido por: {{ $study->technician_name }}</small>
                                </div>
                            </div>
                        </div>

                        <!-- Paciente -->
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark mb-1">Datos del Paciente</label>
                            <div class="card-info-light p-3">
                                <p class="mb-1 text-dark"><strong>Paciente:</strong> {{ $study->patient->first_name ?? 'Facundo' }} {{ $study->patient->last_name ?? 'Rus' }}</p>
                                <p class="mb-1 text-dark"><strong>Edad:</strong> {{ $study->patient->age ?? '25' }} años</p>
                                <p class="mb-0 text-dark"><strong>Motivo:</strong> {{ $study->visit_reason ?? 'Control rutinario' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Editor del Informe -->
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark">Informe Radiológico / Observaciones</label>
                        <textarea class="form-control" name="report_content" rows="5" placeholder="Escriba los hallazgos clínicos y la conclusión del estudio..." style="border-radius: 8px;"></textarea>
                    </div>

                </div>

                <!-- Pie de Modal / Botonera Limpia -->
                <div class="modal-footer bg-white border-0 px-4 pb-4 pt-0 d-flex justify-content-between">
                    <button type="button" class="btn btn-orange-rehacer" onclick="alert('Estudio enviado a rehacer')">
                        Rehacer
                    </button>
                    
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-gray-cancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-blue-action">Guardar y Firmar</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
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