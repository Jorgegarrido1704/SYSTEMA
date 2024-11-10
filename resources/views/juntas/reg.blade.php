@extends('layouts.main')

@section('contenido')

<div class="row">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Part Number</th>
                    <th>Work Order</th>
                    <th>Original Quantity</th>
                    <th>Cutting</th>
                    <th>Terminals</th>
                    <th>Assembly</th>
                    <th>Especial Wires</th>
                    <th>Looming</th>
                    <th>Testing</th>
                    <th>Shipping</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datosTabla as $junta)
                <tr>
                    <td>{{ $junta[0] }}</td>
                    <td>{{ $junta[1] }}</td>
                    <td>{{ $junta[2] }}</td>
                    <td>{{ $junta[3] }}</td>
                    <td>{{ $junta[4] }}</td>
                    <td>{{ $junta[5] }}</td>
                    <td>{{ $junta[6] }}</td>
                    <td>{{ $junta[7] }}</td>
                    <td>{{ $junta[8] }}</td>
                    <td>{{ $junta[9] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>



@endsection
