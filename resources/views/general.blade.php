@extends('layouts.main')

@section('contenido')

 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>

 <div class="row">
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






  @endsection