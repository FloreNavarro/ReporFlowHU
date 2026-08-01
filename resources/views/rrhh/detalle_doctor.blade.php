<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes Realizados - {{ $doctor->name }}</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-white border-end min-vh-100">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-3 text-dark">
                <h3 class="fw-bold my-3 text-primary">Hospital<br><small class="text-secondary fs-6">Universitario</small></h3>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100">
                    <li class="nav-item w-100 mb-2">
                        <a href="{{ route('studies.index') }}" class="nav-link text-dark"><i class="bi bi-eye"></i> Vista Médico</a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="{{ route('tecnico.index') }}" class="nav-link text-dark"><i class="bi bi-upload"></i> Portal Técnico</a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="{{ route('rrhh.index') }}" class="nav-link active bg-primary text-white fw-bold"><i class="bi bi-people"></i> Gestión RRHH</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="col py-3">
            <!-- Topbar -->
            <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
                <div class="w-50">
                    <input type="text" class="form-control rounded-pill" placeholder="Buscar por paciente o estudio...">
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold">RRHH</span>
                    <i class="bi bi-person-workspace fs-3 text-primary"></i>
                </div>
            </div>

            <!-- Botón Volver e Info del Profesional -->
            <div class="d-flex align-items-center gap-3 mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm rounded-pill"><i class="bi bi-arrow-left"></i> Volver</a>
                <h4 class="fw-bold text-secondary m-0">Historial de Informes: {{ $doctor->name }}</h4>
            </div>

            <!-- Tabla de Prácticas Informadas -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold m-0 text-dark">Detalle de Estudios e Informes</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha / Hora</th>
                                <th>Tipo de Práctica</th>
                                <th>Paciente</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studies as $study)
                                <tr>
                                    <td>{{ $study->created_at->format('d/m/Y - H:i') }} hs</td>
                                    <td><strong>{{ $study->study_type }}</strong></td>
                                    <td>{{ $study->patient->first_name ?? '' }} {{ $study->patient->last_name ?? '' }}</td>
                                    <td>
                                        <span class="badge bg-success">Informado</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Este profesional aún no posee informes registrados.</td>
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