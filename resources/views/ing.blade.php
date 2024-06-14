@extends('layouts.mainWithoutsidebar')

@section('contenido')
 <!-- Page Heading -->
 <style>


 </style>

 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-8 col-lg-7"  >
                            <div class="card shadow mb-4" id="card">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">CheckPPAP & PRIM</h5>

                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">
                                        <style>
                                            table {     width: 100%;                     }
                                            td,th{text-align: center;}
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
                                                <th>Area</th>
                                                <th>Sign</th>

                                            </thead>
                                            <tbody>
                                                @if(!empty($inges))
                                                @foreach ($inges as $inge )
                                                    <tr>
                                                        <form action="{{route('autorizar')}}" method="GET">
                                                            <td>{{$inge[0]}}</td>
                                                            <td>{{$inge[1]}}</td>
                                                            <td>{{$inge[2]}}</td>
                                                            <td>{{$inge[3]}}</td>
                                                            <td>{{$inge[4]}}</td>
                                                            <td>{{$inge[5]}}</td>
                                                            @if ($inge[7]==13)
                                                            <td>Assembly</td>
                                                            @elseif ($inge[7]==14)
                                                            <td>Loom</td>
                                                            @elseif ($inge[7]==16)
                                                            <td>Terminals</td>
                                                            @elseif ($inge[7]==17)
                                                            <td>Cutting</td>
                                                            @elseif ($inge[7]==18)
                                                            <td>Quality</td>

                                                            @endif
                                                            <td><input type="hidden" id='iding' name='iding' value="{{$inge[6]}}">
                                                                <input type="hidden" id='count' name='count' value="{{$inge[7]}}">
                                                                <input type="hidden" id='info' name='info' value="{{$inge[8]}}">
                                                            <input type="submit" name="enviar" id="enviar" value='Autorizar'></td>
                                                        </form>
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


                        <div class="col-xl-4 col-lg-5" >
                            <div class="card shadow mb-4" id="card2">
                                    <!-- Set Work -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Set Work</h5>

                                </div>

                                <div class="card-body" style="overflow-y: auto; height: 360px; ">
                                    <div class="row">
                                        <style>

label {
  text-align: center;
  align-items: center;
  margin-bottom: 5px;

}


select {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-bottom: 15px;
}

/* Style for submit button */
#submit {
  text-align: center;
}

#sub {
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

#sub:hover {
  background-color: #0056b3;
}

/* Style for container */
.container {
  width: 50%;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
}


#magia {
  border: solid 1px #ccc;
  padding-bottom: 10px;
}
                                        </style>
                                        <form action="{{route('tareas')}}" method="GET" id='form'>
                                         <label for="Inge"><h4>Ingenier@ a cargo de la tarea</h4></label>
                                            <select name="Inge" id="Inge" required>
                                                    <option value=""></option>
                                                    <option value="Jesus C">Jesus Cervera</option>

                                                    <option value="Carlos R">Carlos Rodriguez</option>
                                                    <option value="Paola S">Paola Silva</option>
                                                    <option value="Nancy A">Nancy Aldana</option>
                                                    <option value="Todos">Todos El equipo</option>
                                                </select>

                                        <label for="act"><h4>Actividad a realizar</h4></label>
                                                <select name="act" id="act" required>
                                                    <option value=""></option>
                                                    <option value="Documentacion ">Documentacion PPAP</option>
                                                    <option value="Soporte en piso">Soporte en piso</option>
                                                    <option value="Colocacion de full size">Colocacion de full size</option>
                                                    <option value="Seguimiento PPAP">Seguimiento PPAP</option>
                                                    <option value="Diseno de piezas 3D">Diseño de piezas 3D</option>
                                                    <option value="Retroalimentacion y aclaraciones a clientes">Retroalimentacion y aclaraciones a clientes</option>
                                                    <option value="Juntas">Juntas</option>
                                                    <option value="Otro">Otro</option>
                                                            </select>
                                                 <textarea name="info" id="info" cols="50" rows="2" required></textarea>
                                                            <br>
                                                        <input type="submit" name="sub" id="sub" value="Guardar">
                                                    </form>
                                                </div>
                                            </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Work in processe -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">


                                <div
                                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Works in processe</h5>

                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id='work'>
                                    <div class="row" >

                                        <table>
                                            <thead>
                                                    <th>Enginner</th>
                                                    <th>Activity</th>
                                                    <th>Description</th>
                                                    <th>Timer</th>
                                                    <th>Stop/continue</th>
                                                    <th>Finish Activity</th>

                                            </thead>

                                                <tbody>
                                                    @if (!empty($enginners))
                                                    @foreach ($enginners as $eng )
                                                    <tr>
                                                        <td>{{$eng[1]}}</td>
                                                        <td>{{$eng[3]}}</td>
                                                        <td>{{$eng[4]}}</td>
                                                        <td>{{$eng[2]}}</td>
                                                        <td>
                                                            <form action="{{route('action')}}" method="GET">
                                                                <input type="hidden" name="id" value="{{$eng[0]}}">
                                                                @if ($eng[5]!="pausado")
                                                                <button type="submit">Pausar</button>
                                                                @elseif ($eng[5]=="pausado")
                                                                <button type="submit">Continuar</button>
                                                                @endif
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form action="{{route('action')}}" method="GET">
                                                                <input type="hidden" name="id_f" value="{{$eng[0]}}">

                                                                <button type="submit">Finalizar</button>
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
                        <!--table of works -->
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Table of Works PPAP&PRIM </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >
                                        <table>
                                            <thead>
                                                <th>Type</th>
                                                <th>Client</th>
                                                <th>part Number</th>
                                                <th>Rev 1</th>
                                                <th>Rev 2</th>
                                                <th>Description Moviement</th>
                                                <th>Date</th>
                                                <th>Enginner</th>
                                                <th>Sign Quality</th>
                                                <th>Sign Imex</th>
                                                <th>Sign Testing</th>
                                                <th>Sign Production</th>
                                                <th>Sign Purchase</th>
                                                <th>Sign Planning</th>
                                            </thead>
                                            <tbody>
                                                @if(!empty($answer))
                                                @foreach ($answer as $answer)
                                                <tr>
                                                    <td>{{$answer[0]}}</td>
                                                    <td>{{$answer[1]}}</td>
                                                    <td>{{$answer[2]}}</td>
                                                    <td>{{$answer[3]}}</td>
                                                    <td>{{$answer[4]}}</td>
                                                    <td>{{$answer[5]}}</td>
                                                    <td>{{$answer[6]}}</td>
                                                    <td>{{$answer[7]}}</td>
                                                    <td>{{$answer[8]}}</td>
                                                    <td>{{$answer[9]}}</td>
                                                    <td>{{$answer[10]}}</td>
                                                    <td>{{$answer[11]}}</td>
                                                    <td>{{$answer[12]}}</td>
                                                    <td>{{$answer[13]}}</td>
                                                </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                          </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">

                                <div  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">CREATE PPAP & PRIM @if(session('error')) <p style="color: #FC4747"> {{session('error')}} </p> @endif</h5>

                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 760px;" id='work'>
                                    <div class="row" >
                                        <style>
                                            /* Form container */
                                            .containerPPAP {
                                              width: 100%;
                                              margin: 0 auto;
                                              padding: 20px;
                                              border-radius: 8px;

                                            }

                                            /* Label styles */
                                            label {
                                              display: block;
                                              margin-bottom: 5px;
                                              font-weight: bold;
                                            }

                                            /* Input styles */
                                            input[type="text"],
                                            textarea,
                                            select {
                                              width: calc(100% - 20px); /* Subtracting padding */
                                              padding: 8px;
                                              margin-bottom: 15px;
                                              border: 1px solid #ccc;
                                              border-radius: 4px;
                                              box-sizing: border-box;
                                            }

                                            /* Select styles */
                                            select {
                                              width: 100%;
                                            }

                                            /* Submit button styles */
                                            input[type="submit"] {
                                              padding: 10px 20px;
                                              background-color: #007bff;
                                              color: #fff;
                                              border: none;
                                              border-radius: 4px;
                                              cursor: pointer;
                                            }

                                            input[type="submit"]:hover {
                                              background-color: #0056b3;
                                            }
                                          </style>
                                          </head>
                                          <body>
                                          <div class="containerPPAP">
                                            <form action="{{route('RegPPAP')}}" method="GET">
                                            <label for="Tipo">Type of Work</label>
                                            <select name="Tipo" id="Tipo" required  >
                                              <option value=""></option>
                                              <option value="PPAP">NEW PPAP</option>
                                              <option value="PRIM">NEW PRIM</option>
                                              <option value="Change PPAP">Change PPAP</option>
                                              <option value="Change PRIM">Change PRIM</option>
                                              <option value="NO PPAP">NO PPAP</option>
                                            </select>
                                            <label for="Client">Client</label>
                                            <select name="Client" id="Client" required>
                                              <option value=""></option>
                                              <option value="DUR-A-LIFT">DUR-A-LIFT</option>
                                              <option value="BERSTROMG">BERGSTROM</option>
                                              <option value="BLUE BIRD">BLUE BIRD</option>
                                                <option value="ATLAS">ATLAS</option>
                                                <option value="UTILIMASTER">UTILIMASTER</option>
                                                <option value="CALIFORNIA">CALIFORNIA</option>
                                                <option value="TICO MANUFACTURING">TICO MANUFACTURING</option>
                                                <option value="SPARTAN">SPARTAN</option>
                                                <option value="PHOENIX">PHOENIX</option>
                                                <option value="FOREST RIVER">FOREST RIVER</option>
                                                <option value="SHYFT">SHYFT</option>
                                                <option value="KALMAR">KALMAR</option>
                                                <option value="MODINE">MODINE</option>
                                                <option value="NILFISK">NILFISK</option>
                                                <option value="PLASTIC OMNIUM">PLASTIC OMNIUM</option>
                                                <option value="ZOELLER">ZOELLER</option>
                                                <option value="COLLINS">COLLINS</option>
                                            </select>
                                            <label for="tipoArnes">Harness Type</label>
                                            <select name="tipoArnes" id="tipoArnes" required>
                                              <option value=""></option>
                                              <option value="Cable de bateria">BATTERY CABLE</option>
                                                <option value="Arnes">HARNESS</option>
                                                <option value="Caja">BOX</option>
                                                <option value="Kit de arneses">HARNESS KIT</option>
                                                <option value="panel">PANEL</option>
                                                <option value="componente">COMPONENT</option>
                                            </select>
                                            <label for="pn">PN</label>
                                            <input type="text" name="pn" id="pn" required onchange="updateRev()">
                                            <label for="rev1">Actual REV or new REV</label>
                                            <input type="text" name="rev1" id="rev1" required>
                                            <label for="rev2">New REV</label>
                                            <input type="text" name="rev2" id="rev2" >
                                            <label for="cambios">Modification's Descriptions </label>
                                            <textarea name="cambios" id="cambios" cols="60" rows="2" ></textarea>
                                            <label for="quien">Engineer</label>
                                            <select name="quien" id="quien" required>
                                              <option value=""></option>
                                                    <option value="Jesus C">Jesus Cervera</option>
                                                    <option value="Victor E">Victor Estrada</option>
                                                    <option value="Carlos R">Carlos Rodriguez</option>
                                                    <option value="Paola S">Paola Silva</option>
                                                    <option value="Nancy A">Nancy Aldana</option>

                                            </select>
                                            <input type="submit" value="Submit">
                                        </form>


                                          </div>
                        </div>

                    </div>
               </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Graficas de informacion </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 760px;" id="tableChange">
                                    <div class="row" >
                                    </div>
                                    <canvas id="graficasIng"></canvas>
                                    </div>
                                </div>
                            </div>

                    </div>
                    @endsection
