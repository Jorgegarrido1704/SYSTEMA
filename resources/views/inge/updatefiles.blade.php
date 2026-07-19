@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4 text-center"></div>

        <div class = "row">
             @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <script>
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        </script>
        </div>
        <div class="row">
             <div class="col-xl-2 col-lg-3">
                            <div class="card shadow mb-6">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">{{ __('Update BOM') }} </h5>

                                </div>

                                <!-- table Body -->
                                <div class="card-body" style=" max-height: 150px;">
                                   <form action="{{ route('updateBomfile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                        <div class="mb-3">
                                            <label for="excel_file" class="form-label">{{ __('Select Excel File') }}</label>
                                            <input type="file" name="excel_file" id="excel_file" accept=".xlsx" class="form-control" required>
                                        </div>
                                        <input type="submit" name="upload" value="{{ __('Updated') }}" class="btn btn-primary">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-3">
                            <div class="card shadow mb-6">

                                <div
                                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h5 class="m-0 font-weight-bold text-primary">{{ __('Update BOM') }} </h5>

                                </div>

                                <!-- table Body -->
                                <div class="card-body" style=" max-height: 250px;">
                                   <form action="{{ route('updateEtiquetas') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                   <div class="row">  
                                        <div class="col-6 ">
                                                <label for="Numero_de_Parte" class="form-label">{{ __('Part Number') }}</label>
                                                <input type="text" name="Numero_de_Parte" id="Numero_de_Parte"  class="form-control" required>    
                                        </div>
                                        <div class="col-6 ">
                                                <label for="Revision" class="form-label">{{ __('Revision') }}</label>
                                                <input type="text" name="Revision" id="Revision"  class="form-control" required>    
                                        </div>
                                            <div class="col-9 ">
                                                <label for="csv_file" class="form-label">{{ __('Select Excel File') }}</label>
                                                <input type="file" name="csv_file" id="csv_file" accept=".CVS,.csv" class="form-control" required>
                                            </div>
                                            <div class="col-3">
                                            <input type="submit" name="upload" value="{{ __('Updated') }}" class="btn btn-primary">
                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
        </div>

@endsection