@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4 text-center">
    <h1 class="h3 mb-0 text-gray-800 ">{{__('Gantt Work Graph')}}</h1>
</div>
<div class="row">
    <div class="col-md-12">
        <canvas id="Paola S" width="800" height="400"></canvas>
    </div>
</div>
<script src="{{ asset('dash/js/gandGraph.js')}}"></script>




@endsection
