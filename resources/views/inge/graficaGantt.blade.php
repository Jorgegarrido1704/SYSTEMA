@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->

<div class="d-sm-flex align-items-center justify-content-between mb-4 text-center">
    <h1 class="h3 mb-0 text-gray-800 ">Gráfica Gantt</h1>
    <div>
    <label for="personal" style='margin-right: 10px; font-weight: bold;'>Número de personal asignado:</label>
    <input type='number' id='personal' value='{{ $personal }}' min='1' max='5' style='width: 60px; text-align: center;' onchange='cambiarPersonal()'>
    </div>
</div>
<script>
    function cambiarPersonal(){
        var personal = document.getElementById('personal').value;
        window.location.href = "/ganttGraph?personal=" + personal;
    }
</script>

<script> var datass = @json($data);
    var maxDs = @json($lastDayoffMonth);
    var orgDatass = @json($origData);
    </script>

<canvas id="ganttChart" width="800" height="400"></canvas>
<script src="{{ asset('dash/js/graficaGantt.js')}}"></script>



 @endsection
