@extends('layouts.main')

@section('contenido')

<script src="{{ asset('dash/js/vacaciones.js') }}"></script>

@if (session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    text: "{{ session('error') }}"
});


</script>
@endif


<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

@push('scripts')



<!-- Calendario -->
@php
    $year = $year ?? now()->year;
    $diasSemana = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];
@endphp

<div class="row">
    @for ($mes ; $mes <= 12; $mes++)
        @php
            $fechaInicio = \Carbon\Carbon::create($year, $mes, 1);
            $diasEnMes = $fechaInicio->daysInMonth;
            // 1 = Lunes, 7 = Domingo (ISO-8601)
            $primerDiaSemana = $fechaInicio->copy()->startOfMonth()->dayOfWeekIso;
        @endphp

        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header py-2 text-center bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">{{ $fechaInicio->locale('es')->isoFormat('MMMM') }}</h6>
                </div>
                <div class="card-body p-2">
                    <table class="table table-sm table-bordered text-center mb-0" style="font-size: 0.85rem;">
                        <thead>
                            <tr class="table-light">
                                @foreach ($diasSemana as $diaNombre)
                                    <th>{{ $diaNombre }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $diaActual = 1;
                                $espaciosVacios = $primerDiaSemana - 1; // Celdas antes del día 1
                            @endphp

                            <tr>
                                {{-- Celdas vacías previas al primer día del mes --}}
                                @for ($i = 0; $i < $espaciosVacios; $i++)
                                    <td class="text-muted bg-light"></td>
                                @endfor

                                {{-- Renderizado de días del mes --}}
                                @while ($diaActual <= $diasEnMes)
                                    @if (($diaActual + $espaciosVacios - 1) % 7 === 0 && $diaActual !== 1)
                                        </tr><tr>
                                    @endif

                                    <td id="{{ \Carbon\Carbon::create($year, $mes, $diaActual)->format('Y-m-d') }}">{{ $diaActual }}</td>

                                    @php $diaActual++; @endphp
                                @endwhile

                                {{-- Celdas vacías al final de la última semana --}}
                                @php
                                    $celdasRestantes = (7 - (($diasEnMes + $espaciosVacios) % 7)) % 7;
                                @endphp
                                @for ($i = 0; $i < $celdasRestantes; $i++)
                                    <td class="text-muted bg-light"></td>
                                @endfor
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endfor
</div>
<script>
    const fechasSeleccionadas = {!! json_encode($fechas_seleccionadas) !!};

    fechasSeleccionadas.forEach(item => {
        const celda = document.getElementById(item.fecha);
        if (celda) {
            celda.style.backgroundColor = '#28a745';
            celda.style.color = 'white';
            celda.style.cursor = 'pointer';

            // Atributos para el popover de Bootstrap
            celda.setAttribute('data-bs-toggle', 'popover'); // Bootstrap 5
            celda.setAttribute('data-toggle', 'popover');    // Bootstrap 4 (por si acaso)
            celda.setAttribute('data-bs-trigger', 'hover');
            celda.setAttribute('data-trigger', 'hover');
            celda.setAttribute('data-bs-html', 'true');
            celda.setAttribute('data-html', 'true');
            celda.setAttribute('data-bs-placement', 'top');
            celda.setAttribute('data-placement', 'top');
            celda.setAttribute('title', item.titulo);
            celda.setAttribute('data-bs-content', item.detalle + '<br><small>' + item.fecha + '</small>');
            celda.setAttribute('data-content', item.detalle + '<br><small>' + item.fecha + '</small>');
        }
    });

    // Inicializar popovers (Bootstrap 5)
    document.addEventListener('DOMContentLoaded', function () {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.forEach(function (el) {
            new bootstrap.Popover(el);
        });
    });

    // Si tu proyecto usa jQuery + Bootstrap 4 en vez de BS5, descomentá esto:
    // $(function () {
    //     $('[data-toggle="popover"]').popover();
    // });
</script>

<style>
    .popover {
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
    }
    .popover-header {
        background-color: #28a745;
        color: #fff;
        font-weight: bold;
        border-radius: 12px 12px 0 0;
    }
</style>


@endsection
