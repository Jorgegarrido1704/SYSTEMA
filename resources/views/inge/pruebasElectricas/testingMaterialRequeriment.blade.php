@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
<script src="{{ asset('dash/js/testingMaterialRequeriment.js') }}"></script>
<script> 
    
   const searchMaterialPruebas = @json(route('searchMaterialPruebas'));
    </script>

<div class="d-sm-flex align-items-center justify-content-between mb-4 text-center"></div>
 <meta http-equiv="refresh" content="180">
<div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Testing Material Requeriment</h5>
                    <button  class="btn btn-primary m-0 font-weight-bold text-white" id="addNewrequirement" onclick="addNewrequirement()"> Add New</button>
                </div>

                <!-- tabla de trabajos -->  
                <div class="card-body" style="overflow-y: auto; max-height: 1200px;">
                   <div class="table-responsive" id="tablaResposiba"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12" id="newrequirement" style="display: none;">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">New Testing Material Requeriment</h5>
                </div>

                <!-- tabla de trabajos -->  
                <div class="card-body" style="overflow-y: auto; max-height: 1200px;">
                    <form action="{{ route('testingMaterialRequeriment.addMaterial') }}" method="POST" id="formNewrequirement">
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <label for="pn">Part number</label>
                                <input type="text" class="form-control" id="pn" name="pn" required>
                            </div>
                            <div class="form-group">
                                <label for="rev">Revision</label>
                                <input type="text" class="form-control" id="rev" name="rev" required>
                            </div>
                            <div class="form-group">
                                <label for="customer">Customer</label>
                               <select class="form-control" id="customer" name="customer" required>
                                    <option value="" disabled selected>Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->customer }}">{{ $customer->customer }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="priority">Priority</label>
                               <select class="form-control" id="priority" name="priority" required>
                                    <option value="" disabled selected>Select Priority</option>
                                    <option value="Baja">Baja</option>
                                    <option value="Media">Media</option>
                                    <option value="Alta">Alta</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="connector">Connector</label>
                                <input type="text" class="form-control" id="connector" name="connector" value="N/A" required>
                            </div>
                            <div class="form-group">
                                <label for="connqty">Connector Quantity</label>
                                <input type="number" class="form-control" id="connqty" name="connqty" min="0" step="1" required>
                            </div>
                            <div class="form-group">
                                <label for="terminal">Terminal</label>
                                <input type="text" class="form-control" id="terminal" name="terminal" value="N/A" required>
                            </div>
                            <div class="form-group">
                                <label for="termqty">Terminal Quantity</label>
                                <input type="number" class="form-control" id="termqty" name="termqty" min="0" step="1" required>
                            </div>
                            <div class="form-group">
                                <label for="observ">Observaciones</label>
                                <input type="text" class="form-control" id="observ" name="observ" value="N/A" required>
                            </div>
                           <button type="submit" class="btn btn-primary">Submit</button>   
                        </div>

                    </form>
                    
                </div>
        </div>
</div>

@endsection