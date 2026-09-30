@extends('layouts.main')

@section('contenido')

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.sim-root { font-family: 'Segoe UI', Tahoma, sans-serif; background: #f0f2f5; min-height: calc(100vh - 60px); padding: 16px; }
.sim-header { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 14px; }
.sim-header h2 { font-size: 16px; font-weight: 700; color: #1a2533; }
.sim-status { font-size: 11px; color: #999; display: flex; align-items: center; gap: 6px; }
.sim-dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }
.sim-dot.loading { background: #f59e0b; animation: blink 1s ease-in-out infinite; }
@keyframes blink { 0%,100% {opacity:1} 50% {opacity:.2} }

.sim-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; align-items: start; }
@media (max-width: 1000px) { .sim-grid { grid-template-columns: 1fr; } }

.sim-panel { background: #fff; border: 1px solid #e3e8ef; border-radius: 10px; overflow: hidden; margin-bottom: 14px; }
.sim-panel-hdr { padding: 11px 14px; border-bottom: 1px solid #f0f2f5; font-size: 12px; font-weight: 700; color: #444;
  text-transform: uppercase; letter-spacing: .04em; display:flex; justify-content:space-between; align-items:center; gap:8px; }
.sim-panel-body { padding: 12px 14px; }

.cfg-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 8px; }
.cfg-field label { display: block; font-size: 9.5px; color: #999; margin-bottom: 3px; text-transform: uppercase; }
.cfg-field input { width: 100%; padding: 6px 8px; font-size: 13px; border: 1px solid #d5dae4; border-radius: 6px; background: #f8f9fb; outline: none; }
.cfg-field input:focus { border-color: #2563eb; background: #fff; }

textarea#lista-demanda { width: 100%; height: 220px; padding: 8px 10px; font-family: Consolas, monospace; font-size: 12px;
  border: 1px solid #d5dae4; border-radius: 6px; background: #f8f9fb; outline: none; resize: vertical; }
textarea#lista-demanda:focus { border-color: #2563eb; background: #fff; }

.btn-primary { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; background:#2563eb; color:#fff; border:none;
  border-radius:6px; font-size:12.5px; font-weight:600; cursor:pointer; }
.btn-primary:hover { background:#1d4ed8; }
.btn-secondary { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; background:#f1f5f9; color:#444;
  border:1px solid #dde2ea; border-radius:6px; font-size:12.5px; font-weight:600; cursor:pointer; }
.btn-secondary:hover { background:#e2e8f0; }

.veredicto { padding: 10px 12px; border-radius: 8px; font-size: 12.5px; font-weight: 700; margin-bottom: 12px; }
.veredicto.ok   { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
.veredicto.warn { background: #fffbeb; border: 1px solid #fde68a; color: #92400e; }
.veredicto.crit { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

.area-row { padding: 7px 0; }
.area-row .top { display: flex; justify-content: space-between; font-size: 12px; margin-bottom: 4px; }
.area-row .top .name { font-weight: 600; color: #222; }
.area-row .top .pct { font-weight: 700; }
.bar-track { height: 12px; background: #f0f2f5; border-radius: 4px; position: relative; overflow: visible; }
.bar-fill { height: 100%; border-radius: 4px; transition: width .2s; }
.bar-100 { position: absolute; top: -3px; bottom: -3px; width: 2px; background: #1a2533; opacity: .55; }
.area-row .meta { font-size: 10.5px; color: #999; margin-top: 3px; }
.chart-legend { font-size: 10.5px; color: #888; margin-top: 4px; }

.sim-table { width: 100%; border-collapse: collapse; font-size: 12px; }
.sim-table thead th { text-align: left; padding: 6px 8px; font-size: 9.5px; text-transform: uppercase; color: #999; border-bottom: 1px solid #eee; position: sticky; top: 0; background:#fff; }
.sim-table tbody td { padding: 5px 8px; border-bottom: 1px solid #f7f8fa; color: #333; }
.pn-code { font-family: 'Consolas', monospace; font-weight: 600; }
.sim-empty { padding: 20px; text-align: center; color: #aaa; font-size: 12.5px; }
.sim-warning { margin-top: 10px; padding: 8px 12px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; font-size: 11.5px; color: #92400e; }

.week-head { display:flex; align-items:center; gap:10px; }
.week-days { display:flex; align-items:center; gap:4px; font-size:10.5px; color:#888; text-transform:none; letter-spacing:0; font-weight:400; }
.week-days input { width: 46px; padding: 3px 5px; font-size: 12px; border: 1px solid #d5dae4; border-radius: 5px; }
details.pn-det summary { cursor: pointer; font-size: 12px; font-weight: 600; color: #2563eb; margin: 10px 0 6px; }
.pn-scroll { max-height: 260px; overflow-y: auto; }
</style>

<div class="sim-root">

  <div class="sim-header">
    <h2>🧮 Simulador de demanda semanal</h2>
    <div class="sim-status">
      <span class="sim-dot" id="sim-dot"></span>
      <span id="sim-status-txt">Pega la lista de demanda para simular</span>
    </div>
  </div>

  <div class="sim-grid">

    {{-- ══ Config ══ --}}
    <div>
      <div class="sim-panel">
        <div class="sim-panel-hdr">Capacidad</div>
        <div class="sim-panel-body">
          <div class="cfg-grid">
            <div class="cfg-field">
              <label>Horas por día</label>
              <input type="number" id="cfg-horas" value="19.8" min="0.5" step="0.1" onchange="onConfigChange()">
            </div>
            @foreach(['Cutting'=>6, 'Terminals'=>18, 'Assembly'=>45, 'Looming'=>9, 'Quality'=>9, 'Packaging'=>9] as $area => $estaciones)
            <div class="cfg-field">
              <label>{{ $area }} (est.)</label>
              <input type="number" id="cfg-op-{{ $area }}" value="{{ $estaciones }}" min="0" step="1" onchange="onConfigChange()">
            </div>
            @endforeach
          </div>
          <div style="font-size:10.5px;color:#aaa;margin-top:8px;">
            "Est." = estaciones/operarios en paralelo por área. La capacidad semanal = horas por día × días laborales de esa semana (editable en cada semana).
          </div>
        </div>
      </div>
    </div>

    {{-- ══ Lista de demanda ══ --}}
    <div>
      <div class="sim-panel">
        <div class="sim-panel-hdr">Lista de demanda</div>
        <div class="sim-panel-body">
          <textarea id="lista-demanda" placeholder="Pega aquí: número de parte, fecha (dd/mm/aaaa), cantidad&#10;1003547479	8/10/2026	100	1&#10;16514514	8/10/2026	20	1"></textarea>
          <div id="parse-info" style="font-size:11px;color:#888;margin-top:6px;"></div>
          <div style="display:flex; gap:8px; margin-top:8px;">
            <button class="btn-primary" onclick="simular()">Simular semanas</button>
            <button class="btn-secondary" onclick="limpiar()">Limpiar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ══ Resumen semanal ══ --}}
  <div class="sim-panel" id="resumen-panel" style="display:none;">
    <div class="sim-panel-hdr">Resumen: utilización máxima por semana</div>
    <div class="sim-panel-body" id="resumen-semanas"></div>
  </div>

  {{-- ══ Detalle por semana ══ --}}
  <div class="sim-grid" id="semanas-container"></div>

</div>

<script>
const $ = id => document.getElementById(id);
const AREAS = ['Cutting','Terminals','Assembly','Looming','Quality','Packaging'];
let debounceTimer = null;
let weekDaysOverride = {};   // { 'YYYY-MM-DD' (lunes): dias }

function csrfToken(){
  const m = document.querySelector('meta[name="csrf-token"]');
  return m ? m.content : '';
}
function fmtMin(min){
  if (min == null) return '--';
  if (min < 60) return min.toFixed(1) + ' min';
  return (min/60).toFixed(1) + ' h';
}
function pad(n){ return String(n).padStart(2,'0'); }
function isoKey(d){ return d.getFullYear() + '-' + pad(d.getMonth()+1) + '-' + pad(d.getDate()); }
function fmtCorta(d){ return pad(d.getDate()) + '/' + pad(d.getMonth()+1); }

/* ── Parseo de la lista pegada: PN, fecha dd/mm/yyyy, cantidad ── */
function parsearLista(){
  const lineas = $('lista-demanda').value.split(/\r?\n/);
  const registros = [];
  let ignoradas = 0;
  lineas.forEach(l => {
    l = l.trim();
    if (!l) return;
    const t = l.split(/\t|\s+/);
    const m = (t[1] || '').match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
    const qty = parseFloat(t[2]);
    if (!t[0] || !m || !(qty > 0)) { ignoradas++; return; }
    registros.push({ pn: t[0], fecha: new Date(+m[3], +m[2]-1, +m[1]), qty });
  });
  return { registros, ignoradas };
}

function lunesDe(d){
  const x = new Date(d.getFullYear(), d.getMonth(), d.getDate());
  x.setDate(x.getDate() - ((x.getDay() + 6) % 7));
  return x;
}

/* Agrupa por semana (lunes–domingo) y suma cantidades por PN */
function agruparSemanas(registros){
  const minFecha = registros.reduce((a, r) => r.fecha < a ? r.fecha : a, registros[0].fecha);
  const semanas = {};
  registros.forEach(r => {
    const lun = lunesDe(r.fecha);
    const k = isoKey(lun);
    if (!semanas[k]) semanas[k] = { key: k, lunes: lun, pns: {}, total: 0 };
    semanas[k].pns[r.pn] = (semanas[k].pns[r.pn] || 0) + r.qty;
    semanas[k].total += r.qty;
  });
  // días laborales por defecto: L–V de la semana, sin contar días anteriores al primer dato
  Object.values(semanas).forEach(s => {
    let dias = 0;
    for (let i = 0; i < 5; i++) {
      const d = new Date(s.lunes); d.setDate(d.getDate() + i);
      if (d >= minFecha) dias++;
    }
    s.diasDefault = dias;
  });
  return Object.values(semanas).sort((a, b) => a.lunes - b.lunes);
}

function recolectarOperarios(){
  const op = {};
  AREAS.forEach(a => { op[a] = parseFloat($('cfg-op-' + a)?.value) || 0; });
  return op;
}

function onConfigChange(){
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(() => { if ($('lista-demanda').value.trim()) simular(); }, 400);
}
function onDiasChange(key, val){
  weekDaysOverride[key] = Math.max(0.5, parseFloat(val) || 1);
  onConfigChange();
}

function limpiar(){
  $('lista-demanda').value = '';
  $('parse-info').textContent = '';
  $('semanas-container').innerHTML = '';
  $('resumen-panel').style.display = 'none';
  $('sim-status-txt').textContent = 'Pega la lista de demanda para simular';
}

/* ── Simulación: una llamada al backend por semana ── */
function simular(){
  const { registros, ignoradas } = parsearLista();
  const dot = $('sim-dot'), txt = $('sim-status-txt');

  if (!registros.length) {
    $('parse-info').textContent = ignoradas ? `${ignoradas} líneas no válidas` : '';
    $('semanas-container').innerHTML = '';
    $('resumen-panel').style.display = 'none';
    return;
  }

  const semanas = agruparSemanas(registros);
  $('parse-info').textContent =
    `${registros.length} renglones · ${semanas.length} semanas` + (ignoradas ? ` · ${ignoradas} líneas ignoradas` : '');

  dot.classList.add('loading');
  txt.textContent = 'Calculando…';

  const horasDia = parseFloat($('cfg-horas').value) || 19.8;
  const operarios = recolectarOperarios();

  const tareas = semanas.map(s => {
    const dias = weekDaysOverride[s.key] ?? s.diasDefault;
    s.dias = dias;
    const items = Object.entries(s.pns).map(([pn, qty]) => ({ pn, qty }));
    return fetch('simulacion/simular', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken(),
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: JSON.stringify({ horas_turno: horasDia * dias, operarios, items }),
    })
      .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
      .then(data => ({ semana: s, data }));
  });

  Promise.all(tareas)
    .then(resultados => { pintarTodo(resultados); txt.textContent = 'Actualizado — ' + new Date().toLocaleTimeString(); })
    .catch(err => { console.error(err); txt.textContent = 'Error al simular'; })
    .finally(() => dot.classList.remove('loading'));
}

function colorPorUtilizacion(pct){
  if (pct >= 100) return { fill: '#ef4444', text: '#991b1b' };
  if (pct >= 85)  return { fill: '#f59e0b', text: '#92400e' };
  return { fill: '#22c55e', text: '#166534' };
}

function barras(items, scaleMax, valFn, labelFn, metaFn){
  const marca = (100 / scaleMax) * 100;
  return items.map(a => {
    const v = valFn(a);
    const c = colorPorUtilizacion(v);
    const w = Math.min(v / scaleMax * 100, 100);
    return `
      <div class="area-row">
        <div class="top"><span class="name">${labelFn(a)}</span><span class="pct" style="color:${c.text}">${v}%</span></div>
        <div class="bar-track">
          <div class="bar-fill" style="width:${w}%;background:${c.fill}"></div>
          <div class="bar-100" style="left:${marca}%"></div>
        </div>
        ${metaFn ? `<div class="meta">${metaFn(a)}</div>` : ''}
      </div>`;
  }).join('');
}

function pintarTodo(resultados){
  // Resumen global
  const maxGlobal = Math.max(100, ...resultados.map(r => r.data.utilizacion_max));
  $('resumen-panel').style.display = 'block';
  $('resumen-semanas').innerHTML =
    barras(resultados, maxGlobal,
      r => r.data.utilizacion_max,
      r => `Semana del ${fmtCorta(r.semana.lunes)} · ${r.data.cuello_botella}`,
      r => `${r.semana.total.toLocaleString()} pzas · ${Object.keys(r.semana.pns).length} PN`) +
    `<div class="chart-legend">La línea oscura marca el 100% de capacidad. Barra roja = no se cubre la demanda de esa semana.</div>`;

  // Tarjetas por semana
  $('semanas-container').innerHTML = resultados.map(({ semana: s, data }) => {
    const util = data.utilizacion_max;
    let clase = 'ok', msg = `✅ Se cubre la demanda — cuello: ${data.cuello_botella} (${util}%)`;
    if (util >= 100) { clase = 'crit'; msg = `⛔ No se cubre — ${data.cuello_botella} al ${util}%`; }
    else if (util >= 85) { clase = 'warn'; msg = `⚠ Se cubre muy justo — ${data.cuello_botella} (${util}%)`; }

    const fin = new Date(s.lunes); fin.setDate(fin.getDate() + 4);
    const scaleMax = Math.max(100, ...data.resumen_areas.map(a => a.utilizacion_pct));

    const graf = barras(data.resumen_areas, scaleMax,
      a => a.utilizacion_pct, a => a.area,
      a => `${fmtMin(a.requerido_min)} requeridos de ${fmtMin(a.capacidad_min)}` +
           (a.disponible_min >= 0 ? ` · ${fmtMin(a.disponible_min)} libres` : ` · excedido por ${fmtMin(Math.abs(a.disponible_min))}`));

    const tiempos = {};
    (data.items || []).forEach(it => tiempos[it.pn] = it.tiempo_total_min);
    const filas = Object.entries(s.pns).sort((a, b) => b[1] - a[1]).map(([pn, qty]) => `
      <tr><td class="pn-code">${pn}</td><td>${qty.toLocaleString()}</td><td>${tiempos[pn] != null ? fmtMin(tiempos[pn]) : '--'}</td></tr>`).join('');

    const sinRuteo = (data.pn_sin_ruteo && data.pn_sin_ruteo.length)
      ? `<div class="sim-warning">⚠ Sin ruteo cargado (no suman tiempo): ${data.pn_sin_ruteo.join(', ')}</div>` : '';

    return `
      <div class="sim-panel">
        <div class="sim-panel-hdr">
          <span>Semana ${fmtCorta(s.lunes)} – ${fmtCorta(fin)}</span>
          <span class="week-days">Días laborales
            <input type="number" min="0.5" step="0.5" value="${s.dias}" onchange="onDiasChange('${s.key}', this.value)">
          </span>
        </div>
        <div class="sim-panel-body">
          <div class="veredicto ${clase}">${msg}</div>
          ${graf}
          <details class="pn-det">
            <summary>${Object.keys(s.pns).length} números de parte · ${s.total.toLocaleString()} pzas</summary>
            <div class="pn-scroll">
              <table class="sim-table">
                <thead><tr><th>PN</th><th>Cantidad</th><th>Tiempo total</th></tr></thead>
                <tbody>${filas}</tbody>
              </table>
            </div>
          </details>
          ${sinRuteo}
        </div>
      </div>`;
  }).join('');
}
</script>

@endsection
