@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="90">
 <style>
    table {     width: 100%;    text-align: center;  }
    td {border-bottom: solid 2px lightblue; }
    thead{background-color: #FC4747; color:white;  }
    a{text-decoration: none; color: whitesmoke;  }
    a:hover{ text-decoration: none; color: white; font:bold;}

    .chart-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chart-area {
        flex: 1;
        margin: 0 10px;
    }


</style>

<script>
    var datos = {!! json_encode($datos) !!};
    var pareto = {!! json_encode($pareto) !!};
    var Qdays={!! json_encode($Qdays) !!}
var colorQ={!! json_encode($colorQ) !!}
var labelQ={!! json_encode($labelQ)!!}
var paretoYear={!! json_encode($monthAndYearPareto) !!};
</script>
 @extends('juntas.calidad')

                    @endsection
