@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
<style>
    td {
        font-size: 22px;
        color: rgb(55, 55, 55)
    }

</style>

        <div class="row">
            <div class="col-lg-6 col-lx-6">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Cutting</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Part Number</th>
                                    <th>Customer</th>
                                    <th>Work Order</th>
                                    <th>Qty %</th>
                                    <th>Recieved Date</th>
                                </tr>
                            </thead>
                            @if(!empty($cutData))
                                @foreach ($cutData as $cut)

                                    <tbody>
                                        <tr style="background-color: {{ $cut[5] }};">

                                            <td><b>{{ $cut[1] }}</td>
                                            <td><b>{{ $cut[0] }}</td>
                                            <td><b>{{ $cut[2] }}</td>
                                            <td><b>{{ $cut[3] }} %</td>
                                            <td><b>{{ $cut[4] }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @endif

                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-lx-6">
                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Terminals</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Part Number</th>
                                    <th>Customer</th>
                                    <th>Work Order</th>
                                    <th>Qty %</th>
                                    <th>Recieved Date</th>
                                </tr>
                            </thead>
                            @if(!empty($libeData))
                                @foreach ($libeData as $cut2)

                                    <tbody>
                                        <tr style="background-color: {{ $cut2[5] }};">

                                            <td><b>{{ $cut2[1] }}</td>
                                            <td><b>{{ $cut2[0] }}</td>
                                            <td><b>{{ $cut2[2] }}</td>
                                            <td><b>{{ $cut2[3] }} %</td>
                                            <td><b>{{ $cut2[4] }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            @endif

                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endsection
