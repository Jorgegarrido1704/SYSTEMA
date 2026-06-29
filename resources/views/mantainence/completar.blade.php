@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Completar registro</h1>
</div>

<div  class="row" id ="completarForm">
<div class="col-md-12">
    <form id="formCompletar" action="{{ route('mantainence.completar', $row->id) }}" method="POST">
        @csrf

        <table class="table table-borderless table-sm mb-4">
            <tbody>
                <tr>
                    <th>FOLIO</th>
                    <td>{{ $row->id }}</td>
                    <th>FECHA</th>
                    <td>{{ $row->fechReq }}</td>
                    <th>EQUIPO</th>
                    <td>{{ $row->equipo }}</td>
                    <th>AREA</th>
                    <td>{{ $row->area }}</td>
                    <th>SOLICITÓ</th>
                    <td>{{ $row->solPor }}</td>

                </tr>
            </tbody>
        </table>
        <div class="row">
                <div class="col-md-4">
                    <label for="tecMant" class="form-label">Tecnico de mantenimiento</label>
                <select name="tecMant" id="tecMant" class="form-control" required>
                        <option value="" disabled selected></option>
                        @foreach ($peronsal as $tecnico)
                            <option value="{{ $tecnico->employeeName }}">{{ $tecnico->employeeName }}</option>
                        @endforeach
                </select>
                </div>

                <div class="col-md-4">

                    <label for="tipomant" class="form-label">Tipo de Mantenimiento</label>
                    <select name="tipomant" id="tipomant" class="form-control" required>
                        <option value=""></option>
                        <option value="MAQUINARIA">MAQUINARIA</option>
                        <option value="SISTEMAS DE INFORMACION">SISTEMAS DE INFORMACION</option>
                        <option value="ESTRUCTURAS Y PLANTA">ESTRUCTURAS Y PLANTA</option>
                        <option value="PREVENTIVO">PREVENTIVO</option>
                        <option value="PRUEBA ELECTRICA">PRUEBA ELECTRICA</option>
                        <option value="CORRECTIVO">CORRECTIVO</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="PERIODO" class="form-label">Periodicidad del Mantenimiento</label>
                    <select name="PERIODO" id="PERIODO" class="form-control" required>
                        <option value=""></option>
                        <option value="UNA VEZ">UNA VEZ</option>
                        <option value="SEMANAL">SEMANAL</option>
                        <option value="MENSUAL">MENSUAL</option>
                        <option value="TRIMESTRAL">TRIMESTRAL</option>
                        <option value="SEMESTRAL">SEMESTRAL</option>
                        <option value="ANUAL">ANUAL</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="desc" class="form-label">Descripción del mantenimiento</label>
                    <textarea name="desc" id="desc" class="form-control" rows="3" required></textarea>
                </div>

                <div class="col-md-3">
                    <label for="ESTATUS" class="form-label">Estatus del mantenimiento</label>
                    <select name="ESTATUS" id="ESTATUS" class="form-control" required>
                        <option value=""></option>
                        <option value="FINALIZADO">FINALIZADO</option>
                        <option value="PENDIENTE">PENDIENTE</option>
                        <option value="INTERRUMPIDO">INTERRUMPIDO</option>
                        <option value="FINALIZADO PERO NO OK">FINALIZADO PERO NO OK</option>
                        <option value="PAUSADO">PAUSADO</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="komment" class="form-label">Comentarios adicionales</label>
                    <textarea name="komment" id="komment" class="form-control" rows="3" required></textarea>
                </div>

                <div class="col-md-3">
                    <label for="tiempo" class="form-label">Tiempo total en minutos</label>
                    <input type="number" name="tiempo" id="tiempo" class="form-control" value="{{ $row->ttServ }}" min="0" required>
                </div>
        </div>
        <div class="row">
                <div class="col-md-6 mt-3 ">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1" required>
                    <label class="form-check-label" for="exampleCheck1">Todo correcto</label>
                </div>
                <div class="col-md-6  mt-3 ">
                <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
        </div>
    </form>
</div>

</div>

@endsection
