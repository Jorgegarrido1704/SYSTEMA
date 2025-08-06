@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

<div class="row">

                        <!-- Firmar por completar -->
                        <div class="col-lg-12 mb-4">

                            <!-- Header Firmas -->
                            <div class="card shadow mb-4">
                                <div  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">New Product Introductions</h6>
                                </div>
                                <!--Firmas -->
                                <div class="card-body">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Moviment type</th>
                                                <th>Client</th>
                                                <th>Harness type</th>
                                                <th>Part number</th>
                                                <th>Rev</th>
                                                <th>Changes description</th>
                                                <th>publish date</th>
                                                <th>Enginner</th>
                                                <th>Sign</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($registroFirmas))
                                            @foreach($registroFirmas as $npi)
                                            <tr class="text-center text-black">
                                                <td>{{$npi->tp}}</td>
                                                <td>{{$npi->client}}</td>
                                                <td>{{$npi->tipo}}</td>
                                                <td>{{$npi->pn}}</td>
                                                @if($npi->REV2 !='N/A')
                                                <td>{{ $npi->REV1}} To {{$npi->REV2}}</td>
                                                @else
                                                <td>{{$npi->REV1}}</td>
                                                @endif
                                                <td>{{$npi->cambios}}</td>
                                                <td>{{$npi->fecha}}</td>
                                                <td>{{$npi->eng}}</td>
                                                <td>
                                                    <form action="{{route('Pendings.update')}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$npi->id}}">
                                                        <input type="hidden" name="who" value="{{$value}}">
                                                        <button type="submit" class="btn btn-primary">Sign</button>
                                                    </form>
                                                </td>
                                            </tr>
                                                    @endforeach
                                                    @endif
                                    </table>
                                </div>
                            </div>
                        </div>
</div>



@endsection
