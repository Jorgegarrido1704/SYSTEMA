@extends('layouts.mainWithoutsidebar')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Harness position</h5>

                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">
                                        <style>
                                            table {     width: 100%;                     }
                                            td {border-bottom: solid 2px lightblue; }
                                            thead{background-color: #FC4747; color:white;  }
                                            a{text-decoration: none; color: whitesmoke;  }
                                            a:hover{ text-decoration: none; color: white; font:bold;}
                                        </style>
                                        <table id="table-harness" class="table-harness">
                                            <thead>
                                                <th>Part Number</th>
                                                <th>Client</th>
                                                <th>REV</th>
                                                <th>WO</th>
                                                <th>PO</th>
                                                <th>Qty</th>
                                                <th>Station</th>
                                                <th>issue</th>
                                                <th>pausa/continuar</th>
                                            </thead>
                                            <tbody>
                                               @foreach ($registros as $registro )
                                                <tr>
                                                    <td>{{ $registro[1] }}</td>
                                                    <td>{{ $registro[2] }}</td>
                                                    <td>{{ $registro[3] }}</td>
                                                    <td>{{ $registro[4] }}</td>
                                                    <td>{{ $registro[5] }}</td>
                                                    <td>{{ $registro[6] }}</td>
                                                    <td>{{ $registro[7] }}</td>
                                                    <td>{{ $registro[8] }}</td>
                                                    @if ($registro[9]=="" && $registro[10]=="")
                                                    <td><form action="{{route('pause')}}" method="GET">

                                                        <input type="hidden" name="id_butC" id="id_butC" value="{{$registro[4]}}">
                                                        <input type="submit" value="Comenzar">
                                                    </form> </td>

                                                    @elseif($registro[10]=="")
                                                    <td><form action="{{route('pause')}}" method="GET">

                                                        <input type="hidden" name="id_but" id="id_but" value="{{$registro[4]}}">
                                                        <input type="hidden" name="funcion" id="funcion" value="pausar">
                                                        <input type="submit" value="pausar">
                                                    </form> </td>
                                                    @else
                                                    <td><form action="{{route('pause')}}" method="GET">

                                                        <input type="hidden" name="id_but" id="id_but" value="{{$registro[4]}}">
                                                        <input type="hidden" name="funcion" id="funcion" value="continuar">
                                                        <input type="submit" value="Continuar">
                                                    </form></td>
                                                    @endif
                                                </tr>


                                               @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                    <!-- Card scaneer -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Scanner Barcode</h5>

                                </div>

                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="chart-pie pt-4 pb-2">
                                        <form action="{{ route('codigo') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <h2 class="mb-3">Scan Your Code</h2>
                                                <input type="text" class="form-control" name="code-bar" id="code-bar" placeholder="Enter code here">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </form>
                                        <br>
                                        <h3 align="center">{{ session('response') }}</h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">


                                <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Set New Work</h5>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                       <a class="dropdown-item" href="#" onclick="changework('desviation')">Desviation</a>
                                        <a class="dropdown-item" href="#" onclick="changework('Materials')">Material Requirement</a>
                                        <a class="dropdown-item" href="#" onclick="changework('Maint')">Maintanience</a>
                                    </div>
                                </div>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                                    <div class="row" >
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Equipo</th>
                                                    <th>Trabajo solicitado</th>
                                                    <th>Daño</th>
                                                    <th>Area</th>
                                                    <th>Guardar </th>
                                                 </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                      <form action="{{ route('maintanance') }}" method="POST" name="registro" id="form">
                                        @csrf
                                       <td align="center"><select name="equipo" id="equipo" onchange="updateSecondSelect()"  >
                                      <option selected="selected"> </option>
                                     <option value="Mantenimiento">Mantenimeinto</option>
                                     <option value="Ingenieria">Ingenieria</option>
                                     <option value="Calidad">Calidad</option>
                                     <option value="Almacen">Almacen</option>

                                     </select></td>
                                                    <td align="center">
                                                       <input type="text" name="nom_equipo" id="nom_equipo" required>
                                                    <td align="center">
                                                        <select name="dano" id="dano"   > </select>
                                                    </td>
                                                    <td><select name="area" id="area" required>
                                                        <option value=""></option>
                                                        <option value="Tablero_Esther">Tablero Esther</option>
                                                        <option value="Tablero_Saul">Tableros Saul</option>
                                                        <option value="Tablero_David">Tableros Jessi</option>
                                                        <option value="Liberacion">Liberacion</option>
                                                        <option value="Corte">Corte</option>
                                                        <option value="Almacen">Alamacen</option>
                                                        <option value="Tableros_Brandon">Tableros Brandon</option>
                                                        <option value="Tableros_Alejandra">Tableros Alejenadra</option>
                                                        <option value="Tableros_Zamarripa">Tableros Zamarripa</option>
                                                        <option value="Loom">Loom</option>
                                                        <option value="Calidad">Calidad</option>
                                                    </select></td>
                                                       <td align="center"><button type="submit" value="save" id="guardar" name="guardar"  >Guardar</button> </td>
                                                   </tr>
                                                </form>
                                            </tbody>
                                        </table>
                                        <br>

                                    <div>
                                </div>
                            </div>

                                </div>
                            </div>
                        </div>
                        <!--table of works -->
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Table of Works </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >
                                        <table>
                                            <thead>
                                                <th>Fecha</th>
                                                <th>Team</th>
                                                <th>trabajo</th>
                                                <th>Tipo de reparacion</th>
                                                <th>Status</th>
                                            </thead>
                                            <tbody>
                                          @if(!empty($paros))
                                          @foreach ( $paros as $paro)
                                                <tr>
                                                    <td>{{$paro[0]}}</td>
                                                    <td>{{$paro[1]}}</td>
                                                    <td>{{$paro[2]}}</td>
                                                    <td>{{$paro[3]}}</td>
                                                    <td>{{$paro[4]}}</td>
                                                </tr>
                                          @endforeach
                                          @endif
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Column 2 -->
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3" align="center">
                                    <h5 class="m-0 font-weight-bold text-primary">Boms Filter <form action="{{ route('Bom') }}" method="POST">
                                        @csrf
                                        <input type="text" name="partnum" id="partnum" >
                                    </form> </h5>
                                </div>
                                <div class="card-body">

                                    @if(isset($resps) && !empty($resps))

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ITEM</th>
                                                <th>QTY</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($resps as $row)
                                                <tr>
                                                    <td>{{ $row[0] }}</td>
                                                    <td>{{ $row[1] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>No results found.</p>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Assistence WEEK {{$week}} </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="row" >
                                    <table >
                                        <thead>
                                            <th>Nombre</th>
                                            <th>Lunes</th>
                                            <th>Martes</th>
                                            <th>Miercoles</th>
                                            <th>Jueves</th>
                                            <th>Viernes</th>
                                            <th>Sabado</th>
                                            <th>Domingo</th>
                                            <th>Bono Asistencia</th>
                                            <th>Bono puntualidad</th>
                                            <th>extras</th>
                                        </thead>
                                        <tbody>
                                            <form action="{{ route('assistence')}}" method="POST">
                                                @csrf
                                                @foreach ($assit as $as)


                                                <tr>
                                                    <td><input type="hidden" name="name[]" id="name">{{$as[2]}}</td>
                                                    @if(!empty($as[3]))
                                                    <td><input type="text" style="max-width: 40px" name="dlu[]" id="dlu" value="{{$as[3]}}"></td>
                                                    @else
                                                    <td><input type="text" style="max-width: 40px" name="dlu[]" id="dlu" value="N/R"></td>
                                                    @endif
                                                    @if(!empty($as[4]))
                                                    <td><input type="text" style="max-width: 40px" name="dma[]" id="dma" value="{{$as[4]}}"></td>
                                                    @else
                                                    <td><input type="text" style="max-width: 40px" name="dma[]" id="dma" value="N/R"></td>
                                                    @endif
                                                    @if(!empty($as[5]))
                                                    <td><input type="text" style="max-width: 40px" name="dmi[]" id="dmi" value="{{$as[5]}}"></td>
                                                    @else
                                                    <td><input type="text" style="max-width: 40px" name="dmi[]" id="dmi" value="N/R"></td>
                                                    @endif
                                                    @if(!empty($as[6]))
                                                    <td><input type="text" style="max-width: 40px" name="dju[]" id="dju" value="{{$as[6]}}"></td>
                                                    @else
                                                    <td><input type="text" style="max-width: 40px" name="dju[]" id="dju" value="N/R"></td>
                                                    @endif
                                                    @if(!empty($as[7]))
                                                    <td><input type="text" style="max-width: 40px" name="dvi[]" id="dvi" value="{{$as[7]}}"></td>
                                                    @else
                                                    <td><input type="text" style="max-width: 40px" name="dvi[]" id="dvi" value="N/R"></td>
                                                    @endif
                                                    @if(!empty($as[8]))
                                                    <td><input type="text" style="max-width: 40px" name="dsa[]" id="dsa" value="{{$as[8]}}"></td>
                                                    @else
                                                    <td><input type="text" style="max-width: 40px" name="dsa[]" id="dsa" value="N/R"></td>
                                                    @endif
                                                    @if(!empty($as[9]))
                                                    <td><input type="text" style="max-width: 40px" name="ddo[]" id="ddo" value="{{$as[9]}}"></td>
                                                    @else
                                                    <td><input type="text" style="max-width: 40px" name="ddo[]" id="ddo" value="N/R"></td>
                                                    @endif
                                                    @if(!empty($as[10]))
                                                    <td><input type="text" style="max-width: 40px" name="dba[]" id="dba" value="{{$as[10]}}"></td>
                                                    @else
                                                    <td><input type="text" style="max-width: 40px" name="dba[]" id="dba" value="N/R"></td>
                                                    @endif
                                                    @if(!empty($as[11]))
                                                    <td><input type="text" style="max-width: 40px" name="dbp[]" id="dbp" value="{{$as[11]}}"></td>
                                                    @else
                                                    <td><input type="text" style="max-width: 40px" name="dbp[]" id="dbp" value="N/R"></td>
                                                    @endif
                                                    @if(!empty($as[12]))
                                                    <td><input type="number" style="max-width: 40px" name="dex[]" id="dex" value="{{$as[12]}}"></td>
                                                    @else
                                                    <td><input type="numer" style="max-width: 40px" name="dex[]" id="dex" value="0"></td>
                                                    @endif
                                                    <td><input type="hidden" name="id[]" id="id" value="{{$as[13]}}"></td>
                                                </tr>
                                            @endforeach
                                            <input type="submit" style="border-radius: 4px; background-color:lightblue;border-bottom:10px" name="sendassit" id="sendassist" value="Save Assistence">

                                            </form>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endsection
