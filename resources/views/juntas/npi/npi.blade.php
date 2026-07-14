@extends('layouts.main')

@section('contenido')
<style>
    .circulo{
        background-color: blue;
        width: 33px;
        height: 33px;
        border-radius: 50%;
}
    </style>
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
                           Pendiente por planeacion ( GenerarWO)
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
                           Pendiente por planeacion (Generar WO)
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
<div class="row text-center"  id="tablas_datos"style="display: none;">
    <div class="col-md-12 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header text-white font-weight-bold py-2" style="background-color: #721c24;">
               Ingenieria
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">

                    <table class="table table-striped table-bordered"  cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('Status') }}</th>
                                <th>{{__('Customer') }}</th>
                                <th>{{ __('Part Number') }}</th>
                                <th>{{__('Revision') }}</th>
                                <th>{{__('Received Date') }}</th>
                                <th>{{__('Commitment Date') }}</th>
                                 <th>{{__('Required Date') }}</th>
                            </tr>
                            <thead>
                                <tbody id="tbody_ingenieria">

                                </tbody>
                    </table>
            </div>
        </div>
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header text-white font-weight-bold py-2" style="background-color: #1e2156;">
               Pendiente por planeacion (Generar WO)
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">
                 <table class="table table-striped table-bordered"  cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>{{__('Customer') }}</th>
                                <th>{{ __('Part Number') }}</th>
                                <th>{{__('Revision') }}</th>
                                <th>{{__('Received Date') }}</th>
                                <th>{{__('Commitment Date') }}</th>
                                <th>{{ __('Completion Date') }}</th>
                                <th>{{__('Required Date') }}</th>
                                <th>{{__('Components in the System') }}</th>
                                <th>{{__('Kit Builded') }}</th>
                            </tr>
                            <thead>
                                <tbody id="tabla_pendiente"> </tbody>
                    </table>
            </div>
        </div>
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header text-white font-weight-bold py-2" style="background-color: #441e56;">
               En piso
            </div>
            <div class="card-body d-flex align-items-center justify-content-center py-4">
                 <table class="table table-striped table-bordered"  cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>{{ __('Status') }}</th>
                                <th>{{__('Customer') }}</th>
                                <th>{{ __('Part Number') }}</th>
                                <th>{{__('Revision') }}</th>
                                <th>{{__('Where is it located') }}</th>
                                <th>{{__('Required Date') }}</th>

                            </tr>
                            <thead>
                                <tbody id="tabla_piso"> </tbody>
                    </table>
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
            document.getElementById('tablas_datos').style.display = 'none';
        }else{
       document.getElementById('ppap').style.display = 'block';
       document.getElementById('prim').style.display = 'none';
       mostrarTablas('ppap');
    }
     }else{
       if(document.getElementById('prim').style.display == 'block'){
            document.getElementById('prim').style.display = 'none';
            document.getElementById('ppap').style.display = 'none';
             document.getElementById('tablas_datos').style.display = 'none';
        }else{
       document.getElementById('prim').style.display = 'block';
       document.getElementById('ppap').style.display = 'none';
       mostrarTablas('prim');
    }
   }
}
function mostrarTablas(id){
    //alert(id);
    document.getElementById('tablas_datos').style.display = 'block';
    let url;
    if(id === 'ppap'){
         url = "{{ route('info_npi', ['id' => 'ppap']) }}";
    }else{
     url = "{{ route('info_npi', ['id' => 'prim']) }}";
    }
    fetch(url).then(response => response.json()).then(data => {
        console.log(data);
        let tabla_ingenieria = document.getElementById('tbody_ingenieria');
        let tabla_pendiente = document.getElementById('tabla_pendiente');
        let tabla_piso = document.getElementById('tabla_piso');
        let html_ingenieria = '';
        let html_pendiente = '';
        let html_piso = '';
        data.inprogres.forEach(inprogres => {
            html_ingenieria += `<tr>
            <td><div class="circulo" style="background-color: ${inprogres.statusColor};"></div></td>
            <td>${inprogres.customer}</td>
            <td>${inprogres.pn}</td>
            <td>${inprogres.WorkRev}</td>
            <td>${inprogres.receiptDate}</td>
            <td>${inprogres.commitmentDate}</td>
            <td>${inprogres.customerDate}</td>
        </tr>`;
        });
        data.totalgeneral.forEach(inprogres => {
          let material= inprogres.material>0 ? 'checked' : '';
          let kit= inprogres.kit>0 ? 'checked' : '';
          let value = "{{ $value }}";
          let checando=['disabled','disabled'];
          if(value == "Julio R" || value == "Admin"){
             checando =['' , 'disabled'];
          }else if(value == "Alex M" || value == "Admin"){
          checando = [  'disabled', ''];
        }
            html_pendiente += `<tr>
            <td><div class="circulo" style="background-color: ${inprogres.statusColor};"></div></td>
            <td>${inprogres.customer}</td>
            <td>${inprogres.pn}</td>
            <td>${inprogres.WorkRev}</td>
            <td>${inprogres.receiptDate}</td>
            <td>${inprogres.commitmentDate}</td>
            <td>${inprogres.CompletionDate}</td>
            <td>${inprogres.customerDate}</td>
            <td><input type="checkbox" id="material_${inprogres.id}" name="material_${inprogres.id}" ${checando[0]}  ${material} onclick="materialsComponent(${inprogres.id})" ></td>
            <td><input type="checkbox" id="kit_${inprogres.id}" name="kit_${inprogres.id}" ${checando[1]} ${kit} onclick="kitsComponent(${inprogres.id})" ></td>

        </tr>`;
        });

        data.registros.forEach(inprogres => {
            html_piso += `<tr>
            <td><div class="circulo" style="background-color: ${inprogres.statusColor};"></div></td>
            <td>${inprogres.cliente}</td>
            <td>${inprogres.NumPart}</td>
            <td>${inprogres.rev}</td>
            <td>${inprogres.donde}</td>
            <td>${inprogres.customerDate}</td>
        </tr>`;
        });
        tabla_ingenieria.innerHTML = html_ingenieria;
        tabla_pendiente.innerHTML = html_pendiente;
        tabla_piso.innerHTML = html_piso;


    })

}
    function materialsComponent(id){
        $value = "{{ $value }}";
        let checkbox = document.getElementById(`material_${id}`);
        let isChecked = checkbox.checked;
        alert(isChecked);
        fetch(`/update_materials/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ isChecked: isChecked })
        }).then(response => response.json()).then(data => {
            console.log(data);
        });
    }
    function kitsComponent(id){
        $value = "{{ $value }}";
        let checkbox = document.getElementById(`kit_${id}`);
        let isChecked = checkbox.checked;

       fetch(`/update_kits/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ isChecked: isChecked })
        }).then(response => response.json()).then(data => {
            console.log(data);
        })
    }

</script>

@endsection
