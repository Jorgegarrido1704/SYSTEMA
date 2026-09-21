@extends('layouts.main')

@section('contenido')

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.sim-root {
  font-family: 'Segoe UI', Tahoma, sans-serif;
  background: #f0f2f5;
  min-height: calc(100vh - 60px);
  padding: 16px;
}

.sim-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 14px; }
.sim-header h2 { font-size: 16px; font-weight: 700; color: #1a2533; }

.sim-status { font-size: 11px; color: #999; display: flex; align-items: center; gap: 6px; }
.sim-dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }
.sim-dot.loading { background: #f59e0b; animation: blink 1s ease-in-out infinite; }
@keyframes blink { 0%,100% {opacity:1} 50% {opacity:.2} }

.sim-grid { display: grid; grid-template-columns: 1.3fr 1fr; gap: 14px; align-items: start; }
@media (max-width: 1000px) { .sim-grid { grid-template-columns: 1fr; } }

.sim-panel { background: #fff; border: 1px solid #e3e8ef; border-radius: 10px; overflow: hidden; margin-bottom: 14px; }
.sim-panel-hdr { padding: 11px 14px; border-bottom: 1px solid #f0f2f5; font-size: 12px; font-weight: 700;
  color: #444; text-transform: uppercase; letter-spacing: .04em; }
.sim-panel-body { padding: 12px 14px; }

/* ── Config de turno ── */
.cfg-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 8px; }
.cfg-field label { display: block; font-size: 9.5px; color: #999; margin-bottom: 3px; text-transform: uppercase; }
.cfg-field input {
  width: 100%; padding: 6px 8px; font-size: 13px; border: 1px solid #d5dae4; border-radius: 6px;
  background: #f8f9fb; outline: none; transition: border-color .15s;
}
.cfg-field input:focus { border-color: #2563eb; background: #fff; }

/* ── Renglones de orden ── */
.orden-row { display: grid; grid-template-columns: 1fr 90px 90px 30px; gap: 8px; align-items: center; margin-bottom: 8px; position: relative; }
.orden-row input {
  padding: 7px 10px; font-size: 13px; border: 1px solid #d5dae4; border-radius: 6px; outline: none;
  background: #f8f9fb; transition: border-color .15s; width: 100%;
}
.orden-row input:focus { border-color: #2563eb; background: #fff; }
.orden-row .qty-lbl { font-size: 9px; color: #aaa; position: absolute; top: -14px; left: 0; }
.btn-remove {
  background: #fef2f2; color: #dc2626; border: none; border-radius: 6px; width: 28px; height: 28px;
  cursor: pointer; font-size: 14px; line-height: 1; display: flex; align-items: center; justify-content: center;
}
.btn-remove:hover { background: #fee2e2; }

.autocomplete-box {
  position: absolute; top: 100%; left: 0; right: 90px; background: #fff; border: 1px solid #d5dae4;
  border-radius: 6px; box-shadow: 0 6px 16px rgba(0,0,0,.08); z-index: 20; max-height: 180px; overflow-y: auto; display: none;
}
.autocomplete-box.show { display: block; }
.autocomplete-item { padding: 7px 10px; font-size: 12.5px; cursor: pointer; }
.autocomplete-item:hover { background: #eff6ff; }

.btn-primary { display:inline-flex; align-items:center; gap:5px; padding:7px 14px;
  background:#2563eb; color:#fff; border:none; border-radius:6px; font-size:12.5px;
  font-weight:600; cursor:pointer; transition:background .15s; }
.btn-primary:hover { background:#1d4ed8; }
.btn-secondary { display:inline-flex; align-items:center; gap:5px; padding:7px 14px;
  background:#f1f5f9; color:#444; border:1px solid #dde2ea; border-radius:6px; font-size:12.5px;
  font-weight:600; cursor:pointer; transition:background .15s; }
.btn-secondary:hover { background:#e2e8f0; }

/* ── Resultado global ── */
.veredicto { padding: 12px 14px; border-radius: 10px; font-size: 13px; font-weight: 700; margin-bottom: 14px;
  display: flex; align-items: center; gap: 10px; }
.veredicto.ok   { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
.veredicto.warn { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
.veredicto.crit { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
.veredicto .sub { font-weight: 400; font-size: 11.5px; opacity: .85; }

/* ── Barras por área ── */
.area-row { padding: 9px 0; border-bottom: 1px solid #f7f8fa; }
.area-row:last-child { border-bottom: none; }
.area-row .top { display: flex; justify-content: space-between; font-size: 12.5px; margin-bottom: 5px; }
.area-row .top .name { font-weight: 600; color: #222; }
.area-row .top .pct { font-weight: 700; }
.bar-track { height: 8px; background: #f0f2f5; border-radius: 4px; overflow: hidden; }
.bar-fill { height: 100%; border-radius: 4px; transition: width .2s; }
.area-row .meta { font-size: 10.5px; color: #999; margin-top: 3px; }

/* ── Tabla items ── */
.sim-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.sim-table thead th { text-align: left; padding: 6px 8px; font-size: 9.5px; text-transform: uppercase;
  color: #999; border-bottom: 1px solid #eee; }
.sim-table tbody td { padding: 6px 8px; border-bottom: 1px solid #f7f8fa; color: #333; }
.pn-code { font-family: 'Consolas', monospace; font-weight: 600; }

.sim-empty { padding: 20px; text-align: center; color: #aaa; font-size: 12.5px; }
.sim-warning { margin-top: 10px; padding: 8px 12px; background: #fffbeb; border: 1px solid #fde68a;
  border-radius: 8px; font-size: 11.5px; color: #92400e; display: none; }
.sim-warning.show { display: block; }
</style>

<div class="sim-root">

  <div class="sim-header">
    <h2>🧮 Simulador de turno</h2>
    <div class="sim-status">
      <span class="sim-dot" id="sim-dot"></span>
      <span id="sim-status-txt">Agrega órdenes para simular</span>
    </div>
  </div>

  <div class="sim-grid">

    {{-- ══ COLUMNA IZQUIERDA: config + órdenes ══ --}}
    <div>
      {{-- Config de turno --}}
      <div class="sim-panel">
        <div class="sim-panel-hdr">Capacidad del turno</div>
        <div class="sim-panel-body">
          <div class="cfg-grid">
            <div class="cfg-field">
              <label>Horas turno</label>
              <input type="number" id="cfg-horas" value="8" min="0.5" step="0.5" oninput="onConfigChange()">
            </div>
            @foreach(['Cutting','Terminals','Assembly','Looming','Quality','Packaging'] as $area)
            <div class="cfg-field">
              <label>{{ $area }} (est.)</label>
              <input type="number" id="cfg-op-{{ $area }}" value="1" min="0" step="1" oninput="onConfigChange()">
            </div>
            @endforeach
          </div>
          <div style="font-size:10.5px;color:#aaa;margin-top:8px;">
            "Est." = estaciones/operarios en paralelo trabajando esa área durante el turno.
          </div>
        </div>
      </div>

      {{-- Órdenes a simular --}}
      <div class="sim-panel">
        <div class="sim-panel-hdr">Órdenes a simular</div>
        <div class="sim-panel-body">
          <div id="ordenes-container"></div>
          <div style="display:flex; gap:8px; margin-top:6px;">
            <button class="btn-secondary" onclick="agregarRenglon()">+ Agregar orden</button>
            <button class="btn-primary" onclick="simular()">Simular</button>
          </div>
        </div>
      </div>
    </div>

    {{-- ══ COLUMNA DERECHA: resultados ══ --}}
    <div>
      <div id="veredicto-box"></div>

      <div class="sim-panel">
        <div class="sim-panel-hdr">Carga por área vs capacidad</div>
        <div class="sim-panel-body" id="areas-resultado">
          <div class="sim-empty">Agrega órdenes y presiona "Simular"</div>
        </div>
      </div>

      <div class="sim-panel">
        <div class="sim-panel-hdr">Detalle por orden</div>
        <div class="sim-panel-body" style="overflow-x:auto;">
          <table class="sim-table">
            <thead>
              <tr><th>PN</th><th>Qty</th><th>Cutting</th><th>Terminals</th><th>Assembly</th><th>Looming</th><th>Quality</th><th>Packaging</th><th>Total</th></tr>
            </thead>
            <tbody id="items-tbody">
              <tr><td colspan="9" class="sim-empty">Sin resultados aún</td></tr>
            </tbody>
          </table>
        </div>
        <div class="sim-warning" id="sin-ruteo-warning"></div>
      </div>
    </div>

  </div>
</div>

<script>
const $ = id => document.getElementById(id);
const AREAS = ['Cutting','Terminals','Assembly','Looming','Quality','Packaging'];
let renglonCount = 0;
let debounceTimer = null;

function csrfToken(){
  const m = document.querySelector('meta[name="csrf-token"]');
  return m ? m.content : '';
}

function fmtMin(min){
  if (min == null) return '--';
  if (min < 60) return min.toFixed(1) + ' min';
  return (min/60).toFixed(1) + ' h';
}

/* ── Renglones dinámicos de orden (pn + qty) ── */
function agregarRenglon(pn = '', qty = ''){
  const id = renglonCount++;
  const wrap = document.createElement('div');
  wrap.className = 'orden-row';
  wrap.id = 'renglon-' + id;
  wrap.innerHTML = `
    <div style="position:relative;">
      <input type="text" placeholder="Número de parte…" id="pn-${id}"
             value="${pn}" oninput="onPnInput(${id})" autocomplete="off">
      <div class="autocomplete-box" id="ac-${id}"></div>
    </div>
    <input type="number" placeholder="Cantidad" id="qty-${id}" value="${qty}" min="0" oninput="onConfigChange()">
    <button class="btn-secondary" style="pointer-events:none;font-size:10px;color:#aaa;">pzas</button>
    <button class="btn-remove" onclick="quitarRenglon(${id})">✕</button>
  `;
  $('ordenes-container').appendChild(wrap);
}

function quitarRenglon(id){
  const el = $('renglon-' + id);
  if (el) el.remove();
  onConfigChange();
}

let acTimer = null;
function onPnInput(id){
  clearTimeout(acTimer);
  const val = $('pn-' + id).value.trim();
  const box = $('ac-' + id);
  if (val.length < 2) { box.classList.remove('show'); return; }

  acTimer = setTimeout(() => {
    fetch(`/simulacion/buscarPn?q=${encodeURIComponent(val)}`)
      .then(r => r.json())
      .then(lista => {
        if (!lista.length) { box.classList.remove('show'); return; }
        box.innerHTML = lista.map(pn =>
          `<div class="autocomplete-item" onclick="seleccionarPn(${id}, '${pn}')">${pn}</div>`
        ).join('');
        box.classList.add('show');
      });
  }, 250);
}

function seleccionarPn(id, pn){
  $('pn-' + id).value = pn;
  $('ac-' + id).classList.remove('show');
  onConfigChange();
}

document.addEventListener('click', (e) => {
  if (!e.target.closest('.orden-row')) {
    document.querySelectorAll('.autocomplete-box').forEach(b => b.classList.remove('show'));
  }
});

function onConfigChange(){
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(simular, 500);
}

/* ── Simulación ── */
function recolectarItems(){
  const rows = document.querySelectorAll('.orden-row');
  const items = [];
  rows.forEach(row => {
    const id = row.id.replace('renglon-', '');
    const pn = $('pn-' + id)?.value.trim();
    const qty = parseFloat($('qty-' + id)?.value);
    if (pn && qty > 0) items.push({ pn, qty });
  });
  return items;
}

function recolectarOperarios(){
  const op = {};
  AREAS.forEach(a => { op[a] = parseFloat($('cfg-op-' + a)?.value) || 0; });
  return op;
}

function simular(){
  const items = recolectarItems();
  const dot = $('sim-dot'), txt = $('sim-status-txt');

  if (items.length === 0) {
    $('veredicto-box').innerHTML = '';
    $('areas-resultado').innerHTML = '<div class="sim-empty">Agrega órdenes y presiona "Simular"</div>';
    $('items-tbody').innerHTML = '<tr><td colspan="9" class="sim-empty">Sin resultados aún</td></tr>';
    if (txt) txt.textContent = 'Agrega órdenes para simular';
    return;
  }

  if (dot) dot.classList.add('loading');
  if (txt) txt.textContent = 'Calculando…';

  fetch('simulacion/simular', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': csrfToken(),
      'X-Requested-With': 'XMLHttpRequest',
    },
    body: JSON.stringify({
      horas_turno: parseFloat($('cfg-horas').value) || 8,
      operarios: recolectarOperarios(),
      items,
    }),
  })
    .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
    .then(pintarResultado)
    .catch(err => {
      console.error(err);
      if (txt) txt.textContent = 'Error al simular';
    })
    .finally(() => { if (dot) dot.classList.remove('loading'); });
}

function colorPorUtilizacion(pct){
  if (pct >= 100) return { fill: '#ef4444', text: '#991b1b' };
  if (pct >= 85)  return { fill: '#f59e0b', text: '#92400e' };
  return { fill: '#22c55e', text: '#166534' };
}

function pintarResultado(data){
  $('sim-status-txt').textContent = 'Actualizado — ' + new Date().toLocaleTimeString();

  // Veredicto
  const util = data.utilizacion_max;
  let clase = 'ok', mensaje = '✅ La carga cabe cómodamente en el turno';
  if (util >= 100) { clase = 'crit'; mensaje = `⛔ No cabe en el turno — ${data.cuello_botella} al ${util}%`; }
  else if (util >= 85) { clase = 'warn'; mensaje = `⚠ Cabe, pero ${data.cuello_botella} queda muy justo (${util}%)`; }
  else { mensaje = `✅ Cabe en el turno — cuello de botella: ${data.cuello_botella} (${util}%)`; }

  $('veredicto-box').innerHTML = `
    <div class="veredicto ${clase}">
      <span>${mensaje}</span>
    </div>`;

  // Barras por área
  $('areas-resultado').innerHTML = data.resumen_areas.map(a => {
    const c = colorPorUtilizacion(a.utilizacion_pct);
    const pct = Math.min(a.utilizacion_pct, 100);
    return `
      <div class="area-row">
        <div class="top">
          <span class="name">${a.area}</span>
          <span class="pct" style="color:${c.text}">${a.utilizacion_pct}%</span>
        </div>
        <div class="bar-track"><div class="bar-fill" style="width:${pct}%;background:${c.fill}"></div></div>
        <div class="meta">${fmtMin(a.requerido_min)} requeridos de ${fmtMin(a.capacidad_min)} disponibles
          ${a.disponible_min >= 0 ? '· ' + fmtMin(a.disponible_min) + ' libres' : '· excedido por ' + fmtMin(Math.abs(a.disponible_min))}</div>
      </div>`;
  }).join('');

  // Tabla de items
  if (data.items.length === 0) {
    $('items-tbody').innerHTML = '<tr><td colspan="9" class="sim-empty">Ninguno de los pn tiene ruteo cargado</td></tr>';
  } else {
    $('items-tbody').innerHTML = data.items.map(it => {
      const t = it.tiempo_por_area;
      return `
        <tr>
          <td class="pn-code">${it.pn}</td>
          <td>${it.qty}</td>
          <td>${fmtMin(t.Cutting)}</td>
          <td>${fmtMin(t.Terminals)}</td>
          <td>${fmtMin(t.Assembly)}</td>
          <td>${fmtMin(t.Looming)}</td>
          <td>${fmtMin(t.Quality)}</td>
          <td>${fmtMin(t.Packaging)}</td>
          <td style="font-weight:700;">${fmtMin(it.tiempo_total_min)}</td>
        </tr>`;
    }).join('');
  }

  // pn sin ruteo
  const warn = $('sin-ruteo-warning');
  if (data.pn_sin_ruteo && data.pn_sin_ruteo.length > 0) {
    warn.textContent = `⚠ Sin tiempos de ruteo cargados para: ${data.pn_sin_ruteo.join(', ')}`;
    warn.classList.add('show');
  } else {
    warn.classList.remove('show');
  }
}

/* ── Inicio: un renglón vacío listo para capturar ── */
document.addEventListener('DOMContentLoaded', () => {
  agregarRenglon();
});
</script>

@endsection