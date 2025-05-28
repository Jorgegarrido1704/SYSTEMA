@extends('layouts.main')

@section('contenido')
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
