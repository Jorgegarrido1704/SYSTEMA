@extends('layouts.main')

@section('contenido')
    <div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="mb-4 text-center">Time Line</h2>
            <div class="vsm-container">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 mb-4">
            <div class="card shadow mb-6">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Moviments </h5>
                </div>

                <!-- table Body -->
                <div class="card-body" style="overflow-y: auto; ">
                    <div class="form-group">
                        <label for="PartNumber" class="form-label">Part Number: </label>
                        <input type="text" class="form-input" id="PartNumber" name="PartNumber" stytle="width: 50px;">

                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-12 col-lg-12 col-md-12 mb-4">
            <div class="card shadow mb-6">

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-0 font-weight-bold text-primary">Routing </h5>
                </div>

                <!-- table Body -->
                <div class="card-body" style="overflow-y: auto; ">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th> Operation Number / Step </th>
                                    <th> Description </th>
                                    <th> Machine/Tool Required </th>
                                    <th> Setup Time </th>
                                    <th> Cycle Time </th>
                                    <th> Operator </th>
                                    <th> Status </th>
                                    <th> Dependencies/Predecessors </th>
                                    <th> Resources </th>
                                    <th> Notes / Comments </th>
                                    <th> Shift / Schedule </th>
                                    <th> Planned Start Date </th>
                                    <th> Planned End Date </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($registros as $registro)
                                <tr>
                                    <td> {{ $registro->work_routing }} </td>
                                    <td> {{ $registro->work_description }} </td>
                                    <td> {{ $registro->posible_stations }} </td>
                                    <td> {{ $registro->setUp_routing	 }} </td>
                                    <td> {{ $registro->QtyTimes	 }} </td>
                                    <td> {{ $registro->setUp_routing}} </td>

                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
