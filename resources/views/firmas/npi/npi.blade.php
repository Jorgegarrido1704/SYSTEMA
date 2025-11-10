@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

<div class="row">

                        <!-- Firmar por completar NPI -->
                        <div class="col-lg-12 mb-4">

                            <!-- Header Firmas -->
                            <div class="card shadow mb-4">
                                <div  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">New Product Introductions</h6>
                                </div>
                                <!--Firmas -->
                                <div class="card-body">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Moviment type</th>
                                                <th>Client</th>
                                                <th>Harness type</th>
                                                <th>Part number</th>
                                                <th>Rev</th>
                                                <th>Changes description</th>
                                                <th>publish date</th>
                                                <th>Enginner</th>
                                                <th>Sign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($registroFirmas))
                                            @foreach($registroFirmas as $npi)
                                            <tr class="text-center text-black">
                                                <td>{{$npi->tp}}</td>
                                                <td>{{$npi->client}}</td>
                                                <td>{{$npi->tipo}}</td>
                                                <td>{{$npi->pn}}</td>
                                                @if($npi->REV2 !='N/A')
                                                <td>{{ $npi->REV1}} To {{$npi->REV2}}</td>
                                                @else
                                                <td>{{$npi->REV1}}</td>
                                                @endif
                                                <td>{{$npi->cambios}}</td>
                                                <td>{{$npi->fecha}}</td>
                                                <td>{{$npi->eng}}</td>
                                                <td>
                                                    <form action="{{route('Pendings.update')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$npi->id}}">
                                                        <input type="hidden" name="who" value="{{$value}}">
                                                        <button type="submit" class="btn btn-primary">Sign</button>
                                                    </form>
                                                </td>
                                            </tr>
                                                    @endforeach
                                                    @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Desviaciones -->
                          <div class="col-lg-12 mb-4">

                            <!-- Header Firmas -->
                            <div class="card shadow mb-4">
                                <div  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Deviations</h6>
                                </div>
                                <!--Firmas -->
                                <div class="card-body">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Who request</th>
                                                <th>Client</th>
                                                <th>Part number</th>
                                                <th>WO</th>
                                                <th>Original item</th>
                                                <th>Substitute item</th>
                                                <th>Quantity</th>
                                                <th>Period of validity</th>
                                                <th>Cause</th>
                                                <th>Accion</th>
                                                <th>Evidence</th>
                                                <th>Sign</th>
                                                <th>Denied</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($desviations))
                                            @foreach($desviations as $des)
                                            <tr class="text-center text-black">
                                                <td>{{$des->id}}</td>
                                                <td>{{$des->quien}}</td>
                                                <td>{{$des->cliente}}</td>
                                                <td>{{$des->Mafec}}</td>
                                                <td>{{$des->wo}}</td>
                                                <td>{{ $des->porg}}</td>
                                                <td> {{$des->psus}}</td>
                                                <td>{{$des->clsus}}</td>
                                                <td>{{$des->peridoDesv}}</td>
                                                <td>{{$des->Causa}}</td>
                                                <td>{{$des->accion}}</td>
                                                <td>{{$des->evidencia}}</td>
                                                <td>
                                                    <form action="{{route('desviation.update')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$des->id}}">
                                                        <input type="hidden" name="who" value="{{$value}}">
                                                        <button type="submit" class="btn btn-primary">Sign</button>
                                                    </form>
                                                </td>
                                                <td>
                                                    <form  action="{{route('desviation.denied')}}" method="GET">
                                                        <input type="hidden" name="idq" id="idq" value="{{ $des->id }}" >
                                                       <textarea name="rechaso" id="rechaso" cols="10" rows="2"></textarea>
                                                        <button type="submit" class="btn btn-danger">Denied</button>
                                                    </form>
                                                </td>
                                            </tr>
                                                    @endforeach
                                                    @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Vacaciones -->
                          <div class="col-lg-12 mb-4">

                            <!-- Header Firmas -->
                            <div class="card shadow mb-4">
                                <div  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Vacations</h6>
                                </div>
                                <!--Firmas -->
                                <div class="card-body">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Folio</th>
                                                <th>Employee name</th>
                                                <th>Employee ID</th>
                                                <th>Employee Area</th>
                                                <th>Supervisor</th>
                                                <th>Vacation start date</th>
                                                <th>Days off</th>
                                                <th>Sign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($vacaciones))
                                            @foreach($vacaciones as $vacacion)
                                            <tr class="text-center text-black">
                                                <td>{{$vacacion->Folio}}</td>
                                                <td>{{$vacacion->nombre}}</td>
                                                <td>{{$vacacion->id_empleado}}</td>
                                                <td>{{$vacacion->area}}</td>
                                                <td>{{$vacacion->supervisor}}</td>
                                                <td>{{$vacacion->fecha_solicitud}}</td>
                                                <td>{{$vacacion->dias_solicitados}}</td>

                                                <td>
                                                    <form action="{{route('vacaciones.update')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="folio" value="{{$vacacion->Folio}}">
                                                        <input type="hidden" name="nombre" value="{{$vacacion->nombre}}">
                                                        <input type="hidden" name="id_vac" value="{{$vacacion->id_empleado}}">
                                                        <input type="hidden" name="area" value="{{$vacacion->area}}">
                                                        <input type="hidden" name="fecha" value="{{$vacacion->fecha_solicitud}}">
                                                        <input type="hidden" name="dias" value="{{$vacacion->dias_solicitados}}">
                                                        <input type="hidden" name="who" value="{{$vacacion->supervisor}}">
                                                        <input type="hidden" name="fecha_retorno" value="{{$vacacion->fehca_retorno}}">
                                                        <button type="submit" class="btn btn-primary">Sign</button>
                                                    </form>
                                                </td>
                                            </tr>
                                                    @endforeach
                                                    @endif
                                    </table>
                                </div>
                            </div>
                        </div>
</div>



@endsection
