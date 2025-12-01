@extends('layouts.main') <!-- or your main layout -->

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

<div class="row">
            <div class="col-lg-6 col-lx-6">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Registros De inicidencias</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; max-height: 400px;" >
                        <!-- Take a picture of the Qr or choice it  -->
                        <form action="{{ route('mantainence.qrs') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="qr_image">Upload QR Code Image:</label>
                                <input type="file" class="form-control-file" id="qr_image" name="qr_image" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Scan QR Code</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-lx-6">

                <div class="card shadow mb-5">
                    <div class="card-header py-3">
                        <h5 class="m-0 font-weight-bold text-primary">Descripcion de incidencias</h5>
                    </div>
                    <div class="card-body" style="overflow-y: auto; max-height: 400px;" >

                    </div>
                </div>
            </div>


</div>
@endsection
