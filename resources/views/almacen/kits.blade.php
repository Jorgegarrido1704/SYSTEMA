@extends('layouts.mainWithoutsidebar')
@section('contenido')
<style>
    table {     width: 100%;    text-align: center;  }
     input[type="number"] { width: 120px; text-align: center; border-radius: 15px; }
</style>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><h1>Numero de parte</h1></th>
                    <th><h1>Wo</h1></th>
                    <th><h1>Item</h1></th>
                    <th><h1>Cantidad</h1></th>
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
