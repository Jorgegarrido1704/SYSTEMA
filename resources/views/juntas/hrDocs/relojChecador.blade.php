@extends('layouts.main')

@section('contenido')


<div class="d-sm-flex align-items-center justify-content-between mb-4"></div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Relog Checador</h5>

                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="ul col-md-6">
                                        @foreach($datosRelog as $registro)
                                            <tr>
                                            @foreach($registro as $valor)
                                                <td>{{ $valor }}</td>
                                                @endforeach
                                            </tr>
                                            @endforeach


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

