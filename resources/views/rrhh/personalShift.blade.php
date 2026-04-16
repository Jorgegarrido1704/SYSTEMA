@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">{{ __('Personal Shift') }}</h5>
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
                            @if(!empty($personal))
                                @foreach ( $personal as $persons )
                                    <tr>
                                        <td>{{ $persons->employeeName }}</td>
                                        <form  id="formShift">
                                            <td><div class="form-group">
                                                <select name="shift" id="shift_{{ $persons->employeeName }}" class="form-control" >
                                                    <option value="{{ $persons->employeeShift }}" selected disabled> {{ $persons->employeeShift }}</option>
                                                    <option value="firstShift">{{ __('firstShift') }}</option>
                                                    <option value="secondShift">{{ __('secondShift') }}</option>
                                                </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-group">
                                                    <select name="schedule" id="schedule_{{ $persons->employeeName }}" class="form-control" onchange="guardarDatosShift('{{ $persons->employeeName }}')">
                                                        <option value="{{ $persons->employeeSchedule }}" selected disabled> {{ $persons->employeeSchedule }}</option>
                                                        <option value="07:00 - 15:30">07:30 - 15:30</option>
                                                        <option value="07:00 - 17:30">07:30 - 17:30</option>
                                                        <option value="19:00 - 07:00">19:00 - 07:00</option>
                                                    </select>
                                                </div>
                                            </td>


                                    </tr>

                                @endforeach
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function guardarDatosShift(employee) {
          const url = @json(route('jsonPersonalShift'));

         let  shift= document.getElementById("shift_"+employee+"").value;
         let  schedule= document.getElementById("schedule_"+employee+"").value;
         if (shift !== null && schedule !== null) {


         alert(employee + " " + shift + " " + schedule);
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    employee: employee,
                    shift: shift,
                    schedule: schedule
                })
            })
            .then(response => response.json())
            .then(data => {
             //console.log(data);
            })
            .catch(error => {
                console.error('Error:', error);
            });

        }
    }

    </script>


    @endsection
