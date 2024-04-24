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
                                    <h5 class="m-0 font-weight-bold text-primary">Salida Bom completo</h5>

                                </div>

                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="chart-pie pt-4 pb-2">
                                        <div align="center">Escaneo de Wo
                                            <form action="{{route('CodeWo')}}" method="GET">

                                                <input type="text" name="codigo" id="codigo">

                                            </form>
                                            <br><br>
                                            @if(!empty($response))
                                            <h2>{{$response}}</h2>
                                            @endif
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
                                <h5 class="m-0 font-weight-bold text-primary"><form action="{{route('parcial')}}"method='GET'>Salidad Parcial <input type="text" name="codPar" id="codPar"></form></h5>

                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                                    <div class="row" >
                                        <table>
                                            <thead>
                                                <th>Item</th>
                                                <th>Qty</th>

                                            </thead>
                                            <tbody>

                                                @if(!empty($infoPar))
                                                <form action="{{route('saveparcial')}}" method="GET">
                                                @foreach ($infoPar as $part)
                                                <tr>
                                                    <td>{{$part[0]}}</td>
                                                    <td>
                                                     <input type="hidden" name="wo" id="wo" value={{$regpar}}>   <input type="hidden" id="item[]" name="item[]" value="{{$part[0]}}" ><input type="number" id="cant[]" name="cant[]" value="{{$part[1]}}" step="0.01"></td>

                                                </tr>

                                                @endforeach
                                                    <input type="submit" name="save" id="save" value="Guardar">
                                                 </form>

                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!--table of works -->
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Entrada de Material </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div align="center">
                                      <form action="{{route('entradas')}}" method="GET">
                                        @csrf
                                        <br>
                                        <label for="Art">Item</label>
                                        <input type="text" id="Art" name="Art" required>
                                        <label for="qtyArt">Cantidad</label>
                                        <input type="number" name="qtyArt" id="qtyArt" min="0" required >
                                        <br>
                                        <label for="Art">Item</label>
                                        <input type="text" id="Art" name="Art" required>
                                        <label for="qtyArt">Cantidad</label>
                                        <input type="number" name="qtyArt" id="qtyArt" min="0" required >
                                        <br>
                                        <label for="Art">Item</label>
                                        <input type="text" id="Art" name="Art" required>
                                        <label for="qtyArt">Cantidad</label>
                                        <input type="number" name="qtyArt" id="qtyArt" min="0" required >
                                        <br>
                                        <label for="Art">Item</label>
                                        <input type="text" id="Art" name="Art" required>
                                        <label for="qtyArt">Cantidad</label>
                                        <input type="number" name="qtyArt" id="qtyArt" min="0" required >
                                        <br>
                                        <label for="Art">Item</label>
                                        <input type="text" id="Art" name="Art" required>
                                        <label for="qtyArt">Cantidad</label>
                                        <input type="number" name="qtyArt" id="qtyArt" min="0" required >
                                        <br>
                                        <input type="submit" name="enviar" id="enviar" value="Registrar ">
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
                                    <h5 class="m-0 font-weight-bold text-primary"><form action="{{route('BomAlm')}}" method="GET">
                                        <label for="NpBom">Numero de parte</label><input type="text" name="NpBom" id="NpBom" required>
                                        <label for="qtyBom">Cantidad</label><input type="number" name="qtyBom" id="qtyBom" min="1" value="1" required>
                                        <input type="submit" name="enviar" id="enviar" value="Buscar">
                                    </form></h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div class="row" >
                                        <table>
                                            <thead>
                                                <th>Item</th>
                                                <th>Qty</th>
                                            </thead>
                                            <tbody>
                                                @if(!empty($BomResp))
                                                @foreach ($BomResp as $bomresp)
                                                <tr>
                                                    <td>{{$bomresp[0]}}</td>
                                                    <td>{{$bomresp[1]}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Boms combiandos </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; max-height: 760px;">
                                    <div class="row" >

                                    </div>
                                </div>
                            </div>
                        </div>

                    @endsection
