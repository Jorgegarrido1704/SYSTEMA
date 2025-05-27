@extends('layouts.main')

@section('contenido')
<div class="d-sm-flex align-items-center justify-content-between mb-4">  </div>
<style>
    #fullscreenPreview {
    transition: opacity 5s ease-in-out;
}
#accidente {
   color:rgba(0, 0, 0, 0.95);
   size: 14px;
   font-style: oblique;
   font: bold;
    }
</style>
<script>
    const registros = @json($registrosDeAsistencia);
    const genero = @json($genero);
</script>
<div class="row">
    <div class="col-lg-4 col-lx-4 col-md-4 mb-4">

        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Today assistence {{date('Y-m-d')}}</h5>
            </div>
            <div class="card-body" style="overflow-y: auto; " >
                <canvas id="assistence"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-lx-4 col-md-4 mb-4">
        <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h5 class="m-1 font-weight-bold text-primary">Diversidad</h5>
            </div>
            <div class="card-body" style="overflow-y: auto;">
                <canvas id="diversidad"></canvas>
            </div>
        </div>
    </div>
   <div class="col-lg-4 col-lx-4 col-md-4 mb-4">
    <div class="card shadow mb-5">
        <div class="card-header py-3">
            <h5 class="m-1 font-weight-bold text-primary">Last Accident Registered</h5>
        </div>
        <div class="card-body click-preview" id="tableChange"
             data-pdf="{{ asset('/dash/pdfs/'.$accidente) }}">
             <p>Ultimo Accidente: Persona se sufrio un accidente</p>
             <p id="accidente">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique fugiat ut inventore vitae neque totam odit reiciendis cupiditate id repudiandae provident numquam, iure eveniet est, dolorum facere eius consectetur distinctio!</p>

        </div>
    </div>
</div>


<script>
document.querySelectorAll('.click-preview').forEach(el => {
    el.addEventListener('mouseover', function () {
        const pdfSrc = this.getAttribute('data-pdf');
        const iframe = document.getElementById('fullscreenIframe');
        iframe.src = pdfSrc;

        const overlay = document.getElementById('fullscreenPreview');
        overlay.style.display = 'flex';
    });
});

// Hide overlay ONLY when the mouse leaves the fullscreen area
document.getElementById('fullscreenPreview').addEventListener('click', function () {
    this.style.display = 'none';
    document.getElementById('fullscreenIframe').src = '';
});
</script>




<div id="fullscreenPreview" style="
    display: none;
    position: fixed;
    top: 5vh;
    left: 5vw;
    width: 90vw;
    height: 90vh;
    background-color: rgba(0, 0, 0, 0.95);
    z-index: 9999;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    box-shadow: 0 0 30px rgba(0,0,0,0.5);
    overflow: hidden;
">
    <button type="circle" class="btn btn-danger" onclick="document.getElementById('fullscreenPreview').style.display = 'none';">Close</button>
    <iframe id="fullscreenIframe" src="" width="100%" height="100%" style="border: none; border-radius: 10px;"></iframe>
</div>

</div>

@endsection
