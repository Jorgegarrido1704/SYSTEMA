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

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4 class="m-0 font-weight-bold text-primary">{{ __('Requieriment Crimpers') }} </h4>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; height: 350px; max-height: 400px;">
                    @if(!empty($crimpersRequested))
                    <table  class="table table-bordered table-sm table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Tooling') }}</th>
                                <th>{{ __('Work') }}</th>
                                <th>{{ __('Whose order') }}</th>
                                <th>{{ __('Working By') }}</th>
                                <th>{{ __('Action') }}</th>
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
                                    @if($crimpersReq->atiende == null || $crimpersReq->atiende == '' )
                                       @if( $value=='Admin' || $cat == 'herra' )
                                        <form action="{{ route('herramientales.update', $crimpersReq->id) }}" method="get">
                                            <td><input type="text" name="nombrePersonal" id="nombrePersonal" required></td>
                                            <td><button type="submit" class="btn btn-primary">{{ __('Take') }}</button></td>
                                        </form>
                                        @endif
                                    @else
                                    @if($value=='Admin' || $cat == 'herra')
                                    <td>{{ $crimpersReq->atiende }}</td>
                                    <td><a href="{{ route('herramientales.update', $crimpersReq->id) }}" class="btn btn-primary">{{ __('Sign') }}</a></td>
                                    @endif
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
        @if($value=='Admin' || $cat=='herra')
        <!-- Add count in crimpers -->
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" >
                    <h4 class="m-0 font-weight-bold text-primary">{{ __('Add Count in Crimpers') }} </h4>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; height: 350px;">
                    <form action="{{ route('herramientales.sumCrimpers') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="tooling">{{ __('Tooling') }}</label>
                            <select name="tooling" id="tooling" class="form-control" required>
                                <option value="" selected disabled>{{ __('Select tooling') }}</option>
                                @foreach($herramntal as $tooling)
                                    <option value="{{ $tooling->terminal }} || {{ $tooling->herramental }}">{{ $tooling->terminal }} || {{ $tooling->herramental }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="qtyHits">{{ __('Hits Quantity Record') }}</label>
                            <input type="number" name="qtyHits" id="qtyHits" class="form-control" min="1" step="1" required>
                        </div>
                        <div class="form-group">
                           <button type="submit" class="btn btn-primary">{{ __('Add Hits') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end Add count in crimpers -->
        <div class="col-xl-3 col-md-3 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" >
                    <h4 class="m-0 font-weight-bold text-primary">{{ __('Add New Crimp Tooling') }} </h4>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; height: 350px;">
                    <form action="{{ route('herramientales.addHerramental') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="newTooling">{{ __('New Tooling Numbre code') }}</label>
                            <input type="text" name="newTooling" id="newTooling"  pattern="[A-Za-z0-9-]{4,12}" class="form-control pattern" required>
                        </div>
                        <div class="form-group">
                            <label for="terminalNewTooling">{{ __('Terminal Applied to') }}</label>
                            <input type="text" name="terminalNewTooling" id="terminalNewTooling" pattern="[A-Za-z0-9-]{4,12}" class="form-control" required>
                        </div>
                        <div class="form-group">
                           <button type="submit" class="btn btn-primary">{{ __('Add Crimper') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow mb-4">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" >
                    <h4 class="m-0 font-weight-bold text-primary">{{ __('Tooling list') }} </h4>
                    <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center flex-wrap">


                        <div class="d-flex align-items-center me-3">
                            <label class="mb-0 me-1" for="tooling">{{ __('Filter By Tooling or Terminal') }}</label>
                            <input type="text" name="tooling" id="tooling" class="form-control form-control-sm ml-2 mr-2"  style="width: 85px;" onchange="filterTooling(this.value)">
                        </div>
                    </h6>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; height: 350px; max-height: 650px;">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-center">
                                <tr class="table-primary">
                                    <th class="sticky-top table-header" style="top: 0; z-index: 2;">{{ __('Tooling') }}</th>
                                    <th class="sticky-top table-header" style="top: 0; z-index: 2;">{{ __('Terminal') }}</th>
                                    <th class="sticky-top table-header" style="top: 0; z-index: 2;">{{ __('Last update') }}</th>
                                    <th class="sticky-top table-header" style="top: 0; z-index: 2;">{{ __('Total hits') }}</th>
                                    <th class="sticky-top table-header" style="top: 0; z-index: 2;">{{ __('Maintainance Qty') }}</th>
                                </tr>
                            </thead>
                        <tbody class="text-center" id="toolingTable">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        const urlRoure = @json(route('filterTooling'));

        function filterTooling(value) {


                if(value.length >= 5) {
                    value = value.toUpperCase();
                }else{
                    value ="all";
                }
                fetch(urlRoure,{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
                        body: JSON.stringify({value: value})

                    }).then(response => response.json()).then(data => {
                        console.log(data);
                        $('#toolingTable').html('');
                        for (let i = 0; i < data.length; i++) {
                            if(data[i].mantenimiento == 'ok'){
                                color= '<tr class="text-center table-success">'
                                }else{
                                color= '<tr class="text-center table-danger">'
                                    }
                            $('#toolingTable').append(color +
                                '<td>' + data[i].herramental + '</td>' +
                                '<td>' + data[i].terminal + '</td>' +
                                '<td>' + data[i].fecha_reg + '</td>' +
                                '<td>' + data[i].golpesTotales + '</td>' +
                                '<td>' + data[i].totalmant + '</td>' +
                                '</tr>');
                        }
                    })
        }
        onload = filterTooling('all');
        setInterval(() => {
            window.location.reload();
        }, 450000);
    </script>
@endsection

