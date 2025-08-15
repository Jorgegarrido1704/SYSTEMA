@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

<div class="row">

                        <!-- Firmar por completar -->
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
                                                    <form onsubmit="return confirmDenied({{ $des->id }});" action="{{route('desviation.denied')}}" method="GET">
                                                        <input type="hidden" name="idq" id="idq"  >
                                                        <input type="hidden" name="rechaso" id="rechaso">
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
</div>
<script>
    function confirmDenied(ides) {
        alert(ides);
        var result= prompt('Why you want to denied ID '+ides+' ?');
        if (result) {
            document.getElementById('idq').value = ides;
            document.getElementById('rechaso').value = result;
            return true;
        }
    }
</script>


@endsection
