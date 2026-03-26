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

     <div class="col-lg-6">
         <div class="card shadow mb-4">
             <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Pending Maintanence Tooling</h6>
             </div>
             <div class="card-body">
                <form action="{{ route('saveMantTooling') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="form-group col-md-12">
                            <label for="tooling">Tooling / Terminal:</label>
                            <select name="tooling" id="tooling" class="form-control" required>   
                                <option value="" disabled selected>Seleccione Herramental</option>
                                @foreach ($correctivo as $cor )
                                    <option value="{{$cor->herramental}}//{{$cor->terminal}}">{{$cor->herramental }} // {{$cor->terminal}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="cantidad">Minutes:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Minutes" min="1" value="0" step="1" required>
                        </div>    
                        <div class="form-group col-md-12">
                            <label for="personalRegistro">Tooling Personal Responsible:</label>
                            <select name="personalRegistro" id="personalRegistro" class="form-control" required>
                                <option value="" disabled selected>Seleccione Personal</option>
                                <option value="Luis">Luis</option>
                                <option value="Angel">Angel</option>
                                <option value="Rodrigo">Rodrigo</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="observaciones">Observations:</label>
                            <textarea class="form-control" name="observaciones" id="observaciones"  cols="55" row="3"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="submit" class="btn btn-primary" value="Guardar">
                        </div>
                    </div>        

                </form>

             </div>
         </div>
     </div>
     <div class="col-lg-6">
         <div class="card shadow mb-4">
             <div class="card-header py-3">
                 <h6 class="m-0 font-weight-bold text-primary">Preventive Maintanence Tooling</h6>
             </div>
             <div class="card-body">
                <form action="{{ route('saveMantTooling') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <div class="form-group col-md-12">
                            <label for="tooling">Tooling / Terminal:</label>
                            <select name="tooling" id="tooling" class="form-control" required>   
                                <option value="" disabled selected>Seleccione Herramental</option>
                                @foreach ($preventivo as $cor )
                                    <option value="{{$cor->herramental}}//{{$cor->terminal}}">{{$cor->herramental }} // {{$cor->terminal}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="cantidad">Minutes:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Minutes" min="1" value="0" step="1" required>
                        </div>    
                        <div class="form-group col-md-12">
                            <label for="personalRegistro">Tooling Personal Responsible:</label>
                            <select name="personalRegistro" id="personalRegistro" class="form-control" required>
                                <option value="" disabled selected>Seleccione Personal</option>
                                <option value="Luis">Luis</option>
                                <option value="Angel">Angel</option>
                                <option value="Rodrigo">Rodrigo</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="observaciones">Observations:</label>
                            <textarea class="form-control" name="observaciones" id="observaciones"  cols="55" row="3"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="submit" class="btn btn-primary" value="Guardar">
                        </div>
                    </div>        

                </form>

             </div>
         </div>
     </div>
</div>
                    



 @endsection