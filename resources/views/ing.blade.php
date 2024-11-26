@extends('layouts.mainWithoutsidebar')

@section('contenido')
 <!-- Page Heading -->


 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-8 col-lg-7"  >
                            <div class="card shadow mb-4" id="card">
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Trabajos ingenieria</h5>
                                </div>

                                <!-- table Body -->
                                <div class="card-body" style="overflow-y: auto; max-height: 400px;">
                                    <div class="chart-area" id="chart-area">
                                        <style>
                                            .ppap {  text-align: center; font-weight: bold; background-color: rgb(53, 243, 75); }
                                            .prim{  text-align: center; font-weight: bold; background-color: rgb(240, 243, 53); }
                                            .table-header {  text-align: center; font-weight: bold; background-color: rgb(235, 83, 202); }
                                            table {     width: 100%;                     }
                                            td,th{text-align: center;}
                                            td {border-bottom: solid 2px lightblue; }
                                            thead{background-color: #bd0606; color:white;  }
                                            a{text-decoration: none; color: whitesmoke;  }
                                            a:hover{ text-decoration: none; color: white; font:bold;}
                                            .soporte{text-align: center; font-weight: bold; background-color: rgb(88, 8, 247); }
                                        </style>
                                        <table id="table-harness" class="table-harness">
                                            <thead>
                                                <tr>
                                                    <th class="ppap"></th>
                                                    <th class="ppap"></th>
                                                    <th class="ppap">PPAP</th>
                                                    <th class="ppap"></th>
                                                    <th class="prim"> </th>
                                                    <th class="prim"> </th>
                                                    <th class="prim">PRIM </th>
                                                    <th class="prim"> </th>
                                                </tr>
                                                <tr>
                                                <th>Part Number</th>
                                                <th>Client</th>
                                                <th>REV</th>
                                                <th>WO</th>
                                                <th>PO</th>
                                                <th>Qty</th>
                                                <th>Area</th>
                                                <th>Sign</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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
                                            </tbody>
                                        </table>
                                        <table id="table-harness" class="table-harness">
                                            <thead>
                                                <tr>
                                                    <th class="table-header"></th>
                                                    <th class="table-header"></th>
                                                    <th class="table-header"></th>
                                                    <th class="table-header"></th>
                                                    <th class="table-header"></th>
                                                    <th class="table-header">FULL SIZE </th>
                                                    <th class="table-header"> </th>
                                                    <th class="table-header"> </th>
                                                    <th class="table-header"> </th>
                                                    <th class="table-header"> </th>
                                                </tr>
                                                <tr>
                                                <th>Solcitado por</th>
                                                <th>Fecha de solictud</th>
                                                <th>np</th>
                                                <th>rev</th>
                                                <th>Cliente</th>
                                                <th>Cantidad requerida</th>
                                                <th>Tablero</th>
                                                <th>Estatus</th>
                                                <th>Modificar</th>
                                                <th>Finalizar</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($fullreq as $inge )
                                                    <tr>
                                                            <td>{{$inge[1]}}</td>
                                                            <td>{{$inge[2]}}</td>
                                                            <td>{{$inge[3]}}</td>
                                                            <td>{{$inge[4]}}</td>
                                                            <td>{{$inge[5]}}</td>
                                                            <td>{{$inge[6]}}</td>
                                                            <td>{{$inge[8]}}</td>
                                                            <form action="{{"modifull"}}" method="GET">
                                                            <td><select name="estatus" id="estatus">
                                                                <option value="{{$inge[7]}}">{{$inge[7]}}</option>
                                                                <option value="En_proceso">En proceso</option>
                                                                <option value="Pausado">Pausado</option>
                                                            </select></td>
                                                            <td><input type="hidden" id='mod' name='mod' value="{{$inge[0]}}">
                                                            <input type="submit" name="enviar" id="enviar" value='Modificar'></td>
                                                        </form>
                                                           <form action="{{"modifull"}}" method="GET">
                                                            <td><input type="hidden" id='finAct' name='finAct' value="{{$inge[0]}}">
                                                            <input type="submit" name="enviar" id="enviar" value='Finalizar'></td>
                                                        </form>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="soporte"></th>
                                                    <th class="soporte"></th>
                                                    <th class="soporte"></th>
                                                    <th class="soporte">SOPORTE EN PISO</th>
                                                    <th class="soporte"></th>
                                                    <th class="soporte"></th>
                                                    <th class="soporte"></th>

                                                </tr>
                                                <tr>
                                                    <th>Part Number</th>
                                                    <th>WO</th>
                                                    <th>REV</th>
                                                    <th>Problem</th>
                                                    <th>Who requested</th>
                                                    <th>Date</th>
                                                    <th>Take action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($soporte as $sop )
                                                <tr>
                                                    <td>{{$sop[1]}}</td>
                                                    <td>{{$sop[2]}}</td>
                                                    <td>{{$sop[3]}}</td>
                                                    <td>{{$sop[4]}}</td>
                                                    <td>{{$sop[5]}}</td>
                                                    <td>{{$sop[6]}}</td>
                                                    <td><form action="#">
                                                        <button type="submit">iniciar</button>
                                                    </form></td>
                                                </tr>

                                                @endforeach
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
                                                    <option value="Jorge G">Jorge Garrido</option>
                                                    <option value="Carlos R">Carlos Rodriguez</option>
                                                    <option value="Paola S">Paola Silva</option>
                                                    <option value="Nancy A">Nancy Aldana</option>
                                                    <option value="Todos">Todos El equipo</option>
                                                </select>

                                        <label for="act"><h4>Actividad a realizar</h4></label>
                                                <select name="act" id="act" required>
                                                    <option value=""></option>
                                                    <option value="Sistemas">Modificacion o creacion de sistemas</option>
                                                    <option value="Documentacion ">Documentacion PPAP</option>
                                                    <option value="Soporte en piso">Soporte en piso</option>
                                                    <option value="Colocacion de full size">Colocacion de full size</option>
                                                    <option value="Seguimiento PPAP">Seguimiento PPAP</option>
                                                    <option value="Diseno de piezas 3D">Diseño de piezas 3D</option>
                                                    <option value="Comida">Comida</option>
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
                                <h5 class="m-0 font-weight-bold text-primary">CREATE PPAP & PRIM @if(session('error')) <p style="color: #FC4747"> {{session('error')}} </p> @endif <a style="hover: none" href="{{route('excel_ing')}}">excel</a></h5>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                        aria-labelledby="dropdownMenuLink">
                                       <a class="dropdown-item" href="#" onclick="ingregistro('cronograma')">Cronograma</a>
                                        <a class="dropdown-item" href="#" onclick="ingregistro('ppap')">Registro de ppap</a>

                                    </div>
                                </div>
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
                                            input[type="date"],
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

                                          <div class="containerPPAP" id="containerPPAP">
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
                                              <option value="MORGAN OLSON">MORGAN OLSON</option>
                                              <option value="JHON DEERE">JHON DEERE</option>
                                              <option value="OP MOVILITY">OP MOVILITY</option>
                                              <option value="BROWN">BROWN</option>
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
                                                <option value="Proterra Powered LLC">Proterra Powered LLC.</option>"></option>
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
                                                    <option value="Jorge G">Jorge Garrido</option>

                                            </select>
                                            <input type="submit" value="Submit">
                                        </form>


                                          </div>
                        </div>

                    </div>
               </div>
                        </div>
                        <style>
                                   /* Add this CSS code to your stylesheet or in a <style> tag in your HTML file */
        #tiempos {
            transition: all 0.3s ease; /* Smooth transition effect */
            width: 100%; /* Initial width */
            height: auto; /* Initial height */
            position: relative; /* Ensure normal positioning initially */
        }

        #tiempos:hover {
            width: 100vw;  /* Make the width 100% of the viewport width */
            height: 100vh; /* Make the height 100% of the viewport height */
            position: fixed; /* Fix the position to the viewport */
            top: 0; /* Align to the top of the viewport */
            left: 0; /* Align to the left of the viewport */
            z-index: 9999; /* Bring the element to the front */
            overflow: auto; /* Ensure overflow is handled */
            background: white; /* Optional: Set a background color */
        }
        canvas {
            max-height: 50%;
        }
        a{
            color: #007bff;
        }
                        </style>
                        <div class="col-lg-6 mb-4" >
                            <!-- AREAS -->

                            <div class="card shadow mb-4" id="tiempos">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Cronograma de Trabajo ING</h5>
                                    <button><a href="/ing" >Mes actual</a></button><button><a href="/ing?mont='fr'">Siguiente mes</a></button>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 760px; " id="">
                                    <div class="row" >
                                        <div id="table">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Cliente</th>
                                                    <th>No. Parte</th>
                                                    <th>REV</th>
                                                    <th>Fecha Fecha Compromiso Inicial</th>
                                                    <th>Fecha Compromiso con cambios</th>
                                                    @foreach ($dias_mes as $dias)
                                                    <th>{{$dias}}</th>
                                                    @endforeach
                                                    <th>Nueva Fecha</th>
                                                    <th>Guardar cambio</th>
                                                    <th>Finalizar</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                    @foreach($cronoGram as $cron )
                                                        <tr>
                                                            <td>{{$cron[1]}}</td>
                                                            <td>{{$cron[2]}}</td>
                                                            <td>{{$cron[3]}}</td>
                                                            <td>{{$cron[5]}}</td>
                                                            @if ($cron[5] == $cron[6])
                                                            <td></td>
                                                             @else
                                                            <td> {{$cron[6]}}</td>
                                                            @endif
                                                            @foreach ($dias_mes as $dias)
                                                            @if($dias >= $cron[11] && $dias <= $cron[10] && $cron[5] == $cron[6])
                                                            <td ><input type="box" name="check" id="check" style="background-color:GREEN; width: 20px; height: 20px;"></td>
                                                            @elseif ($dias >= $cron[11] && $dias <= $cron[10] && $cron[5] != $cron[6])
                                                                @if($dias >= $cron[11] && $dias <= $cron[10]-$cron[12])
                                                                    <td ><input type="box" name="check" id="check" style="background-color:GREEN; width: 20px; height: 20px;"></td>
                                                                @else
                                                                    <td ><input type="box" name="check" id="check" style="background-color:lightblue; width: 20px; height: 20px;"></td>
                                                                @endif
                                                            @else
                                                            <td ><input type="box" name="check" id="check" style=" width: 20px; height: 20px;"></td>
                                                            @endif
                                                            @endforeach
                                                            <form action="{{route('cronoReg')}}" method="GET">
                                                            <td>
                                                            <input type="date" name="nuevaFecha" id="nuevaFecha" >
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="id_cambio" id="id_cambio" value="{{$cron[0]}}">
                                                                <input type="submit" name="enviar" id="enviar" value='Guardar'></td>
                                                        </form>
                                                        <td>
                                                            <form action="{{route('cronoReg')}}" method="GET">
                                                                <input type="hidden" name="id_fin" id="id_fin" value="{{$cron[0]}}">
                                                                <input type="submit" name="enviar" id="enviar" value='Finalizar'>
                                                            </form>
                                                        </td>
                                                        </tr>


                                                    @endforeach


                                            </tbody>
                                        </table>
                                        <canvas id="regGraf"></canvas>

                                    </div>

                                    </div>

                                </div>
                                </div>
                            </div>

                    </div>
                   <!-- Reportes -->
                    <div class="row">
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="m-0 font-weight-bold text-primary">Problems on the floor</h5>

                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" >
                                    <form class="row g-3" action="{{route('problemas')}}" method="GET">
                                        <div class="col-md-6">
                                          <label for="pnIs" class="form-label">Part Number</label>
                                          <input type="text" class="form-control" name="pnIs" id="pnIs" required>
                                        </div>
                                        <div class="col-md-6">
                                          <label for="workIs" class="form-label">Work Order</label>
                                          <input type="text" class="form-control" name="workIs" id="workIs"  minlength="6" required>
                                        </div>
                                        <div class="col-md-6">
                                          <label for="revIs" class="form-label">Revision</label>
                                          <input type="text" class="form-control" name="revIs" id="revIs" minlength="1" required>
                                        </div>
                                        <div class="col-md-6">
                                          <label for="probIs" class="form-label">Problem</label>
                                          <select id="probIs"  name="probIs" class="form-select" required>
                                            <option selected>...</option>
                                            <option value = "Prosses Error">Prosses Error</option>
                                            <option value = "Paper work">Paper work</option>
                                            <option value = "Both(Prosses Error and Paper work)">Both(Prosses Error and Paper work)</option>
                                            <option value = "Other">Other</option>
                                          </select>
                                        </div>
                                        <div class="col-md-9">
                                          <label for="descIs" class="form-label">Description</label>
                                          <textarea class="form-control"  name="descIs" id="descIs" rows="3"></textarea>
                                        </div>
                                        <div class="col-md-3">
                                          <label for="answer" class="form-label">Have you fixed it</label>
                                          <select id="answer" name="answer" class="form-select" required>
                                            <option selected>...</option>
                                            <option value = "Yes">Yes</option>
                                            <option value = "No">No</option>
                                            <option value = 'No yet'>No yet</option>
                                          </select>

                                          <div class="col-md-12">
                                            <label for="val" class="form-label">Validation By</label>
                                            <input type="text" class="form-control" name="val" id="val" minlength="1" required>
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <button type="submit" class="btn btn-primary">Send Info</button>
                                        </div>
                                      </form>
                                </div>
                            </div>
                        </div>

                        <!--table of works -->
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Create</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" >

                                </div>
                            </div>
                        </div>
                    </div>

                    @endsection
