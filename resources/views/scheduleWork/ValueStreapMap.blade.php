@extends('layouts.main')

@section('contenido')
 <div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>
<style>
        .process-box {
            border: 2px solid #333;
            border-radius: 10px;
            background-color: #f8f9fa;
            padding: 15px;
            min-width: 120px;
            text-align: center;
            margin: 10px;
        }
        .arrow {
            font-size: 24px;
            margin: auto 10px;
        }
        .vsm-container {
            display: flex;
            flex-wrap: nowrap;
            align-items: center;
            overflow-x: auto;
            padding: 20px;
        }
    </style>

    <h2 class="mb-4 text-center">Value Stream Mapping</h2>
    <div class="mb-4 text-center" id='img-vsm'>
        <img src="{{ asset('/pngs/mvs.png')}}" alt="" class="img-fluid" style="width: 75%; height: auto;">
    </div>

    <div class="vsm-container">
        @foreach ($steps as $step)
            <div class="process-box">
                <strong>{{ $step['name'] }}</strong><br>
                <small class="text-muted">{{ $step['label']	 }}</small>
            </div>

            @if (!$loop->last)
                <div class="arrow">➡️</div>
            @endif
        @endforeach
    </div>

@endsection
