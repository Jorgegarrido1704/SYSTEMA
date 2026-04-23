@extends(   'layouts.main')

@section('contenido')
<meta http-equiv="refresh" content="180">
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
<script>const Error = {{ json_encode(session('error')) }};
if (Error) {
    alert(Error);}
</script>
<!-- First Period -->
<div class="row">
    <div class="col-lg-12 col-lx-12 mb-4">
        <style>
            #OK {background-color: rgba(76, 175, 80, 0.5); color: black;}
            #F{background-color: rgba(255, 47, 47, 0.75); color: black;}
            #PSS{background-color: rgba(237, 142, 1, 0.75); color: black;}
            #PCS{background-color: rgba(237, 142, 1, 0.8); color: black;}
            #INC{background-color: rgba(253, 207, 71, 0.84); color: black;}
            #V{background-color: rgba(73, 50, 204, 0.5); color: black;}
            #R{background-color: rgba(245, 13, 129, 0.35);color: black;}
            #SUS{background-color: rgba(100, 9, 9, 0.81); color: black;}
            #PCT{background-color: rgba(103, 95, 95, 0.35); color: black;}
            #TSP{background-color: rgba(247, 130, 159, 0.35); color: black;}
            #empleado{background-color: rgba(255, 255, 255, 0.5); color: black; font-weight: bold; font-size: 16px;}
            #ASM{background-color: rgba(102, 33, 146, 0.5); color: black; font-weight: bold; font-size: 16px;}
            #SCE{background-color: rgba(239, 3, 164, 0.5); color: black; font-weight: bold; font-size: 16px;}
            #HE{background-color: rgba(3, 239, 145, 0.5); color: black; font-weight: bold; font-size: 16px;}
            #AddPersonal,#modificarEmpleado{display: none; }
            #N{background-color: rgba(0, 0, 0, 0.5); color: white; font-weight: bold; font-size: 16px; }
        </style>


                <div class="card shadow mb-5 item-center">
                    <div class="card-header py-3 text-center">
                        <h5 class="m-0 font-weight-bold text-primary">{{__('Employee Data Modification') }}</h5>
                        @if($cat != "RRHH" and $cat != "SupAdmin")
                        <div class="row">
                             @php
                                                            $semanal1=$weekNum;
                                                            $semanal2=$weekNum;
                                                        @endphp
                            <div class="col-md-2">
                                 <form class="row g-3" action="{{ route('exportarListaAsistenciaIndividual') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                        <label for="semana" class="form-label">{{__('Assistance List') }}</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                        <select name="numeroSemanaIncidencias" id="numeroSemanaIncidencias" class="form-control" required>
                                            <option value="" disabled selected> {{ __('Select a Work Week') }}</option>
                                            @for($semanal2; $semanal2>=1 ; $semanal2--)
                                            <option value="{{$semanal2}}">{{ __('Week') }} {{$semanal2}}</option>
                                            @endfor
                                        </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-primary">{{ __('Incidence List') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                          @elseif($cat == "RRHH" or $cat == "SupAdmin")
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addModal" id="addPersonal" onclick="addEmpleado();" >{{ __('Add') }} {{ __('Employee') }}</button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#addModal" id="modificarEmpleados" onclick="modificarEmpleado();">{{ __('Modify') }} {{ __('Employee') }}</button>
                       <!-- //reportes de RRHH -->
                        <div class="row">
                            <div class="col-md-6">
                                <form class="row g-3" action="{{ route('excelRelogChecador') }}" method="POST">
                                            @csrf
                                               <div class="row">

                                                    <div class="form-group col-md-12">
                                                    <label for="semana" class="form-label">{{ __('log Checker Report') }}</label>
                                                    </div>
                                                     <div class="form-group col-md-12">
                                                    <select name="semana" id="semana" class="form-control" required>
                                                        <option value="" disabled selected> {{ __('Select a Work Week') }}</option>
                                                        @php
                                                            $semanal1=$weekNum;
                                                            $semanal2=$weekNum;
                                                        @endphp
                                                        @for($semanal1; $semanal1>=1 ; $semanal1--)
                                                        <option value="{{$semanal1}}">{{ __('Week') }} {{$semanal1}}</option>
                                                        @endfor
                                                    </select>
                                                     </div>
                                                    <div class="form-group col-md-12">
                                                        <button type="submit" class="btn btn-primary">{{ __('Report') }}</button>
                                                    </div>
                                                </div>


                                </form>
                            </div>
                            <div class="col-md-6">
                                <form class="row g-3" action="{{ route('exportarListaAsistencia') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                        <label for="semana" class="form-label">{{__('Assistance List') }}</label>
                                        </div>
                                        <div class="form-group col-md-12">
                                        <select name="numeroSemanaIncidencias" id="numeroSemanaIncidencias" class="form-control" required>
                                            <option value="" disabled selected> {{__('Select a Work Week') }}</option>
                                            @for($semanal2; $semanal2>=1 ; $semanal2--)
                                            <option value="{{$semanal2}}">{{ __('Week') }} {{$semanal2}}</option>
                                            @endfor
                                        </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-primary">{{ __('Incidence List') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                       <!-- //ocultos de modal -->
                        <div id ="AddPersonal" >
                           <form class="row g-3" action="{{ route('addperson') }}" method="POST">
                            @csrf
                                <div class="col-md-2">
                                    <label for="nombre" class="form-label">{{ ('Employee Name') }}: </label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="id_empleado" class="form-label">{{ ('Employee ID') }}</label>
                                    <input type="text" class="form-control" id="id_empleado" name="id_empleado" minlength="4" maxlength="4" required>
                                </div>
                                <div class="col-md-1">
                                    <label for="ingreso" class="form-label">{{__('Joining Date') }}</label>
                                    <input type="date" class="form-control" id="ingreso" name="ingreso" required>
                                </div>
                                 <div class="col-md-1">
                                    <label for="Genero" class="form-label">{{__('Gender') }}</label>
                                   <select id="Genero" name="Genero" class="form-select">
                                    <option selected disabled>{{ __('Choose') }}...</option>
                                    <option value="H">{{__('Man') }}</option>
                                    <option value="M">{{__('Woman') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="area" class="form-label">{{__('Work Area') }}</label>
                                   <select id="area" name="area" class="form-select">
                                    <option selected disabled>{{ __('Choose') }}...</option>
                                    <option value="Ingenieria">{{__('Engineering') }}</option>
                                    <option value="Corte">{{__('Cut') }}</option>
                                    <option value="Ensamble">{{__('Assembly') }}</option>
                                    <option value="Servicio al cliente">{{__('Customer Service') }}</option>
                                    <option value="Liberacion">{{__('Release') }}</option>
                                    <option value="Almacen">{{__('Warehouse') }}</option>
                                    <option value="Calidad">{{__('Quality') }}</option>
                                    <option value="Comercio Internacional">{{__('International Trade') }}</option>
                                    <option value="Embarques">{{__('Shipping') }}</option>
                                    <option value="Limpieza">{{__('Cleaning') }}</option>
                                    <option value="Mantenimiento">{{__('Maintenance') }}</option>
                                    <option value="Materiales">{{__('Materials') }}</option>
                                    <option value="Vigilancia">{{__('Security') }}</option>
                                    <option value="EMBARQUE">{{__('Shipping') }}</option>
                                    <option value="PRODUCCION">{{__('Production') }}</option>
                                    <option value="Finanzas">{{__('Finance') }}</option>
                                    <option value="Compras">{{__('Purchases') }}</option>
                                    <option value="Enfermeria">{{__('Nursing') }}</option>
                                    <option value="Planeacion">{{__('Planning') }}</option>
                                    <option value="RECURSOS HUMANOS">{{__('Human Resources') }}</option>
                                    <option value="Nomina">{{__('Payroll') }}</option>
                                    <option value="Operaciones">{{__('Operations') }}</option>
                                    <option value="PPAP">{{__('PPAP') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label for="lider" class="form-label">{{__('Employee List') }}</label>
                                   <select id="lider" name="lider" class="form-select">
                                    <option selected >{{ __('Choose') }}...</option>
                                       @foreach ($lidername as $lider)
                                        <option value="{{ $lider->employeeLider }}">{{ $lider->employeeLider }}</option>
                                       @endforeach
                                    </select>
                                </div>
                                  <div class="col-md-1">
                                    <label for="tipoDeTrabajador" class="form-label">{{__('Employee Type') }}</label>
                                   <select id="tipoDeTrabajador" name="tipoDeTrabajador" class="form-select">
                                        <option selected >{{ __('Choose') }}...</option>
                                        <option value="Directo">{{__('Direct') }}</option>
                                        <option value="Indirecto">{{__('Indirect') }}</option>
                                        <option value="Practicante">{{__('Intern') }}</option>
                                        <option value="Asimilado">{{__('Assimilated') }}</option>
                                        <option value="Servicio comprado">{{__('Purchased Service') }}</option>
                                    </select>
                                </div>

                                <div class="col-1">
                                    <button type="submit" class="btn btn-primary">{{__('Add Employee') }}</button>
                                </div>
                            </form>
                        </div>
                        <div id="modificarEmpleado">
                                <hr>
                                    <div class= "row g-3">
                                    <div class="col-md-2">
                                    <label for="nombreEmpleado" class="form-label">{{__('Search Employee') }}: </label><input type="text" name="nombreEmpleado" id="nombreEmpleado" onchange="buscarempleado()"></div>
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

                                        <th id="OK">OK = {{ __('Assistence') }}</th>
                                        <th id="F">F = {{ __('Absents') }}</th>
                                        <th id="PSS">PSS = {{ __('Permission Without Salary') }}</th>
                                        <th id="PCS">PCS = {{ __('Permission With Salary') }}</th>
                                        <th id="INC">INC = {{ __('Disability') }}</th>
                                        </tr>
                                        <tr>
                                        <th id="V">V = {{ __('Holidays') }}</th>
                                        <th id="R">R = {{ __('Late') }}</th>
                                        <th id="SUS">SUS = {{ __('Suspension') }}</th>
                                        <th id="PCT">PCT = {{ __('Intern') }}</th>
                                        <th id="TSP">TSP = {{ __('Time Off') }}</th>
                                        </tr>
                                        <tr>
                                        <th id="ASM">ASM = {{ __('Assimilated') }}</th>
                                        <th id="SCE">SCE = {{ __('Purchased Service') }}</th>
                                        <th id="HE">HE = {{ __('Special Schedule') }}</th>
                                        <th id="N">N = {{ __('Nocturn') }}</th>
                                        <th id=""></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <h6>* {{ __('Attendance must be registered before 8:20 a.m.') }} </h6>
                                <h6>* {{ __('Overtime and time-for-time hours must be logged before 12:00 AM') }} </h6>
                                <h6>* {{ __('Overtime hours worked on Friday, Saturday, and Sunday must be recorded on Mondays before 10:00 AM. The attendance list for the previous week can be found at the bottom of this page.') }} </h6>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>

                                                    @if($cat == "RRHH" or $cat == "SupAdmin")
                                                        <th>{{ __('Employee') }}</th>
                                                        <th>{{ __('Monday') }}</th><th>{{ __('OverTime') }}</th> <th>{{ __('Tuesday') }}</th><th>{{ __('OverTime') }}</th>
                                                        <th>{{ __('Wednesday') }}</th><th>{{ __('OverTime') }}</th>
                                                        <th>{{ __('Thursday') }}</th>  <th>{{ __('OverTime') }}</th>  <th>{{ __('Friday') }}</th>
                                                        <th>{{ __('OverTime') }}</th>  <th>{{ __('Saturday') }}</th>  <th>{{ __('OverTime') }}</th>
                                                        <th>{{ __('Sunday') }}</th> <th>{{ __('OverTime') }}</th> <th> {{ __('Attendance Bonus') }}</th>
                                                        <th>{{ __('Punctuality Bonus') }}</th>  <th>{{ __('Total Extras') }}</th> <th> {{ __('Time-for-Time') }} </th>
                                                        <th>{{ __('Employee ID') }}</th>
                                                        <th>{{ __('Modify') }}</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($datosRHWEEK as $d => $as)

                                                            <tr>

                                                                <form action="{{route('updateAsistencia')}}" method="GET">
                                                                <td id="empleado">{{$as['name']}}</td>
                                                                <td id="{{ $as['lunes'] }}"><input type="text" style="max-width: 45px" name="lun[]" id="lun"   minlength="1" maxlength="3" value="{{$as['lunes']}}" {{ $diasRegistro[0] }} ></td>
                                                                <td >TE:<input type="number" style="max-width: 45px" name="extra_lun[]" id="extra_lun" value="{{$as['extLunes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[1] }} required>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_lunes[]" id="tt_lunes" value="{{$as['tt_lunes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[1] }} required></td>
                                                                <td id="{{ $as['martes'] }}"><input type="text" style="max-width: 45px" name="mar[]" id="mar" value="{{$as['martes']}}" minlength="1" maxlength="3"   {{ $diasRegistro[1] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_mar[]" id="extra_mar" value="{{$as['extMartes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[2] }} required>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_martes[]" id="tt_martes" value="{{$as['tt_martes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[2] }} required></td>
                                                                <td id="{{ $as['miercoles'] }}"><input type="text" style="max-width: 45px" name="mie[]" id="mie" value="{{$as['miercoles']}}" minlength="1" maxlength="3"   {{ $diasRegistro[2] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_mie[]" id="extra_mie" value="{{$as['extMiercoles']}}" min="0" max="30" step="0.5"  {{ $diasRegistro[3] }} required>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_miercoles[]" id="tt_miercoles" value="{{$as['tt_miercoles']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[3] }} required></td>
                                                                <td id="{{ $as['jueves'] }}"><input type="text" style="max-width: 45px" name="jue[]" id="jue" value="{{$as['jueves']}}" minlength="1" maxlength="3"  {{ $diasRegistro[3] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_jue[]" id="extra_jue" value="{{$as['extJueves']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }} required>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_jueves[]" id="tt_jueves" value="{{$as['tt_jueves']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }} required></td>
                                                                <td id="{{ $as['viernes'] }}"><input type="text" style="max-width: 45px" name="vie[]" id="vie" value="{{$as['viernes']}}"minlength="1" maxlength="3"   {{ $diasRegistro[4] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_vie[]" id="extra_vie" value="{{$as['extViernes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }} required>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_viernes[]" id="tt_viernes" value="{{$as['tt_viernes']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }} required></td>
                                                                <td id="{{ $as['sabado'] }}"><input type="text" style="max-width: 45px" name="sab[]" id="sab" value="{{$as['sabado']}}" minlength="1" maxlength="3"  {{ $diasRegistro[4] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_sab[]" id="extra_sab" value="{{$as['extSabado']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }} required>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_sabado[]" id="tt_sabado" value="{{$as['tt_sabado']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }} required></td>
                                                                <td id="{{ $as['domingo'] }}"><input type="text" style="max-width: 45px" name="dom[]" id="dom" value="{{$as['domingo']}}" minlength="1" maxlength="3"  {{ $diasRegistro[4] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_dom[]" id="extra_dom" value="{{$as['extDomingo']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }} required>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_domingo[]" id="tt_domingo" value="{{$as['tt_domingo']}}"  min="0" max="30" step="0.5" {{ $diasRegistro[4] }} required></td>
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
                                                <th>{{ __('Employee') }}</th>
                                                        <th style="display: {{ $diasRegistros[0] }};">{{__('Monday')}}</th><th style="display: {{ $diasRegistros[1] }};">{{__('OverTime')}}</th>
                                                        <th style="display: {{ $diasRegistros[1] }};">{{__('Tuesday')}}</th><th style="display: {{ $diasRegistros[2] }};">{{__('OverTime')}}</th>
                                                        <th style="display: {{ $diasRegistros[2] }};">{{__('Wednesday')}}</th><th style="display: {{ $diasRegistros[3] }};">{{__('OverTime')}}</th>
                                                        <th style="display: {{ $diasRegistros[3] }};">{{__('Thursday')}}</th>  <th style="display: {{ $diasRegistros[4] }};">{{__('OverTime')}}</th>  <th style="display: {{ $diasRegistros[4] }};">{{__('Friday')}}</th>
                                                        <th style="display: {{ $diasRegistros[4] }};">{{__('OverTime')}}</th>  <th style="display: {{ $diasRegistros[4] }};">{{__('Saturday')}}</th>  <th style="display: {{ $diasRegistros[4] }};">{{__('OverTime')}}</th>
                                                        <th style="display: {{ $diasRegistros[4] }};">{{__('Sunday')}}</th> <th style="display: {{ $diasRegistros[4] }};">{{__('OverTime')}}</th> <th> {{ __('Attendance Bonus') }}</th>
                                                        <th>{{ __('Punctuality Bonus') }}</th>  <th>{{ __('Total Extras') }}</th> <th> {{ __('Time by Time') }}</th>
                                                        <th> {{ __('Employee Number') }}</th>

                                                        </tr>
                                                        </thead>
                                            <tbody>
                                                <form action="{{route('updateAsistencia')}}" method="GET">
                                                @foreach ($datosRHWEEK as $d => $as)
                                                            <tr>

                                                                <td id="empleado">{{$as['name']}}</td>
                                                                <td id="{{ $as['lunes'] }}"><input type="text" style="max-width: 45px" name="lun[]" id="lun"   minlength="1" maxlength="3" value="{{$as['lunes']}}" {{ $diasRegistro[0] }} ></td>
                                                                <td >TE:<input type="number" style="max-width: 45px" name="extra_lun[]" id="extra_lun" value="{{$as['extLunes']}}"  min="0" max="30" step="0.5" {{ $tt[1] }}>
                                                            <hr>TT:<input type="number" style="max-width: 45px" name="tt_lunes[]" id="tt_lunes" value="{{$as['tt_lunes']}}"  min="0" max="30" step="0.5" {{ $tt[1] }}></td>
                                                                <td id="{{ $as['martes'] }}"><input type="text" style="max-width: 45px" name="mar[]" id="mar" value="{{$as['martes']}}" minlength="1" maxlength="3"   {{ $diasRegistro[1] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_mar[]" id="extra_mar" value="{{$as['extMartes']}}"  min="0" max="30" step="0.5" {{ $tt[2] }}>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_martes[]" id="tt_martes" value="{{$as['tt_martes']}}"  min="0" max="30" step="0.5" {{ $tt[2] }}></td>
                                                                <td id="{{ $as['miercoles'] }}"><input type="text" style="max-width: 45px" name="mie[]" id="mie" value="{{$as['miercoles']}}" minlength="1" maxlength="3"   {{ $diasRegistro[2] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_mie[]" id="extra_mie" value="{{$as['extMiercoles']}}" min="0" max="30" step="0.5"  {{ $tt[3] }}>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_miercoles[]" id="tt_miercoles" value="{{$as['tt_miercoles']}}"  min="0" max="30" step="0.5" {{ $tt[3] }}></td>
                                                                <td id="{{ $as['jueves'] }}"><input type="text" style="max-width: 45px" name="jue[]" id="jue" value="{{$as['jueves']}}" minlength="1" maxlength="3"  {{ $diasRegistro[3] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_jue[]" id="extra_jue" value="{{$as['extJueves']}}"  min="0" max="30" step="0.5" {{ $tt[4] }}>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_jueves[]" id="tt_jueves" value="{{$as['tt_jueves']}}"  min="0" max="30" step="0.5" {{ $tt[4] }}></td>
                                                                <td id="{{ $as['viernes'] }}"><input type="text" style="max-width: 45px" name="vie[]" id="vie" value="{{$as['viernes']}}"minlength="1" maxlength="3"   {{ $diasRegistro[4] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_vie[]" id="extra_vie" value="{{$as['extViernes']}}"  min="0" max="30" step="0.5" {{ $tt[4] }}>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_viernes[]" id="tt_viernes" value="{{$as['tt_viernes']}}"  min="0" max="30" step="0.5" {{ $tt[4] }}></td>
                                                                <td id="{{ $as['sabado'] }}"><input type="text" style="max-width: 45px" name="sab[]" id="sab" value="{{$as['sabado']}}" minlength="1" maxlength="3"  {{ $diasRegistro[4] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_sab[]" id="extra_sab" value="{{$as['extSabado']}}"  min="0" max="30" step="0.5" {{ $tt[4] }}>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_sabado[]" id="tt_sabado" value="{{$as['tt_sabado']}}"  min="0" max="30" step="0.5" {{ $tt[4] }}></td>
                                                                <td id="{{ $as['domingo'] }}"><input type="text" style="max-width: 45px" name="dom[]" id="dom" value="{{$as['domingo']}}" minlength="1" maxlength="3"  {{ $diasRegistro[4] }}></td>
                                                                <td>TE:<input type="number" style="max-width: 45px" name="extra_dom[]" id="extra_dom" value="{{$as['extDomingo']}}"  min="0" max="30" step="0.5" {{ $tt[4] }}>
                                                                <hr>TT:<input type="number" style="max-width: 45px" name="tt_domingo[]" id="tt_domingo" value="{{$as['tt_domingo']}}"  min="0" max="30" step="0.5" {{ $tt[4] }}></td>
                                                                <td><input type="text" style="max-width: 45px" name="bono_asistencia[]" id="bono_asistencia" value="{{$as['bonoAsistencia']}}"   disabled></td>
                                                                <td><input type="text" style="max-width: 45px" name="bono_puntualidad[]" id="bono_puntualidad" value="{{$as['bonoPuntualidad']}}"  disabled ></td>
                                                                <td><input type="number" style="max-width: 45px" name="total_extras[]" id="total_extras" value="{{$as['extras']}}" step="0.5" disabled ></td>
                                                                <td><input type="number" style="max-width: 45px" name="tiempo_por_tiempo[]" id="tiempo_por_tiempo" value="{{$as['tiempoPorTiempo']}}"disabled  step="0.5"></td>
                                                                <td><input type="text" style="max-width: 60px" name="numero_emplead[]" id="numero_emplead" value="{{$as['id_empleado']}}" disabled></td>
                                                            <td> <input type="hidden" name="numero_empleado[]" id="numero_empleado[]" value="{{$as['id_empleado']}}">     </tr>
                                                @endforeach
                                                <div>
                                                <button type="submit" name="enviar" id="enviar" class=" btn btn-primary" >{{ __('Modify') }}</button>
                                                </div>
                                                            </form>
                                                @endif

                                            </tbody>
                                        </table>
                            </div>
                              <hr>
                            <div class="col-md-12">
                                @if($datosRHWEEKLastWeek != null)
                                       <h2>{{ __('Last Week Insidences') }}</h2><hr>
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>


                                                    <th>{{ __('Employee') }}</th>
                                                    <th>{{ __('Monday') }}</th><th>{{ __('OverTime') }} {{ __('Monday') }}</th> <th>{{ __('Tuesday') }}</th><th>{{ __('OverTime') }} {{ __('Tuesday') }}</th>
                                                    <th>{{ __('Wednesday') }}</th><th>{{ __('OverTime') }} {{ __('Wednesday') }}</th>
                                                    <th>{{ __('Thursday') }}</th>  <th>{{ __('OverTime') }} {{ __('Thursday') }}</th>  <th>{{ __('Friday') }}</th>
                                                    <th>{{ __('OverTime') }} {{ __('Friday') }}</th>  <th>{{ __('Saturday') }}</th>  <th>{{ __('OverTime') }} {{ __('Saturday') }}</th>
                                                    <th>{{ __('Sunday') }}</th> <th>{{ __('OverTime') }} {{ __('Sunday') }}</th> <th> {{ __('Attendance Bonus') }}</th>
                                                    <th>{{ __('Punctuality Bonus') }}</th>  <th>{{ __('Total OverTime') }}</th> <th> {{ __('Time by Time') }} </th>
                                                    <th>{{ __('Employee ID') }}</th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($datosRHWEEKLastWeek as $d => $as)

                                                        <tr>

                                                            <form action="{{route('updateLastWeek')}}" method="GET">
                                                            <td id="empleado">{{$as['name']}}</td>
                                                            <td id="{{ $as['lunes'] }}"><input type="text" style="max-width: 45px" name="lun[]" id="lun"   minlength="1" maxlength="3" value="{{$as['lunes']}}" readonly ></td>
                                                            <td >TE:<input type="number" style="max-width: 45px" name="extra_lun[]" id="extra_lun" value="{{$as['extLunes']}}"  min="0" max="30" step="0.5" readonly >
                                                            <hr>TT:<input type="number" style="max-width: 45px" name="tt_lunes[]" id="tt_lunes" value="{{$as['tt_lunes']}}"  min="0" max="30" step="0.5" readonly ></td>
                                                            <td id="{{ $as['martes'] }}"><input type="text" style="max-width: 45px" name="mar[]" id="mar" value="{{$as['martes']}}" minlength="1" maxlength="3"   readonly ></td>
                                                            <td>TE:<input type="number" style="max-width: 45px" name="extra_mar[]" id="extra_mar" value="{{$as['extMartes']}}"  min="0" max="30" step="0.5" readonly >
                                                            <hr>TT:<input type="number" style="max-width: 45px" name="tt_martes[]" id="tt_martes" value="{{$as['tt_martes']}}"  min="0" max="30" step="0.5" readonly ></td>
                                                            <td id="{{ $as['miercoles'] }}"><input type="text" style="max-width: 45px" name="mie[]" id="mie" value="{{$as['miercoles']}}" minlength="1" maxlength="3"   readonly ></td>
                                                            <td>TE:<input type="number" style="max-width: 45px" name="extra_mie[]" id="extra_mie" value="{{$as['extMiercoles']}}" min="0" max="30" step="0.5"  readonly >
                                                            <hr>TT:<input type="number" style="max-width: 45px" name="tt_miercoles[]" id="tt_miercoles" value="{{$as['tt_miercoles']}}"  min="0" max="30" step="0.5" readonly ></td>
                                                            <td id="{{ $as['jueves'] }}"><input type="text" style="max-width: 45px" name="jue[]" id="jue" value="{{$as['jueves']}}" minlength="1" maxlength="3"  readonly ></td>
                                                            <td>TE:<input type="number" style="max-width: 45px" name="extra_jue[]" id="extra_jue" value="{{$as['extJueves']}}"  min="0" max="30" step="0.5" readonly >
                                                            <hr>TT:<input type="number" style="max-width: 45px" name="tt_jueves[]" id="tt_jueves" value="{{$as['tt_jueves']}}"  min="0" max="30" step="0.5" readonly ></td>
                                                            <td id="{{ $as['viernes'] }}"><input type="text" style="max-width: 45px" name="vie[]" id="vie" value="{{$as['viernes']}}"minlength="1" maxlength="3"   required ></td>
                                                            <td>TE:<input type="number" style="max-width: 45px" name="extra_vie[]" id="extra_vie" value="{{$as['extViernes']}}"  min="0" max="30" step="0.5"   required>
                                                            <hr>TT:<input type="number" style="max-width: 45px" name="tt_viernes[]" id="tt_viernes" value="{{$as['tt_viernes']}}"  min="0" max="30" step="0.5"   required></td>
                                                            <td id="{{ $as['sabado'] }}"><input type="text" style="max-width: 45px" name="sab[]" id="sab" value="{{$as['sabado']}}" minlength="1" maxlength="3"  required ></td>
                                                            <td>TE:<input type="number" style="max-width: 45px" name="extra_sab[]" id="extra_sab" value="{{$as['extSabado']}}"  min="0" max="30" step="0.5"   required>
                                                            <hr>TT:<input type="number" style="max-width: 45px" name="tt_sabado[]" id="tt_sabado" value="{{$as['tt_sabado']}}"  min="0" max="30" step="0.5"   required></td>
                                                            <td id="{{ $as['domingo'] }}"><input type="text" style="max-width: 45px" name="dom[]" id="dom" value="{{$as['domingo']}}" minlength="1" maxlength="3"  required ></td>
                                                            <td>TE:<input type="number" style="max-width: 45px" name="extra_dom[]" id="extra_dom" value="{{$as['extDomingo']}}"  min="0" max="30" step="0.5"   required>
                                                            <hr>TT:<input type="number" style="max-width: 45px" name="tt_domingo[]" id="tt_domingo" value="{{$as['tt_domingo']}}"  min="0" max="30" step="0.5"   required></td>
                                                            <td><input type="text" style="max-width: 45px" name="bono_asistencia[]" id="bono_asistencia" value="{{$as['bonoAsistencia']}}"   disabled></td>
                                                            <td><input type="text" style="max-width: 45px" name="bono_puntualidad[]" id="bono_puntualidad" value="{{$as['bonoPuntualidad']}}"  disabled ></td>
                                                            <td><input type="number" style="max-width: 45px" name="total_extras[]" id="total_extras" value="{{$as['extras']}}" step="0.5" disabled></td>
                                                            <td><input type="number" style="max-width: 45px" name="tiempo_por_tiempo[]" id="tiempo_por_tiempo" value="{{$as['tiempoPorTiempo']}}"disabled  step="0.5"></td>
                                                            <td><input type="text" style="max-width: 60px" name="numero_emplead[]" id="numero_emplead" value="{{$as['id_empleado']}}" disabled></td>
                                                        <td> <input type="hidden" name="numero_empleado[]" id="numero_empleado[]" value="{{$as['id_empleado']}}">
                                                        <button type="submit" name="enviar" id="enviar" class=" btn btn-primary" >{{ __('Modify') }}</button></td>
                                                        </form>
                                                        </tr>
                                            @endforeach

                                    </tbody>
                                </table>
                            @endif
                           </div>
                        </div>

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
      const url = "{{ route('modificarEmpleado') }}?dato="+dato;
      fetch(url, { method: 'GET',
                    headers: {   'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  },
                      })
                .then(response => response.json())
                .then(data => {  console.log(data);
                       const registros = document.getElementById('datos');
        let table = "<table class='table table-striped' style='width:100%'><thead><tr><th>Nombre</th><th>Numero de empleado</th><th>Lider</th><th>Area</th><th>Genero</th><th>Estado</th><th>Tipo</th><th>Editar</th></tr> </thead><tbody>";

        for (let i = 0; i < data.length; i++) {
            const emp = data[i];

            table += `
            <form action="{{ route('modificarEmpleado') }}" method="GET">
            <tr>
                <td><input type="text" id="nameEmployee_${emp.employeeNumber}" maxlength="45" minlength="9" value="${emp.employeeName}"></td>
                <td><input type="text" id="id_employee_${emp.employeeNumber}" maxlength="4" minlength="4" value="${emp.employeeNumber.substring(1, 5)}"></td>
                <td>
                    <select id="lider_${emp.employeeNumber}" >
                            <option value="${emp.employeeLider}"> Actual ${emp.employeeLider}</option>
                        @foreach ($lidername as $lider)
                            <option value="{{ $lider->employeeLider }}">{{ $lider->employeeLider }}</option>
                        @endforeach
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
                          <option value="Baja">Baja</option>
                          <option value="Incapacidad">Incapacidad</option>
                    <option value="Suspension">Suspension</option>
                    <option value="Vacaciones">Vacaciones</option>
                    <option value="PCS">Permiso temporal con gose</option>
                    <option value="PSS">Permiso temporal sin gose</option>
                    </select>
                </td>
                <td>
                    <select id="typeSalida_${emp.employeeNumber}" required>
                        <option value="" noselected>Choose an option</option>
                        <option value="VOLUNTARIA">VOLUNTARIA</option>
                          <option value="Terminación de contrato ">Terminación de contrato </option>
                          <option value="Involuntaria">Involuntaria</option>
                    </select>
                </td>
                <td>
                    <select id="typeWorker_${emp.employeeNumber}">
                        <option value="${emp.typeWorker}"> Actual ${emp.typeWorker}</option>
                           <option value="Directo">Directo</option><option value="Indirecto">Indirecto</option>
                    <option value="Practicante">Practicante</option>
                    <option value="Asimilado">Asimilado</option>
                    <option value="Servicio Comprado">Servicios Comprados</option>
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


            const nameEmployee = document.getElementById("nameEmployee_"+valor).value;
            const id_employee = document.getElementById("id_employee_"+valor).value;
            const lider = document.getElementById("lider_"+valor).value;
            const area = document.getElementById("area_"+valor).value;
            const genero = document.getElementById("genero_"+valor).value;
            const status = document.getElementById("status_"+valor).value;
            const typeWorker = document.getElementById("typeWorker_"+valor).value;
            const typeSalida = document.getElementById("typeSalida_"+valor).value;
    const url = "{{ route('editarEmepleado') }}?valor="+valor+"&id_employee="+id_employee+"&nameEmployee="+nameEmployee+
    "&lider="+lider+"&area="+area+"&genero="+genero+"&status="+status+"&typeWorker="+typeWorker+"&typeSalida="+typeSalida;

            fetch(url, { method: 'GET',
                headers: {   'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  },
                  })
                .then(response => response.json())
                .then(data => {  console.log(data);
                    alert(data);
                    window.location.reload();

                })
                .catch(error => { console.error('Error:', error);  });



        }



</script>

@endsection
