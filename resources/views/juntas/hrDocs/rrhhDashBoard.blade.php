@extends(   'layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
<script>const Error = {{ json_encode(session('error')) }};
if (Error) {
    alert(Error);}
</script>
<!-- First Period -->
<div class="row">
    <div class="col-lg-12 col-lx-12 mb-4">
        <style>
#OK {background-color: rgba(76, 175, 80, 0.5); color: white;}
#F{background-color: rgba(255, 47, 47, 0.75); color: white;}
#PSS{background-color: rgba(237, 142, 1, 0.75); color: white;}
#PCS{background-color: rgba(237, 142, 1, 0.8); color: white;}
#INC{background-color: rgba(253, 207, 71, 0.84); color: white;}
#V{background-color: rgba(73, 50, 204, 0.5); color: white;}
#R{background-color: rgba(245, 13, 129, 0.35);color: white;}
#SUS{background-color: rgba(100, 9, 9, 0.81); color: white;}
#PCT{background-color: rgba(103, 95, 95, 0.35); color: black;}
#empleado{background-color: rgba(255, 255, 255, 0.5); color: black; font-weight: bold; font-size: 16px;}
#AddPersonal,#modificarEmpleado{display: none; }

        </style>


                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Modificaciones de Registos </h5>
                          @if($cat == "RRHH" or $cat == "SupAdmin")
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal" id="addPersonal" onclick="addEmpleado();" >Agregar personal</button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#addModal" id="modificarEmpleados" onclick="modificarEmpleado();">Modifiar empleado</button>

                        <div id ="AddPersonal" >
                           <form class="row g-3" action="{{ route('addperson') }}" method="POST">
                            @csrf
                                <div class="col-md-2">
                                    <label for="nombre" class="form-label">Nombre de empleado: </label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md-1">
                                    <label for="id_empleado" class="form-label">Numero de empleado</label>
                                    <input type="text" class="form-control" id="id_empleado" name="id_empleado" minlength="4" maxlength="4" required>
                                </div>
                                <div class="col-md-1">
                                    <label for="ingreso" class="form-label">Fecha de ingreso</label>
                                    <input type="date" class="form-control" id="ingreso" name="ingreso" required>
                                </div>
                                 <div class="col-md-1">
                                    <label for="Genero" class="form-label">Genero del trabajador</label>
                                   <select id="Genero" name="Genero" class="form-select">
                                    <option selected>Choose...</option>
                                    <option value="H">Hombre</option>
                                    <option value="M">Mujer</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="area" class="form-label">Area de trabajo</label>
                                   <select id="area" name="area" class="form-select">
                                    <option selected>Choose...</option>
                                      <option value="Ingenieria">Ingenieria</option>
                    <option value="Corte">Corte</option>
                    <option value="Ensamble">Ensamble</option>
                    <option value="Servicio al cliente">Servicio al cliente</option>
                    <option value="Liberacion">Liberacion</option>
                    <option value="Almacen">Almacen</option>
                    <option value="Calidad">Calidad</option>
                    <option value="Comercio Internacional">Comercio Internacional</option>
                    <option value="Embarques">Embarques</option>
                    <option value="Limpieza">Limpieza</option>
                    <option value="Mantenimiento">Mantenimiento</option>
                    <option value="Materiales">Materiales</option>
                    <option value="Vigilancia">Vigilancia</option>
                    <option value="EMBARQUE">EMBARQUE</option>
                    <option value="PRODUCCION">PRODUCCION</option>
                    <option value="Finanzas">Finanzas</option>
                    <option value="Compras">Compras</option>
                    <option value="Enfermeria">Enfermeria</option>
                    <option value="Planeacion">Planeacion</option>
                    <option value="RECURSOS HUMANOS">RECURSOS HUMANOS</option>
                    <option value="Nomina">Nomina</option>
                    <option value="Operaciones">Operaciones</option>
                    <option value="PPAP">PPAP</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="lider" class="form-label">Lider de empleado</label>
                                   <select id="lider" name="lider" class="form-select">
                                    <option selected >Choose...</option>
                                     <option value="Jesus_C">Jesus_C</option>
                    <option value="Juan G">Juan G</option>
                    <option value="Chava Cort">Chava Cort</option>
                    <option value="Juan O">Juan O</option>
                    <option value="Jessi_S">Jessi_S</option>
                    <option value="David V">David V</option>
                    <option value="Saul">Saul</option>
                    <option value="loom.manue">loom.manue</option>
                    <option value="Angel_G">Angel_G</option>
                    <option value="Gamboa J">Gamboa J</option>
                    <option value="Andrea P">Andrea P</option>
                    <option value="Efrain V">Efrain V</option>
                    <option value="Edward M">Edward M</option>
                    <option value="Luis R">Luis R</option>
                    <option value="Rocio F">Rocio F</option>
                    <option value="Paco G">Paco G</option>
                    <option value="Paola A">Paola A</option>
                    <option value="Javier C">Javier C</option>
                                    </select>
                                </div>
                                  <div class="col-md-1">
                                    <label for="tipoDeTrabajador" class="form-label">Tipo de empleado</label>
                                   <select id="tipoDeTrabajador" name="tipoDeTrabajador" class="form-select">
                                    <option selected >Choose...</option>
                                    <option value="Directo">Directo</option><option value="Indirecto">Indirecto</option>
                    <option value="Practicante">Practicante</option>
                                    </select>
                                </div>

                                <div class="col-1">
                                    <button type="submit" class="btn btn-primary">Sign in</button>
                                </div>
                            </form>
                        </div>
                        <div id="modificarEmpleado">
                                <hr>
                                <div class= "row g-3">
                                <div class="col-md-2">
                                <label for="nombreEmpleado" class="form-label">Buscar empleado: </label><input type="text" name="nombreEmpleado" id="nombreEmpleado" onchange="buscarempleado()"></div>
                                <hr>
                                <div id="datos"></div>

                                </div>
                        </div>
                        @endif
                    </div>
                </div>
                    <div class="card-body" style="overflow-y: auto; " >
                        <div class="row">

                            <div class="col-md-12">
                                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>

                                    <th id="OK">OK = Asistencia</th>
                                    <th id="F">F = Falta</th>
                                    <th id="PSS">PSS = Permiso sin gose</th>
                                    <th id="PCS">PCS = Permiso con gose</th>
                                    <th id="INC">INC = Incapacidad</th>
                                    </tr>
                                    <tr>
                                    <th id="V">V = Vacaciones</th>
                                    <th id="R">R = Retardo</th>
                                    <th id="SUS">SUS = Suspension</th>
                                    <th id="PCT">PCT = Practicante</th>

                                    </tr>
                                </thead>
                            </table>


                            </div>
                        </div>
                        <br>
                        <hr>
                               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                   <thead>
                                       <tr>

                                          @if($cat == "RRHH" or $cat == "SupAdmin")
                                            <th>Empleado</th>
                                            <th>lunes</th><th>extras lunes</th> <th>martes</th><th>extras martes</th>
                                            <th>miercoles</th><th>extras miercoles</th>
                                            <th>jueves</th>  <th>extras jueves</th>  <th>viernes</th>
                                            <th>extras viernes</th>  <th>sabado</th>  <th>extras sabado</th>
                                            <th>domingo</th> <th>extras domingo</th> <th> bono asistencia</th>
                                            <th>bono puntualidad</th>  <th>total extras</th> <th> tiempo por tiempo</th>
                                            <th>numero de empleado</th>
                                            <th>Modificar</th>

                                       </tr>
                                   </thead>
                                   <tbody>

                                    @foreach ($datosRHWEEK as $d => $as)

                                                <tr>

                                                    <form action="{{route('updateAsistencia')}}" method="GET">
                                                    <td id="empleado">{{$as['name']}}</td>
                                                    <td id="{{ $as['lunes'] }}"><input type="text" style="max-width: 45px" name="lun[]" id="lun"   minlength="1" maxlength="3" value="{{$as['lunes']}}" {{ $diasRegistro[0] }} ></td>
                                                    <td >TE:<input type="number" style="max-width: 45px" name="extra_lun[]" id="extra_lun" value="{{$as['extLunes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[1] }}>
                                                   <hr>TT:<input type="number" style="max-width: 45px" name="tt_lunes[]" id="tt_lunes" value="{{$as['tt_lunes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[1] }}></td>
                                                    <td id="{{ $as['martes'] }}"><input type="text" style="max-width: 45px" name="mar[]" id="mar" value="{{$as['martes']}}" minlength="1" maxlength="3"   {{ $diasRegistro[1] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_mar[]" id="extra_mar" value="{{$as['extMartes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[2] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_martes[]" id="tt_martes" value="{{$as['tt_martes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[2] }}></td>
                                                    <td id="{{ $as['miercoles'] }}"><input type="text" style="max-width: 45px" name="mie[]" id="mie" value="{{$as['miercoles']}}" minlength="1" maxlength="3"   {{ $diasRegistro[2] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_mie[]" id="extra_mie" value="{{$as['extMiercoles']}}" min="0" max="30" step="0.5"  {{ $diasRegistro[3] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_miercoles[]" id="tt_miercoles" value="{{$as['tt_miercoles']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[3] }}></td>
                                                    <td id="{{ $as['jueves'] }}"><input type="text" style="max-width: 45px" name="jue[]" id="jue" value="{{$as['jueves']}}" minlength="1" maxlength="3"  {{ $diasRegistro[3] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_jue[]" id="extra_jue" value="{{$as['extJueves']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_jueves[]" id="tt_jueves" value="{{$as['tt_jueves']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}></td>
                                                    <td id="{{ $as['viernes'] }}"><input type="text" style="max-width: 45px" name="vie[]" id="vie" value="{{$as['viernes']}}"minlength="1" maxlength="3"   {{ $diasRegistro[4] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_vie[]" id="extra_vie" value="{{$as['extViernes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_viernes[]" id="tt_viernes" value="{{$as['tt_viernes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}></td>
                                                    <td id="{{ $as['sabado'] }}"><input type="text" style="max-width: 45px" name="sab[]" id="sab" value="{{$as['sabado']}}" minlength="1" maxlength="3"  {{ $diasRegistro[4] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_sab[]" id="extra_sab" value="{{$as['extSabado']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_sabado[]" id="tt_sabado" value="{{$as['tt_sabado']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}></td>
                                                    <td id="{{ $as['domingo'] }}"><input type="text" style="max-width: 45px" name="dom[]" id="dom" value="{{$as['domingo']}}" minlength="1" maxlength="3"  {{ $diasRegistro[4] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_dom[]" id="extra_dom" value="{{$as['extDomingo']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_domingo[]" id="tt_domingo" value="{{$as['tt_domingo']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}></td>
                                                    <td><input type="text" style="max-width: 45px" name="bono_asistencia[]" id="bono_asistencia" value="{{$as['bonoAsistencia']}}"   disabled></td>
                                                    <td><input type="text" style="max-width: 45px" name="bono_puntualidad[]" id="bono_puntualidad" value="{{$as['bonoPuntualidad']}}"  disabled ></td>
                                                    <td><input type="number" style="max-width: 45px" name="total_extras[]" id="total_extras" value="{{$as['extras']}}" step="0.5" disabled></td>
                                                    <td><input type="number" style="max-width: 45px" name="tiempo_por_tiempo[]" id="tiempo_por_tiempo" value="{{$as['tiempoPorTiempo']}}"disabled  step="0.5"></td>
                                                    <td><input type="text" style="max-width: 60px" name="numero_emplead[]" id="numero_emplead" value="{{$as['id_empleado']}}" disabled></td>
                                                   <td> <input type="hidden" name="numero_empleado[]" id="numero_empleado[]" value="{{$as['id_empleado']}}">
                                                  <button type="submit" name="enviar" id="enviar" class=" btn btn-primary" >Modificar</button></td>
                                                </form>
                                                </tr>
                                    @endforeach
                                    @else
                                      <th>Empleado</th>
                                            <th style="display: {{ $diasRegistros[0] }};">lunes</th><th style="display: {{ $diasRegistros[1] }};">extras lunes</th> <th style="display: {{ $diasRegistros[1] }};">martes</th><th style="display: {{ $diasRegistros[2] }};">extras martes</th>
                                            <th style="display: {{ $diasRegistros[2] }};">miercoles</th><th style="display: {{ $diasRegistros[3] }};">extras miercoles</th>
                                            <th style="display: {{ $diasRegistros[3] }};">jueves</th>  <th style="display: {{ $diasRegistros[4] }};">extras jueves</th>  <th style="display: {{ $diasRegistros[4] }};">viernes</th>
                                            <th style="display: {{ $diasRegistros[4] }};">extras viernes</th>  <th style="display: {{ $diasRegistros[4] }};">sabado</th>  <th style="display: {{ $diasRegistros[4] }};">extras sabado</th>
                                            <th style="display: {{ $diasRegistros[4] }};">domingo</th> <th style="display: {{ $diasRegistros[4] }};">extras domingo</th> <th> bono asistencia</th>
                                            <th>bono puntualidad</th>  <th>total extras</th> <th> tiempo por tiempo</th>
                                            <th>numero de empleado</th>
                                            </tr>
                                             </thead>
                                   <tbody>
                                    <form action="{{route('updateAsistencia')}}" method="GET">
                                    @foreach ($datosRHWEEK as $d => $as)
                                                <tr>

                                                      <td id="empleado">{{$as['name']}}</td>
                                                    <td id="{{ $as['lunes'] }}"><input type="text" style="max-width: 45px" name="lun[]" id="lun"   minlength="1" maxlength="3" value="{{$as['lunes']}}" {{ $diasRegistro[0] }} ></td>
                                                    <td >TE:<input type="number" style="max-width: 45px" name="extra_lun[]" id="extra_lun" value="{{$as['extLunes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[1] }}>
                                                   <hr>TT:<input type="number" style="max-width: 45px" name="tt_lunes[]" id="tt_lunes" value="{{$as['tt_lunes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[1] }}></td>
                                                    <td id="{{ $as['martes'] }}"><input type="text" style="max-width: 45px" name="mar[]" id="mar" value="{{$as['martes']}}" minlength="1" maxlength="3"   {{ $diasRegistro[1] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_mar[]" id="extra_mar" value="{{$as['extMartes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[2] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_martes[]" id="tt_martes" value="{{$as['tt_martes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[2] }}></td>
                                                    <td id="{{ $as['miercoles'] }}"><input type="text" style="max-width: 45px" name="mie[]" id="mie" value="{{$as['miercoles']}}" minlength="1" maxlength="3"   {{ $diasRegistro[2] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_mie[]" id="extra_mie" value="{{$as['extMiercoles']}}" min="0" max="30" step="0.5"  {{ $diasRegistro[3] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_miercoles[]" id="tt_miercoles" value="{{$as['tt_miercoles']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[3] }}></td>
                                                    <td id="{{ $as['jueves'] }}"><input type="text" style="max-width: 45px" name="jue[]" id="jue" value="{{$as['jueves']}}" minlength="1" maxlength="3"  {{ $diasRegistro[3] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_jue[]" id="extra_jue" value="{{$as['extJueves']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_jueves[]" id="tt_jueves" value="{{$as['tt_jueves']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}></td>
                                                    <td id="{{ $as['viernes'] }}"><input type="text" style="max-width: 45px" name="vie[]" id="vie" value="{{$as['viernes']}}"minlength="1" maxlength="3"   {{ $diasRegistro[4] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_vie[]" id="extra_vie" value="{{$as['extViernes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_viernes[]" id="tt_viernes" value="{{$as['tt_viernes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}></td>
                                                    <td id="{{ $as['sabado'] }}"><input type="text" style="max-width: 45px" name="sab[]" id="sab" value="{{$as['sabado']}}" minlength="1" maxlength="3"  {{ $diasRegistro[4] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_sab[]" id="extra_sab" value="{{$as['extSabado']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_sabado[]" id="tt_sabado" value="{{$as['tt_sabado']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}></td>
                                                    <td id="{{ $as['domingo'] }}"><input type="text" style="max-width: 45px" name="dom[]" id="dom" value="{{$as['domingo']}}" minlength="1" maxlength="3"  {{ $diasRegistro[4] }}></td>
                                                    <td>TE:<input type="number" style="max-width: 45px" name="extra_dom[]" id="extra_dom" value="{{$as['extDomingo']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}>
                                                    <hr>TT:<input type="number" style="max-width: 45px" name="tt_domingo[]" id="tt_domingo" value="{{$as['tt_domingo']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }}></td>
                                                    <td><input type="text" style="max-width: 45px" name="bono_asistencia[]" id="bono_asistencia" value="{{$as['bonoAsistencia']}}"   disabled></td>
                                                    <td><input type="text" style="max-width: 45px" name="bono_puntualidad[]" id="bono_puntualidad" value="{{$as['bonoPuntualidad']}}"  disabled ></td>
                                                    <td><input type="number" style="max-width: 45px" name="total_extras[]" id="total_extras" value="{{$as['extras']}}" step="0.5" disabled ></td>
                                                    <td><input type="number" style="max-width: 45px" name="tiempo_por_tiempo[]" id="tiempo_por_tiempo" value="{{$as['tiempoPorTiempo']}}"disabled  step="0.5"></td>
                                                    <td><input type="text" style="max-width: 60px" name="numero_emplead[]" id="numero_emplead" value="{{$as['id_empleado']}}" disabled></td>
                                                   <td> <input type="hidden" name="numero_empleado[]" id="numero_empleado[]" value="{{$as['id_empleado']}}">     </tr>
                                    @endforeach
                                    <div>
                                     <button type="submit" name="enviar" id="enviar" class=" btn btn-primary" >Modificar</button>
                                     </div>
                                                </form>
                                    @endif

                                   </tbody>
                               </table>

                    </div>
    </div>
</div>
<script>
    function addEmpleado() {
        if(document.getElementById("AddPersonal").style.display == "none"){
            document.getElementById("AddPersonal").style.display = "block";
            return;
        }else{
            document.getElementById("AddPersonal").style.display = "none";
        }

    }
    function modificarEmpleado() {
        if(document.getElementById("modificarEmpleado").style.display == "none"){
            document.getElementById("modificarEmpleado").style.display = "block";
            return;
        }else{
            document.getElementById("modificarEmpleado").style.display = "none";
        }
    }
    function buscarempleado() {
      let  dato=document.getElementById("nombreEmpleado").value;
      console.log(dato);
      const url = "{{ route('modificarEmpleado') }}";
      const codigoValue = dato;
      fetch(url, { method: 'POST',
                    headers: {   'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  },
                    body: JSON.stringify({ dato: codigoValue }),   })
                .then(response => response.json())
                .then(data => {  console.log(data);
                       const registros = document.getElementById('datos');
        let table = "<table class='table table-striped' style='width:100%'><thead><tr><th>Nombre</th><th>Numero de empleado</th><th>Lider</th><th>Area</th><th>Genero</th><th>Estado</th><th>Tipo</th><th>Editar</th></tr> </thead><tbody>";

        for (let i = 0; i < data.length; i++) {
            const emp = data[i];

            table += `
            <form action="{{ route('modificarEmpleado') }}" method="POST">
            <tr>
                <td><input type="text" id="nameEmployee_${emp.employeeNumber}" maxlength="45" minlength="9" value="${emp.employeeName}"></td>
                <td><input type="text" id="id_employee_${emp.employeeNumber}" maxlength="4" minlength="4" value="${emp.employeeNumber.substring(1, 5)}"></td>
                <td>
                    <select id="lider_${emp.employeeNumber}" >
                        <option value="${emp.employeeLider}"> Actual ${emp.employeeLider}</option>
                           <option value="Jesus_C">Jesus_C</option>
                    <option value="Juan G">Juan G</option>
                    <option value="Chava Cort">Chava Cort</option>
                    <option value="Juan O">Juan O</option>
                    <option value="Jessi_S">Jessi_S</option>
                    <option value="David V">David V</option>
                    <option value="Saul">Saul</option>
                    <option value="loom.manue">loom.manue</option>
                    <option value="Angel_G">Angel_G</option>
                    <option value="Gamboa J">Gamboa J</option>
                    <option value="Andrea P">Andrea P</option>
                    <option value="Efrain V">Efrain V</option>
                    <option value="Edward M">Edward M</option>
                    <option value="Luis R">Luis R</option>
                    <option value="Rocio F">Rocio F</option>
                    <option value="Paco G">Paco G</option>
                    <option value="Paola A">Paola A</option>
                    <option value="Javier C">Javier C</option>
                    </select>
                </td>
                <td>
                    <select id="area_${emp.employeeNumber}">
                        <option value="${emp.employeeArea}">Actual ${emp.employeeArea}</option>
                        <option value="Ingenieria">Ingenieria</option>
                    <option value="Corte">Corte</option>
                    <option value="Ensamble">Ensamble</option>
                    <option value="Servicio al cliente">Servicio al cliente</option>
                    <option value="Liberacion">Liberacion</option>
                    <option value="Almacen">Almacen</option>
                    <option value="Calidad">Calidad</option>
                    <option value="Comercio Internacional">Comercio Internacional</option>
                    <option value="Embarques">Embarques</option>
                    <option value="Limpieza">Limpieza</option>
                    <option value="Mantenimiento">Mantenimiento</option>
                    <option value="Materiales">Materiales</option>
                    <option value="Vigilancia">Vigilancia</option>
                    <option value="EMBARQUE">EMBARQUE</option>
                    <option value="PRODUCCION">PRODUCCION</option>
                    <option value="Finanzas">Finanzas</option>
                    <option value="Compras">Compras</option>
                    <option value="Enfermeria">Enfermeria</option>
                    <option value="Planeacion">Planeacion</option>
                    <option value="RECURSOS HUMANOS">RECURSOS HUMANOS</option>
                    <option value="Nomina">Nomina</option>
                    <option value="Operaciones">Operaciones</option>
                    <option value="PPAP">PPAP</option>

                    </select>
                </td>
                <td>
                    <select id="genero_${emp.employeeNumber}">
                        <option value="${emp.Gender}">Actual ${emp.Gender}</option>
                        <option value="M">M</option><option value="H">H</option>
                    </select>
                </td>
                <td>
                    <select id="status_${emp.employeeNumber}">
                        <option value="${emp.status}">Actual ${emp.status}</option>
                        <option value="Activo">Activo</option>
                          <option value="Baja">Baja</option><option value="Incapacidad">Incapacidad</option>
                    <option value="Suspension">Suspension</option>
                    <option value="Permiso temporal con gose">Permiso temporal con gose</option>
                    <option value="Permiso temporal sin gose">Permiso temporal sin gose</option>
                    </select>
                </td>
                <td>
                    <select id="typeWorker_${emp.employeeNumber}">
                        <option value="${emp.typeWorker}"> Actual ${emp.typeWorker}</option>
                           <option value="Directo">Directo</option><option value="Indirecto">Indirecto</option>
                    <option value="Practicante">Practicante</option>
                    </select>
                </td>
                <td>
                <button class="btn btn-primary" type="button" onclick="altaEmpleado('${emp.employeeNumber}')">Editar</button>
                </td>
            </tr>
            </form>`;
        }
        table += "</tbody></table>";

        registros.innerHTML = table;


                })
                .catch(error => { console.error('Error:', error);  });
            }

        function altaEmpleado(valor){
            const url = "{{ route('editarEmepleado') }}";

            const nameEmployee = document.getElementById("nameEmployee_"+valor).value;
            const id_employee = document.getElementById("id_employee_"+valor).value;
            const lider = document.getElementById("lider_"+valor).value;
            const area = document.getElementById("area_"+valor).value;
            const genero = document.getElementById("genero_"+valor).value;
            const status = document.getElementById("status_"+valor).value;
            const typeWorker = document.getElementById("typeWorker_"+valor).value;

            const codigoValue = {
                valor: valor,
                nameEmployee: nameEmployee,
                id_employee: id_employee,
                lider: lider,
                area: area,
                genero: genero,
                status: status,
                typeWorker: typeWorker
            };
            console.log(codigoValue);

            fetch(url, { method: 'POST',
                headers: {   'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  },
                body: JSON.stringify({ nameEmployee: nameEmployee,valor: valor,
                id_employee: id_employee,
                lider: lider,
                area: area,
                genero: genero,
                status: status,
                typeWorker: typeWorker }),   })
                .then(response => response.json())
                .then(data => {  console.log(data);
                    alert(data);
                    window.location.reload();

                })
                .catch(error => { console.error('Error:', error);  });



        }



</script>

@endsection
