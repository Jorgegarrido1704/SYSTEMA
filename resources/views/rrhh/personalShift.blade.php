@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Personal Shift</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Shift') }}</th>
                                <th>{{ __('Schedule') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($personalShift))
                                @foreach ( $personalShift as $persons )
                                    <tr>
                                        <td>{{ $persons->employeeName }}</td>
                                        <td>{{ $persons->employeeShift }}</td>
                                        <td>{{ $persons->employeeSchedule }}</td>
                                        
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