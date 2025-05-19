@extends('layouts.main')

@section('contenido')
    <!--<link rel="stylesheet" href="{{ asset('/dash/css/workSchedule.css') }}">-->

    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
<script src="{{ asset('/dash/js/workSchedule.js') }}"></script>
    <script>
        const datas = '{{ route('workStateJason') }}';
    </script>
    <div class="row">
        <div class="col-xl-12 col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary"> Engineering work scheduled </h5>
                    <input type="text" class="form-control" id="pns"  value="" placeholder="Search for PNs.." onchange="search()">
                </div>
                <!-- filtros -->
                    <div class="col-12 text-center mb-5">
                        <div class="col-12">
                            <h5 class="m-0 font-weight-bold text-primary">Filters</h5>
                        </div>
                        <div class="form-group position-relative row">
                            <div class="col-2 m-0">
                                <div class="form-group">
                                    <label for="customer" class="form-label">Customer</label>
                                </div>
                                <div class="form-group">
                                    <select name="customer" id="customer" class="form-select">
                                        <option value="" selected>Customer</option>
                                        @foreach ($customer as $cust )
                                            <option value="{{ $cust }}">{{ $cust }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1 ">
                               <div class="form-group">
                                <label for="size" class="form-label"> Size</label>
                               </div>
                                <div class="form-group">
                                <select name="size" class="form-select" id="size">
                                    <option value="" selected>Size</option>
                                    <option value="Ch">Ch</option>
                                    <option value="M">M</option>
                                    <option value="G">G</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                <label for="responsable">Responsable</label>
                                </div ><div>
                                <select name="responsable" class="form-select" id="responsable">
                                    <option value="" selected>Responsable</option>
                                    @foreach ($ingResp as $resp)
                                        <option value="{{ $resp }}">{{ $resp }}</option>
                                    @endforeach

                                </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                <label for="Filter">Filter Dates</label>
                            </div><div>
                                <select name="Filter" class="form-select" id="Filter">
                                    <option value="" selected>Filter</option>
                                    <option value="MRP">MRP</option>
                                    <option value="receiptDate">Receipt Date</option>
                                    <option value="commitmentDate">Commitment Date</option>
                                    <option value="CompletionDate">Completion Date</option>
                                    <option value="documentsApproved">Documents Approved</option>
                                    <option value="customerDate">Customer Date</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <label for="DateIni">Date Init:</label><input type="date" class="form-control" id="DateIni" ></label>
                            </div>
                            <div class="col-2">
                                <label for="DateEnd">Date End:</label><input type="date" class="form-control" id="DateEnd" ></label>
                            </div>

                                <button class="form-button btn btn-primary" onclick="search()">Search</button>

                        </div>
                    </div>
                    <!-- add Work engineering -->
                    <div class ="col-12 text-center mb-5 " >
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal" id="addWork" onclick="addworks()" >Add Another </button>
                    </div>
                    <div class ="col-12 text-center mb-5 ">
                        <div id="formularioRegistro"  style="display: none">
                            <form action="{{ route('saveWorkschedule') }}" method="GET">
                                <div class="form-group">
                                <label for="pnWork">PN:</label> <br>
                                <input type="text" name="pnWork" id="pnWork">
                                </div> <div class="form-group">
                                <label for="customerWork">Customer:</label><br>
                                <input type="text" name="customerWork" id="customerWork">
                                </div><div>
                                <label for="revWork">Work Rev:</label><br>
                                <input type="text" name="revWork" id="revWork">
                                </div>  <div>
                                <label for="sizeWork">Size:</label><br>
                                <input type="text" name="sizeWork" id="sizeWork">
                                </div> <div>
                                <label for="receiptDateWork">Receipt Date:</label><br>
                                <input type="date" name="receiptDateWork" id="receiptDateWork">
                                </div><div>
                                <label for="commitmentDateWork">Commitment Date:</label><br>
                                <input type="date" name="commitmentDateWork" id="commitmentDateWork">
                                </div><div>
                                <label for="customerDateWork">Customer Date:</label><br>
                                <input type="date" name="customerDateWork" id="customerDateWork">
                                </div><div>
                                <label for="resposible">Resposible:</label><br>
                                <input type="text" name="resposible" id="resposible">
                                </div><div>
                                <label for="comments">Comments:</label><br>
                                <textarea name="comments" id="comments" cols="10" rows="3"></textarea>
                                </div>
                                <input type="submit" class="btn btn-primary" name="enviar" id="enviar" value="Guardar">

                            </form>

                        </div>
                    </div>
                    <hr>

                <!-- Schedule work engineering -->
                <div class="card-body" style="overflow-y: auto; ">
                     <div class="table">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>PN</th>
                                    <th>Customer</th>
                                    <th>WorkRev</th>
                                    <th>Size</th>
                                    <th>FullSize</th>
                                    <th>MRP</th>
                                    <th>Receipt Date</th>
                                    <th>Commitment Date</th>
                                    <th>Completion Date</th>
                                    <th>Documents Approved</th>
                                    <th>Status</th>
                                    <th>Responsible</th>
                                    <th>Customer Date</th>
                                    <th>Comments</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">



                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
