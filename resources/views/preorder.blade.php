@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="90">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h4 class="m-0 font-weight-bold text-primary">Pre-accepted data</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="preorder">
                            <thead>
                                <tr>
                                    <th scope="col">Part number</th>
                                    <th scope="col">Work Order</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Acepted</th>
                                    <th scope="col">Rejected</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($preorder))
                                @foreach ($preorder as $item)
                                    <tr>
                                        <td>{{ $item->pn }}</td>
                                        <td>{{ $item->wo}}</td>
                                        <td>{{ $item->preCalidad}}</td>
                                        <td>
                                            <form action="{{ route('accepted') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="acpt" value="{{ $item->id }}" id="acpt">
                                                <button type="submit" class="btn btn-success">Acepted</button>
                                            </form>
                                        </td>
                                        <td> <form action="{{ route('accepted') }}" method="GET">
                                            @csrf
                                            <input type="hidden" name="denied" value="{{ $item->id }}" id="denied">
                                            <button type="submit" class="btn btn-danger">Rejected  </button>
                                        </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

 @endsection
