@extends('layouts.main')

@section('contenido')

<script src="{{ asset('/dash/js/vacaciones.js') }}"></script>


<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>


<!-- First Period -->
<div class="row">
    <div class="col-lg-12 col-lx-12 mb-4">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Vacations
                           <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal" onclick="document.getElementById('agregarVacaciones').style.display = 'block';" > Agregar vacaciones</button></h5>

                    </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <div class="form-group" id="agregarVacaciones" style= "display: none;">
                            <form action="{{ route('addVacation') }}" method="GET">

                                <div class="form-row">
                                    <div class="col-md-4 mb-3">
                                        <label for="personalIng">Personal:</label>
                                            <select  class="form-control" name="personalIng" id="personalIng" required>
                                                <option value="" disabled selected> Select an option</option>
                                                @foreach ($empleados as $empleado )
                                                <option value="{{ $empleado[6] }}">{{ $empleado[0] }} -- {{ $empleado[6] }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="endDate">Fecha de fin:</label>
                                        <input type="date" class="form-control" id="endDate" name="endDate" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="diasT">Dias:</label>
                                        <input type="number" class="form-control" id="diasT" name="diasT" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </form>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Employee</th>
                                            <th>First day</th>
                                            <th>Vacations {{$anos[3]}} - {{$anos[0]}}</th>
                                            <th>Limit date to use</th>
                                            <th>Vacations {{$anos[0]}} - {{$anos[1]}}</th>
                                            <th>Limit date to use</th>
                                            <th>Vacations {{$anos[1]}} - {{$anos[2]}}</th>
                                            <th>Limit date to use</th>
                                            <th>Total vacations</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                          @foreach ($empleados as $empleado)
                                            <tr id='{{$empleado[6]}}' class='emp'>
                                                <td class="text-center font-weight-bold text-primary">{{ $empleado[0] }}</td>
                                                <td class="text-center font-weight-bold text-primary">{{ $empleado[1] }}</td>
                                                <td class="text-center font-weight-bold text-primary">{{ $empleado[9] }}</td>
                                                <td class="text-center font-weight-bold text-primary">{{ $empleado[8] }}</td>
                                                <td class="text-center font-weight-bold text-primary">{{ $empleado[2] }}</td>
                                                <td class="text-center font-weight-bold text-primary">{{ $empleado[3] }}</td>
                                                <td class="text-center font-weight-bold text-primary">{{ $empleado[4] }}</td>
                                                <td class="text-center font-weight-bold text-primary">{{ $empleado[5] }}</td>
                                                <td class="text-center font-weight-bold text-primary">{{ $empleado[7] }}</td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                </div>
    </div>
</div>
<!-- First Period -->
<div class="row">
    @foreach ($diasAviles as $mes => $dias)
    <div class="col-lg-2 col-lx-2 mb-2">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">{{ \Carbon\Carbon::create()->month($mes)->format('F') }}</h5>
            </div>
            <div class="card-body" style="overflow-y: auto;">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            @foreach (collect($dias)->take(5) as $dia)
                                <td>{{ $dia['Dia'] }}</td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dias as $index => $dia)
                            @if ($index % 5 === 0)
                                <tr>
                            @endif
                            <td class="vacation-cell" id="{{ $dia['vacas'] }}">{{ $dia['dia'] }}</td>
                            @if (($index + 1) % 5 === 0 || $index + 1 === count($dias))
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
<script>
    function getColorForEmployee(id) {
        if (!employeeColors[id]) {
            employeeColors[id] = `rgba(106, 104, 104, 0.5)`; // Color por defecto si no existe
        }
        return employeeColors[id];
    }

    document.querySelectorAll('.vacation-cell').forEach(td => {
        const ids = td.id.split('-');
        if (ids.length === 1) {
            // Un solo empleado
            td.style.background = getColorForEmployee(ids[0]);
            td.style.color = 'white';
        } else {
            // Mezcla de varios empleados
            const colors = ids.map(id => getColorForEmployee(id));
            const gradient = colors.map((c, i) => `${c} ${(i * 100 / colors.length)}%, ${c} ${((i+1) * 100 / colors.length)}%`).join(', ');
            td.style.background = `linear-gradient(90deg, ${gradient})`;
            td.style.color = 'white';
        }
    });
    document.querySelectorAll('.emp').forEach(td => {
        const id = td.id;
        td.classList.add(id);
        td.style.background = getColorForEmployee(id);
        td.style.color = 'white';
    })

</script>




@endsection
