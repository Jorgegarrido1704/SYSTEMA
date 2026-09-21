@extends('layouts.main')

@section('contenido')

{{-- ════════════════════════════════════════════════════════════════════
     TIEMPOS DE PRODUCCIÓN — resumen registroparcial × tiemposderuteo
     ════════════════════════════════════════════════════════════════════ --}}

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

.tp-root {
  font-family: 'Segoe UI', Tahoma, sans-serif;
  background: #f0f2f5;
  min-height: calc(100vh - 60px);
  padding: 16px;
}

.tp-header { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin-bottom: 14px; }
.tp-header h2 { font-size: 16px; font-weight: 700; color: #1a2533; }

.tp-search { flex: 1; min-width: 220px; max-width: 380px; position: relative; }
.tp-search input {
  width: 100%; padding: 8px 12px 8px 32px; border: 1px solid #d5dae4; border-radius: 8px;
  font-size: 13px; background: #fff; outline: none; transition: border-color .15s;
}
.tp-search input:focus { border-color: #2563eb; }
.tp-search .icon { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: #999; font-size: 13px; }

.tp-status { font-size: 11px; color: #999; display: flex; align-items: center; gap: 6px; }
.tp-dot { width: 6px; height: 6px; border-radius: 50%; background: #22c55e; }
.tp-dot.loading { background: #f59e0b; animation: blink 1s ease-in-out infinite; }
@keyframes blink { 0%,100% {opacity:1} 50% {opacity:.2} }

/* ── KPI cards ── */
.tp-kpis { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 10px; margin-bottom: 18px; }
.tp-kpi { background: #fff; border: 1px solid #e3e8ef; border-radius: 10px; padding: 12px 14px; }
.tp-kpi .lbl { font-size: 10px; color: #999; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 4px; }
.tp-kpi .val { font-size: 20px; font-weight: 700; color: #1a2533; }
.tp-kpi .sub { font-size: 11px; color: #aaa; margin-top: 2px; }

/* ── Panels ── */
.tp-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 14px; align-items: start; }
@media (max-width: 980px) { .tp-grid { grid-template-columns: 1fr; } }

.tp-panel { background: #fff; border: 1px solid #e3e8ef; border-radius: 10px; overflow: hidden; }
.tp-panel-hdr { padding: 11px 14px; border-bottom: 1px solid #f0f2f5; font-size: 12px; font-weight: 700;
  color: #444; text-transform: uppercase; letter-spacing: .04em; display: flex; justify-content: space-between; align-items: center; }
.tp-panel-body { padding: 6px 0; max-height: 560px; overflow-y: auto; }

/* ── Área bars ── */
.area-row { padding: 9px 14px; border-bottom: 1px solid #f7f8fa; }
.area-row:last-child { border-bottom: none; }
.area-row .top { display: flex; justify-content: space-between; font-size: 12.5px; margin-bottom: 5px; }
.area-row .top .name { font-weight: 600; color: #222; }
.area-row .top .time { font-weight: 700; color: #1a2533; }
.area-row .meta { font-size: 10.5px; color: #999; margin-top: 3px; }
.bar-track { height: 7px; background: #f0f2f5; border-radius: 4px; overflow: hidden; }
.bar-fill { height: 100%; border-radius: 4px; background: linear-gradient(90deg, #2563eb, #60a5fa); }

/* ── Tabla arnés ── */
.tp-table { width: 100%; border-collapse: collapse; font-size: 12.5px; }
.tp-table thead th {
  position: sticky; top: 0; background: #f8f9fb; text-align: left; padding: 8px 12px;
  font-size: 10px; text-transform: uppercase; color: #999; letter-spacing: .04em; border-bottom: 1px solid #eee;
}
.tp-table tbody td { padding: 8px 12px; border-bottom: 1px solid #f7f8fa; color: #333; }
.tp-table tbody tr:hover { background: #fafbfe; cursor: pointer; }
.tp-table tbody tr.expanded { background: #eff6ff; }
.pn-code { font-family: 'Consolas', monospace; font-weight: 600; color: #1a2533; }
.time-strong { font-weight: 700; color: #1a2533; }
.sub-areas { display: none; padding: 6px 12px 10px 28px; background: #f8fafd; font-size: 11.5px; color: #555; }
.sub-areas.open { display: block; }
.sub-areas span { display: inline-block; margin-right: 12px; padding: 2px 8px; background: #fff;
  border: 1px solid #e3e8ef; border-radius: 12px; margin-bottom: 4px; }

.tp-empty { padding: 30px; text-align: center; color: #aaa; font-size: 13px; }

.tp-warning-banner {
  margin-top: 10px; padding: 8px 12px; background: #fffbeb; border: 1px solid #fde68a;
  border-radius: 8px; font-size: 11.5px; color: #92400e; display: none;
}
.tp-warning-banner.show { display: block; }
</style>

<div class="tp-root">

  <div class="tp-header">
    <h2>⏱ Tiempos de producción</h2>

    <div class="tp-search">
      <span class="icon">🔍</span>
      <input type="text" id="pn-search" placeholder="Buscar número de parte (pn)…" oninput="onSearchInput()">
    </div>

    <div class="tp-status">
      <span class="tp-dot" id="tp-dot"></span>
      <span id="tp-status-txt">Cargando…</span>
    </div>
  </div>

  {{-- KPIs generales --}}
  <div class="tp-kpis">
    <div class="tp-kpi">
      <div class="lbl">Órdenes con ruteo</div>
      <div class="val" id="kpi-ordenes">--</div>
    </div>
    <div class="tp-kpi">
      <div class="lbl">Arneses distintos</div>
      <div class="val" id="kpi-arneses">--</div>
    </div>
    <div class="tp-kpi">
      <div class="lbl">Tiempo de proceso</div>
      <div class="val" id="kpi-proceso">--</div>
      <div class="sub">sin setup</div>
    </div>
    <div class="tp-kpi">
      <div class="lbl">Tiempo de setup</div>
      <div class="val" id="kpi-setup">--</div>
    </div>
    <div class="tp-kpi">
      <div class="lbl">Tiempo total</div>
      <div class="val" id="kpi-total-min">--</div>
      <div class="sub" id="kpi-total-horas">-- h</div>
    </div>
  </div>

  <div class="tp-warning-banner" id="pn-sin-ruteo-banner"></div>

  <div class="tp-grid">

    {{-- Desglose por ÁREA --}}
    <div class="tp-panel">
      <div class="tp-panel-hdr">Desglose por área</div>
      <div class="tp-panel-body" id="areas-body">
        <div class="tp-empty">Cargando…</div>
      </div>
    </div>

    {{-- Desglose por ARNÉS --}}
    <div class="tp-panel">
      <div class="tp-panel-hdr">
        <span>Desglose por arnés (pn)</span>
        <span id="arnes-count" style="font-weight:400;color:#aaa;text-transform:none;font-size:11px;"></span>
      </div>
      <div class="tp-panel-body" style="max-height:560px;">
        <table class="tp-table">
          <thead>
            <tr>
              <th>PN</th>
              <th># Órdenes</th>
              <th>Piezas</th>
              <th>T. Proceso</th>
              <th>T. Setup</th>
              <th>T. Total</th>
            </tr>
          </thead>
          <tbody id="arnes-tbody">
            <tr><td colspan="6" class="tp-empty">Cargando…</td></tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<script>
const $ = id => document.getElementById(id);

let debounceTimer = null;
function onSearchInput(){
  clearTimeout(debounceTimer);
  debounceTimer = setTimeout(cargarResumen, 350);
}

function fmtMin(min){
  if (min == null) return '--';
  if (min < 60) return min.toFixed(1) + ' min';
  return (min/60).toFixed(1) + ' h';
}

function cargarResumen(){
  const dot = $('tp-dot'), txt = $('tp-status-txt');
  const pn  = $('pn-search').value.trim();

  if (dot) dot.classList.add('loading');
  if (txt) txt.textContent = 'Consultando…';

  fetch(`/vsmData?pn=${encodeURIComponent(pn)}`, {
      headers: {'X-Requested-With': 'XMLHttpRequest'}
    })
    .then(r => { if(!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
    .then(pintar)
    .catch(err => {
      console.error(err);
      if (txt) txt.textContent = 'Error de conexión';
    })
    .finally(() => { if (dot) dot.classList.remove('loading'); });
}

function pintar(data){
  const tg = data.total_general;
  $('kpi-ordenes').textContent   = tg.ordenes_totales;
  $('kpi-arneses').textContent   = tg.arneses_distintos;
  $('kpi-proceso').textContent   = fmtMin(tg.tiempo_proceso_min);
  $('kpi-setup').textContent     = fmtMin(tg.tiempo_setup_min);
  $('kpi-total-min').textContent = fmtMin(tg.tiempo_total_min);
  $('kpi-total-horas').textContent = tg.tiempo_total_horas + ' h totales';

  $('tp-status-txt').textContent = 'Actualizado — ' + new Date().toLocaleTimeString();

  // Aviso de pn sin ruteo cargado
  const banner = $('pn-sin-ruteo-banner');
  if (data.pn_sin_ruteo && data.pn_sin_ruteo.length > 0) {
    banner.textContent = `⚠ ${data.pn_sin_ruteo.length} número(s) de parte en órdenes activas no tienen tiempos de ruteo cargados: ` +
      data.pn_sin_ruteo.slice(0, 8).join(', ') + (data.pn_sin_ruteo.length > 8 ? '…' : '');
    banner.classList.add('show');
  } else {
    banner.classList.remove('show');
  }

  pintarAreas(data.por_area);
  pintarArneses(data.por_arnes);
}

function pintarAreas(areas){
  const cont = $('areas-body');
  if (!areas || areas.length === 0) {
    cont.innerHTML = '<div class="tp-empty">Sin datos para este filtro</div>';
    return;
  }
  const maxTiempo = Math.max(...areas.map(a => a.tiempo_total_min));
  cont.innerHTML = areas
    .sort((a,b) => b.tiempo_total_min - a.tiempo_total_min)
    .map(a => {
      const pct = maxTiempo > 0 ? (a.tiempo_total_min / maxTiempo * 100) : 0;
      return `
        <div class="area-row">
          <div class="top">
            <span class="name">${a.area}</span>
            <span class="time">${fmtMin(a.tiempo_total_min)}</span>
          </div>
          <div class="bar-track"><div class="bar-fill" style="width:${pct}%"></div></div>
          <div class="meta">${a.ordenes} órdenes · ${a.piezas_totales.toLocaleString()} pz · setup ${fmtMin(a.tiempo_setup_min)}</div>
        </div>`;
    }).join('');
}

function pintarArneses(arneses){
  const tbody = $('arnes-tbody');
  $('arnes-count').textContent = arneses ? `${arneses.length} resultado(s)` : '';

  if (!arneses || arneses.length === 0) {
    tbody.innerHTML = '<tr><td colspan="6" class="tp-empty">Sin resultados para ese número de parte</td></tr>';
    return;
  }

  tbody.innerHTML = arneses
    .sort((a,b) => b.tiempo_total_min - a.tiempo_total_min)
    .map((a, i) => {
      const areasHtml = a.areas.map(ar => `<span>${ar.area}: ${fmtMin(ar.tiempo_total_min)}</span>`).join('');
      return `
        <tr onclick="toggleArnes(${i})">
          <td class="pn-code">${a.pn}</td>
          <td>${a.ordenes.length}</td>
          <td>${a.orgQty_total.toLocaleString()}</td>
          <td>${fmtMin(a.tiempo_proceso_min)}</td>
          <td>${fmtMin(a.tiempo_setup_min)}</td>
          <td class="time-strong">${fmtMin(a.tiempo_total_min)}</td>
        </tr>
        <tr class="sub-row-${i}"><td colspan="6" style="padding:0;border:none;">
          <div class="sub-areas" id="sub-${i}">${areasHtml}</div>
        </td></tr>`;
    }).join('');
}

function toggleArnes(i){
  const el = $('sub-' + i);
  if (el) el.classList.toggle('open');
}

document.addEventListener('DOMContentLoaded', cargarResumen);
</script>

@endsection