@extends('layouts.mainWithoutsidebar')

@section('contenido')
<div class="row">
    <!-- Content Column -->
    <div class="col-lg-6 mb-4">
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h4 class="m-0 font-weight-bold text-primary">Inventario por Work Order</h4>

            </div>
            <!-- Percent section -->
            <div class="card-body" style="overflow-y: auto; height: 600px;">
                @if (!empty($items))
                <table>
                    <tr>
                        <th colspan="2"><b>Work Order: {{ $wo }}</b</th>

                        <th colspan="2"><b>Quantity: {{ $qt }}</b></th>
                    </tr>
                    <tr>

                        <th>Item</th>
                        <th>Quantity</th>
                    </tr>
                    <form action="{{ route('WOitems') }}" method="GET">
                    @foreach ($items as $item)
                    <tr>
                    <td> <input type="disabled" name="items[]" id="items" value="{{ $item[0] }}" required></td>
                    <td><input type="number" name="qty[]" id="qty" value="{{ $item[1] }}" min=0 step="0.01" required class="form-control"></td>
                        <input type="hidden" name="wo" id="wo" value="{{ $wo }}">


                </tr>
                    @endforeach
                    <div class="form-group">
                    <input type="submit" name="enviar" id="enviar" value="Guardar" class="btn btn-primary">
                    </div>
                </form>
                </table>

                @else

                <form action="{{ route('index_inventario') }}" method="GET">
                    <div class="form-group">
                        <label for="wo">Part Number</label>
                        <input type="text" name="wo" id="wo" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="qty_pn">Quantity</label>
                        <input type="number" name="qty_pn" id="qty_pn" min="1" required class="form-control">
                    </div>
                    <input type="submit" name="enviar" id="enviar" value="Buscar" class="btn btn-primary">
                </form>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h4 class="m-0 font-weight-bold text-primary">Inventario por item</h4>
            </div>
            <!-- Percent section -->
            <div class="card-body" style="overflow-y: auto; height: 360px;">
                <form action="{{ route('indItems') }}" method="GET">
                    <div class="form-group">
                        <label for="itemunic">Item</label>
                        <input type="text" name="itemunic" id="itemunic" required class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="qtyunic">Quantity</label>
                        <input type="number" name="qtyunic" id="qtyunic" step="0.01" min="0" required class="form-control">
                    </div>
                    <input type="submit" name="send" id="send" value="Agregar" class="btn btn-primary">


                </form>
            </div>
        </div>
    </div>
</div>
@endsection
