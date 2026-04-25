@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
 @if(!empty(session('message')))
 <div class="alert alert-success alert-dismissible fade show" role="alert">
     {{ session('message') }}
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
         <span aria-hidden="true">&times;</span>
     </button>
 </div>
 @endif
 <div class="row">
        <div class="col-xl-12 col-md-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between" style="max-height: 25px">
                    <h6 class="m-0 font-weight-bold text-primary">Request Crimp Tooling Analysis</h6>
                </div>
                <!-- table Body -->
                <div class="card-body"style="overflow-y: auto; height: 350px;">  
                    <div class="row"> 
                        <div class="col-xl-6 col-md-6 mb-4">
                            <div class="row">   
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-danger shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Waiting for work</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$promedioespera}}</div>
                                                </div>                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-warning shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Time of Working avergage</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$timeWorking}}</div>
                                                </div>                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6 mb-4">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Total Time Setup Avergage</div>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    {{ $totalTimesAVG }}
                                                    </div>
                                                </div>                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 mb-4">
                            <table class="table  table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Top 10 most requiring tooling</th>
                                        <th scope="col" class="text-center">Times</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tooling as $tool)
                                    <tr>
                                        <td class="text-center text-success font-weight-bold">{{$tool->nombreEquipo}}</td>
                                        <td class="text-center text-primary font-weight-bold">{{$tool->tiemposVal}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>


 @endsection