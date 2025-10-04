@extends('layouts.main')

@section('contenido')

<!-- Page Heading -->
    <meta http-equiv="refresh" content="60">
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
                                    <th>Item</th>
                                    <th>First update</th>
                                    <th>second update</th>
                                    <th>Diference</th>
                                </tr>
                            </thead>
                            <tbody>
                              <!--
                             
                            -->
                        </table>
                    </div>
                </div>
            </div>
             <div class="col-lg-6 col-lx-6">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Inventary</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; height: 360px;"  >

                    </div>
                </div>
            </div>

    </div>
@endsection
