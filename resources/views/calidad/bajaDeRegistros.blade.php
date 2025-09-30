@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="60; url={{route('calidad')}} ">
 <script src="{{ asset('/dash/js/calidadReg.js')}}"></script>
<script>
    const modificacionsCali = @json(route('buscarcodigo'));
    const empleadosFallas = @json(route('personalFallas'));
    </script>
                    <!-- Content Row -->
        <div class="row">
                        <!-- Content Column -->
                        <div class="col-lg-12 mb-12">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h4 class="m-0 font-weight-bold text-primary">Ready for test</h4>

                                </div>
                                <!-- Percent section -->
                                <div class="card-body" style="overflow-y: auto; height: 760px;">

                                        <div align="center">
                                            <div class="d-flex justify-content-center" align="center">

                                                <h3><span style="margin-right: 30px">Client:  {{$buscarInfor->client}}</span> <span style="margin-right: 30px">Part Number: {{$buscarInfor->np}}</span> <span style="margin-right: 30px">Qty: {{$buscarInfor->qty}}</span><span style="margin-right: 30px"> Wo: {{$buscarInfor->wo}}</span></h3>
                                              </div>

                                                    <br>
                                                    <form action="{{route('saveData')}}" method="POST">
                                                        @csrf
                                        <div> <h4>OK<input type="number" style="width:80px;margin-right:80px;" name="ok" id="ok" value="0"  max="{{ $cambioestados[0] }}" onchange="return checkOk()">
                                               NOK<input type="number" style="width: 80px;margin-right:80px" name="nok" id="nok" value="0"  max="5" onchange="return checkOk()"></h4></div>
                                                         <script>
                                                                    function checkOk(){
                                                                    var checkOk=document.getElementById('ok').value;
                                                                    var checkNok=document.getElementById('nok').value;
                                                                var total=parseInt(checkOk)+parseInt(checkNok);
                                                                        if(total>{{$buscarInfor->qty}}){
                                                                    document.getElementById('ok').value=0;
                                                                    document.getElementById('nok').value=0;

                                                                }
                                                                    }
                                                         </script>
                                      <br>

                                        <div class="row d-flex justify-content-center" style="display:  {{ $cambioestados[3] }} ">
                                            <div class=" col-md-2 mt-2">
                                                <div class="d-flex justify-content-center">Code #1</div>
                                                <div class="d-flex justify-content-center">
                                                <input type="text" style="width:80px;" name="codigo1" id="codigo1" onchange="buscarcodigo1()">
                                                <input type="text" style="width:280px;" name="rest_code1" id="rest_code1">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mt-2">
                                                <div class="d-flex justify-content-center">
                                                    <input type="hidden" style="width: 80px;margin-right:80px" name="1" id="1" value="0" >
                                                    Responsable
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <input type="text" style="width: 80px;margin-right:80px"
                                                    name="responsable1" id="responsable1" value="0000" minlength="4" maxlength="4" onchange="empleado1()">
                                                        <input type="text" style="width: 380px;margin-right:80px" name="resp1" id="resp1" readonly>
                                                    High Rework<input type="checkbox" name="check1" id="check1" value="1">
                                            </div>
                                        </div>


                                         <div><h4>Serial <input type="text" style="width: 180px" name="serial" id="serial" {{ $cambioestados[2] }} {{ $cambioestados[4] }}> </h4></div>
                                        <br>
                                        <input type="hidden" name="clienteErr" id="clienteErr" value="{{$buscarInfor->client}}">
                                        <input type="hidden" name="infoCal" id="infoCal" value="{{$buscarInfor->info}}">
                                        <input type="hidden" name="pn_cali" id="pn_cali" value="{{$buscarInfor->np}}">
                                        <input type="hidden" name="id_cali" id="id_cali" value="{{$buscarInfor->id}}">
                                         <input type="submit" name="enviar" id="enviar" value="Save">
                                        </form>
                                    </div>





                              </div>
                            </div>
                           </div>
                        <!-- Content Column -->
                        <div class="col-lg-6 mb-6">
                            <!-- Project Card Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h4 class="m-0 font-weight-bold text-primary">Estatus de registro</h4>
                                </div>
                                <div class="card-body" style=" height: 85px;">
                                  <p>{{ session('response') }}</p>
                                </div>
                            </div>
                        </div>
            </div>



@endsection
