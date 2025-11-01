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
                            <td>Standar Time</td>
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
<div class="row">
    <div class="col-xl-6 col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-0 font-weight-bold text-primary"> Comments</h5>
            </div>
            <!-- table Body -->
            <div class="card-body" style="overflow-y: auto; height: 400px;">
                <table class="table table-info table-striped-columns" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Comments</th>
                            <th>Responsable</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @if($value == 'Gamboa J' or $value == 'Juan G' or $value == 'Andrea P' or $value == 'Jesus_C' or
                            $value=='Luis R' or $value=='Edward M' or $value=='Carlos R' or $value=='Juan O' or $value=='David V'
                            or $value=='Estela G' or $value=='Mario V' or $value=='Admin' or $value=='Jesus_C' or $value=='Alex M' or $cat == 'inge' )
                            <form action="{{ route('conSeguimientos') }}" method="get">
                            <td>
                                <div class="form-group">
                                    <textarea class="form-control" id="comments" name="comments"  rows="2" cols="10" required></textarea>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                               <input type="text" class="form-control" id="responsable" name="responsable" value="{{ $value}} "   readonly>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="date_issue" name="date_issue" required >
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control" id="status_issue" name="status_issue" required>
                                        <option value="" disabled selected>Select an option</option>
                                        <option>On Hold</option>
                                        <option>No stop</option>
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="id_issue" name="id_issue" value="{{ $id }}" >
                                    <input type="submit" class="btn btn-primary" id="btnGuardar" name="btnGuardar" value="Save">
                                </div>
                            </form>
                            @endif
                        </tr>
                            </form>
                        @if(!empty($commentsBefore))
                        @foreach ($commentsBefore as $item)
                        <tr >
                            <td>{{ $item[0] }}</td>
                            <td>{{ $item[2] }}</td>
                            <td>{{ $item[1] }}</td>
                            <td>{{ $item[3] }}</td>
                            @if($item[3] == 'On Hold' or $item[3] == 'No stop')
                            <td>
                                @if($value =='Admin' or $value == 'Gamboa J' or $value == 'Juan G' or $value == 'Andrea P' or $value == 'Jesus_C' or
                            $value=='Luis R' or $value=='Edward M' or $value=='Carlos R' or $value=='Juan O' or $value=='David V' or $value=='Andrea P'
                            or $value=='Estala G' or $cat == 'inge' or $value=='Alex M')
                                <form action="{{ route('registroComment') }}" method="get">
                                    <input type="hidden" name="dataok" id="dataok'" value="{{$id}}">
                                <input type="submit" class="btn btn-primary" id="btnGuardar" name="btnGuardar" value="Fix it">
                                </form>
                                @endif
                            </td>
                            @endif
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

