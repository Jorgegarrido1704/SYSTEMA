@extends('layouts.main') <!-- or your main layout -->

@section('contenido')
<div class="container">
  <header>
    <h1>Escáner QR Mantenimiento</h1>
  </header>

  <main>
    <video id="video" playsinline autoplay></video>
    <div class="overlay" aria-hidden="true"></div>
    <canvas id="canvas" style="display:none"></canvas>
  </main>

  <div class="controls">
    <button id="btnToggle">Detener cámara</button>
    <button id="btnCopy" class="secondary" disabled>Copiar</button>
    <button id="btnOpen" class="secondary" disabled>Abrir</button>
    <button id="btnShare" class="secondary" disabled>Compartir</button>
    <div style="flex:1"></div>
    <div class="hint">Recomendado: usar en HTTPS o en localhost para que la cámara funcione.</div>
  </div>
</div>

<div id="resultCard" class="result-card" role="dialog" aria-modal="true">
  <h3>QR detectado</h3>
  <div id="resultText" class="result-text"></div>
  <div class="result-actions">
    <button id="okBtn">Cerrar</button>
    <button id="cardCopyBtn">Copiar</button>
    <button id="cardOpenBtn">Abrir</button>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    const btnToggle = document.getElementById('btnToggle');
    const btnCopy = document.getElementById('btnCopy');
    const btnOpen = document.getElementById('btnOpen');
    const btnShare = document.getElementById('btnShare');
    const resultCard = document.getElementById('resultCard');
    const resultText = document.getElementById('resultText');
    const okBtn = document.getElementById('okBtn');
    const cardCopyBtn = document.getElementById('cardCopyBtn');
    const cardOpenBtn = document.getElementById('cardOpenBtn');

    let stream = null;
    let scanning = true;
    let lastDetected = null;
    let lastDetectedTime = 0;
    const DEBOUNCE_MS = 2000;

    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: { ideal: "environment" } },
                audio: false
            });
            video.srcObject = stream;
            await video.play();
            scanning = true;
            btnToggle.textContent = 'Detener cámara';
            requestAnimationFrame(scanLoop);
        } catch (err) {
            alert('Error al acceder a la cámara: ' + err);
        }
    }

    function stopCamera() {
        scanning = false;
        if (stream) {
            stream.getTracks().forEach(t => t.stop());
            stream = null;
        }
        video.pause();
        video.srcObject = null;
        btnToggle.textContent = 'Iniciar cámara';
    }

    btnToggle.addEventListener('click', () => {
        if (scanning) stopCamera();
        else startCamera();
    });

    function isProbablyUrl(text) {
        try {
            const url = new URL(text);
            return url.protocol === 'http:' || url.protocol === 'https:';
        } catch (e) {
            return false;
        }
    }

    function showResult(text) {
        resultText.textContent = text;
        resultCard.style.display = 'block';
        btnCopy.disabled = false;
        cardCopyBtn.disabled = false;
        btnOpen.disabled = !isProbablyUrl(text);
        cardOpenBtn.disabled = !isProbablyUrl(text);
        btnShare.disabled = !(navigator.share !== undefined);
        if (navigator.vibrate) navigator.vibrate(50);
    }

    function hideResult() {
        resultCard.style.display = 'none';
        lastDetected = null;
    }

    okBtn.addEventListener('click', hideResult);

    async function copyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            alert('Copiado al portapapeles');
        } catch (e) {
            alert('No se pudo copiar: ' + e);
        }
    }

    btnCopy.addEventListener('click', () => lastDetected && copyToClipboard(lastDetected));
    cardCopyBtn.addEventListener('click', () => lastDetected && copyToClipboard(lastDetected));
    btnOpen.addEventListener('click', () => lastDetected && isProbablyUrl(lastDetected) && window.open(lastDetected, '_blank'));
    cardOpenBtn.addEventListener('click', () => lastDetected && isProbablyUrl(lastDetected) && window.open(lastDetected, '_blank'));
    btnShare.addEventListener('click', async () => {
        if (lastDetected && navigator.share) {
            try { await navigator.share({ text: lastDetected }); } catch (e) {}
        } else {
            alert('Compartir no está disponible en este navegador');
        }
    });

    function scanLoop() {
        if (!scanning) return;
        if (video.readyState === video.HAVE_ENOUGH_DATA) {
            if (canvas.width !== video.videoWidth || canvas.height !== video.videoHeight) {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
            }
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const code = jsQR(imageData.data, imageData.width, imageData.height, { inversionAttempts: "attemptBoth" });
            if (code && code.data) {
                const now = Date.now();
                if (code.data !== lastDetected || (now - lastDetectedTime) > DEBOUNCE_MS) {
                    lastDetected = code.data;
                    lastDetectedTime = now;
                    showResult(code.data);
                }
            }
        }
        requestAnimationFrame(scanLoop);
    }

    startCamera();
    window.addEventListener('beforeunload', stopCamera);
});
</script>

</script>
@endsection
