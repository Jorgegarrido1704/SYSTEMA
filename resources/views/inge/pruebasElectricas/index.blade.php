@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4 text-center"></div>

<div class="row">
     <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-4" id="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Electrical Test Requested</h5>
                </div>

                <!-- tabla de trabajos -->
                <div class="card-body" style="overflow-y: auto; height: 260px;">
                        <table id="table-harness" class="table ">
                            <thead
                                style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: #bd0606; color: white; ">
                                <tr>
                                <th>Part Number</th>
                                <th>Client</th>
                                <th>WO</th>
                                <th>Requested By</th>
                                <th>Date Requested</th>
                                <th>Status</th>
                                <th>Dispatch</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pruebas as $elec)
                                    <tr>
                                        <td>{{ $elec->pn }}</td>
                                        <td>{{ $elec->client }}</td>
                                        <td>{{ $elec->wo }}</td>
                                        <td>{{ $elec->requested_by }}</td>
                                        <td>{{ $elec->created_at }}</td>
                                        <td>{{ $elec->status_of_order }}</td>
                                        <td>
                                            <form action="{{ route('dispatchElecticalTest') }}" method="GET">
                                                <input type="hidden" name="id" id="id"
                                                    value="{{ $elec->id }}">
                                                <button type="submit">Dispatch</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                </div>

            </div>

        </div>
         <div class="col-4">
            <div class="card shadow mb-5">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">Pruebas en rack</h5>
                        </div>
                        <div class="card-body" style="overflow-y: auto; height: 360px;" >
                        </div>
            </div>
        </div>
         <div class="col-4">
                <div class="card shadow mb-5">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">Prevencion de arneses</h5>
                            </div>

                            <div   class="card-body" style="overflow-y: auto; height: 360px;" >
                                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                                    <thead
                                        style=" position: sticky; z-index: 0.1; top: 0; text-align: center; background-color: #bd0606; color: white; ">
                                        <tr>
                                        <th>Part Number</th>
                                        <th>WO</th>
                                        <th>Original Qty</th>
                                        <th>Pending</th>
                                        <th>Dispatched</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($arneses as $arnes)
                                            @if($arnes->ensaPar>0)
                                            <tr style="background-color: rgba(223, 134, 0, 0.25);">
                                                @elseif($arnes->loomPar>0)
                                                <tr style="background-color: rgba(255, 47, 47, 0.259);">
                                                @elseif($arnes->specialWire>0)
                                                <tr style="background-color: #87770c;">
                                                @endif
                                                <td>{{ $arnes->pn }}</td>
                                                <td>{{ $arnes->wo }}</td>
                                                <td>{{ $arnes->orgQty }}</td>
                                                <td>{{ $arnes->cortPar + $arnes->libePar + $arnes->ensaPar + $arnes->loomPar+
                                                    $arnes->preCalidad + $arnes->eng
                                                    + $arnes->fallasCalidad+ $arnes->specialWire}}</td>
                                                <td><form action="#" method="GET">
                                                    <input type="hidden" name="id" id="id"
                                                        value="{{ $arnes->id }}">
                                                    <button type="submit">Dispatch</button>
                                                </form></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                </div>
            </div>
    </div>






 @endsection
