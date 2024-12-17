@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <script>
    const routeMostrarWo = @json(route('mostrarWOJ'));
</script>


 <div class="d-sm-flex align-items-center justify-content-between mb-4">

                    </div>
                    <div class="row">

                        <!-- Table and Graph -->
                        <div class="col-xl-7 col-lg-7">
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
                                                <th>Cutting</th>
                                                <th>Terminals</th>
                                                <th>Assembly</th>
                                                <th>Lomming</th>
                                                <th>Testing</th>
                                                <th>Shipping</th>
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
                                    <h5 class="m-0 font-weight-bold text-primary">Quality issue (FTQ: <span id="tftq"></span>)</h5>
                                </div>
                                <div class="card-body" style="overflow-y: auto; height: 360px;">
                                    <div style="text-align: center">
                                    <h3>Testing   OK: <span id="tok"></span> NG: <span id="tng"></span></h3>
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
                                               <th>Operator</th>
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
