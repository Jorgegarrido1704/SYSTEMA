@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="180">
 <script src="{{ asset('/dashjs/calidadReg.js')}}"></script>
 <style>
    #overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); z-index: 99; }
    .modal { display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.2); z-index: 100; width: 340px; max-height: 80vh; overflow-y: auto; }
    .modal h3 { margin-top: 0; font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 10px; position: sticky; top: 0; background: white; z-index: 2;}

</style>
    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
    <div class="row" id="annuncement">
        @if(session('response'))
            <div class="col-lg-12 mb-4">
                <div class="alert alert-success">
                    {{ session('response') }}
                </div>
            </div>
            @endif
    </div>
                    <!-- Content Row -->
        <div class="row">
                        <!-- Content Column -->
                        <div class="col-lg-5 mb-4">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h4 class="m-0 font-weight-bold text-primary">{{ __('Ready for test') }}</h4>

                                </div>
                                <!-- Percent section -->
                                <div class="card-body" style="overflow-y: auto; height: 500px;">
                                    @if(empty($id))


                                    <div class="table">
                                        <table style="width: 100%;">
                                            <thead  align="center" style=" color:aliceblue; background-color:rgb(253, 3, 3);">
                                                <th>{{__('Part Number')}}</th>
                                                <th>{{ __('Customer') }}</th>
                                                <th>{{ __('WO') }}</th>
                                                <th>{{ __('Qty') }}</th>
                                                <th>{{ __('Start Test') }}</th>
                                                <th>{{ __('Reject') }}</th>
                                            </thead>
                                            <tbody class="table-group-divider">

                                                @foreach ($calidad as $cal)
                                                <tr>
                                                    <td class="text-center">{{$cal->np}}</td>
                                                    <td class="text-center">{{$cal->client}}</td>
                                                    <td class="text-center">{{$cal->wo}}</td>
                                                    <td class="text-center">{{$cal->qty}}</td>
                                                    <td class="text-center">
                                                        <form action="{{route('baja')}}" method="GET" id="forma">
                                                            <input type="hidden" name="id" id="id" value="{{$cal->id}}">
                                                            <button class="btn btn-primary" type="submit" id="enviar">{{ __('Start') }}</button>
                                                        </form></td>
                                                        <td class="text-center">
                                                            @if(substr($cal->rev, 0, 4) != 'PPAP' and substr($cal->rev, 0, 4) != 'PRIM')
                                                            <button class="btn btn-danger" onclick="abrirModalRechazo({{$cal->id}})">{{ __('Reject') }}</button>

                                                        @endif
                                                        </td>

                                                    </tr>
                                                    @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                         <div id="overlay"></div>
                                         <div id="modal-cable" class="modal">
                                                <h3>{{__('Rejection')}} id: <span id="identificador"></span></h3>
                                                <form action="{{ route('fallasCalidad') }}" method="POST" id="form-rechazo">
                                                @csrf
                                                <div class="form-group"><label>{{__('Why rejection')}}</label><textarea name="porqueRechazo" id="porqueRechazo" cols="30" rows="10" required class="form-control"></textarea></div>
                                                   <div class="form-group"><label>{{__('Select responsible')}}</label> <select id="responsableRechazon" name="responsableRechazon" class="form-control" required>
                                                        <option value="" selected disabled> {{__('Select responsible')}}</option>
                                                        @foreach ($personal as $item)
                                                            <option value="{{ $item->user }}">{{ $item->employeeName }}</option>
                                                        @endforeach

                                                    </select>
                                                    <input type="hidden" name="idRechazos" id="idRechazos">
                                                   </div>


                                                <div class="modal-actions"><div><button class="btn-cancel btn-danger mr-2" onclick="cerrarModales()">{{ __('Cancel') }}</button><button class="btn-success btn" type="submit" >{{ __('Save') }}</button></div></div>
                                                </form>
                                        </div>
                                        @endif

                                </div>
                                </div>
                           </div>
                            <div class="col-md-4 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h4 class="m-0 font-weight-bold text-primary">{{ __('Pre-accepted data') }}</h4>
                                    </div>
                                    <div class="card-body" style="overflow-y: auto; height: 500px;">
                                        <table class="table table-bordered" id="preorder">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('Part Number') }}</th>
                                                    <th scope="col">{{ __('WO') }}</th>
                                                    <th scope="col">{{ __('Qty') }}</th>
                                                    <th scope="col">{{ __('Accept') }}</th>
                                                    <th scope="col">{{ __('Decline') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($preorder))
                                                @foreach ($preorder as $item)
                                                    <tr>
                                                        <td>{{ $item->pn }}</td>
                                                        <td>{{ $item->wo}}</td>
                                                        <td>{{ $item->preCalidad}}</td>
                                                        <td>
                                                            <form action="{{ route('accepted') }}" method="GET">
                                                                @csrf
                                                                <input type="hidden" name="acpt" value="{{ $item->id }}" id="acpt">
                                                                <button type="submit" class="btn btn-success">{{ __('Accept') }}</button>
                                                            </form>
                                                        </td>
                                                        @if(substr($item->rev, 0, 4) != 'PPAP' and substr($item->rev, 0, 4) != 'PRIM')
                                                        <td> <form action="{{ route('accepted') }}" method="GET">
                                                            @csrf
                                                            <input type="hidden" name="denied" value="{{ $item->id }}" id="denied">
                                                            <button type="submit" class="btn btn-danger">{{ __('Decline') }}</button>
                                                        </form>
                                                        </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h4 class="m-0 font-weight-bold text-primary">{{ __('Total') }}</h4>
                                    </div>
                                    <div class="card-body" style="overflow-y: auto; height: 500px;">
                                        <table class="table table-bordered" id="total">
                                            <thead>
                                                <tr>
                                                    <th scope="col">{{ __('Employee') }}</th>
                                                    <th scope="col">{{ __('No. Employee') }}</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(!empty($employee))
                                                @foreach ($employee as $emp)
                                                    <tr>
                                                        <td><strong>{{ $emp->employeeName }}</strong></td>
                                                        <td><strong>{{ $emp->employeeNumber}}</strong></td>
                                                    </tr>
                                                @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        <!-- Second Column for WO by Area and Shipping Area -->
                        <div class="col-lg-2 mb-4">
                            <!-- WO by Area -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">{{__('Where is the order?')}}</h6>
                                </div>
                                <div class="card-body">
                                    <!-- Your WO by Area content here -->
                                    <div class="card-body" style="overflow-y: auto; height: 320px;">
                                        <div class="chart-pie pt-4 pb-2">
                                            <form action="{{ route('codigoCalidad') }}" method="POST">
                                                @csrf
                                                <div class="form-group">

                                                    <input type="text" class="form-control" name="code-bar" id="code-bar" placeholder="{{ __('Enter code here') }}">
                                                </div>
                                                    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                                            </form>
                                            <br>
                                            <h3 align="center">{{ session('response') }}</h3>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <!-- Shipping Area -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">{{__('Quality Inspection Report') }}</h6>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                                            <div class="input-group mb-3">
                                                                <label class="input-group-text" for="wo_search">{{ __('WO') }}</label>
                                                                <input class="form-control" type="text" id="wo_search" name="wo_search" placeholder="000000" min_length="6" max_length="6" onchange="searchWO(this.value)">
                                                            </div>
                                                            <div id=tables_work_orders></div>
                                                                
                                                           

                                </div>
                            </div>
                        </div>


             <div class="col-lg-6 mb-4">
                            <!-- Request Testing -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h4 class="m-0 font-weight-bold text-primary">{{ __('Reworks') }}</h4>
                                </div>

                            <div class="card body" style="overflow-y: scroll; height: 360px">
                                <table class="table table-bordered table-hover " id="reworkTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Part Number') }}</th>
                                            <th>{{ __('WO') }}</th>
                                            <th>{{ __('Issue') }}</th>
                                            <th>{{ __('Responsable') }}</th>
                                            <th>{{ __('Why? (production)') }}</th>
                                            <th>{{ __('What will do') }}</th>
                                            <th>{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    @if(!empty($fallas))
                                    <tbody>
                                        @foreach ($fallas as $item)
                                            <tr>
                                                <td>{{ $item->pn }}</td>
                                                <td>{{ $item->wo }}</td>
                                                <td>{{ $item->porqueCalidad }}</td>
                                                <td>{{ $item->responsable_produccion }}</td>
                                                <td>{{ $item->porqueProduccion }}</td>
                                                <td>{{ $item->accionCorrectiva }}</td>
                                                <td>
                                                @if(!empty($item->porqueProduccion))
                                                <button class="btn btn-danger" onclick="location.href='{{ route('calidad.cerrarFalla', ['id' => $item->id, 'accion' =>'0']) }}'">{{ __('Reopen') }}</button>
                                                <button class="btn btn-success"
                                                onclick="location.href='{{ route('calidad.cerrarFalla', ['id' => $item->id, 'accion' =>'1']) }}'">{{ __('Close') }}</button>
                                                @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    @endif

                                </table>
                            </div>
                            </div>
             </div>

        </div>

        <script>
            function searchWO(wo) {
                const order=wo;
                var url = '/wo_search_progress/'+wo;
                var table= document.getElementById('tables_work_orders');
                table.innerHTML='';
                // change workOrder for w
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                       
                    let html = `
                    <table class="table table-bordered table-hover" id="reworkTable" cellspacing="0">
                        <thead>
                            <tr>
                                <th>{{ __('Area') }}</th>
                                <th>{{ __('Qty') }}</th>
                                <th>{{ __('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                    `;

                    data.forEach(item => {
                        html += `
                            <tr>
                                <td>${item.area}</td>
                                <td>${item.qtyPar}</td>
                                <td>${item.fechaReg}</td>
                            </tr>
                        `;
                    });

                    html += `
                        </tbody>
                    </table>
                    `;
                    table.innerHTML = html;

                       
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }


            function updateInfoCalidad() {
                var wo = document.getElementById('workElectrical').value;
                var url= @json(route('informationWo'));
                fetch(url, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ workElectrical: wo })
                })
                    .then(response => response.json())
                    .then(data => {

                       console.log(data);
                        document.getElementById('pn').value = data.NumPart;
                        document.getElementById('cust').value = data.cliente;
                        document.getElementById('qty').value = 1;
                        document.getElementById('rev').value = data.rev;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });

            }
            function abrirModalRechazo(id) { enlaceActual = id; $('#overlay, #modal-cable').show();
            document.getElementById('idRechazos').value=id;
            document.getElementById('identificador').textContent=id;
            }
            function cerrarModales() { $('#overlay, #modal-cable').hide(); }
            function VerificarRechazo() {
                var idRechazos = document.getElementById('idRechazos').value;
                var porqueRechazo = document.getElementById('porqueRechazo').value;
                var responsableRechazon = document.getElementById('responsableRechazon').value;
                if(porqueRechazo === '' || responsableRechazon === '' || idRechazos === '') {
                    alert('Please fill in all fields');
                    return false;
                }
                return true;
            }
        </script>



@endsection
