@extends('layouts.main')

@section('contenido')
 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4"> </div>


<div class="row">
    <!-- registro de fechas -->
    <div class="col-xl-12 col-md-6 mb-4">
                <div class="card-header py-2 d-flex flex-row align-items-center justify-content-between">
                    <div class="form-group  ">
                        <div class= "row">
                            <div class="col-md-6">
                                <h4 class="m-0 font-weight-bold text-primary">{{ __('Date') }} </h4>
                            </div>
                            <div class="col-md-6">
                                <input type="date" name="fecha" id="fecha" value="{{ date('Y-m-d') }}" onchange="getCorte()">
                            </div>
                        </div>
                    </div>
                </div>
         </div>
         <!-- end registro de fechas -->
         <!-- Maquina 1 -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-x font-weight-bold text-primary text-uppercase mb-1">
                                MC-1</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span id="mc1"></span>%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-Pallet fa-3x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!--end Maquina 1 -->
</div>
    <script>

      async function getCorte(){
    const fechaInput = document.getElementById('fecha').value;
    // Si el input está vacío, puedes decidir no enviar nada o enviar la fecha de hoy
    if(!fechaInput) return;

    try {
        const response = await fetch('/chart/getDatacorte?fecha=' + fechaInput);

        // Si el servidor responde con error (500, 404, etc) saltará al catch
        if (!response.ok) {
            throw new Error(`Error en el servidor: ${response.status}`);
        }

        const data = await response.json();
        console.log(data);
        document.getElementById('mc1').textContent = data.OEE;

    } catch (error) {
        console.error("Hubo un problema al obtener el corte:", error);
    }
}
    getCorte();
    setInterval(getCorte, 30000);
    </script>



 @endsection
/
