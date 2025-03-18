@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-6">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Movimientos </h5>

                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">
                                        <style>
                                            table {     width: 100%;                     }
                                            td {text-align: center; border-bottom: solid 2px lightblue; }
                                            thead{background-color: #FC4747; color:white; text-align: center; }
                                            a{text-decoration: none; color: whitesmoke;  }
                                            a:hover{ text-decoration: none; color: white; font:bold;}

                                            #save{ align-content: center; margin-top: 10%;  border-radius: 4px;  background-color: blue; color: rgb(207, 202, 202); }
                                        </style>
                                        <table id="table-harness" class="table-harness">
                                            <thead>
                                                <th>Fecha</th>
                                                <th>Articulo</th>
                                                <th>Cantidad</th>
                                                <th>Moviemiento</th>
                                                <th>Wo</th>


                                            </thead>
                                            <tbody>
                                                @if(!empty($listas))
                                                @foreach ($listas as $lista)
                                                <tr>
                                                    <td>{{$lista[0]}}</td>
                                                    <td>{{$lista[1]}}</td>
                                                    <td>{{$lista[2]}}</td>
                                                    <td>{{$lista[3]}}</td>
                                                    <td>{{$lista[4]}}</td>
                                                </tr>

                                                @endforeach
                                                @endif

                                            </tbody>
                                            <tbody>




                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-3 mb-3">
                            <div class="card shadow mb-3">
                                    <!-- Card scaneer -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Retorno de material </h5>
                                </div>

                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="chart-pie pt-4 pb-2">
                                        <div align="center">
                                            <form action="{{route('entradas')}}" method="GET">
                                                @csrf
                                                <label for="Work">Work Order</label>
                                                <input type="text" name="Work" id="Work" required>
                                                <input type="submit" name="value" id="value" value="Buscar">
                                              </form>
                                        </div>



                                </div>
                            </div>
                        </div>
                    </div>
                         <!-- Function not issued  <div class="col-lg-3 mb-3">
                            // AREAS
                            <div class="card shadow mb-3">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><form action="{{route('registroKit')}}"method='GET' class="form-inline">Registro Salidas <input type="text" class="form-control" name="codigo" id="codigo" required></form></h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                                    <div class="row" >
                                        @if(!empty($infoPar))
                                        <table>
                                            <thead>
                                                <th>Item</th>
                                                <th>Qty</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($infoPar as $part)
                                                <tr>
                                                    <td>{{$part[0]}}</td>
                                                    <td>{{$part[1]}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <form action="{{route('registroKit')}}" method="GET">
                                            <input type="hidden" name="woitem" id="woitem" value="{{$part[2]}}">
                                            <input type="submit" name="save" id="save" value="Guardar">
                                         </form>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>    -->
                        <div class="col-lg-3 mb-3">
                            <!-- AREAS -->
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Concentrado de materiales</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div align="center">

                                         <form action="{{route('concentrado')}}" method="GET">
                                            <div>     <label for="Works">Numero de parte</label>      </div>
                                            <div> <textarea name="Works" id="Works" cols="30" rows="4" required></textarea></div>
                                            <div>     <label for="cant">Cantidad</label>      </div>
                                            <div> <textarea name="cant" id="cant" cols="30" rows="4" required></textarea></div>
                                         <div> <input type="submit" name="value" id="value" value="Buscar"> </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Second Row Row -->
                    <div class="row">
                        <!--table of works -->


                        <div class="col-lg-6 mb-4">
                            <!-- AREAS  DESVIATION-->
                            <div class="card shadow mb-4">
                                <div     class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Set New Work</h5>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>x
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                     <!--  <a class="dropdown-item" href="#" onclick="changework('desviation')">Desviation</a>
                                     <a class="dropdown-item" href="#" onclick="changework('Materials')">Material Requirement</a>
                                        <a class="dropdown-item" href="#" onclick="changework('Kits')">Requerimiento Kits</a>
                                        <a class="dropdown-item" href="{{'general'}}" onclick="changework('Maintanience')">Maintanience</a>
                                        <a class="dropdown-item" href="#" onclick="changework('full')">Requerimiento full size</a>-->
                                    </div>
                                </div>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                                <div class="desv" align="center">
                            <form  id="formula" action="{{ route('desviationAlm') }}" method="GET">
                                @csrf
                    <div class="form-group">
                        <label for="modelo">Modelo Afectado:</label>
                        <input type="text" class="form-control" name="modelo" id="modelo" placeholder="B222930" required>
                    </div>
                    <div class="form-group">
                        <label for="numPartOrg">No° de parte original:</label>
                        <input type="text" class="form-control" name="numPartOrg" id="numPartOrg" placeholder="TT2-171" required>
                    </div>
                    <div class="form-group">
                        <label for="numPartSus">No° parte sustituto:</label>
                        <input type="text" class="form-control" name="numPartSus" id="numPartSus" placeholder="DT1-17" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Periodo de la desviacion:</label>
                        <input type="text" class="form-control" name="time" id="time" placeholder="12-12-2023" required>
                    </div>
                    <div class="form-group">
                        <label for="cant">Cantidad limitada de piezas a sustituir:</label>
                        <input type="number" class="form-control" name="cant" id="cant" placeholder="1200" required>
                    </div>
                    <div class="form-group">
                        <label for="text">Causa de desviacion:</label>
                        <input class="form-control" name="text" id="text" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="acc">Accion preventiva:</label>
                        <input class="form-control" name="acc" id="acc" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="evi">Evidencia:</label>
                        <input class="form-control" name="evi" id="evi" rows="3" required></textarea>
                    </div>


                    <input type="submit" class="btn btn-primary" name="enviar" id="enviar" value="Save">
                </form>            </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-3">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary"> Tabla desviaciones</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">

                                        <table>
                                            <thead>
                                                <th>Folio</th>
                                                <th>Modelo</th>
                                                <th>Parte Original</th>
                                                <th>Parte Sustituto</th>
                                                <th>Cliente</th>
                                                <th>Firma Compras</th>
                                                <th>Firma ingenieria</th>
                                                <th>Firma Calidad</th>
                                                <th>Firma Produccion</th>
                                                <th>Firma Imex</th>
                                                <th>Fecha</th>
                                                </thead>
                                            <tbody>
                                                @if(!empty($desviations))
                                          @foreach ( $desviations as $desviation)
                                                <tr>
                                                    <td>{{$desviation[0]}}</td>
                                                    <td>{{$desviation[1]}}</td>
                                                    <td>{{$desviation[2]}}</td>
                                                    <td>{{$desviation[3]}}</td>
                                                    <td>{{$desviation[4]}}</td>
                                                    <td>{{$desviation[5]}}</td>
                                                    <td>{{$desviation[6]}}</td>
                                                    <td>{{$desviation[7]}}</td>
                                                    <td>{{$desviation[8]}}</td>
                                                    <td>{{$desviation[9]}}</td>
                                                    <td>{{$desviation[10]}}</td>

                                                    </tr>
                                          @endforeach
                                          @endif
                                            </tbody>
                                        </table>


                                </div>
                            </div>
                        </div>

                        </div>
                        <!-- third row -->
                        <div class="row">

                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Kids waiting for work</h5>
                                </div>

                                <div class="card-body" style="overflow-y: auto; height: 560px;">


                                            <div class="form-group">
                                                <table class="table absolute">
                                                    <thead>
                                                        <th>Model#</th>
                                                        <th>Wo</th>
                                                        <th>Status</th>
                                                        <th>Qty</th>
                                                        <th>Moviment</th>
                                                    </thead>
                                                    <tbody>
                                                        @if(!empty($kispendientes))
                                                        @foreach ($kispendientes as $kispendiente)
                                                        <tr>
                                                            <td>{{$kispendiente[1]}}</td>
                                                            <td>{{$kispendiente[2]}}</td>
                                                            <td>{{$kispendiente[3]}}</td>
                                                            <td>{{$kispendiente[4]}}</td>
                                                            <td> <form action="{{route('registroKit')}}"  class="form-container" id="kispendientes">
                                                            <input type="hidden" name="idkit"  value="{{$kispendiente[0]}}">

                                                                <button class="btn btn-primary" type="submit" >
                                                                    @if($kispendiente[3] == 'En proceso' or $kispendiente[3] == 'Parcial')
                                                                    Continue
                                                                @elseif($kispendiente[3] == 'En espera')
                                                                    start
                                                                @endif
                                                            </button>
                                                            </form>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>

                                                </table>
                                </div>
                                </div>
                            </div>
                        </div>
                     <!--   <div class="col-lg-6 mb-4">
                            // AREAS
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary"> </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 550px;">

                                </div>
                            </div>
                        </div> -->
                    </div>

                    @endsection
