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
            <div class="col-lg-12 col-lx-12">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Priorities</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto;  height: 600px;" >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: black; color: white; ">
                                <tr>
                                    <th>Part Number</th>
                                    <th>Customer</th>
                                    <th>Work Order</th>
                                    <th>Required Date by PO </th>
                                    <th>Materials</th>
                                    <th> Engineering Documentation</th>
                                    <th>Cutting/Assembly</th>
                                    <th>Quality</th>
                                    <th>Approved by Customer</th>
                                    <th>Comments</th>

                                </tr>
                            </thead>
                            @if(!empty($registroPPAP))
                                @foreach ($registroPPAP as $cut)

                                    <tbody>
                                        <tr style="background-color: {{ $cut['color'] }};">

                                            <td><b>{{ $cut['cliente'] }}</td>
                                            <td><b>{{ $cut['pn'] }}</td>
                                            <td><b>{{ $cut['rev'] }}</td>
                                            <td><b>{{ $cut['prioridad'] }}</td>
                                            <td><b>{{$cut['materiales']}}</td>
                                            <td><b>{{$cut['ingeniria']}}</td>
                                            <td><b>{{$cut['cutting']}}/{{$cut['ensamble']}}</td>
                                       
                                            <td><b>{{$cut['calidad']}}</td>
                                            <td><b>{{$cut['aprovado']}}</td>
                                            <td><b>{{ $cut['comments'] }}</td>
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
