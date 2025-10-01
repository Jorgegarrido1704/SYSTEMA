@extends('layouts.main')

@section('contenido')

<!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
    <div class="row">
        <div class="col-lg-6 col-lx-6">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Inventary captured</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; height: 360px;" >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Item</th>
                                    <th>first count register</th>
                                    <th>Qty first count</th>
                                    <th>Qty second count</th>
                                    <th>Difference</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datosRegistros as $itemDatos)
                                <tr>
                                    <td>{{ $itemDatos->id_item }}</td>
                                    <td>{{ $itemDatos->items }}</td>
                                    <td>{{ $itemDatos->Register_first_count }}</td>
                                    <td>{{ $itemDatos->first_qty_count }}</td>
                                    <td>{{ $itemDatos->second_qty_count }}</td>
                                    <td>{{ $itemDatos->difference }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if($cat=="invreg1" || $cat=="invreg2" || $cat=="capt" )
             <div class="col-lg-6 col-lx-6">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Registro Datos</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; height: 360px;"  >

                    </div>
                </div>
            </div>
            @endif
             @if($cat=="invwo1" || $cat=="invwo2" || $cat=="capt" )
             <div class="col-lg-6 col-lx-6">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Work Order</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; "  >
                    <div class="row">
                          <div class="col-lg-12 col-lx-12">
                            <p>Enter the Work Order and the name of the auditor to start capturing the inventory data.</p>
                            <input type="text" class="form-control" id="workOrder" name="workOrder" minlength="6" maxlength="6" onchange="datosWorkOrder()">
                        </div>
                        <div class="col-lg-12 col-lx-12">
                            <form method="POST" action="{{ route('getDatosInventarioWork') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="workOrder">Work Order</label>
                                    <input type="text" class="form-control" id="workOrder" name="workOrder" required>
                                </div>
                                <div class="form-group">
                                    <label for="auditor">Auditor</label>
                                    <input type="text" class="form-control" id="auditor" name="auditor" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

    </div>


    <script>
        const url=@json('getDatosInventarioWork');
        function datosWorkOrder(){
          fetch(url,{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body:JSON.stringify({
                workOrder:document.getElementById('workOrder').value
            })
          }).then(response=>response.json())
        }
@endsection
