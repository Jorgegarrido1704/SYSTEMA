@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
@if(!empty($data))
<script> const datas = @json($data); </script>

@endif
<canvas id="ganttChart" width="800" height="400"></canvas>
<script src="{{ asset('/dash/js/graficaGantt.js')}}"></script>



 @endsection
