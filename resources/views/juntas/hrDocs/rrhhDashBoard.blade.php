@extends(   'layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

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
        </style>

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Modificaciones de Registos </h5>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal" id="ad" ></button>
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
@endsection
