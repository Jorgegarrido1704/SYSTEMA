@extends('layouts.main')

@section('contenido')

 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

 <div class="row">
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <script>
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        </script>
 </div>
 <div class="row">
    <!-- Escanner -->
     <div class="col-xl-12 col-lg-12" >
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                <h6 class="m-0 font-weight-bold text-primary">{{__('Where is the order?') }}</h6>

            </div>

            <!-- table Body -->
            <div class="card-body" style=" height: 180px; ">
                <div class='input-group mb-3'>
                    <label class="input-group-text" for="controlWoSearch">Select</label>
                    <input class="form-control" type="text" id="controlWoSearch" name="controlWoSearch" placeholder="WO" max_length="6" onchange="whereIsTheOrder(this.value)">
                </div>
                <div id='WhereIsTheOrder'></div>


            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4" >
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                <h6 class="m-0 font-weight-bold text-primary">{{__('Accept Orders') }}</h6>

            </div>

            <!-- table Body -->
            <div class="card-body" style=" height: 380px; overflow-y: scroll">
                @if($previo->count() > 0)
                <table class="table table-bordered table-sm table-striped" id="previo" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('Part Number') }}</th>
                            <th>{{ __('WO') }}</th>
                            <th>{{ __('Qty') }}</th>
                            <th>{{ __('Accept') }}</th>
                            <th>{{ __('Decline') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($previo as $item)
                        <tr>
                            <td>{{ $item->pn }}</td>
                            <td>{{ $item->wo }}</td>
                            <td>{{ $item->qty }}</td>
                            <td><a href="{{ route('previos', ['wo'=>$item->wo ,'status'=>'accept']) }}" class="btn btn-success">{{ __('Accept') }}</a></td>
                            <td><a href="{{ route('previos', ['wo'=>$item->wo,'status'=>'decline']) }}" class="btn btn-danger">{{ __('Decline') }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>
        </div>
    </div>
     <div class="col-xl-4 col-lg-4" >
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                <h6 class="m-0 font-weight-bold text-primary">{{__('Work Not Started') }}</h6>

            </div>

            <!-- table Body -->
              <div class="card-body" style=" height: 380px; overflow-y: scroll">
                @if($iniciar->count() > 0)
                <table class="table table-bordered table-sm table-striped" id="previo" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('Part Number') }}</th>
                            <th>{{ __('WO') }}</th>
                            <th>{{ __('Qty') }}</th>
                            <th>{{ __('Start') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($iniciar as $item)
                        <tr>
                            <td>{{ $item->pn }}</td>
                            <td>{{ $item->wo }}</td>
                            <form action="{{ route('iniciar_work',['wo'=>$item->wo]) }}" method="POST">
                                @csrf

                            <td><input type="number" name="qty" id="qty" value="{{ $item->qty }}" min="0" max="{{ $item->qty }}" required></td>
                             <td><button type="submit" class="btn btn-warning">{{ __('Move') }}</button></td>
                            </form>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4" >
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                <h6 class="m-0 font-weight-bold text-primary">{{__('Work In Progress') }}</h6>

            </div>

            <!-- table Body -->
             <div class="card-body" style=" height: 380px; overflow-y: scroll">
                @if($registros->count() > 0)
                <table class="table table-bordered table-sm table-striped" id="registrar_work" cellspacing="0">
                    <thead>
                        <tr>
                            <th>{{ __('Part Number') }}</th>
                            <th>{{ __('WO') }}</th>
                            <th>{{ __('Qty') }}</th>
                            <th>{{ __('Finish') }}</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registros as $item)
                        <tr>
                            <td>{{ $item->pn }}</td>
                            <td>{{ $item->wo }}</td>
                            <form action="{{ route('registrar_work',['wo'=>$item->wo]) }}" method="POST">
                                @csrf

                            <td><input type="number" name="qty" id="qty" value="{{ $item->qty }}" min="0" max="{{ $item->qty }}" required></td>
                             <td><button type="submit" class="btn btn-danger">{{ __('Finish') }}</button></td>
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

                    <div class="row">

                        <!-- Active Work
                        <div class="col-xl-6 col-lg-4">
                            <div class="card shadow mb-4">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Harness position</h5>

                                </div>

                                <! table Body ->
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
                        <!- Active Work END-->

                        <!-- Table Work -->
                            <div class="col-lg-6 mb-4">
                                <!-- AREAS -->
                                <div class="card shadow mb-4">


                                    <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">{{__('Report Issue') }}</h5>
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

                                            <form  action="{{ route('maintananceGen')}}" method="POST">
                                                @csrf
                                                <div class="row" >
                                                    <div class="col-md-6">
                                                        <label for="nom_equipo" class="form-label">Equipo:</label>
                                                        <select id="nom_equipo" name="nom_equipo" class="form-select" required>
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
                                                    <div class="col-md-6">
                                                        <label for="dano" class="form-label">Daño del equipo</label>
                                                        <input type="text" id="dano" name="dano" class="form-input" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                            <label for="quien" class="form-label">Quien solicita</label>
                                                            <input type="text" id="quien" name="quien" class="form-input" readonly value="{{ $value }}" required>
                                                    </div>

                                                    <div class="col-md-6">
                                                            <label for="area" class="form-label">Area que solicita</label>
                                                            <select name="area" id="area" class="form-select" required>
                                                                <option value=""></option>
                                                                <option value="Corte">Corte</option>
                                                                <option value="Liberacion">Liberacion</option>
                                                                <option value="Ensamble">Ensable</option>
                                                                <option value="Loom">Loom</option>
                                                                <option value="Pruebas Electricas">Pruebas Electricas</option>
                                                            </select>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
                                                    </div>
                                                </div>
                                                </form>


                                    </div>
                                </div>
                            </div>
                               <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">{{ __('Pending Works') }} </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >
                                        <style>
                                            #Pendiente{   color: rgb(179, 179, 12);    }
                                            #Pausado{ color:  rgb(163, 3, 3);}
                                            #En_proceso{color: rgb(120, 184, 120);}

                                        </style>
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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

                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!--table of works -->


                        <!-- Column 2 -->
                        <div class="col-lg-6 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3" align="center">
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="m-0 font-weight-bold text-primary">Boms Filter
                                                <input type="text" class="form-control" name="partnum" id="partnum" onchange="SearchBom(this.value)" >
                                             </h5>
                                        </div>
                                        <div class="col-6">
                                            <h6 class="m-0 font-weight-bold text-primary">{{ __('Part Number W/braid') }}</h6>
                                            <div class="form-group">
                                                <select name="braid" id="braid" class="form-control" onchange="selectBraid()">
                                                    <option value="" disabled selected></option>
                                                    <option value="LSL132-1">Braid 0.028 delgado</option>
                                                    <option value="LSL364-34">Braid 0.040 grueso</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive" id="resps">
                                    </div>
                                 
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ITEM</th>
                                                <th>QTY</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_items">
                                           <tr>
                                                <td colspan="2" class="text-center">No data available</td>
                                            </tr>
                                        </tbody>
                                    </table>
                               
                                </div>
                            </div>
                        </div>

                 </div>
                 <script>
                    function whereIsTheOrder(wo){


                        var    url = '/whereIsTheOrder/' + wo;
                        fetch(url)
                         .then(response => response.json())
                     .then(data => {
                        console.log(data)
                        var plan=data.planpar;
                        var cut=parseInt(data.cortPar)+parseInt(data.precut)+parseInt(data.tobecut);
                        var term=parseInt(data.libePar)+parseInt(data.preterm)+parseInt(data.tobeterm);
                        var assem=parseInt(data.ensaPar)+parseInt(data.preassembly)+parseInt(data.tobeassembly)+parseInt(data.specialWire);
                        var loom=parseInt(data.loomPar)+parseInt(data.preloom)+parseInt(data.tobeloom);
                        var test=parseInt(data.testPar)+parseInt(data.fallasCalidad)+parseInt(data.preCalidad);
                        var pack=parseInt(data.preemba)+parseInt(data.embPar);
                        var eng = data.eng;
                        let html =`
                        <table class="table table-bordered table-hover" id="WhereIsTheOrder" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>{{ __('Part Number') }}</th>
                                    <th>{{ __('WO') }}</th>
                                    <th>{{ __('Planning') }}</th>
                                    <th>{{ __('Cutting') }}</th>
                                    <th>{{ __('Terminals') }}</th>
                                    <th>{{ __('Assembly') }}</th>
                                    <th>{{ __('Looming') }}</th>
                                    <th>{{ __('Testing') }}</th>
                                    <th>{{ __('Packing') }}</th>
                                    <th>{{ __('Enginner') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>${data.pn}</td>
                                    <td>${data.wo}</td>
                                    <td>${plan}</td>
                                    <td>${cut}</td>
                                    <td>${term}</td>
                                    <td>${assem}</td>
                                    <td>${loom}</td>
                                    <td>${test}</td>
                                    <td>${pack}</td>
                                    <td>${eng}</td>
                                </tr>
                            </tbody>
                        </table>
                                `;
                                document.getElementById('WhereIsTheOrder').innerHTML = html;
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });


                    }

                    async function selectBraid() {
                                            const braid = document.getElementById('braid').value
                        // Si el input está vacío, puedes decidir no enviar nada o enviar la fecha de hoy
                        if(!braid) return;
                                            try {
                            const response = await fetch('/getBraid?braid=' + braid);

                            // Si el servidor responde con error (500, 404, etc) saltará al catch
                            if (!response.ok) {
                                throw new Error(`Error en el servidor: ${response.status}`);
                            }
                            const data = await response.json();
                            console.log(data);

                                        }
                                        catch (error) {
                                            console.error(error);
                                        }
                                        }

                
                                        function SearchBom(bom){
                                                var url = '/Bom/' + bom;
                                                fetch(url)
                                                .then(response => response.json())
                                            .then(data => {
                                                console.log(data)
                                             
                                                        let html = data.map(data => `
                                                        <tr>
                                                            <td>${data.item}</td>
                                                            <td>${data.qty}</td>
                                                        </tr>
                                                        `);
                                                        
                                                        document.getElementById('tbody_items').innerHTML = html;
                                                    })
                                                    .catch(error => {
                                                        console.error('Error:', error);
                                                    });

                                        }

                </script>

  @endsection
