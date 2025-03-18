@extends('layouts.main')
@section('contenido')
<style>
    body{
        @media screen and (max-width: 768px) {
            font-size: 12px;
            text-align: center;
            align-items: center;
            margin-bottom: 5px;
            display: block;
        }
    }
    table {     width: 100%;    text-align: center;  }
     input[type="number"] { width: 120px; text-align: center; border-radius: 15px; }
     input[type="submit"] { width: 120px; text-align: center; border-radius: 15px; background-color: blue; color: white; }
    #volver { width: 120px; text-align: center; border-radius: 15px; background-color: blue; color: white; }
    .form-control{

        width: 400px;
        text-align: center;
        border-radius: 15px;
    }
</style>
<div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>
                @if(!empty($kits))
                <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-6">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Pn: {{$datosPn[0]}}  WO: {{$datosPn[1]}} </h5>

                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; ">


                            <div class="table-responsive">

                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th><h1>Item</h1></th>
                                            <th><h1>Cantidad</h1></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($kits as $kit)
                                        <tr>
                                            <td>{{ $kit[2] }}</td>
                                            <td>{{ $kit[3] }}</td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-6">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h5 class="m-0 font-weight-bold text-primary">Registro de Cantidad</h5>
                    </div>
                    <div class="card-body" >
                        <form action="{{route('registroKit')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="codigo" id="codigo" placeholder="Qr Code " required>
                            </div>
                    </div>

                </div>
            </div>
    </div>

        @endif
@endsection
