<h2>{{ $trabajo->job }}</h2>

<a href="{{ route('trabajos.excel', $trabajo) }}">Descargar Excel</a>

@foreach ($trabajo->pasos as $paso)
    <div style="border:1px solid #ccc; padding:10px; margin:10px 0">
        <strong>{{ $paso->orden }}. {{ $paso->plantilla->titulo }}</strong>
        <p>{{ $paso->plantilla->descripcion }}</p>

        @if ($paso->imagen_prueba)
            <img src="{{ asset('storage/'.$paso->imagen_prueba) }}" width="200">
            <p>Completado: {{ $paso->completado_at->format('d/m/Y H:i') }}</p>
        @endif

        <form method="POST" action="{{ route('pasos.evidencia', $paso) }}" enctype="multipart/form-data">
            @csrf
            <input type="file" name="foto" accept="image/*" capture="environment" required>
            <button type="submit">Subir evidencia</button>
        </form>
    </div>
@endforeach
