@extends('layouts.main')

@section('contenido')


<div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Registros de personal </h5>
                                <form action="{{route('datosPersonal')}}"method='GET' class="form-inline">
                                    <div class="form-group">
                                        <label  class ="form-label"for="empleado">numero de empleado:</label>
                                    </div>
                                    <div class="form-group">
                                    <input type="text" class="form-control" name="empleado" id="empleado" onchange="return form.submit()">
                                    </div>

                                </form>

                            </div>
                            <div class="card-body">
                                @if(!empty($personalDatos))
                                    <div class="col-md-12">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Numero de empleado</th>
                                                    <th>Area</th>
                                                    <th>Fecha de ingreso</th>
                                                    <th>Lider</th>
                                                    <th>Dias de vacaciones</th>
                                                    <th>Estatus</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{$personalDatos->employeeName}}</td>
                                                    <td>{{$personalDatos->employeeNumber}}</td>
                                                    <td>{{$personalDatos->employeeArea}}</td>
                                                    <td>{{$personalDatos->DateIngreso}}</td>
                                                    <td>{{$personalDatos->employeeLider}}</td>
                                                    <td>{{$personalDatos->DaysVacationsAvailble}}</td>
                                                    <td>{{$personalDatos->status}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    @endif

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card shadow mb-4">
                                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                                    <h5 class="m-0 font-weight-bold text-primary">Vacaciones</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="col-md-12 overflow-auto" style="max-height: 400px;">
                                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Fecha de vacacion</th>
                                                                    <th>anio de vacaciones</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($vaciones as $vacacion)
                                                                <tr>
                                                                    <td>{{$vacacion->fecha_de_solicitud}}</td>
                                                                    <td>{{$vacacion->usedYear}}</td>
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

