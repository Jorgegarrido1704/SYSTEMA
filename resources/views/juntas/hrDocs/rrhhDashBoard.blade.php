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
                                    @foreach ($datosRHWEEK as $d => $as)
                                                <tr>
                                                    <td>{{$as['name']}}</td>
                                                    <td><input type="text" style="max-width: 40px" name="lun[]" id="lun" value="{{$as['lunes']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="extra_lun[]" id="extra_lun" value="{{$as['extLunes']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="mar[]" id="mar" value="{{$as['martes']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="extra_mar[]" id="extra_mar" value="{{$as['extMartes']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="mie[]" id="mie" value="{{$as['miercoles']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="extra_mie[]" id="extra_mie" value="{{$as['extMiercoles']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="jue[]" id="jue" value="{{$as['jueves']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="extra_jue[]" id="extra_jue" value="{{$as['extJueves']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="vie[]" id="vie" value="{{$as['viernes']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="extra_vie[]" id="extra_vie" value="{{$as['extViernes']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="sab[]" id="sab" value="{{$as['sabado']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="extra_sab[]" id="extra_sab" value="{{$as['extSabado']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="dom[]" id="dom" value="{{$as['domingo']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="extra_dom[]" id="extra_dom" value="{{$as['extDomingo']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="bono_asistencia[]" id="bono_asistencia" value="{{$as['bonoAsistencia']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="bono_puntualidad[]" id="bono_puntualidad" value="{{$as['bonoPuntualidad']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="total_extras[]" id="total_extras" value="{{$as['extras']}}" ></td>
                                                    <td><input type="text" style="max-width: 40px" name="tiempo_por_tiempo[]" id="tiempo_por_tiempo" value="{{$as['tiempoPorTiempo']}}" ></td>
                                                    <td><input type="text" style="max-width: 60px" name="numero_empleado[]" id="numero_empleado" value="{{$as['id_empleado']}}" disabled></td>
                                                </tr>
                                    @endforeach
                                   </tbody>
                               </table>

                    </div>
    </div>
</div>
@endsection
