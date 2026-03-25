@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
 @if(!empty(session('message')))
 <div class="alert alert-success alert-dismissible fade show" role="alert">
     {{ session('message') }}
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
 </div>
 @endif

    <div class="row">
        <!-- Requieriment Crimpers -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                    <h6 class="m-0 font-weight-bold text-primary">Requieriment Crimpers </h6>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; height: 350px; max-height: 400px;">
                    @if(!empty($crimpersRequested))
                    <table  class="table table-bordered table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Tooling</th>
                                <th>Work</th>
                                <th>Whose order</th>
                                <th>Working By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($crimpersRequested as $crimpersReq)
                                @if($crimpersReq->atiende == null or $crimpersReq->atiende == '')
                                <tr class="table-danger">
                                    @else
                                    <tr class="table-warning">
                                        @endif
                                    <td>{{ $crimpersReq->fecha}}</td>
                                    <td>{{ $crimpersReq->nombreEquipo }}</td>
                                    <td>{{ $crimpersReq->dano }}</td>
                                    <td>{{ $crimpersReq->quien }}</td>
                                    @if($crimpersReq->atiende == null or $crimpersReq->atiende == '')
                                        <form action="{{ route('herramientales.update', $crimpersReq->id) }}" method="get">
                                            <td><input type="text" name="nombrePersonal" id="nombrePersonal" required></td>
                                            <td><button type="submit" class="btn btn-primary">Take</button></td>
                                        </form>
                                    @else
                                    <td>{{ $crimpersReq->atiende }}</td>
                                    <td><a href="{{ route('herramientales.update', $crimpersReq->id) }}" class="btn btn-primary">Sign</a></td>
                                        @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
        <!--end Requieriment Crimpers -->
        <!-- Add count in crimpers -->
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                    <h6 class="m-0 font-weight-bold text-primary">Add Count in Crimpers </h6>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; height: 350px;">
                    <form action="{{ route('herramientales.sumCrimpers') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="tooling">Tooling</label>
                            <select name="tooling" id="tooling" class="form-control" required>
                                <option value="" selected disabled>Select tooling</option>
                                @foreach($herramntal as $tooling)
                                    <option value="{{ $tooling->terminal }} || {{ $tooling->herramental }}">{{ $tooling->terminal }} || {{ $tooling->herramental }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="qtyHits">Quantity of hits</label>
                            <input type="number" name="qtyHits" id="qtyHits" class="form-control" min="1" step="1" required>
                        </div>
                        <div class="form-group">
                           <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end Add count in crimpers -->
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                    <h6 class="m-0 font-weight-bold text-primary">Add New Crimp Tooling </h6>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; height: 350px;">
                    <form action="{{ route('herramientales.addHerramental') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="newTooling">New Tooling Numbre code</label>
                            <input type="text" name="newTooling" id="newTooling"  pattern="[A-Za-z0-9-]{4,12}" class="form-control pattern" required>
                        </div>
                        <div class="form-group">
                            <label for="terminalNewTooling">Terminal Applied to</label>
                            <input type="text" name="terminalNewTooling" id="terminalNewTooling" pattern="[A-Za-z0-9-]{4,12}" class="form-control" required>
                        </div>
                        <div class="form-group">
                           <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                    <h6 class="m-0 font-weight-bold text-primary">Tooling list </h6>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; height: 350px; max-height: 650px;">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center table-primary">
                                <th class="table-header">Tooling</th>
                                <th class="table-header">Terminal</th>
                                <th class="table-header">Last update</th>
                                <th class="table-header">Total hits</th>
                                <th class="table-header">Mantainance Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($herramntal as $tooling)
                                @if($tooling->mantenimiento == 'ok')
                                <tr class="text-center table-success">
                                @else
                                <tr class="text-center table-danger">
                                @endif  
                                    <td>{{ $tooling->herramental }}</td>
                                    <td>{{ $tooling->terminal }}</td>
                                    <td>{{ $tooling->fecha_reg }}</td>
                                    <td>{{ $tooling->golpesTotales }}</td>
                                    <td>{{ $tooling->totalmant }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  

    </div>
@endsection
