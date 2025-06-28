@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="60; url={{route('calidad')}} ">
 <script src="{{ asset('/dash/js/calidadReg.js')}}"></script>
<script>
    const modificacionsCali = @json(route('buscarcodigo'));
    </script>
                    <!-- Content Row -->
        <div class="row">
                        <!-- Content Column -->
                        <div class="col-lg-6 mb-6">
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
                                        <div> <h4>OK<input type="number" style="width:80px;margin-right:80px;" name="ok" id="ok" value="1"  max="{{ $cambioestados[0] }}" onchange="return checkOk()">      NOK<input type="number" style="width: 80px;margin-right:80px" name="nok" id="nok" value="0"  max="5" onchange="return checkOk()"></h4></div>
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
                                      <br> <br> <br>

                                        <div class="d-flex justify-content-center"  >
                                            <h4>Code #1
                                                <input type="text" style="width:80px;margin-right:10px;" name="codigo1" id="codigo1" onchange="buscarcodigo1()">
                                                <input type="text" style="width:280px;margin-right:80px;" name="rest_code1" id="rest_code1">
                                            <input type="hidden" style="width: 80px;margin-right:80px" name="1" id="1" value="0" >
                                            Responsable  <input type="text" style="width: 80px;margin-right:80px" name="responsable1" id="responsable1" value="0" maxlength="4">
                                            High Rework<input type="checkbox" name="check1" id="check1" value="1">
                                            </h4>
                                        </div>

                                        <div class="d-flex justify-content-center"  style="display:  {{ $cambioestados[3] }}">
                                            <h4>Code #2
                                                <input type="text" style="width:80px;margin-right:10px;" name="codigo2" id="codigo2" onchange="buscarcodigo2()" {{ $cambioestados[1] }} >
                                                <input type="text" style="width:280px;margin-right:80px;" name="rest_code2" id="rest_code2"{{ $cambioestados[1] }} >
                                                <input type="hidden" style="width: 80px;margin-right:80px" name="2" id="2" value="0" {{ $cambioestados[1] }}>
                                                Responsable  <input type="text" style="width: 80px;margin-right:80px" name="responsable2" id="responsable2" value="0" {{ $cambioestados[1] }}>
                                                High Rework<input type="checkbox" name="check2" id="check2" value="1" {{ $cambioestados[1] }}>
                                            </h4>
                                        </div>

                                        <div class="d-flex justify-content-center"  style="display:  {{ $cambioestados[3] }}">
                                            <h4>Code #3
                                                <input type="text" style="width:80px;margin-right:10px;" name="codigo3" id="codigo3" onchange="buscarcodigo3()" {{ $cambioestados[1] }}>
                                                <input type="text" style="width:280px;margin-right:80px;" name="rest_code3" id="rest_code3" {{ $cambioestados[1] }}>
                                                <input type="hidden" style="width: 80px;margin-right:80px" name="3" id="3" value="0" {{ $cambioestados[1] }} >
                                                Responsable  <input type="text" style="width: 80px;margin-right:80px" name="responsable3" id="responsable3" value="0" {{ $cambioestados[1] }} >
                                                High Rework<input type="checkbox" name="check3" id="check3" value="1" {{ $cambioestados[1] }}>
                                            </h4>
                                        </div>
                                        <div class="d-flex justify-content-center" style="display:  {{ $cambioestados[3] }}">
                                            <h4>Code #4
                                                <input type="text" style="width:80px;margin-right:10px;" name="codigo4" id="codigo4" onchange="buscarcodigo4()" {{ $cambioestados[1] }}>
                                                <input type="text" style="width:280px;margin-right:80px;" name="rest_code4" id="rest_code4" {{ $cambioestados[1] }}>
                                                <input type="hidden" style="width: 80px;margin-right:80px" name="4" id="4" value="0" {{ $cambioestados[1] }} >
                                                Responsable  <input type="text" style="width: 80px;margin-right:80px" name="responsable4" id="responsable4" value="0" {{ $cambioestados[1] }}>
                                                High Rework<input type="checkbox" name="check4" id="check4" value="1" {{ $cambioestados[1] }}>
                                            </h4>
                                        </div>
                                        <div class="d-flex justify-content-center" style="display: {{ $cambioestados[3] }}">
                                            <h4>Code #5
                                                <input type="text" style="width:80px;margin-right:10px;" name="codigo5" id="codigo5" onchange="buscarcodigo5()" {{ $cambioestados[1] }}>
                                                <input type="text" style="width:280px;margin-right:80px;" name="rest_code5" id="rest_code5" {{ $cambioestados[1] }}>
                                                <input type="hidden" style="width: 80px;margin-right:80px" name="5" id="5"  value="0" {{ $cambioestados[1] }} >
                                                Responsable  <input type="text" style="width: 80px;margin-right:80px" name="responsable5" id="responsable5" value="0" {{ $cambioestados[1] }}>
                                                High Rework<input type="checkbox" name="check5" id="check5" value="1" {{ $cambioestados[1] }}>
                                            </h4>
                                        </div>


                                         <div><h4>Serial <input type="text" style="width: 180px" name="serial" id="serial" {{ $cambioestados[2] }} {{ $cambioestados[4] }}> </h4></div>
                                        <br>
                                        <input type="hidden" name="clienteErr" id="clienteErr" value="{{$buscarInfor->client}}">
                                        <input type="hidden" name="infoCal" id="infoCal" value="{{$buscarInfor->info}}">
                                        <input type="hidden" name="pn_cali" id="pn_cali" value="{{$buscarInfor->np}}">
                                        <input type="hidden" name="id_cali" id="id_cali" value="{{$buscarInfor->id}}">
                                         <input type="submit" name="enviar" id="enviar" value="Save">
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
