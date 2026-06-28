@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Mantenimiento</h1>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">Pendientes de ingeniería</h5>
            </div>
            <div class="card-body" style="overflow-x: auto;">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">FOLIO</th>
                            <th scope="col">FECHA</th>
                            <th scope="col">NOMBRE EQUIPO</th>
                            <th scope="col">QUIEN SOLICITO</th>
                            <th scope="col">AREA</th>
                            <th scope="col">ATENDIO POR</th>
                            <th scope="col">COMPLETAR FORMATO</th>
                            <th scope="col">Excel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($manteninance as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->fechReq }}</td>
                                <td>{{ $row->equipo }}</td>
                                <td>{{ $row->solPor }}</td>
                                <td>{{ $row->area }}</td>
                                <td>{{ $row->tecMant }}</td>
                                <td>
                                    @if (empty($row->descTrab))
                                    <form action="{{ route('mantainence.completarForm', $row->id) }}" method="GET">
                                        <button type="submit" class="btn btn-primary btn-sm">Completar</button>
                                    </form>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($row->descTrab))
                                        <form action="{{ route('mantainence.excel') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="ides" value="{{ $row->id }}">
                                            <button type="submit" class="btn btn-success btn-sm">Excel</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No hay registros pendientes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@endsection

