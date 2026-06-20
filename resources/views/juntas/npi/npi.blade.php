@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Introduccion de nuevos productos</h1>
</div>

<div class="row text-center mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-dark text-white font-weight-bold py-2">
                Total nuevos productos
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">
                <h2 class="display-4 font-weight-bold text-dark mb-0">{{ $totales }}</h2>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4" onclick="mostrar('ppap')">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-success text-white font-weight-bold py-2">
                PPAP ( Hojas Verdes)
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">
                <h2 class="display-4 font-weight-bold text-success mb-0">{{ $totalesPPAP }}</h2>
            </div>
        </div>
    </div>



    <div class="col-xl-4 col-md-6 mb-4" onclick="mostrar('prim')">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-warning text-white font-weight-bold py-2" >
                Primeras piezas ( Hojas Amarillas)
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">
                <h2 class="display-4 font-weight-bold text-warning mb-0" >{{ $totalesPRIM }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row" id="ppap" style="display: none;">
            <div class="row text-center mb-4">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header text-white font-weight-bold py-2" style="background-color: #721c24;">
                            En ingenieria
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center py-4">
                            <h2 class="display-4 font-weight-bold mb-0" style="color: #721c24;">{{ $pendppaping }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header text-white font-weight-bold py-2" style="background-color: #1e2156;">
                           Pendiente por bajar
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center py-4">
                            <h2 class="display-4 font-weight-bold mb-0" style="color: #1e2156;">{{ $pendbajarppap }}</h2>
                        </div>
                    </div>
                </div>
                    <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header text-white font-weight-bold py-2" style="background-color: #441e56;">
                           En produccion
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center py-4">
                            <h2 class="display-4 font-weight-bold mb-0" style="color: #441e56;">{{ $enproduccionppap }}</h2>
                        </div>
                    </div>
                </div>
            </div>
</div>
<div class="row" id="prim" style="display: none;">
            <div class="row text-center mb-4">
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header text-white font-weight-bold py-2" style="background-color: #721c24;">
                            En ingenieria
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center py-4">
                            <h2 class="display-4 font-weight-bold mb-0" style="color: #721c24;">{{ $pendpriming }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header text-white font-weight-bold py-2" style="background-color: #1e2156;">
                           Pendiente por bajar
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center py-4">
                            <h2 class="display-4 font-weight-bold mb-0" style="color: #1e2156;">{{ $pendbajarprim }}</h2>
                        </div>
                    </div>
                </div>
                    <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-header text-white font-weight-bold py-2" style="background-color: #441e56;">
                           En produccion
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center py-4">
                            <h2 class="display-4 font-weight-bold mb-0" style="color: #441e56;">{{ $enproduccionprim}}</h2>
                        </div>
                    </div>
                </div>
            </div>
</div>


<script>
function mostrar(id) {
   if(id == 'ppap'){
        if(document.getElementById('ppap').style.display == 'block'){
            document.getElementById('ppap').style.display = 'none';
            document.getElementById('prim').style.display = 'none';
        }else{
       document.getElementById('ppap').style.display = 'block';
       document.getElementById('prim').style.display = 'none';
    }
   }else{
       if(document.getElementById('prim').style.display == 'block'){
            document.getElementById('prim').style.display = 'none';
            document.getElementById('ppap').style.display = 'none';
        }else{
       document.getElementById('prim').style.display = 'block';
       document.getElementById('ppap').style.display = 'none';
    }
   }
}

</script>

@endsection
