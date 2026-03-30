@extends('layouts.main')

@section('contenido')
    <!--<link rel="stylesheet" href="{{ asset('/dash/css/workSchedule.css') }}">-->

    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
<script src="{{ asset('/dash/js/workSchedule.js') }}"></script>
    <script>
        const datas = '{{ route('workStateJason') }}';
    </script>
    <style>
        input[type="text"] {
            text-align: center;
            width: 100px;
        }
        select {
            text-align: center;
            width: 100px;
        }
        #pns{
            text-align: center;
            width: 400px;
        }
    </style>
    <div class="row">
        <div class="col-xl-12 col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary"> {{ __('Engineering work scheduled') }} </h5>
                    <input type="text" class="form-control" id="pns"  value="" placeholder="Search for PNs.." onchange="search()">
                </div>
                <!-- filtros -->
                    <div class="col-12 text-center mb-5">
                        <div class="col-12">
                            <h5 class="m-0 font-weight-bold text-primary">{{ __('Filters') }}</h5>
                        </div>
                        <div class="form-group position-relative row">
                            <div class="col-1 m-0">
                                <div class="form-group">
                                    <label for="customer" class="form-label">{{ __('Customer') }}</label>
                                </div>
                                <div class="form-group">
                                    <select name="customer" id="customer" class="form-select">
                                        <option value="" selected>{{ __('Customer') }}</option>
                                        @foreach ($customer as $cust )
                                            <option value="{{ $cust }}">{{ $cust }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-1 ">
                               <div class="form-group">
                                <label for="size" class="form-label"> {{ __('Size') }}</label>
                               </div>
                                <div class="form-group">
                                <select name="size" class="form-select" id="size">
                                    <option value="" selected>{{ __('Size') }}</option>
                                    <option value="Ch">{{ __('Small') }}</option>
                                    <option value="M">{{ __('Medium') }}</option>
                                    <option value="G">{{ __('Large') }}</option>
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
                                <label for="Filter">{{ ('Filter by Dates') }}</label>
                            </div><div>
                                <select name="Filter" class="form-select" id="Filter">
                                    <option value="" selected>{{ __('Filter by Dates') }}</option>
                                    <option value="MRP">MRP</option>
                                    <option value="receiptDate">{{ __('Receipt Date') }}</option>
                                    <option value="commitmentDate">{{ __('Commitment Date') }}</option>
                                    <option value="CompletionDate">{{ __('Completion Date') }}</option>
                                    <option value="documentsApproved">{{ __('Documents Approved') }}</option>
                                    <option value="customerDate">{{ __('Customer Date') }}</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-1">
                                <label for="empty">{{ __('Empty') }}</label>
                                <br> <input type="checkbox" name="empty" id="empty" >
                            </div>
                            <div class="col-2">
                                <label for="DateIni">{{ __('Start Date') }}:</label><input type="date" class="form-control" id="DateIni" ></label>
                            </div>
                            <div class="col-2">
                                <label for="DateEnd">{{ __('End Date') }}:</label><input type="date" class="form-control" id="DateEnd" ></label>
                            </div>

                                <button class="form-button btn btn-primary" onclick="search()">{{ __('Search') }}</button>

                        </div>
                    </div>
                    <!-- add Work engineering -->
                    <div class ="col-12 text-center mb-5 " >
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal" id="addWork" onclick="addworks()" >{{ __('Add Another') }} </button>
                    </div>
                    <div class ="col-12 text-center mb-5 ">
                        <div id="formularioRegistro"  style="display: none">
                            <form action="{{ route('saveWorkschedule') }}" method="GET">
                                <div class="form-group">
                                <label for="color">{{ __('Color sheet') }}:</label><br>
                                    <select name="color" id="color">
                                       <option value="" selected disabled>Color</option>
                                       <option value="green">PPAP // {{ __('Change Rev') }} PPAP</option>
                                       <option value="yellow">PRIM // {{ __('Change Rev') }} PRIM</option>
                                       <option value="white">NO PPAP // {{ __('Just documentation') }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                <label for="pnWork">{{ __('Part Number') }}:</label> <br>
                                <input type="text" name="pnWork" id="pnWork" required>
                                </div> <div class="form-group">
                                <label for="customerWork">{{ __('Customer') }}:</label><br>
                                <input type="text" name="customerWork" id="customerWork" required>
                                </div><div>
                                <label for="revWork">{{ __('Revision') }}:</label><br>
                                <input type="text" name="revWork" id="revWork" required>
                                </div>  <div>
                                <label for="sizeWork">{{ __('Size') }}:</label><br>
                                <select name="sizeWork" id="sizeWork" required>
                                    <option value="" selected disabled>{{ __('Size') }}</option>
                                    <option value="Ch">{{ __('Small') }}</option>
                                    <option value="M">{{ __('Medium') }}</option>
                                    <option value="G">{{ __('Large') }}</option>
                                </select>
                                </div> <div>
                                <label for="qtyInPo">{{ __('Po Qty') }}:</label><br>
                                <input type="text" name="qtyInPo" id="qtyInPo" min=0>
                                </div> <div>
                                <label for="receiptDateWork">{{ __('Receipt Date') }}:</label><br>
                                <input type="date" name="receiptDateWork" id="receiptDateWork" >
                                </div><div>
                                <label for="commitmentDateWork">{{ __('Commitment Date') }}:</label><br>
                                <input type="date" name="commitmentDateWork" id="commitmentDateWork" >
                                </div><div>
                                <label for="customerDateWork">{{ __('Customer Date') }}:</label><br>
                                <input type="date" name="customerDateWork" id="customerDateWork" >
                                </div><div>
                                <label for="resposible">{{ __('Resposible') }}:</label><br>
                                <input type="text" name="resposible" id="resposible" >
                                </div><div>
                                <label for="comments">{{ __('Comments') }}:</label><br>
                                <textarea name="comments" id="comments" cols="10" rows="3"></textarea>
                                </div>
                                <input type="submit" class="btn btn-primary" name="enviar" id="enviar" value="{{ __('Save') }}">

                            </form>

                        </div>
                    </div>
                    <hr>

                <!-- Schedule work engineering -->
                <div class="card-body" style="overflow-y: auto; ">
                     <div  style="overflow-y: auto; height: 800px;">
                    <table class="table table-striped table-bordered"  cellspacing="0" width="100%">
                        <thead style=" position: sticky; z-index: 1; top: 0; text-align: center; background-color: black; color: white; ">
                                <tr>
                                    <th>{{ __('Part Number') }}</th>
                                    <th>{{ __('Customer') }}</th>
                                    <th>{{ __('Color') }}</th>
                                    <th>{{ __('Revision') }}</th>
                                    <th >{{ __('Size') }}</th>
                                    <th>{{ __('FullSize') }}</th>
                                    <th>{{ __('MRP') }}</th>
                                    <th>{{ __('Receipt Date') }}</th>
                                    <th>{{ __('Commitment Date') }}</th>
                                    <th>{{ __('Completion Date') }}</th>
                                    <th>{{ __('Documents Approved') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Responsible') }}</th>
                                    <th>{{ __('Customer Date') }}</th>
                                    <th>{{ __('Po Qty') }}</th>
                                    <th>{{ __('Comments') }}</th>
                                    <th>{{ __('Edit') }}</th>
                                    <th>{{ __('Delete') }}</th>
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
