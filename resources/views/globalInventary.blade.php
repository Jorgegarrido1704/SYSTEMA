@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>
                    <div class="row">

                        <!-- Last 100 movimentes -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-6">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Movimientos </h5>

                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">

                                        <table id="table-harness" class="table" style="width:100%">
                                            <thead >
                                                <tr class="table-danger">
                                                <th>Fecha</th>
                                                <th>Articulo</th>
                                                <th>Cantidad</th>
                                                <th>Moviemiento</th>
                                                </tr>
                                                </thead>
                                            <tbody>
                                                @if (!empty($itemOut))
                                                @foreach ($itemOut as $item)
                                                <tr>
                                                    <td>{{ $item[0] }}</td>
                                                    <td>{{ $item[1] }}</td>
                                                    <td>{{ $item[2] }}</td>
                                                    <td>{{ $item[3] }}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-6">
                                    <!-- Invetary  -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Inventario</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <table class="table" style="width:100%">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>Item interno</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($inventario))
                                            @foreach ($inventario as $item)
                                            <tr>
                                                <td>{{ $item[0] }}</td>
                                                <td>{{ $item[1] }}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endsection

