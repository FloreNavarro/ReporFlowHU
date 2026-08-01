<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Universitario - Portal RRHH</title>
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
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start w-100" id="menu">
                    <li class="nav-item w-100 mb-2">
                        <a href="{{ route('studies.index') }}" class="nav-link text-dark">
                            <i class="bi bi-eye"></i> Vista Médico
                        </a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="{{ route('technician.index') }}" class="nav-link text-dark">
                            <i class="bi bi-upload"></i> Portal Técnico
                        </a>
                    </li>
                    <li class="nav-item w-100 mb-2">
                        <a href="{{ route('rrhh.index') }}" class="nav-link active bg-primary text-white fw-bold">
                            <i class="bi bi-people"></i> Gestión RRHH
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
                    <input type="text" class="form-control rounded-pill" placeholder="Buscar empleado por nombre o DNI...">
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold">Mariana (Recursos Humanos)</span>
                    <i class="bi bi-person-workspace fs-3 text-primary"></i>
                </div>
            </div>

            <!-- Alertas de éxito -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Tarjetas de Métricas -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 border-start border-primary border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted fw-bold mb-1">Total Personal</h6>
                                <h3 class="fw-bold mb-0">{{ count($employees) }}</h3>
                            </div>
                            <i class="bi bi-people fs-1 text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 border-start border-success border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted fw-bold mb-1">Personal Activo</h6>
                                <h3 class="fw-bold mb-0 text-success">{{ $employees->where('status', 'Activo')->count() }}</h3>
                            </div>
                            <i class="bi bi-check-circle fs-1 text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm p-3 border-start border-info border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted fw-bold mb-1">Médicos & Técnicos</h6>
                                <h3 class="fw-bold mb-0 text-info">{{ $employees->whereIn('role', ['Médico', 'Técnico'])->count() }}</h3>
                            </div>
                            <i class="bi bi-hospital fs-1 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Encabezado y Botón Registrar Empleado -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold text-secondary">Nómina de Personal</h4>
                <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#modalNuevoEmpleado">
                    <i class="bi bi-person-plus-fill"></i> Registrar Empleado
                </button>
            </div>

            <!-- Tabla de Empleados -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre / Apellido</th>
                                <th>DNI</th>
                                <th>Email</th>
                                <th>Rol / Cargo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                <tr>
                                    <td><strong>{{ $employee->name }}</strong></td>
                                    <td>{{ $employee->dni ?? 'N/A' }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $employee->role ?? 'Empleado' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ ($employee->status ?? 'Activo') == 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $employee->status ?? 'Activo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No hay empleados registrados en el sistema.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL REGISTRAR EMPLEADO -->
<div class="modal fade" id="modalNuevoEmpleado" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold">Registrar Nuevo Empleado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            
            <form action="{{ route('rrhh.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre Completo</label>
                        <input type="text" name="name" class="form-control" placeholder="Ej: Dra. María González" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">DNI / Documento</label>
                        <input type="text" name="dni" class="form-control" placeholder="Ej: 38123456" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" placeholder="ejemplo@hospital.com" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Rol en el Hospital</label>
                        <select name="role" class="form-select" required>
                            <option value="" selected disabled>Seleccionar rol...</option>
                            <option value="Médico">Médico Radiólogo</option>
                            <option value="Técnico">Técnico Radiólogo</option>
                            <option value="Administrativo">Administrativo / Recepción</option>
                            <option value="RRHH">Recursos Humanos</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary fw-bold">Guardar Empleado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>