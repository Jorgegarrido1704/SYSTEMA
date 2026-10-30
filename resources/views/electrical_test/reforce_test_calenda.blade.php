
@extends('layouts.main')

@section('contenido')

@php
    $year = $year ?? now()->year;
    $diasSemana = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];
@endphp

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error'))
        });
    </script>
@endif

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Correcto',
            text: @json(session('success'))
        });
    </script>
@endif

<div class="container-fluid">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="font-weight-bold text-dark mb-1">
                <i class="fas fa-tools text-primary"></i>
                Control de mantenimientos
            </h4>
            <small class="text-muted">
                Calendario y registro de trabajos realizados
            </small>
        </div>

        @if($value == "Admin")
            <a href="{{ route('pruebas.cargar_seis_meses') }}"
               class="btn btn-primary">
                <i class="fas fa-calendar-plus"></i>
                Cargar próximos 6 meses
            </a>
        @endif
    </div>


    <!-- CALENDARIO -->
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-primary text-white">
            <h6 class="mb-0 font-weight-bold">
                <i class="fas fa-calendar-alt"></i>
                Calendario de mantenimientos
            </h6>
        </div>

        <div class="card-body">

            <div class="row">

                @for($mes = 1; $mes <= 12; $mes++)

                    @php
                        $fechaInicio = \Carbon\Carbon::create($year, $mes, 1);
                        $diasEnMes = $fechaInicio->daysInMonth;
                        $primerDiaSemana = $fechaInicio->dayOfWeekIso;
                    @endphp

                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">

                        <div class="card shadow-sm h-100">

                            <div class="card-header bg-light text-center py-2">
                                <strong class="text-primary">
                                    {{ $fechaInicio->locale('es')->isoFormat('MMMM') }}
                                </strong>
                            </div>

                            <div class="card-body p-2">

                                <table class="table table-sm table-bordered text-center mb-0"
                                       style="font-size: 13px;">

                                    <thead>
                                        <tr class="bg-light">
                                            @foreach($diasSemana as $dia)
                                                <th>{{ $dia }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @php
                                            $diaActual = 1;
                                            $espaciosVacios = $primerDiaSemana - 1;
                                        @endphp

                                        <tr>

                                            @for($i = 0; $i < $espaciosVacios; $i++)
                                                <td class="bg-light"></td>
                                            @endfor

                                            @while($diaActual <= $diasEnMes)

                                                @if(($diaActual + $espaciosVacios - 1) % 7 === 0 && $diaActual !== 1)
                                                    </tr><tr>
                                                @endif

                                                @php
                                                    $fechaCelda = \Carbon\Carbon::create(
                                                        $year,
                                                        $mes,
                                                        $diaActual
                                                    )->format('Y-m-d');
                                                @endphp

                                                <td id="{{ $fechaCelda }}"
                                                    class="dia-calendario"
                                                    data-fecha="{{ $fechaCelda }}"
                                                    style="cursor:pointer;">
                                                    {{ $diaActual }}
                                                </td>

                                                @php $diaActual++; @endphp

                                            @endwhile

                                            @php
                                                $celdasRestantes = (
                                                    7 - (($diasEnMes + $espaciosVacios) % 7)
                                                ) % 7;
                                            @endphp

                                            @for($i = 0; $i < $celdasRestantes; $i++)
                                                <td class="bg-light"></td>
                                            @endfor

                                        </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>

                @endfor

            </div>

            <div class="mt-2">
                <span class="badge badge-success p-2">
                    <i class="fas fa-calendar-check"></i>
                    Fecha con mantenimientos programados
                </span>

                <span class="badge badge-primary p-2">
                    <i class="fas fa-calendar-day"></i>
                    Fecha seleccionada
                </span>
            </div>

        </div>
    </div>


    <!-- FORMULARIO DE MANTENIMIENTO -->
    <div class="card shadow border-0 mb-4">

        <div class="card-header bg-primary text-white py-3">

            <h5 class="mb-0 font-weight-bold">
                <i class="fas fa-clipboard-list"></i>
                Registro de mantenimiento
            </h5>

            <small>
                Selecciona una fecha, los números de parte y registra el trabajo realizado.
            </small>

        </div>

        <div class="card-body p-4">

            <form id="formMantenimiento"
                  action="{{ route('guardarTrabajoRealizados') }}"
                  method="POST">

                @csrf

                <!-- FECHA -->
                <div class="row mb-4">

                    <div class="col-md-5">

                        <label class="font-weight-bold">
                            <i class="fas fa-calendar-alt text-primary"></i>
                            Fecha programada
                        </label>

                        <input type="date"
                               id="fecha_programada"
                               name="fecha_programada"
                               class="form-control form-control-lg"
                               required>

                    </div>

                    <div class="col-md-7">

                        <div class="alert alert-info mb-0 mt-md-4">

                            <i class="fas fa-info-circle"></i>

                            Selecciona un día del calendario o utiliza el selector de fecha para consultar los números de parte.

                        </div>

                    </div>

                </div>

                <hr>

                <!-- NUMEROS DE PARTE -->
                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h6 class="font-weight-bold text-dark mb-0">

                        <i class="fas fa-list text-primary"></i>
                        Números de parte programados

                    </h6>

                    <span class="badge badge-primary p-2">
                        <span id="totalPN">0</span> seleccionados
                    </span>

                </div>


                <div id="contenedorPN"
                     class="border rounded bg-light p-3"
                     style="min-height:140px;">

                    <div id="mensajeInicial"
                         class="text-center text-muted py-4">

                        <i class="fas fa-calendar-day fa-2x mb-2"></i>

                        <p class="mb-0">
                            Selecciona una fecha para visualizar los números de parte.
                        </p>

                    </div>

                    <div id="listaPN" class="row"></div>

                </div>


                <div class="mt-3">

                    <button type="button"
                            class="btn btn-sm btn-outline-primary"
                            id="seleccionarTodos">

                        <i class="fas fa-check-double"></i>
                        Seleccionar todos

                    </button>

                    <button type="button"
                            class="btn btn-sm btn-outline-secondary"
                            id="deseleccionarTodos">

                        <i class="fas fa-times"></i>
                        Limpiar selección

                    </button>

                </div>


                <hr class="my-4">


                <!-- REPORTE -->
                <div class="form-group">

                    <label class="font-weight-bold">

                        <i class="fas fa-file-alt text-primary"></i>
                        Reporte del trabajo realizado

                    </label>

                    <textarea name="trabajo_realizado"
                              id="trabajo_realizado"
                              class="form-control"
                              rows="5"
                              maxlength="5000"
                              placeholder="Describe las actividades realizadas, reparaciones, ajustes, materiales utilizados y observaciones..."
                              required></textarea>

                    <div class="d-flex justify-content-between mt-2">

                        <small class="text-muted">
                            Describe detalladamente el mantenimiento.
                        </small>

                        <small class="text-muted">
                            <span id="contador">0</span>/5000
                        </small>

                    </div>

                </div>


                <!-- RESUMEN -->
                <div class="card bg-light border mt-4">

                    <div class="card-body">

                        <div class="row text-center">

                            <div class="col-md-4 mb-2">

                                <small class="text-muted d-block">
                                    Fecha seleccionada
                                </small>

                                <strong id="resumenFecha">
                                    Sin seleccionar
                                </strong>

                            </div>

                            <div class="col-md-4 mb-2">

                                <small class="text-muted d-block">
                                    Números de parte
                                </small>

                                <strong id="resumenCantidad">
                                    0
                                </strong>

                            </div>

                            <div class="col-md-4 mb-2">

                                <small class="text-muted d-block">
                                    Estatus al guardar
                                </small>

                                <span class="badge badge-success">
                                    Finalizado
                                </span>

                            </div>

                        </div>

                    </div>
                </div>


                <!-- BOTONES -->
                <div class="d-flex justify-content-end mt-4">

                    <button type="reset"
                            class="btn btn-outline-secondary mr-2">

                        <i class="fas fa-eraser"></i>
                        Limpiar

                    </button>

                    <button type="submit"
                            class="btn btn-primary px-4"
                            id="btnGuardar">

                        <i class="fas fa-save"></i>
                        Guardar mantenimiento

                    </button>

                </div>

            </form>

        </div>
    </div>

</div>


<!-- JAVASCRIPT -->
<script>

document.addEventListener('DOMContentLoaded', function() {

    // DATOS DEL CONTROLADOR
    const fechasSeleccionadas = @json($fechas_seleccionadas);

    const fechaInput = document.getElementById('fecha_programada');
    const listaPN = document.getElementById('listaPN');
    const mensajeInicial = document.getElementById('mensajeInicial');

    const form = document.getElementById('formMantenimiento');

    let fechasAgrupadas = {};


    // NORMALIZAR FECHAS
    function normalizarFecha(fecha) {

        if (!fecha) return '';

        if (typeof fecha === 'object' && fecha.date) {
            return fecha.date.substring(0, 10);
        }

        return String(fecha).substring(0, 10);

    }


    // AGRUPAR NUMEROS DE PARTE POR FECHA
    fechasSeleccionadas.forEach(item => {

        let fecha = normalizarFecha(item.fecha_programada);

        if (!fechasAgrupadas[fecha]) {
            fechasAgrupadas[fecha] = [];
        }

        if (!fechasAgrupadas[fecha].some(p => p.pn === item.pn)) {
            fechasAgrupadas[fecha].push(item);
        }

    });


    // ACTUALIZAR RESUMEN
    function actualizarResumen() {

        let seleccionados = document.querySelectorAll(
            '.pn-checkbox:checked'
        ).length;

        document.getElementById('totalPN').textContent = seleccionados;

        document.getElementById('resumenCantidad').textContent = seleccionados;

    }


    // CARGAR NUMEROS DE PARTE
    function cargarNumerosParte(fecha) {

        listaPN.innerHTML = '';

        let registros = fechasAgrupadas[fecha] || [];

        mensajeInicial.style.display = registros.length ? 'none' : 'block';

        if (registros.length === 0) {

            mensajeInicial.innerHTML = `
                <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                <p class="mb-0">
                    No hay números de parte programados para esta fecha.
                </p>
            `;

        }


        registros.forEach(item => {

            let finalizado = item.estatus === 'Finalizado';

            let div = document.createElement('div');

            div.className = 'col-md-6 col-lg-4 col-xl-3 mb-3';

            let label = document.createElement('label');

            label.className = 'card shadow-sm p-3 mb-0 h-100';

            label.style.cursor = finalizado ? 'not-allowed' : 'pointer';

            label.style.borderRadius = '10px';

            let fila = document.createElement('div');

            fila.className = 'd-flex align-items-center justify-content-between';

            let izquierda = document.createElement('div');

            izquierda.className = 'd-flex align-items-center';

            let checkbox = document.createElement('input');

            checkbox.type = 'checkbox';
            checkbox.name = 'numeros_parte[]';
            checkbox.value = item.pn;
            checkbox.className = 'mr-2 pn-checkbox';
            checkbox.disabled = finalizado;

            let nombre = document.createElement('strong');

            nombre.textContent = item.pn;

            izquierda.appendChild(checkbox);
            izquierda.appendChild(nombre);

            let estado = document.createElement('span');

            estado.className = finalizado
                ? 'badge badge-success'
                : 'badge badge-warning';

            estado.textContent = finalizado
                ? 'Finalizado'
                : 'Pendiente';

            fila.appendChild(izquierda);
            fila.appendChild(estado);

            label.appendChild(fila);

            if (finalizado) {

                label.classList.add('bg-light');
                label.title = 'Este mantenimiento ya fue finalizado';

            }

            div.appendChild(label);

            listaPN.appendChild(div);

            checkbox.addEventListener('change', function() {

                label.classList.toggle('border-primary', checkbox.checked);

                actualizarResumen();

            });

        });

        actualizarResumen();

    }


    // SELECCIONAR FECHA DESDE INPUT
    fechaInput.addEventListener('change', function() {

        seleccionarFecha(this.value);

    });


    // SELECCIONAR FECHA DESDE CALENDARIO
    function seleccionarFecha(fecha) {

        if (!fecha) return;

        fechaInput.value = fecha;

        document.getElementById('resumenFecha').textContent = fecha;

        // Marcar fecha seleccionada en el calendario
        document.querySelectorAll('.dia-calendario').forEach(celda => {

            celda.style.backgroundColor = '';
            celda.style.color = '';
            celda.style.fontWeight = '';

            let fechaCelda = celda.dataset.fecha;

            if (fechasAgrupadas[fechaCelda]) {

                celda.style.backgroundColor = '#28a745';
                celda.style.color = '#fff';

            }

            if (fechaCelda === fecha) {

                celda.style.backgroundColor = '#007bff';
                celda.style.color = '#fff';
                celda.style.fontWeight = 'bold';

            }

        });

        cargarNumerosParte(fecha);

    }


    // EVENTO DE CLIC EN CALENDARIO
    document.querySelectorAll('.dia-calendario').forEach(celda => {

        celda.addEventListener('click', function() {

            seleccionarFecha(this.dataset.fecha);

        });

        let fecha = celda.dataset.fecha;

        if (fechasAgrupadas[fecha]) {

            celda.style.backgroundColor = '#28a745';
            celda.style.color = '#fff';
            celda.style.fontWeight = 'bold';

            celda.title = fechasAgrupadas[fecha].length +
                ' números de parte programados';

        }

    });


    // SELECCIONAR TODOS
    document.getElementById('seleccionarTodos')
        .addEventListener('click', function() {

            document.querySelectorAll('.pn-checkbox:not(:disabled)')
                .forEach(check => {

                    check.checked = true;

                    check.closest('label').classList.add('border-primary');

                });

            actualizarResumen();

        });


    // DESELECCIONAR TODOS
    document.getElementById('deseleccionarTodos')
        .addEventListener('click', function() {

            document.querySelectorAll('.pn-checkbox')
                .forEach(check => {

                    check.checked = false;

                    check.closest('label').classList.remove('border-primary');

                });

            actualizarResumen();

        });


    // CONTADOR DE CARACTERES
    document.getElementById('trabajo_realizado')
        .addEventListener('input', function() {

            document.getElementById('contador').textContent =
                this.value.length;

        });


    // VALIDAR FORMULARIO
    form.addEventListener('submit', function(e) {

        let seleccionados = document.querySelectorAll(
            '.pn-checkbox:checked'
        ).length;

        if (!fechaInput.value) {

            e.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Fecha requerida',
                text: 'Selecciona una fecha para continuar.'
            });

            return;

        }

        if (seleccionados === 0) {

            e.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Números de parte requeridos',
                text: 'Selecciona al menos un número de parte pendiente.'
            });

            return;

        }

        if (!document.getElementById('trabajo_realizado').value.trim()) {

            e.preventDefault();

            Swal.fire({
                icon: 'warning',
                title: 'Reporte requerido',
                text: 'Escribe el trabajo realizado.'
            });

            return;

        }

        document.getElementById('btnGuardar').disabled = true;

        document.getElementById('btnGuardar').innerHTML =
            '<i class="fas fa-spinner fa-spin"></i> Guardando...';

    });


    // RESTABLECER FORMULARIO
    form.addEventListener('reset', function() {

        setTimeout(function() {

            listaPN.innerHTML = '';

            mensajeInicial.style.display = 'block';

            mensajeInicial.innerHTML = `
                <i class="fas fa-calendar-day fa-2x mb-2"></i>
                <p class="mb-0">
                    Selecciona una fecha para visualizar los números de parte.
                </p>
            `;

            document.getElementById('contador').textContent = '0';

            document.getElementById('resumenFecha').textContent =
                'Sin seleccionar';

            actualizarResumen();

        }, 0);

    });


    // CARGAR FECHA INICIAL SI EXISTE
    // Puedes establecer aquí una fecha por defecto si lo necesitas.

});

</script>


<style>

    .dia-calendario {
        transition: all .2s ease;
    }

    .dia-calendario:hover {
        background-color: #007bff !important;
        color: white !important;
        font-weight: bold;
    }

    #listaPN .card {
        transition: all .2s ease;
    }

    #listaPN .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,.12) !important;
    }

    #listaPN .card.border-primary {
        border: 2px solid #007bff !important;
    }

    .card {
        border-radius: 10px;
    }

    .popover {
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,.15);
    }

</style>

@endsection
