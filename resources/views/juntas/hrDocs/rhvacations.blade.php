@extends('layouts.main')

@section('contenido')

<div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
<div class="row">
    <div class="col-lg-5 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Mover Vacaciones</h6>
            </div>
            <div class="card-body">
                <div class="form-group mb-4" id="seccionAgregarVacaciones">
                    <form action="{{ route('addVacation') }}" method="GET">
                        
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="personalIng">Personal:</label>
                                <select class="form-control" name="personalIng" id="personalIng" required>
                                    <option value="" disabled selected>Selecciona un empleado...</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->employeeNumber }}">{{ $empleado->employeeName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold" for="endDate">Fecha de inicio:</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold" for="diasT">Días:</label>
                                <input type="number" class="form-control" id="diasT" name="diasT" min="1" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-plus fa-sm"></i> Agregar Vacaciones
                        </button>
                    </form>
                </div>

                <hr class="sidebar-divider">

                <div class="form-group mt-4" id="seccionRemoverVacaciones">
                    <form action="{{ route('removeVacations') }}" method="GET">

                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="removePersonal">Personal:</label>
                                <select class="form-control" name="removePersonal" id="removePersonal" required>
                                    <option value="" disabled selected>Selecciona un empleado...</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->employeeNumber }}">{{ $empleado->employeeNumber }} - {{ $empleado->employeeName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="remover">Fecha que se removerá:</label>
                                <input type="date" class="form-control" id="remover" name="remover" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger btn-block">
                            <i class="fas fa-trash fa-sm"></i> Quitar Vacaciones
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Vacaciones</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="VacacionesPersonal">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th>Empleado</th>
                                <th>Dia de vacacion</th>
                                <th>periodo de vacacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($vacaciones))
                            @foreach ($vacaciones as $vacacion)
                            <tr>
                                <td>{{ $vacacion->employeeName }}</td>
                                <td>{{ $vacacion->fecha_de_solicitud }}</td>
                                <td>{{ $vacacion->periodo }}</td>
                            </tr>
                            @endforeach
                            @endif
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
