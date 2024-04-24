@extends('layouts.main')
@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="po-section">
                <form class="" action="{{ route('po.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="po-label" for="pn">Número de parte</label>
                        <input type="text" name="pn" id="pn" class="form-control" required onchange="return obtenerInformacion()" autofocus>
                    </div>
                    <div class="form-group">
                        <label class="po-label" for="client">Cliente</label>
                        <input type="text" id="client" name="client" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="po-label" for="Rev">REV</label>
                        <input type="text" name="Rev" id="Rev" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="po-label" for="Description">Descripción</label>
                        <input type="text" id="Description" name="Description" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="po-label" for="Uprice">Precio unitario</label>
                        <input type="number" name="Uprice" id="Uprice" step="0.01" min="0" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="po-label" for="Enviar">Enviar a</label>
                        <input type="text" id="Enviar" name="Enviar" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="po-label" for="po">PO</label>
                        <input type="text" id="po" name="po" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="po-label" for="qty">Cantidad req</label>
                        <input type="number" name="qty" id="qty" min="1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="po-label" for="Orday">Día que se ordenó (Formato dd/mm/YY)</label>
                        <input type="text" id="Orday" name="Orday" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="po-label" for="Reqday">Día requerido (Formato dd/mm/YY)</label>
                        <input type="text" name="Reqday" id="Reqday" class="form-control" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <label class="po-label" for="WO">WO</label>
                        <input type="text" name="WO" id="WO" class="form-control" required>
                    </div>
                    <input type="submit" name="enviar" id="enviar" value="Crear" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function obtenerInformacion() {
        var pn = document.getElementById('pn').value;

        if (pn && pn.trim() !== '') {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', "{{ route('getPnDetails') }}", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Add CSRF token to request headers
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 400) {
                    try {
                        var respuesta = JSON.parse(xhr.responseText);
                        console.log(respuesta);
                        document.getElementById('client').value = respuesta.client || '';
                        document.getElementById('Rev').value = respuesta.rev || '';
                        document.getElementById('Description').value = respuesta.desc || '';
                        document.getElementById('Uprice').value = respuesta.price || '';
                        document.getElementById('Enviar').value = respuesta.send || '';
                    } catch (error) {
                        console.error('Error parsing JSON response:', error);
                    }
                } else {
                    console.error('Error in XMLHttpRequest. Status:', xhr.status);
                }
            };

            xhr.onerror = function() {
                console.error('Request failed');
            };

            xhr.send('pn=' + pn);
        } else {
            console.error('Invalid part number');
            document.getElementById('Rev').value = '';
            document.getElementById('Description').value = '';
            document.getElementById('Uprice').value = '';
            document.getElementById('Enviar').value = '';
        }
    }
</script>
@endsection
