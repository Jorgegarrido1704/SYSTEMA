@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

 <div class="row">

    <!-- Escanner -->
    <div class="col-xl-12 col-lg-4" >
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                <h6 class="m-0 font-weight-bold text-primary">Scanner Barcode</h6>

            </div>

            <!-- table Body -->
            <div class="card-body" style=" height: 180px;">
                <div class="chart-pie pt-4 pb-2">
                    <form action="{{ route('codigo') }}" method="POST">
                        @csrf
                        <div class="form-group" style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
                            <!-- Cantidad -->
                            <div class="input-group" style="flex: 1; min-width: 150px;">
                                <label for="cantidad" class="form-label" style="padding-right: 10px;"><b>Qty scanned</b></label>
                                <input type="number" class="form-control" name="cantidad" id="cantidad" value="0" min="0" required>
                            </div>

                            <!-- Código de Barras -->
                            <div class="input-group" style="flex: 2; min-width: 200px;">
                                <label for="code-bar" class="form-label" style="padding-right: 10px;"><b>Scan Your Code</b></label>
                                <input type="text" class="form-control" name="code-bar" id="code-bar" placeholder="Enter code here" required>
                            </div>

                            <!-- Botón de Enviar -->
                            <div style="flex: 0 0 auto;">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <br>
                    <h3 align="center">{{ session('response') }}</h3>
                </div>
            </div>
        </div>
    </div>
 </div>

                    <div class="row">

                        <!-- Active Work -->
                        <div class="col-xl-6 col-lg-4">
                            <div class="card shadow mb-4">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Harness position</h5>

                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">
                                        <style>
                                            table {     width: 100%;   text-align: center                  }
                                            td {border-bottom: solid 2px lightblue; }
                                            thead{background-color: #FC4747; color:white;  }
                                            a{text-decoration: none; color: whitesmoke;  }
                                            a:hover{ text-decoration: none; color: white; font:bold;}
                                        </style>
                                        <table id="table-harness" class="table-harness">
                                            <thead>
                                                <th>PN and Rev</th>
                                                <th>WO</th>
                                                <th>Qty</th>
                                                <th>Issue</th>
                                                <th>Time in proccess</th>
                                                <th>pausa/continuar</th>
                                            </thead>
                                            <tbody>
                                               @foreach ($registros as $registro )
                                                <tr>
                                                    <td>{{ $registro[1] }} <br>REV {{ $registro[2] }}</td>
                                                    <td>{{ $registro[3] }}</td>
                                                    <td>{{ $registro[4] }}</td>
                                                    <td>{{ $registro[5] }}</td>
                                                    <td>{{ $registro[6] }}</td>

                                                    @if ($registro[5]=="" )
                                                    <td><form action="{{route('pause')}}" method="GET">
                                                        <input type="hidden" name="id_butC" id="id_butC" value="{{$registro[3]}}">
                                                        <input type="submit" value="Comenzar">
                                                    </form> </td>
                                                    @elseif($registro[5]=="En proceso")
                                                    <td><form action="{{ route('pause') }}" method="GET" >
                                                        <input type="hidden" name="id_but" id="id_but" value="{{ $registro[3] }}">
                                                        <input type="hidden" name="funcion" id="funcion" value="pausar">
                                                        <textarea name="motivo" id="motivo" cols="10" rows="2"></textarea>
                                                        <input type="submit" value="Pausar" >
                                                    </form>
                                                </td>
                                                    @else
                                                    <td><form action="{{route('pause')}}" method="GET">
                                                        <input type="hidden" name="id_but" id="id_but" value="{{$registro[3]}}">
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

                        <!-- Table Work -->
                            <div class="col-lg-6 mb-4">
                                <!-- AREAS -->
                                <div class="card shadow mb-4">


                                    <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Report Issue</h5>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>x
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                            aria-labelledby="dropdownMenuLink">
                                        <!--  <a class="dropdown-item" href="#" onclick="changework('desviation')">Desviation</a>
                                        <a class="dropdown-item" href="#" onclick="changework('Materials')">Material Requirement</a>
                                            <a class="dropdown-item" href="#" onclick="changework('Kits')">Requerimiento Kits</a>-->
                                            <a class="dropdown-item" href="{{'general'}}" onclick="changework('Maintanience')">Maintanience</a>
                                            <a class="dropdown-item" href="#" onclick="changework('full')">Requerimiento full size</a>
                                            <a class="dropdown-item" href="#" onclick="changework('help')">Requierimiento de ingenieria</a>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                                        <div class="row" >
                                            <form  action="{{ route('maintananceGen')}}" method="POST">
                                                @csrf
                                                    <div class="form-group">
                                                <label for="nom_equipo">Equipo:</label>
                                                <select id="nom_equipo" name="nom_equipo" class="form-control" required>
                                                    <option value=""></option>
                                                    <option value='USAMT-01'>USAMT-01</option>
                                                    <option value='USAMT-02'>USAMT-02</option>
                                                    <option value='USAMT-03'>USAMT-03</option>
                                                    <option value='USAMT-04'>USAMT-04</option>
                                                    <option value='PRINT-1'>PRINT-1</option>
                                                    <option value='PRINT-2'>PRINT-2</option>
                                                    <option value='PRINT-3'>PRINT-3</option>
                                                    <option value='PRINT-4'>PRINT-4</option>
                                                    <option value='PRINT-5'>PRINT-5</option>
                                                    <option value='PRINT-6'>PRINT-6</option>
                                                    <option value='PRINT-7'>PRINT-7</option>
                                                    <option value='PRINT-8'>PRINT-8</option>
                                                    <option value='PRINT-9'>PRINT-9</option>
                                                    <option value='PRE-1'>PRE-1</option>
                                                    <option value='PRE-2'>PRE-2</option>
                                                    <option value='PRE-3'>PRE-3</option>
                                                    <option value='PRE-4'>PRE-4</option>
                                                    <option value='PRE-5'>PRE-5</option>
                                                    <option value='PRE-6'>PRE-6</option>
                                                    <option value='PRE-7'>PRE-7</option>
                                                    <option value='PRE-8'>PRE-8</option>
                                                    <option value='PRE-9'>PRE-9</option>
                                                    <option value='PRE-10'>PRE-10</option>
                                                    <option value='PRE-11'>PRE-11</option>
                                                    <option value='PRE-12'>PRE-12</option>
                                                    <option value='PRE-13'>PRE-13</option>
                                                    <option value='PRE-14'>PRE-14</option>
                                                    <option value='PRE-15'>PRE-15</option>
                                                    <option value='PRE-16'>PRE-16</option>
                                                    <option value='PRE-17'>PRE-17</option>
                                                    <option value='PRE-18'>PRE-18</option>
                                                    <option value='PRE-19'>PRE-19</option>
                                                    <option value='PRE-20'>PRE-20</option>
                                                    <option value='PRE-21'>PRE-21</option>
                                                    <option value='PRE-22'>PRE-22</option>
                                                    <option value='MCUT-1'>MCUT-1</option>
                                                    <option value='MCUT-2'>MCUT-2</option>
                                                    <option value='MCUT-3'>MCUT-3</option>
                                                    <option value='MCUT-4'>MCUT-4</option>
                                                    <option value='MCUT-5'>MCUT-5</option>
                                                    <option value='MCUT-6'>MCUT-6</option>
                                                    <option value='MCUT-7'>MCUT-7</option>
                                                    <option value='MCUT-8'>MCUT-8</option>
                                                    </select>
                                                    </div>
                                                    <div class="form-group">
                                                    <label for="dano">Daño del equipo</label>
                                                <input type="text" id="dano" name="dano" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                <label for="quien">Quien solicita</label>
                                                <input type="text" id="quien" name="quien" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                <label for="area">Area que solicita</label>
                                                <select name="area" id="  area" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Corte">Corte</option>
                                                    <option value="Liberacion">Liberacion</option>
                                                    <option value="Ensamble">Ensable</option>
                                                    <option value="Loom">Loom</option>
                                                    <option value="Pruebas Electricas">Pruebas Electricas</option>
                                                </select>
                                                </div>

                                                <input type="submit" id="submit" value="Send">
                                                </form>
                                    </div>

                                    </div>
                                </div>
                            </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!--table of works -->
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Table of Works </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >
                                        <style>
                                            #Pendiente{   color: rgb(179, 179, 12);    }
                                            #Pausado{ color:  rgb(163, 3, 3);}
                                            #En_proceso{color: rgb(120, 184, 120);}

                                        </style>
                                        <table>
                                            <thead>
                                                <th>Fecha de solicitud</th>
                                                <th>Cliente</th>
                                                <th>Numero de Parte</th>
                                                <th>Revision</th>
                                                <th>Cantidad</th>
                                                <th>Status</th>
                                            </thead>
                                            <tbody>
                                          @if(!empty($fulls))
                                          @foreach ( $fulls as $full)
                                              <tr>
                                                    <td id="{{$full[5]}}" >{{$full[0]}}</td>
                                                    <td id="{{$full[5]}}">{{$full[3]}}</td>
                                                    <td id="{{$full[5]}}">{{$full[1]}}</td>
                                                    <td id="{{$full[5]}}">{{$full[2]}}</td>
                                                    <td id="{{$full[5]}}">{{$full[4]}}</td>
                                                    <td id="{{$full[5]}}">{{$full[5]}}</td>
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

                 </div>



                    @endsection
