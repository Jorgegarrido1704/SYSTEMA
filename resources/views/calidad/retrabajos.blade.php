@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <meta http-equiv="refresh" content="90">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h4 class="m-0 font-weight-bold text-primary">Reworks</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="preorder">
                            <thead>
                                <tr>
                                    <th scope="col">Part number</th>
                                    <th scope="col">Error name</th>
                                    <th scope="col">Responsable</th>
                                    <th scope="col">Barcode</th>
                                    <th scope="col">Fixed</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($registrosFallas))
                                @foreach ($registrosFallas as $item)
                                    <tr>
                                        <td>{{ $item[1] }}</td>
                                        <td>{{ $item[2]}}</td>
                                        <td>{{ $item[3]}}</td>
                                        <td>{{ $item[4]}}</td>
                                        <td>
                                            <form action="{{ route('fallasCalidad') }}" method="GET">
                                                @csrf
                                                <input type="hidden" name="fallas" value="{{ $item->id }}" id="fallas">
                                                <button type="submit" class="btn btn-caution">Done </button>
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
