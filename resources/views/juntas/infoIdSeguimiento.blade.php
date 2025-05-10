@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
<link rel="stylesheet" href="{{ asset('/dash/css/seguimientos.css') }}">


<div class="row">
    <div class="col-lg-12 col-lx-12 col-md-12 mb-4">

        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Work order Data</h5>
            </div>
            <div class="card-body" style="overflow-y: auto; " >
                <table class="table-harness" width="100%" cellspacing="0" >
                    <thead>
                        <tr>
                            <th>Spectations</th>
                            <th>Customer</th>
                            <th>Part Number</th>
                            <th>Work Order</th>
                            <th>Initial Date</th>
                            <th>Qty</th>
                            <th>Cutting & Terminals</th>
                            <th>Assembly</th>
                            <th>Looming</th>
                            <th>Quality</th>
                            <th>Packing</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Calculate  Time</td>
                            <td>{{ $datosInforRegistro[2] }}</td>
                            <td>{{ $datosInforRegistro[0] }}</td>
                            <td>{{ $datosInforRegistro[1] }}</td>
                            <td>{{ $datosInforRegistro[9] }}</td>
                            <td>{{ $datosInforRegistro[4] }}</td>
                            <td>{{ $datosInforRegistro[10] }}</td>
                            <td>{{ $datosInforRegistro[11] }}</td>
                            <td>{{ $datosInforRegistro[12] }}</td>
                            <td>{{ $datosInforRegistro[13] }}</td>
                            <td>{{ $datosInforRegistro[14] }}</td>
                        </tr>
                        <tr>
                            <td>Real Time</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{ $datosInforRegistro[5] }}</td>
                            <td>{{ $datosInforRegistro[6] }}</td>
                            <td>{{ $datosInforRegistro[7] }}</td>
                            <td>{{ $datosInforRegistro[8] }}</td>
                            <td>{{ $datosInforRegistro[8] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection
