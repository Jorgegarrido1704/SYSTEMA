@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
<link rel="stylesheet" href="{{ asset('/dash/css/seguimientos.css') }}">


        <div class="row">
            <div class="col-lg-12 col-lx-12 col-md-12 mb-4">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-1 font-weight-bold text-primary">Idetification Colors</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <input type="text" name="excelentWork" id="excelentWork" value="Excelent Work"  style="width: 120px; height: 30px;"  readonly>
                        <input type="text" name="onTime" id="onTime" value="On Time"  style="width:70px;  height: 30px;"  readonly>
                        <input type="text" name="onWorking" id="onWorking" value="On precess" style="width:85px;  height: 30px;"  readonly>
                        <input type="text" name="closeToexpiring" id="closeToexpiring" value="close to expiring"  style="width:135px; height: 30px;"  readonly>
                        <input type="text" name="delayed" id="delayed" value="Delayed"  style="width: 70px; height: 30px;"  readonly>
                        <input type="text" name="delayedandclosedtoexpiring" id="delayedandclosedtoexpiring" value="delayed and close to expiring"  style="width:225px;  height: 30px;"  readonly>
                        <input type="text" name="late" id="late" value="Late" style="width: 50px; height: 30px;"  readonly>
                        <input type="text" name="onHold" id="onHold" value="On Hold"  style="width: 70px; height: 30px;"  readonly>

                    </div>
                </div>
            </div>
           <div class="col-lg-12 col-lx-12 col-md-12 mb-4">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-1 font-weight-bold text-primary">Status orders </h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
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


                                </tr>
                            </thead>
                            @if(!empty($buscarDatos))
                                @foreach ($buscarDatos as $cut)

                                    <tbody>
                                        <tr  onclick ="location.href='{{ url('juntas/seguimiento/'.$cut[15]) }}'" style="cursor: pointer;">
                                            <td id=""><b>{{ $cut[0]  }}
                                                </td>
                                            <td id=""><b>{{ $cut[1]  }}
                                               </td>
                                            </td>
                                            <td><b>{{ $cut[2] }}</td>
                                            <td><b>{{ $cut[3] }}</td>
                                            <td><b>{{ $cut[4] }}</td>
                                            <td id="{{$cut[10]}}"><b>{{ $cut[5] }}</td>
                                            <td id="{{$cut[11]}}"><b>{{ $cut[6] }}</td>
                                            <td id="{{$cut[12]}}"><b>{{ $cut[7] }}</td>
                                            <td id="{{$cut[13]}}"><b>{{ $cut[8] }}</td>
                                            <td id="{{$cut[14]}}"><b>{{ $cut[9] }}</td>
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
