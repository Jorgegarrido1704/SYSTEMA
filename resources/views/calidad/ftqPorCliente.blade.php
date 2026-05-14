@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

 <div class="row">

    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">{{ __('FTQ by Customer') }}: {{ $customer }}</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>

                            <th>{{ __('Code') }}</th>
                            <th>{{ __('Qty') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!@empty($codigos))
                        @foreach ($codigos as $datoFtqClientes)
                            <tr>
                                <td>{{ $datoFtqClientes->codigo }}</td>
                                <td>{{ $datoFtqClientes->total }}</td>
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
