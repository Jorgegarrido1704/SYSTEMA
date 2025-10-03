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
                    <div class="card-body" style="overflow-y: auto; height: 860px;" >
                        <table class="table table-bordered"  width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Item</th>
                                    <th>first count register</th>
                                    <th>Qty first count</th>
                                    <th>second count register</th>
                                    <th>Qty second count</th>
                                    <th>Difference</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datosRegistros as $itemDatos)
                                <tr>
                                     @if($cat=="invwo1" || $cat=="invwo2"  )
                                    <td>{{ $itemDatos->id_workOrder }}</td>
                                    @else
                                    <td>{{ $itemDatos->Folio_sheet_audited }}</td>
                                    @endif
                                    <td>{{ $itemDatos->items }}</td>
                                    <td>{{ $itemDatos->Register_first_count }}</td>
                                    <td>{{ $itemDatos->first_qty_count }}</td>
                                    <td>{{ $itemDatos->Register_second_count }}</td>
                                    <td>{{ $itemDatos->second_qty_count }}</td>
                                    @if($itemDatos->difference > 0)
                                    <td style="color: red"> {{ $itemDatos->difference }}</td>
                                    @else
                                    <td>{{ $itemDatos->difference }}</td>
                                    @endif
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
                        <form action="{{ route('addInventarios') }}" method="POST">
                        @csrf
                        <div class="form-group col-lg-6 col-lx-6">
                            <label for="folios">Folio</label>
                            <input type="text" class="form-control" id="folios" name="folios" value="{{ $folio->Folio_sheet_audited?? ''}}" required>
                        </div>
                        <div class="form-group col-lg-6 col-lx-6">
                            <label for="items">Item</label>
                            <input type="text" class="form-control" id="item" name="item" required>
                        </div>
                        <div class="form-group col-lg-6 col-lx-6">
                            <label for="qty">Quantity</label>
                            <input type="number" class="form-control" id="qty" name="qty" min="0" step="0.01" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            @if($cat=="invwo1" || $cat=="invwo2"  )
             <div class="col-lg-6 col-lx-6">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Work Order</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; "  >
                    <div class="row">
                          <div class="col-lg-12 col-lx-12">
                            <label for="cantidad">quantity</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" min="0" step="1" required>
                            <label for="workOrder">Work Order</label>
                            <input type="text" class="form-control" id="workOrder" name="workOrder" minlength="6" maxlength="6" onchange="datosWorkOrder()">
                        </div>
                        <div class="col-lg-12 col-lx-12">

                            <form method="POST" action="{{ route('addWorkOrder') }}">
                            @csrf
                            <div class= "row mt-3" id="datosWorkOrder">  </div>
                            <input type="hidden" name="id_workOrder" id="id_workOrder">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

    </div>


    <script>
        var messege = @json(session('message'));
        if (messege) {
            alert(messege);
        }

        const url=@json('getDatosInventarioWork');
        function datosWorkOrder(){
            try{
                document.getElementById('datosWorkOrder').innerHTML = '';
          fetch(url,{
            method:'POST',
            headers:{
                'Content-Type':'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body:JSON.stringify({
                workOrder:document.getElementById('workOrder').value,
                cantidad:document.getElementById('cantidad').value
            })
          })
          .then(response => response.json())
          .then(data => {
            if(data.status === 'success'){
                document.getElementById('id_workOrder').value=document.getElementById('workOrder').value;
                for (let i = 0; i < data.data.length; i++) {
                    const element = data.data[i];
                    document.getElementById('datosWorkOrder').innerHTML += `
                    <div class="form-group col-lg-6 col-lx-6">
                        <label for="item${i}">Item</label>
                        <input type="text" class="form-control" id="item${i}" name="item[]" value="${element.item}" readonly>
                    </div>
                    <div class="form-group col-lg-6 col-lx-6">
                        <label for="qty${i}">Quantity</label>
                        <input type="number" class="form-control" id="qty${i}" name="qty[]" value="${element.qty}" min="0" step="0.01" >
                    </div>`;
                }
                document.getElementById('datosWorkOrder').innerHTML += `

                <button type="submit" class="btn btn-primary">Submit</button>`;
            }else{
                alert(data.error);
            }
            console.log(data);
          })}catch(error){
            console.error('Error:',error);
          }
        }
        </script>
@endsection
