@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->

 <script>const routeMostrarWo = @json(route('datosOrdenes'));
    const updateDatos = @json(route('altaDatos'));
 </script>
<script src="{{ asset('/dash/js/mostrarWo.js')}}"></script>
<style>
    input[type="number"] {
        width: 65px;
        padding: 4px;

    }
</style>

 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">
                        <!-- Shipping Area -->
                        <div class="card shadow mb-4 col-lg-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Shipping Area</h6>
                            </div>
                                        <div class="card-body" style="overflow-y: auto; height: 360px;">
                                                            <form action="{{ route('excel_calidad')}}" method="GET" >

                                                                <div class="form-group">
                                                                    <label for="text">De fecha:</label>
                                                                    <input type="date" class="form-control" name="de" id="de" required >
                                                                    <span id="errorMessage" style="color: red; display: none;">Weekends are not allowed!</span>
                                                                    <input type="hidden" name="di" id="di">

                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="text">A fecha:</label>
                                                                    <input type="date" class="form-control" name="a" id="a" required>
                                                                    <span id="errorMessage1" style="color: red; display: none;">Weekends are not allowed!</span>
                                                                    <input type="hidden" name="df" id="df">
                                                                </div>
                                                                <input type="submit" class="btn btn-primary"   value="Descargar Excel">
                                                            </form>
                                                            <script>
                                                                document.getElementById('de').addEventListener('change', function() {
                                                                    var de = document.getElementById('de').value;
                                                                    const errorMessage = document.getElementById('errorMessage');
                                                                    const selectedDate = new Date(de);
                                                                        const dayOfWeek = selectedDate.getDay(); // 0 is Sunday, 6 is Saturday

                                                                        if (dayOfWeek === 6 || dayOfWeek === 5) {
                                                                            errorMessage.style.display = 'inline';
                                                                            alert('Weekends are not allowed!');
                                                                            document.getElementById('de').value='';
                                                                        } else {
                                                                            errorMessage.style.display = 'none';
                                                                    deA= de.slice(0,4);
                                                                    dem=de.slice(5,7);
                                                                    deD=de.slice(8,10);
                                                                    de=deD+"-"+dem+"-"+deA+" 00:00";
                                                                    document.getElementById('di').value=de;
                                                                    console.log('De fecha:', de);}
                                                                    });

                                                                document.getElementById('a').addEventListener('change', function() {
                                                                    var a = document.getElementById('a').value;
                                                                    const errorMessage1 = document.getElementById('errorMessage1');
                                                                    const selectedDate1 = new Date(a);
                                                                        const dayOfWeek1 = selectedDate1.getDay(); // 0 is Sunday, 6 is Saturday

                                                                        if (dayOfWeek1 === 6 || dayOfWeek1 === 5) {
                                                                            errorMessage1.style.display = 'inline';
                                                                            alert('Weekends are not allowed!');
                                                                            document.getElementById('a').value='';
                                                                        } else {
                                                                            errorMessage1.style.display = 'none';

                                                                    aA= a.slice(0,4);
                                                                    am=a.slice(5,7);
                                                                    aD=a.slice(8,10);
                                                                    a=aD+"-"+am+"-"+aA+" 23:59";
                                                                    document.getElementById('df').value=a;
                                                                       console.log('A fecha:', a);}
                                                                    });
                                                            </script>


                                            </div>
                        </div>
                         <div class="card shadow mb-4 col-lg-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Shipping Area</h6>
                            </div>
                                        <div class="card-body" style="overflow-y: auto; height: 360px;">
                                            <div class= "row">
                                                <div class="col-lg-4 mb-4">
                                                            <form action="{{ route('registrosGenerales')}}" method="GET" >
                                                                <input type="hidden" name="setAddWeek" id="setAddWeek" value="1">
                                                                <button type="submit" class="btn btn-primary">Generar Reporte</button>

                                                            </form>
                                                </div>
                                            </div>

                                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Part Numbers</h5>
                                    <div class="dropdown no-arrow">
                                        <label for="buscarWo" class="form-label">Search</label>
                                        <input type="text" name="buscarWo" id="buscarWo" class="form-control " onchange="mostrarWo(this.value)">
                                    </div>
                                </div>

                                <div class="card-body" style="overflow-y: auto; max-height: 350px;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>PN</th>
                                                <th>WO</th>
                                                <th>Return Plannig</th>
                                                <th>Cutting</th>
                                                <th>Terminals</th>
                                                <th>Assembly</th>
                                                <th>Lomming</th>
                                                <th>Pre Testing</th>
                                                <th>Testing</th>
                                                <th>Shipping</th>
                                                <th>ENG</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-harness">  </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="col-xl-5 col-lg-7">
                            <div class="card shadow mb-4">
                                    <!-- Card scaneer -->
                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">Production Records </h5>

                                </div>

                                <div class="card-body" style="overflow-y: auto; height: 350px;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>PN</th>

                                                <th>WO</th>
                                                <th>Qty</th>
                                                <th>Tiempo</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-retiradas">  </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-lg-4 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Quality issue(FTQ: <span id="tftq"></span>)</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div style="text-align: center">
                                    <h3>Testing   OK: <span id="tok"></span> NG: <span id="tng"></span> </h3>
                                    </div>
                                    <hr>
                                    <div>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                  <th>Issue code</th>
                                                  <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody id="table-ftq">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Column 2 -->

                        <div class="col-lg-8 mb-4">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Pull Test</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                               <th>Date</th>
                                               <th>PN</th>
                                               <th>AWG</th>
                                               <th>Pressure</th>
                                               <th>Applicated form</th>
                                               <th>Terminal</th>
                                               <th>Operatior</th>
                                               <th>Quality</th>
                                               <th>Result</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-pulltest">  </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-4" style="max-width: 60%">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Registros</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >


                                    </div>
                                </div>
                            </div>
                        </div>
                       <!-- <div class="col-lg-6 mb-4" style="max-width: 33.33%">
                             AREAS
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Table of Works </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">
                                    <div class="row" >


                                    </div>
                                </div>
                            </div>
                        </div>-->
                        <div class="col-lg-6 mb-4" style="max-width: 40%">
                            <!-- AREAS -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h5 class="m-0 font-weight-bold text-primary">Table of Works </h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;" id="tableChange">

                                    </div>
                                </div>
                            </div>
                        </div>



                    @endsection
