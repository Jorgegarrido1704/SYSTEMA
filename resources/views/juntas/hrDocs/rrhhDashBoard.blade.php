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
                                    @foreach ($datosRHWEEK as $d => $val)
                                       <tr>
                                           <td>{{ $val['name'] }}</td><td>{{ $val['lunes'] }}</td><td>{{ $val['extLunes'] }}</td>
                                           <td>{{ $val['martes'] }}</td><td>{{ $val['extMartes'] }}</td>
                                           <td>{{ $val['miercoles'] }}</td><td>{{ $val['extMiercoles'] }}</td>
                                           <td>{{ $val['jueves'] }}</td><td>{{ $val['extJueves'] }}</td>
                                           <td>{{ $val['viernes'] }}</td><td>{{ $val['extViernes'] }}</td>
                                           <td>{{ $val['sabado'] }}</td><td>{{ $val['extSabado'] }}</td>
                                           <td>{{ $val['domingo'] }}</td><td>{{ $val['extDomingo'] }}</td>
                                           <td>{{ $val['bonoAsistencia'] }}</td><td>{{ $val['bonoPuntualidad'] }}</td>
                                           <td>{{ $val['extras'] }}</td><td>{{ $val['tiempoPorTiempo'] }}</td>
                                           <td>{{ $val['id_empleado'] }}</td>
                                       
                                       </tr>
                                       @endforeach
                                   </tbody>
                               </table>

                    </div>
    </div>
</div>
@endsection
