@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4 text-center"></div>

        <div class = "row">
             <div class="col-xl-3 col-lg-3">
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
        </div>

@endsection