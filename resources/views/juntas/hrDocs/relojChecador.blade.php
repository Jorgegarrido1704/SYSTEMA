@extends('layouts.main')

@section('contenido')


<div class="d-sm-flex align-items-center justify-content-between mb-4"></div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Relog Checador</h5>
                                <form action="{{ route('relogChecador') }}" method="GET" id="formRelog">
                                    <div class="input-group">
                                        <input type="date" class="form-control form-control-sm"
                                         id="datepicker" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2"
                                         name="datepicker" onchange="return form.submit()"
                                         >

                                         </div>

                                </form>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="ul col-md-12" style="overflow-y: auto;  max-height: 450px;">
                                        <table class="table table-striped table-bordered table-sm-responsive">
                                            <thead>
                                                <tr>
                                                    <th>Numero de empleado</th>
                                                    <th>Hora entrada </th>
                                                    <th>Hora salida</th>
                                                    <th>Retardo (min)</th>
                                                    <th>Total tiempo en planta (horas)</th>
                                                    <th>Desayuno (min)</th>
                                                    <th>Comida (min)</th>
                                                    <th>Permisos (min)</th>
                                                    <th>Observaciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach($registroRelog as $registro)
                                                        <tr>
                                                            @foreach($registro as $dato)
                                                            <td class="text-center"  >{{ $dato }}</td>
                                                            @endforeach
                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Reportes Reloj por fechas</h5>

                            </div>
                            <div class="card-body">
                                <form class="row g-3" action="{{ route('excelRelogChecador') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                        <label for="semana" class="form-label">Reporte de Semana</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                        <select name="semana" id="semana" class="form-control" required>
                                            <option value="" disabled selected> Seleccione Un Semana</option>
                                            @for($weekNum; $weekNum>=1 ; $weekNum--)
                                            <option value="{{$weekNum}}">Semana {{$weekNum}}</option>
                                            @endfor
                                        </select>
                                        </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-primary">Reporte</button>
                                    </div>
                                    </div>
                                </form>
                              </div>
                        </div>
                    </div>
                </div>




@endsection

