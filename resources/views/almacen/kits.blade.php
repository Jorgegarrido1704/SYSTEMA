@extends('layouts.mainWithoutsidebar')
@section('contenido')
<style>
    table {     width: 100%;    text-align: center;
     }
</style>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Numero de parte</th>
                    <th>Wo</th>
                    <th>Item</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($kits))
                @foreach ($kits as $kit)
                <tr>
                    <td>{{ $kit[0] }}</td>
                    <td>{{ $kit[1] }}</td>
                    <td>{{ $kit[2] }}</td>
                    <td><input type="number" name="qty[]" value="{{ $kit[3] }}" step="0.01" id="qty"></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
