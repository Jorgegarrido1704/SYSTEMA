@extends('layouts.main')

@section('contenido')
<div align=center>
    <style>
        table {     width: 100%;                     }
        td {border-bottom: solid 2px lightblue; }
        thead{background-color: #FC4747; color:white;  }
        a{text-decoration: none; color: whitesmoke;  }
        a:hover{ text-decoration: none; color: white; font:bold;}
    </style>
    <div style="max-height: 850px; overflow-y: auto; overflow-x: auto;">
        <table>
            <thead>
                <th>Folio</th>
                <th>Request Date</th>
                <th>Cliente</th>
                <th>Model</th>
                <th>Original Part</th>
                <th>Sustitute Part</th>
                <th>Who Request</th>
                <th>Qty</th>
                <th>limit Date</th>
                <th>Why?</th>
                <th>Action</th>
                <th>Evidence</th>
                <th>Sign</th>
            </thead>
            <tbody>
             @foreach ($info as $inf)
                <tr>
                    <form action="{{route('pending')}}" method="GET">
                        <td>{{$inf[11]}}</td>
                        <td>{{$inf[0]}}</td>
                        <td>{{$inf[1]}}</td>
                        <td>{{$inf[2]}}</td>
                        <td>{{$inf[3]}}</td>
                        <td>{{$inf[4]}}</td>
                        <td>{{$inf[5]}}</td>
                        <td>{{$inf[6]}}</td>
                        <td>{{$inf[7]}}</td>
                        <td>{{$inf[8]}}</td>
                        <td>{{$inf[9]}}</td>
                        <td>{{$inf[10]}}</td>
                        <input type="hidden" name="id" id="id" value="{{$inf[11]}}">
                        <td><input type="submit" name="enviar" id="enviarl" value="Sign"></td>
                    </form>
                </tr>
             @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
