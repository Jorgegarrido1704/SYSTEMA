@extends(   'layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

<!-- First Period -->
<div class="row">
    <div class="col-lg-12 col-lx-12 mb-4">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Modificaciones de Registos </h5>
                    </div>
                </div>
                    <div class="card-body" style="overflow-y: auto; " >

                               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                   <thead>
                                       <tr>
                                            <th>Empleado</th>
                                            <th>lunes</th><th>extras lunes</th> <th>martes</th><th>extras martes</th>
                                            <th>miercoles</th><th>extras miercoles</th>
                                            <th>jueves</th>  <th>extras jueves</th>  <th>viernes</th>
                                            <th>extras viernes</th>  <th>sabado</th>  <th>extras sabado</th>
                                            <th>domingo</th> <th>extras domingo</th> <th> bono asistencia</th>
                                            <th> bono puntualidad</th>  <th>total extras</th> <th> tiempo por tiempo</th>
                                            <th>numero de empleado</th>

                                       </tr>
                                   </thead>
                                   <tbody>
                                    <form action="{{route('updateAsistencia')}}" method="GET">
                                    @foreach ($datosRHWEEK as $d => $as)

                                                <tr>

                                                    <td>{{$as['name']}}</td>
                                                    <td><input type="text" style="max-width: 40px" name="lun[]" id="lun" value="{{$as['lunes']}}" minlength="1" maxlength="3" {{ $diasRegistro[0] }} ></td>
                                                    <td><input type="number" style="max-width: 40px" name="extra_lun[]" id="extra_lun" value="{{$as['extLunes']}}"  min="0" max="30" {{ $diasRegistro[1] }}></td>
                                                    <td><input type="text" style="max-width: 40px" name="mar[]" id="mar" value="{{$as['martes']}}" minlength="1" maxlength="3"   {{ $diasRegistro[1] }}></td>
                                                    <td><input type="number" style="max-width: 40px" name="extra_mar[]" id="extra_mar" value="{{$as['extMartes']}}"  min="0" max="30" {{ $diasRegistro[2] }}></td>
                                                    <td><input type="text" style="max-width: 40px" name="mie[]" id="mie" value="{{$as['miercoles']}}" minlength="1" maxlength="3"   {{ $diasRegistro[2] }}></td>
                                                    <td><input type="number" style="max-width: 40px" name="extra_mie[]" id="extra_mie" value="{{$as['extMiercoles']}}" min="0" max="30"  {{ $diasRegistro[3] }}></td>
                                                    <td><input type="text" style="max-width: 40px" name="jue[]" id="jue" value="{{$as['jueves']}}" minlength="1" maxlength="3"  {{ $diasRegistro[3] }}></td>
                                                    <td><input type="number" style="max-width: 40px" name="extra_jue[]" id="extra_jue" value="{{$as['extJueves']}}"  min="0" max="30" {{ $diasRegistro[4] }}></td>
                                                    <td><input type="text" style="max-width: 40px" name="vie[]" id="vie" value="{{$as['viernes']}}"minlength="1" maxlength="3"   {{ $diasRegistro[4] }}></td>
                                                    <td><input type="number" style="max-width: 40px" name="extra_vie[]" id="extra_vie" value="{{$as['extViernes']}}"  min="0" max="30" {{ $diasRegistro[4] }}></td>
                                                    <td><input type="text" style="max-width: 40px" name="sab[]" id="sab" value="{{$as['sabado']}}" minlength="1" maxlength="3"  {{ $diasRegistro[4] }}></td>
                                                    <td><input type="number" style="max-width: 40px" name="extra_sab[]" id="extra_sab" value="{{$as['extSabado']}}"  min="0" max="30" {{ $diasRegistro[4] }}></td>
                                                    <td><input type="text" style="max-width: 40px" name="dom[]" id="dom" value="{{$as['domingo']}}" minlength="1" maxlength="3"  {{ $diasRegistro[4] }}></td>
                                                    <td><input type="number" style="max-width: 40px" name="extra_dom[]" id="extra_dom" value="{{$as['extDomingo']}}"  min="0" max="30" {{ $diasRegistro[4] }}></td>
                                                    <td><input type="text" style="max-width: 40px" name="bono_asistencia[]" id="bono_asistencia" value="{{$as['bonoAsistencia']}}"   disabled></td>
                                                    <td><input type="text" style="max-width: 40px" name="bono_puntualidad[]" id="bono_puntualidad" value="{{$as['bonoPuntualidad']}}"  disabled ></td>
                                                    <td><input type="number" style="max-width: 40px" name="total_extras[]" id="total_extras" value="{{$as['extras']}}" disabled></td>
                                                    <td><input type="number" style="max-width: 40px" name="tiempo_por_tiempo[]" id="tiempo_por_tiempo" value="{{$as['tiempoPorTiempo']}}"disabled ></td>
                                                    <td><input type="text" style="max-width: 60px" name="numero_emplead[]" id="numero_emplead" value="{{$as['id_empleado']}}" disabled></td>
                                                    <input type="hidden" name="numero_empleado[]" id="numero_empleado[]" value="{{$as['id_empleado']}}">
                                                </tr>
                                    @endforeach
                                    <div class="form-group">


                                    <button type="submit" name="enviar" id="enviar" class=" btn btn-primary" >Modificar</button>
                                    </div>
                                                </form>
                                   </tbody>
                               </table>

                    </div>
    </div>
</div>
@endsection
