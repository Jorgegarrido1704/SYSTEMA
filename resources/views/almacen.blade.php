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


                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
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
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">


                                <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary"><form action="{{route('parcial')}}"method='GET'>Registro Salidas <input type="text" name="codigo" id="codigo"></form></h5>
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
                                        <form action="{{route('saveparcial')}}" method="GET">
                                            <input type="hidden" name="woitem" id="woitem" value="{{$part[2]}}">
                                            <input type="submit" name="save" id="save" value="Guardar">
                                         </form>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--table of works -->
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
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


                        <!-- Column 2 -->

                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary"></h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="row" >

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary"> </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; max-height: 760px;">
                                    <div class="row" >

                                    </div>
                                </div>
                            </div>
                        </div>

                    @endsection
