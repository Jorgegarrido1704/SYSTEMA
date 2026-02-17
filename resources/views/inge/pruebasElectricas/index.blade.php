@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4 text-center"></div>
 <meta http-equiv="refresh" content="120">
<div class="row">
        <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-4" id="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">Electrical Test Requested</h5>
                    </div>

                    <!-- tabla de trabajos -->
                    <div class="card-body" style="overflow-y: auto; height: 360px;">
                          <table id="table-harness" class="table">
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
                                        @if($elec->status_of_order=='Pending')
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
                                                    <button type="submit">Add Rack</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>

                    </div>

                </div>

        </div>
        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-5">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">Harness in rack</h5>
                        </div>
                        <div class="card-body" style="overflow-y: auto; height: 360px;" >

                             <table id="table-harness" class="table">
                                <thead
                                    style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: #bd0606; color: white; ">
                                    <tr>
                                    <th>Part Number</th>
                                    <th>Order Qty</th>
                                    <th>Rest Qty</th>
                                    <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($racks as $elec)

                                        @if($elec->total==0)
                                        <tr style="background-color: rgba(255, 26, 26, 0.562); color: white;">
                                        @else
                                        <tr>
                                        @endif
                                            <td>{{ $elec->pn }}</td>

                                            <td>{{ $elec->orgQty }}</td>
                                            <td>{{ $elec->total }}</td>
                                            @if($elec->total==0)
                                            <td>
                                                <form action="{{ route('dispatchElecticalTest') }}" method="GET">
                                                    <input type="hidden" name="remove" id="remove"
                                                        value="{{ $elec->id }}">
                                                    <button type="submit">remove it</button>
                                                </form>
                                            </td>
                                            @else
                                            <td>N/A</td>
                                            @endif
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4">
                <div class="card shadow mb-5">
                            <div class="card-header py-3">
                                <h5 class="m-0 font-weight-bold text-primary">Prevention of harnesses</h5>
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
                                            @if($arnes->testPar>0 or $arnes->preCalidad>0)
                                            <tr style="background-color: rgba(255, 26, 26, 0.8); color: white;">
                                            @elseif($arnes->ensaPar>0)
                                            <tr style="background-color: rgba(223, 134, 0, 0.25);">
                                                @elseif($arnes->loomPar>0)
                                                <tr style="background-color: rgba(255, 47, 47, 0.259);">
                                                @elseif($arnes->specialWire>0)
                                                <tr style="background-color: #87770c;">
                                                @elseif($arnes->eng>0)
                                                <tr style="background-color: rgba(26, 255, 0, 0.253);">
                                                @endif
                                                <td>{{ $arnes->pn }}</td>
                                                <td>{{ $arnes->wo }}</td>
                                                <td>{{ $arnes->orgQty }}</td>
                                                <td>{{ $arnes->cortPar + $arnes->libePar + $arnes->ensaPar + $arnes->loomPar+
                                                    $arnes->preCalidad + $arnes->eng
                                                    + $arnes->fallasCalidad+ $arnes->specialWire}}</td>
                                                <td><form action="{{ route('dispatchElecticalTest') }}" method="GET">
                                                    <input type="hidden" name="addRack" id="addRack"
                                                        value="{{ $arnes->wo }}">
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
<div class="row">
        <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4" id="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">Localization</h5>
                    </div>

                    <!-- tabla de trabajos -->
                    <div class="card-body" style="overflow-y: auto; height: 460px;">


                    </div>

                </div>

        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-5">
                        <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary">Pruebas en rack</h5>
                        </div>
                        <div class="card-body" style="overflow-y: auto; height: 360px;" >
                        </div>
            </div>
        </div>

</div>






 @endsection
