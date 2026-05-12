@extends('layouts.main')

@section('contenido')

{{-- ════════════════════════════════════════════════════════════════════
     VSM DINÁMICO — Runner (Greens) Future State
     Layout: mapa fijo izquierda · panel de control con scroll derecha
     ════════════════════════════════════════════════════════════════════ --}}

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

/* ════════ LAYOUT RAÍZ ════════ */
.vsm-root {
  display: flex;
  flex-direction: column;
  height: calc(100vh - 60px);
  font-family: 'Segoe UI', Tahoma, sans-serif;
  background: #f0f2f5;
  overflow: hidden;
}

/* ── Barra superior ── */
.vsm-topbar {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 7px 14px;
  background: #fff;
  border-bottom: 1px solid #dde2ea;
  flex-shrink: 0;
  flex-wrap: wrap;
}
.vsm-topbar h2 { font-size: 13px; font-weight: 700; color: #1a2533; white-space: nowrap; }
.kpi-strip { display: flex; gap: 6px; flex: 1; flex-wrap: wrap; }
.kpi-card { background: #f8f9fb; border: 1px solid #e3e8ef; border-radius: 7px; padding: 4px 11px; min-width: 110px; }
.kpi-card .lbl { font-size: 9px; color: #999; text-transform: uppercase; letter-spacing: .05em; }
.kpi-card .val { font-size: 15px; font-weight: 700; color: #1a2533; }
.kpi-card .val.warn { color: #b45309; }
.kpi-card .val.crit { color: #991b1b; }

/* ── Botones ── */
.btn-primary { display:inline-flex; align-items:center; gap:5px; padding:5px 13px;
  background:#2563eb; color:#fff; border:none; border-radius:6px; font-size:12px;
  font-weight:600; cursor:pointer; white-space:nowrap; transition:background .15s; }
.btn-primary:hover { background:#1d4ed8; }
.btn-icon { padding:4px 9px; background:#f1f5f9; color:#444; border:1px solid #dde2ea;
  border-radius:6px; font-size:13px; cursor:pointer; transition:background .15s; line-height:1; }
.btn-icon:hover { background:#e2e8f0; }
.zoom-lbl { font-size:11px; color:#888; min-width:36px; text-align:center; }

/* ════════ CUERPO (2 COLUMNAS) ════════ */
.vsm-body { display: flex; flex: 1; overflow: hidden; }

/* ── Columna SVG ── */
.vsm-canvas-col { flex: 1; background: #fafbfc; overflow: hidden; display: flex; flex-direction: column; }
.vsm-canvas-wrap { flex: 1; overflow: auto; position: relative; }
#vsm-svg { display: block; background: #fafbfc; transform-origin: top left; transition: transform .15s; }

/* ── Sidebar ── */
.vsm-sidebar {
  width: 320px; min-width: 260px; max-width: 360px;
  background: #f0f2f5; border-left: 1px solid #dde2ea;
  overflow-y: auto; flex-shrink: 0; padding: 8px;
}

/* ── Acordeón ── */
.acc { background:#fff; border:1px solid #dde2ea; border-radius:8px; margin-bottom:7px; overflow:hidden; }
.acc-hdr { display:flex; align-items:center; justify-content:space-between; padding:8px 11px;
  cursor:pointer; user-select:none; font-size:10px; font-weight:700; color:#555;
  text-transform:uppercase; letter-spacing:.05em; transition:background .1s; }
.acc-hdr:hover { background:#f8f9fb; }
.acc-arr { font-size:9px; color:#bbb; transition:transform .2s; }
.acc-arr.open { transform:rotate(180deg); }
.acc-body { padding:9px 11px 11px; border-top:1px solid #f0f2f5; display:none; }
.acc-body.open { display:block; }

/* ── Campos ── */
.proc-card { border:1px solid #e8ecf2; border-radius:7px; padding:8px; margin-bottom:7px; }
.proc-card:last-child { margin-bottom:0; }
.proc-card h4 { font-size:11px; font-weight:600; color:#222; margin-bottom:6px;
  display:flex; align-items:center; gap:5px; }
.proc-card h4 .dot { width:7px; height:7px; border-radius:50%; flex-shrink:0; }
.g2 { display:grid; grid-template-columns:1fr 1fr; gap:5px; }
.g3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:5px; }
.field-wrap label { display:block; font-size:9px; color:#999; margin-bottom:2px; }
.field-wrap input { width:100%; font-size:12px; font-weight:500; padding:4px 6px;
  border:1px solid #d5dae4; border-radius:5px; background:#f8f9fb; color:#1a2533;
  transition:border-color .15s; outline:none; }
.field-wrap input:focus { border-color:#4a90d9; background:#fff; }

/* ── Timeline mini ── */
.tl-mini { border-radius:6px; border:1.5px solid #e0e4ec; padding:5px 4px 4px; text-align:center; }
.tl-mini.trigger { border-color:#93c5fd; background:#eff6ff; }
.tl-mini.va      { border-color:#86efac; background:#f0fdf4; }
.tl-mini.nva     { border-color:#fcd34d; background:#fffbeb; }
.tl-mini .lbl    { font-size:7px; font-weight:700; text-transform:uppercase; color:#777; margin-bottom:2px; }
.tl-mini input   { width:100%; font-size:13px; font-weight:700; text-align:center;
  border:none; background:transparent; color:#1a2533; outline:none; }

/* ── Status ── */
.status-row { display:flex; align-items:center; gap:6px; font-size:10px; color:#aaa; margin-top:7px; }
.status-dot { width:6px; height:6px; border-radius:50%; background:#22c55e; flex-shrink:0; }
.status-dot.loading { background:#f59e0b; animation:blink 1s ease-in-out infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:.2} }

@media (max-width:768px) {
  .vsm-body { flex-direction:column; }
  .vsm-sidebar { width:100%; max-width:100%; border-left:none; border-top:1px solid #dde2ea; height:40vh; }
  .vsm-canvas-col { height:60vh; }
}
</style>

<div class="vsm-root">

  {{-- ── TOPBAR ── --}}
  <div class="vsm-topbar">
    <h2>Runner (Greens) — Future State VSM</h2>
    <div class="kpi-strip">
      <div class="kpi-card"><div class="lbl">Lead Time</div><div class="val" id="kpi-lt">--</div></div>
      <div class="kpi-card"><div class="lbl">VA Time</div><div class="val" id="kpi-va">--</div></div>
      <div class="kpi-card"><div class="lbl">Takt</div><div class="val" id="kpi-takt">--</div></div>
      <div class="kpi-card"><div class="lbl">Eficiencia</div><div class="val" id="kpi-eff">--</div></div>
    </div>
    <button class="btn-icon" onclick="zoomVSM(-0.1)">−</button>
    <span class="zoom-lbl" id="zoom-lbl">100%</span>
    <button class="btn-icon" onclick="zoomVSM(+0.1)">+</button>
    <button class="btn-icon" onclick="zoomFit()" title="Ajustar a pantalla">⊡</button>
    <button class="btn-primary" onclick="cargarDesdeLaravel()">↻ Actualizar</button>
  </div>

  {{-- ── CUERPO ── --}}
  <div class="vsm-body">

    {{-- ══ MAPA ══ --}}
    <div class="vsm-canvas-col">
      <div class="vsm-canvas-wrap" id="canvas-wrap">
        <svg id="vsm-svg" width="1280" height="710" viewBox="0 0 1280 710" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <marker id="arr" viewBox="0 0 10 10" refX="8" refY="5" markerWidth="5" markerHeight="5" orient="auto-start-reverse">
              <path d="M2 1L8 5L2 9" fill="none" stroke="context-stroke" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </marker>
          </defs>

          {{-- INFO SUPERIOR --}}
          <rect x="620" y="38" width="125" height="52" fill="white" stroke="#555" stroke-width="1" rx="2"/>
          <text x="682" y="58" text-anchor="middle" font-size="10" font-weight="bold" fill="#222">Material Planning</text>
          <line x1="620" y1="64" x2="745" y2="64" stroke="#ccc" stroke-width="0.5"/>
          <text x="682" y="76" text-anchor="middle" font-size="8" fill="#666">Schedule &amp; PO mgmt</text>
          <text x="682" y="87" text-anchor="middle" font-size="8" fill="#666">Supplier coordination</text>

          <rect x="478" y="38" width="112" height="30" fill="white" stroke="#888" stroke-width="0.5" rx="2"/>
          <text x="534" y="52" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">PO Acknowledgment</text>
          <text x="534" y="62" text-anchor="middle" font-size="7" fill="#777">Confirmed orders</text>

          <rect x="478" y="76" width="112" height="30" fill="white" stroke="#888" stroke-width="0.5" rx="2"/>
          <text x="534" y="90" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">Supplier Schedule</text>
          <text x="534" y="100" text-anchor="middle" font-size="7" fill="#777">Weekly / Monthly</text>

          <rect x="865" y="32" width="90" height="80" fill="white" stroke="#333" stroke-width="1.5" rx="2"/>
          <text x="910" y="60" text-anchor="middle" font-size="17" font-weight="bold" fill="#111">MRP</text>
          <line x1="865" y1="66" x2="955" y2="66" stroke="#ccc" stroke-width="0.5"/>
          <text x="910" y="79" text-anchor="middle" font-size="8" fill="#555">Material Resource</text>
          <text x="910" y="90" text-anchor="middle" font-size="8" fill="#555">Planning</text>
          <text x="910" y="105" text-anchor="middle" font-size="8" fill="#777" id="svg-mrp-dem">Demand: --/day</text>

          <rect x="996" y="38" width="112" height="48" fill="white" stroke="#333" stroke-width="1.5" rx="2"/>
          <text x="1052" y="60" text-anchor="middle" font-size="10" font-weight="bold" fill="#222">ORDER ENTRY</text>
          <text x="1052" y="75" text-anchor="middle" font-size="8" fill="#666">Customer orders</text>

          <rect x="1148" y="34" width="96" height="60" fill="#d4ecec" stroke="#7f8c8d" stroke-width="2" rx="2"/>
          <path d="M1162 78 L1162 57 L1170 63 L1170 52 L1178 58 L1178 52 L1186 58 L1186 78 Z" fill="#7f8c8d" opacity="0.65"/>
          <text x="1196" y="56" text-anchor="middle" font-size="11" font-weight="bold" fill="#234040">CUSTOMER</text>
          <text x="1196" y="70" text-anchor="middle" font-size="9" fill="#234040" id="svg-cust-dem">1000/day</text>
          <text x="1196" y="83" text-anchor="middle" font-size="9" fill="#234040" id="svg-cust-takt">Takt: 28.8s</text>

          {{-- PROVEEDORES --}}
          <rect x="158" y="40" width="88" height="56" fill="#ccffcc" stroke="#009900" stroke-width="2" rx="2"/>
          <path d="M172 84 L172 63 L181 70 L181 57 L190 64 L190 57 L199 64 L199 84 Z" fill="#009900" opacity="0.65"/>
          <text x="202" y="60" text-anchor="middle" font-size="11" font-weight="bold" fill="#004d00">WABCO</text>
          <text x="202" y="74" text-anchor="middle" font-size="8" fill="#004d00">Daily delivery</text>

          <rect x="268" y="40" width="88" height="56" fill="#ffe0cc" stroke="#e67e22" stroke-width="2" rx="2"/>
          <path d="M282 84 L282 63 L291 70 L291 57 L300 64 L300 57 L309 64 L309 84 Z" fill="#e67e22" opacity="0.65"/>
          <text x="312" y="60" text-anchor="middle" font-size="11" font-weight="bold" fill="#7a3000">Multiple</text>
          <text x="312" y="74" text-anchor="middle" font-size="8" fill="#7a3000">Weekly</text>

          <rect x="378" y="40" width="88" height="56" fill="#f0e0ff" stroke="#9b59b6" stroke-width="2" rx="2"/>
          <path d="M392 84 L392 63 L401 70 L401 57 L410 64 L410 57 L419 64 L419 84 Z" fill="#9b59b6" opacity="0.65"/>
          <text x="422" y="60" text-anchor="middle" font-size="11" font-weight="bold" fill="#4a1070">Multiple</text>
          <text x="422" y="74" text-anchor="middle" font-size="8" fill="#4a1070">Weekly</text>

          <rect x="172" y="104" width="44" height="20" fill="#ccffcc" stroke="#009900" stroke-width="1" rx="2"/>
          <circle cx="180" cy="126" r="4" fill="#333"/><circle cx="207" cy="126" r="4" fill="#333"/>
          <rect x="282" y="104" width="44" height="20" fill="#ffe0cc" stroke="#e67e22" stroke-width="1" rx="2"/>
          <circle cx="290" cy="126" r="4" fill="#333"/><circle cx="317" cy="126" r="4" fill="#333"/>
          <rect x="392" y="104" width="44" height="20" fill="#f0e0ff" stroke="#9b59b6" stroke-width="1" rx="2"/>
          <circle cx="400" cy="126" r="4" fill="#333"/><circle cx="427" cy="126" r="4" fill="#333"/>

          {{-- WAREHOUSE --}}
          <rect x="148" y="148" width="325" height="405" fill="none" stroke="#888" stroke-dasharray="8,4" stroke-width="1.5" rx="4"/>
          <text x="310" y="168" text-anchor="middle" font-size="12" font-weight="bold" fill="#555">WAREHOUSE</text>

          <text x="408" y="193" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">SS  LOOM PM</text>
          <polygon points="398,203 418,203 408,191" fill="none" stroke="#333" stroke-width="1"/>
          <rect x="383" y="206" width="50" height="11" fill="#f2f2f2" stroke="#999" stroke-width="0.5"/>
          <rect x="383" y="217" width="50" height="11" fill="#f2f2f2" stroke="#999" stroke-width="0.5"/>
          <rect x="383" y="228" width="50" height="11" fill="#f2f2f2" stroke="#999" stroke-width="0.5"/>
          <rect x="383" y="239" width="50" height="11" fill="#f2f2f2" stroke="#999" stroke-width="0.5"/>
          <text x="408" y="262" text-anchor="middle" font-size="9" fill="#333" id="svg-loom-pm">-- pz</text>

          <text x="274" y="396" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">SS</text>
          <polygon points="263,407 285,407 274,394" fill="none" stroke="#333" stroke-width="1"/>
          <rect x="234" y="410" width="80" height="12" fill="#f2f2f2" stroke="#888" stroke-width="0.5"/>
          <rect x="234" y="422" width="80" height="12" fill="#f2f2f2" stroke="#888" stroke-width="0.5"/>
          <rect x="234" y="434" width="80" height="12" fill="#f2f2f2" stroke="#888" stroke-width="0.5"/>
          <rect x="234" y="446" width="80" height="12" fill="#f2f2f2" stroke="#888" stroke-width="0.5"/>
          <rect x="234" y="458" width="80" height="12" fill="#f2f2f2" stroke="#888" stroke-width="0.5"/>
          <text x="274" y="482" text-anchor="middle" font-size="9" fill="#222" id="svg-wh-inv">-- pz</text>
          <text x="274" y="494" text-anchor="middle" font-size="8" fill="#888">WH Inventory</text>

          <text x="210" y="513" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">SS  WIRE PM</text>
          <polygon points="200,522 220,522 210,511" fill="none" stroke="#333" stroke-width="1"/>
          <rect x="183" y="525" width="54" height="11" fill="#f2f2f2" stroke="#999" stroke-width="0.5"/>
          <rect x="183" y="536" width="54" height="11" fill="#f2f2f2" stroke="#999" stroke-width="0.5"/>
          <rect x="183" y="547" width="54" height="11" fill="#f2f2f2" stroke="#999" stroke-width="0.5"/>
          <text x="210" y="570" text-anchor="middle" font-size="9" fill="#222" id="svg-wire-pm">-- pz</text>

          {{-- MPS --}}
          <rect x="868" y="150" width="133" height="110" fill="white" stroke="#333" stroke-width="1.5" rx="2"/>
          <text x="934" y="188" text-anchor="middle" font-size="24" font-weight="bold" fill="#111">MPS</text>
          <line x1="868" y1="196" x2="1001" y2="196" stroke="#ccc" stroke-width="0.5"/>
          <text x="934" y="213" text-anchor="middle" font-size="9" fill="#555">Master Production Schedule</text>
          <text x="934" y="227" text-anchor="middle" font-size="9" fill="#555" id="svg-mps-takt">Takt: --s</text>
          <text x="934" y="241" text-anchor="middle" font-size="9" fill="#555" id="svg-mps-dem">Demand: --/day</text>
          <text x="934" y="255" text-anchor="middle" font-size="10" letter-spacing="3" fill="#333">X O X O</text>

          <rect x="758" y="202" width="104" height="60" fill="white" stroke="#666" stroke-width="1" rx="2"/>
          <text x="810" y="222" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">Scanned Inventory</text>
          <text x="810" y="235" text-anchor="middle" font-size="8" fill="#666">Transfer</text>
          <text x="810" y="250" text-anchor="middle" font-size="7" fill="#999">System sync</text>

          <rect x="1006" y="284" width="112" height="60" fill="white" stroke="#666" stroke-width="1" rx="2"/>
          <text x="1062" y="304" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">Scanned Inventory</text>
          <text x="1062" y="317" text-anchor="middle" font-size="8" fill="#666">Transfer</text>
          <text x="1062" y="332" text-anchor="middle" font-size="7" fill="#999">System sync</text>

          <rect x="806" y="320" width="165" height="120" fill="white" stroke="#333" stroke-width="2" rx="2"/>
          <text x="888" y="352" text-anchor="middle" font-size="17" font-weight="bold" fill="#111">Production</text>
          <text x="888" y="374" text-anchor="middle" font-size="17" font-weight="bold" fill="#111">Schedule</text>
          <line x1="806" y1="382" x2="971" y2="382" stroke="#ccc" stroke-width="0.5"/>
          <text x="888" y="399" text-anchor="middle" font-size="9" fill="#666">1 Day rolling window</text>
          <text x="888" y="414" text-anchor="middle" font-size="9" fill="#555" id="svg-ps-dem">Demand: --/day</text>
          <text x="888" y="430" text-anchor="middle" font-size="8" fill="#aaa">Supplier kanban trigger</text>

          <rect x="526" y="438" width="156" height="28" fill="white" stroke="#333" stroke-width="1.5" rx="6"/>
          <text x="604" y="456" text-anchor="middle" font-size="11" font-weight="bold" fill="#222">1 Day in advance</text>

          {{-- SUB ASSEMBLY --}}
          <rect x="432" y="488" width="372" height="200" fill="none" stroke="#888" stroke-dasharray="8,4" stroke-width="1.5" rx="4"/>
          <text x="618" y="507" text-anchor="middle" font-size="12" font-weight="bold" fill="#555">SUB ASSEMBLY</text>

          <text x="516" y="682" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">Terms Lineside PM</text>
          <rect x="446" y="685" width="22" height="14" fill="white" stroke="#555" stroke-width="0.5"/><text x="457" y="695" text-anchor="middle" font-size="7" fill="#333">T1</text>
          <rect x="470" y="685" width="22" height="14" fill="white" stroke="#555" stroke-width="0.5"/><text x="481" y="695" text-anchor="middle" font-size="7" fill="#333">T2</text>
          <rect x="494" y="685" width="22" height="14" fill="white" stroke="#555" stroke-width="0.5"/><text x="505" y="695" text-anchor="middle" font-size="7" fill="#333">T3</text>
          <rect x="518" y="685" width="22" height="14" fill="white" stroke="#555" stroke-width="0.5"/><text x="529" y="695" text-anchor="middle" font-size="7" fill="#333">T4</text>
          <rect x="542" y="685" width="22" height="14" fill="white" stroke="#555" stroke-width="0.5"/><text x="553" y="695" text-anchor="middle" font-size="7" fill="#333">T5</text>
          <rect x="566" y="685" width="22" height="14" fill="white" stroke="#555" stroke-width="0.5"/><text x="577" y="695" text-anchor="middle" font-size="7" fill="#333">T6</text>

          <rect id="box-act" x="440" y="520" width="170" height="100" fill="#e8f5e9" stroke="#4caf50" stroke-width="2" rx="2"/>
          <text x="525" y="538" text-anchor="middle" font-size="10" font-weight="bold" fill="#222">Auto Cut/Terms</text>
          <line x1="440" y1="543" x2="610" y2="543" stroke="#ccc" stroke-width="0.5"/>
          <text x="448" y="557" font-size="9" fill="#333">C/T: <tspan id="sv-act-ct" font-weight="bold">--</tspan> s</text>
          <text x="448" y="571" font-size="9" fill="#333">WIP: <tspan id="sv-act-wip" font-weight="bold">--</tspan> pz</text>
          <text x="448" y="585" font-size="9" fill="#333">C/O: <tspan id="sv-act-co" font-weight="bold">--</tspan></text>
          <text x="448" y="599" font-size="9" fill="#333">Uptime: <tspan id="sv-act-up" font-weight="bold">--</tspan>%</text>
          <rect x="620" y="525" width="56" height="10" fill="#ddd" stroke="#bbb" stroke-width="0.5" rx="1"/>
          <rect x="620" y="539" width="56" height="10" fill="#ddd" stroke="#bbb" stroke-width="0.5" rx="1"/>
          <rect x="620" y="553" width="56" height="10" fill="#ddd" stroke="#bbb" stroke-width="0.5" rx="1"/>

          <rect id="box-shr" x="612" y="520" width="143" height="100" fill="#e8f5e9" stroke="#4caf50" stroke-width="2" rx="2"/>
          <text x="683" y="538" text-anchor="middle" font-size="10" font-weight="bold" fill="#222">Shrink</text>
          <line x1="612" y1="543" x2="755" y2="543" stroke="#ccc" stroke-width="0.5"/>
          <text x="620" y="557" font-size="9" fill="#333">C/T: <tspan id="sv-shr-ct" font-weight="bold">--</tspan> s</text>
          <text x="620" y="571" font-size="9" fill="#333">WIP: <tspan id="sv-shr-wip" font-weight="bold">--</tspan> pz</text>
          <text x="620" y="585" font-size="9" fill="#333">C/O: <tspan id="sv-shr-co" font-weight="bold">--</tspan></text>
          <text x="620" y="599" font-size="9" fill="#333">Uptime: <tspan id="sv-shr-up" font-weight="bold">--</tspan>%</text>

          <rect x="612" y="630" width="143" height="36" fill="#fffde7" stroke="#f9a825" stroke-width="1" rx="2"/>
          <text x="683" y="645" text-anchor="middle" font-size="8" font-weight="bold" fill="#6d4c00">SHRINK Consumables</text>
          <text x="683" y="657" text-anchor="middle" font-size="7" fill="#888">SX38-32</text>

          <text x="796" y="501" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">Cut/Terms SUB WIP PM</text>
          <g id="svg-kanban-sub"></g>
          <polygon points="826,486 841,486 833,499 843,499 830,515 837,501 827,501" fill="#ff9800" stroke="#e65100" stroke-width="0.5"/>
          <text x="848" y="498" font-size="7" fill="#b45309" font-weight="bold">Signal Kanban</text>
          <rect x="754" y="489" width="14" height="10" fill="white" stroke="#333" stroke-width="0.5"/>
          <text x="761" y="498" text-anchor="middle" font-size="7" fill="#333" font-weight="bold">W</text>
          <rect x="1023" y="489" width="14" height="10" fill="white" stroke="#333" stroke-width="0.5"/>
          <text x="1030" y="498" text-anchor="middle" font-size="7" fill="#333" font-weight="bold">W</text>

          {{-- FINAL ASSEMBLY --}}
          <rect x="826" y="488" width="356" height="192" fill="none" stroke="#888" stroke-dasharray="8,4" stroke-width="1.5" rx="4"/>
          <text x="1004" y="507" text-anchor="middle" font-size="12" font-weight="bold" fill="#555">FINAL ASSEMBLY</text>

          <text x="884" y="516" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">Component KIT PM</text>
          <g id="svg-kanban-kit"></g>
          <text x="1058" y="516" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">Loom Lineside PM</text>
          <g id="svg-kanban-loom"></g>

          <rect id="box-asm" x="838" y="522" width="160" height="112" fill="#e8f5e9" stroke="#4caf50" stroke-width="2" rx="2"/>
          <text x="918" y="540" text-anchor="middle" font-size="10" font-weight="bold" fill="#222">Assembly &amp; Test</text>
          <line x1="838" y1="545" x2="998" y2="545" stroke="#ccc" stroke-width="0.5"/>
          <text x="846" y="559" font-size="9" fill="#333">C/T: <tspan id="sv-asm-ct" font-weight="bold">--</tspan> s</text>
          <text x="846" y="573" font-size="9" fill="#333">WIP: <tspan id="sv-asm-wip" font-weight="bold">--</tspan> pz</text>
          <text x="846" y="587" font-size="9" fill="#333">C/O: <tspan id="sv-asm-co" font-weight="bold">--</tspan></text>
          <text x="846" y="601" font-size="9" fill="#333">Uptime: <tspan id="sv-asm-up" font-weight="bold">--</tspan>%</text>
          <text x="918" y="628" text-anchor="middle" font-size="9" letter-spacing="3" fill="#777">X O X O</text>

          <rect id="box-lp" x="1006" y="522" width="160" height="112" fill="#e8f5e9" stroke="#4caf50" stroke-width="2" rx="2"/>
          <text x="1086" y="540" text-anchor="middle" font-size="10" font-weight="bold" fill="#222">Looming &amp; Pack</text>
          <line x1="1006" y1="545" x2="1166" y2="545" stroke="#ccc" stroke-width="0.5"/>
          <text x="1014" y="559" font-size="9" fill="#333">C/T: <tspan id="sv-lp-ct" font-weight="bold">--</tspan> s</text>
          <text x="1014" y="573" font-size="9" fill="#333">WIP: <tspan id="sv-lp-wip" font-weight="bold">--</tspan> pz</text>
          <text x="1014" y="587" font-size="9" fill="#333">C/O: <tspan id="sv-lp-co" font-weight="bold">--</tspan></text>
          <text x="1014" y="601" font-size="9" fill="#333">Uptime: <tspan id="sv-lp-up" font-weight="bold">--</tspan>%</text>

          <rect x="838" y="644" width="160" height="38" fill="#fffde7" stroke="#f9a825" stroke-width="1" rx="2"/>
          <text x="918" y="659" text-anchor="middle" font-size="8" font-weight="bold" fill="#6d4c00">ASSY Consumables</text>
          <text x="918" y="670" text-anchor="middle" font-size="7" fill="#888">LW-20  LW-22  Tape-21  Tape-25</text>

          {{-- SHIPPING --}}
          <rect x="1174" y="488" width="122" height="175" fill="white" stroke="#333" stroke-width="1.5" rx="2"/>
          <text x="1235" y="508" text-anchor="middle" font-size="10" font-weight="bold" fill="#222">MIN/MAX</text>
          <text x="1193" y="520" font-size="8" fill="#888">SS</text>
          <text x="1235" y="532" text-anchor="middle" font-size="8" fill="#777">FG Market</text>
          <g id="svg-fg-slots"></g>
          <text x="1235" y="658" text-anchor="middle" font-size="10" font-weight="bold" fill="#333">SHIPPING</text>

          <rect x="1194" y="112" width="52" height="24" fill="white" stroke="#333" stroke-width="1" rx="2"/>
          <text x="1220" y="127" text-anchor="middle" font-size="9" font-weight="bold" fill="#333">LTL</text>
          <path d="M1220 136 L1220 158 L1195 158 L1195 200" stroke="#666" stroke-width="1.5" fill="none" marker-end="url(#arr)"/>
          <rect x="1178" y="200" width="42" height="20" fill="#d4ecec" stroke="#7f8c8d" stroke-width="1" rx="2"/>
          <circle cx="1186" cy="222" r="4" fill="#333"/><circle cx="1212" cy="222" r="4" fill="#333"/>

          <rect x="1086" y="148" width="102" height="30" fill="white" stroke="#bbb" stroke-width="0.5" rx="2"/>
          <text x="1137" y="162" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">INVOICE</text>
          <text x="1137" y="173" text-anchor="middle" font-size="7" fill="#888">Transactions in shipping</text>
          <rect x="1176" y="188" width="112" height="42" fill="white" stroke="#bbb" stroke-width="0.5" rx="2"/>
          <text x="1232" y="204" text-anchor="middle" font-size="8" font-weight="bold" fill="#333">SHIP REPORT</text>
          <text x="1232" y="216" text-anchor="middle" font-size="7" fill="#888">Due dates 7 days</text>
          <text x="1232" y="226" text-anchor="middle" font-size="7" fill="#888">in advance</text>

          {{-- FLUJOS MATERIAL --}}
          <path d="M202 148 L202 200 L263 200 L263 408" stroke="#009900" stroke-width="2.5" fill="none" marker-end="url(#arr)"/>
          <path d="M312 148 L312 186 L408 186 L408 206" stroke="#e67e22" stroke-width="2.5" fill="none" marker-end="url(#arr)"/>
          <path d="M422 148 L422 186 L210 186 L210 522" stroke="#9b59b6" stroke-width="2" fill="none" marker-end="url(#arr)"/>
          <path d="M310 510 L834 510" stroke="#a0522d" stroke-width="3" fill="none" marker-end="url(#arr)"/>
          <text x="578" y="500" text-anchor="middle" font-size="9" fill="#8B4513" font-weight="bold">ASSY KIT</text>
          <path d="M312 474 L436 535" stroke="#666" stroke-width="1.5" fill="none" stroke-dasharray="4,3" marker-end="url(#arr)"/>
          <rect x="756" y="553" width="46" height="10" fill="#ddd" stroke="#bbb" stroke-width="0.5" rx="1"/>
          <rect x="756" y="566" width="46" height="10" fill="#ddd" stroke="#bbb" stroke-width="0.5" rx="1"/>
          <rect x="756" y="579" width="46" height="10" fill="#ddd" stroke="#bbb" stroke-width="0.5" rx="1"/>
          <path d="M1166 578 L1172 578" stroke="#333" stroke-width="2" fill="none" marker-end="url(#arr)"/>

          {{-- FLUJOS INFORMACIÓN --}}
          <path d="M1148 55 L1110 60" stroke="red" stroke-width="1.5" fill="none" marker-end="url(#arr)"/>
          <path d="M996 58 L957 58" stroke="red" stroke-width="1.5" fill="none" marker-end="url(#arr)"/>
          <path d="M865 68 L747 68" stroke="red" stroke-width="1.5" fill="none" marker-end="url(#arr)"/>
          <path d="M620 60 L592 56" stroke="red" stroke-width="1.5" fill="none" marker-end="url(#arr)"/>
          <path d="M620 72 L592 88" stroke="red" stroke-width="1.5" fill="none" marker-end="url(#arr)"/>
          <path d="M910 112 L930 150" stroke="red" stroke-width="1.5" fill="none" marker-end="url(#arr)"/>
          <path d="M870 200 L808 320" stroke="red" stroke-width="1" fill="none" marker-end="url(#arr)"/>
          <path d="M878 260 L852 520" stroke="red" stroke-width="1" fill="none" marker-end="url(#arr)"/>
          <path d="M934 260 L934 520" stroke="red" stroke-width="1" fill="none" marker-end="url(#arr)"/>
          <path d="M978 260 L1078 520" stroke="red" stroke-width="1" fill="none" marker-end="url(#arr)"/>
          <path d="M994 245 L1186 488" stroke="red" stroke-width="1" fill="none" marker-end="url(#arr)"/>
          <path d="M806 408 L684 442" stroke="red" stroke-width="1" fill="none" marker-end="url(#arr)"/>
          <path d="M818 438 L684 456" stroke="red" stroke-width="1" fill="none" marker-end="url(#arr)"/>
          <path d="M868 228 L764 228" stroke="red" stroke-width="1" fill="none" marker-end="url(#arr)"/>

          {{-- TIMELINE --}}
          <g id="svg-timeline"></g>
        </svg>
      </div>
    </div>

    {{-- ══ SIDEBAR ══ --}}
    <div class="vsm-sidebar">

      {{-- Actualizar --}}
      <div class="acc" style="background:#fff">
        <div style="padding:9px 11px">
          <button class="btn-primary" style="width:100%" onclick="cargarDesdeLaravel()">↻ Actualizar desde BD</button>
          <div class="status-row">
            <span class="status-dot" id="status-dot"></span>
            <span id="status-txt">Datos cargados</span>
          </div>
        </div>
      </div>

      {{-- Procesos --}}
      <div class="acc">
        <div class="acc-hdr" onclick="toggleAcc(this)">Métricas de proceso <span class="acc-arr open">▲</span></div>
        <div class="acc-body open">
          <div class="proc-card">
            <h4><span class="dot" style="background:#4caf50"></span>Auto Cut/Terms</h4>
            <div class="g2">
              <div class="field-wrap"><label>Cycle Time (s)</label><input type="number" id="f-act-ct" value="45" min="1" oninput="updateAll()"></div>
              <div class="field-wrap"><label>WIP (pz)</label><input type="number" id="f-act-wip" value="3000" min="0" oninput="updateAll()"></div>
              <div class="field-wrap"><label>C/O</label><input type="text" id="f-act-co" value="10min" oninput="updateAll()"></div>
              <div class="field-wrap"><label>Uptime (%)</label><input type="number" id="f-act-up" value="95" min="0" max="100" oninput="updateAll()"></div>
            </div>
          </div>
          <div class="proc-card">
            <h4><span class="dot" style="background:#66bb6a"></span>Shrink</h4>
            <div class="g2">
              <div class="field-wrap"><label>Cycle Time (s)</label><input type="number" id="f-shr-ct" value="30" min="1" oninput="updateAll()"></div>
              <div class="field-wrap"><label>WIP (pz)</label><input type="number" id="f-shr-wip" value="1500" min="0" oninput="updateAll()"></div>
              <div class="field-wrap"><label>C/O</label><input type="text" id="f-shr-co" value="5min" oninput="updateAll()"></div>
              <div class="field-wrap"><label>Uptime (%)</label><input type="number" id="f-shr-up" value="98" min="0" max="100" oninput="updateAll()"></div>
            </div>
          </div>
          <div class="proc-card">
            <h4><span class="dot" style="background:#2196f3"></span>Assembly &amp; Test</h4>
            <div class="g2">
              <div class="field-wrap"><label>Cycle Time (s)</label><input type="number" id="f-asm-ct" value="120" min="1" oninput="updateAll()"></div>
              <div class="field-wrap"><label>WIP (pz)</label><input type="number" id="f-asm-wip" value="500" min="0" oninput="updateAll()"></div>
              <div class="field-wrap"><label>C/O</label><input type="text" id="f-asm-co" value="15min" oninput="updateAll()"></div>
              <div class="field-wrap"><label>Uptime (%)</label><input type="number" id="f-asm-up" value="92" min="0" max="100" oninput="updateAll()"></div>
            </div>
          </div>
          <div class="proc-card">
            <h4><span class="dot" style="background:#9c27b0"></span>Looming &amp; Pack</h4>
            <div class="g2">
              <div class="field-wrap"><label>Cycle Time (s)</label><input type="number" id="f-lp-ct" value="60" min="1" oninput="updateAll()"></div>
              <div class="field-wrap"><label>WIP (pz)</label><input type="number" id="f-lp-wip" value="300" min="0" oninput="updateAll()"></div>
              <div class="field-wrap"><label>C/O</label><input type="text" id="f-lp-co" value="8min" oninput="updateAll()"></div>
              <div class="field-wrap"><label>Uptime (%)</label><input type="number" id="f-lp-up" value="95" min="0" max="100" oninput="updateAll()"></div>
            </div>
          </div>
        </div>
      </div>

      {{-- Inventarios --}}
      <div class="acc">
        <div class="acc-hdr" onclick="toggleAcc(this)">Inventarios &amp; Cliente <span class="acc-arr open">▲</span></div>
        <div class="acc-body open">
          <div class="g2">
            <div class="field-wrap"><label>WH Inventory (pz)</label><input type="number" id="f-wh" value="25000" min="0" oninput="updateAll()"></div>
            <div class="field-wrap"><label>Loom PM (pz)</label><input type="number" id="f-lpm" value="8000" min="0" oninput="updateAll()"></div>
            <div class="field-wrap"><label>Wire PM (pz)</label><input type="number" id="f-wpm" value="15000" min="0" oninput="updateAll()"></div>
            <div class="field-wrap"><label>Demanda diaria</label><input type="number" id="f-dem" value="1000" min="1" oninput="updateAll()"></div>
            <div class="field-wrap"><label>Takt Time (s)</label><input type="number" id="f-takt" value="28.8" step="0.1" oninput="updateAll()"></div>
          </div>
        </div>
      </div>

      {{-- Kanban --}}
      <div class="acc">
        <div class="acc-hdr" onclick="toggleAcc(this)">Slots Kanban <span class="acc-arr open">▲</span></div>
        <div class="acc-body open">
          <div class="g3">
            <div class="field-wrap"><label>WIP Sub (máx 10)</label><input type="number" id="f-ksub" value="7" min="0" max="10" oninput="updateAll()"></div>
            <div class="field-wrap"><label>KIT (máx 6)</label><input type="number" id="f-kkit" value="4" min="0" max="6" oninput="updateAll()"></div>
            <div class="field-wrap"><label>Loom (máx 6)</label><input type="number" id="f-kloom" value="5" min="0" max="6" oninput="updateAll()"></div>
          </div>
        </div>
      </div>

      {{-- FG Market --}}
      <div class="acc">
        <div class="acc-hdr" onclick="toggleAcc(this)">FG Market — Shipping <span class="acc-arr open">▲</span></div>
        <div class="acc-body open">
          <div class="g2">
            <div class="field-wrap"><label>FG1</label><input type="number" id="fg-0" value="200" min="0" oninput="updateAll()"></div>
            <div class="field-wrap"><label>FG2</label><input type="number" id="fg-1" value="150" min="0" oninput="updateAll()"></div>
            <div class="field-wrap"><label>FG3</label><input type="number" id="fg-2" value="300" min="0" oninput="updateAll()"></div>
            <div class="field-wrap"><label>FG4</label><input type="number" id="fg-3" value="250" min="0" oninput="updateAll()"></div>
            <div class="field-wrap"><label>FG5</label><input type="number" id="fg-4" value="180" min="0" oninput="updateAll()"></div>
            <div class="field-wrap"><label>FG6</label><input type="number" id="fg-5" value="220" min="0" oninput="updateAll()"></div>
          </div>
        </div>
      </div>

      {{-- Lead Time --}}
      <div class="acc">
        <div class="acc-hdr" onclick="toggleAcc(this)">Lead Time — días por paso <span class="acc-arr open">▲</span></div>
        <div class="acc-body open">
          <div class="g2">
            <div class="tl-mini trigger"><div class="lbl">Customer Order</div><input type="number" id="tl-0" value="1" min="0" step="0.5" oninput="updateAll()"></div>
            <div class="tl-mini nva">   <div class="lbl">Planning</div>      <input type="number" id="tl-1" value="1" min="0" step="0.5" oninput="updateAll()"></div>
            <div class="tl-mini va">    <div class="lbl">Cutting</div>       <input type="number" id="tl-2" value="1" min="0" step="0.5" oninput="updateAll()"></div>
            <div class="tl-mini va">    <div class="lbl">Terminals</div>     <input type="number" id="tl-3" value="1" min="0" step="0.5" oninput="updateAll()"></div>
            <div class="tl-mini va">    <div class="lbl">Sub-Assembly</div>  <input type="number" id="tl-4" value="1" min="0" step="0.5" oninput="updateAll()"></div>
            <div class="tl-mini va">    <div class="lbl">Assembly</div>      <input type="number" id="tl-5" value="1" min="0" step="0.5" oninput="updateAll()"></div>
            <div class="tl-mini va">    <div class="lbl">Looming</div>       <input type="number" id="tl-6" value="1" min="0" step="0.5" oninput="updateAll()"></div>
            <div class="tl-mini va">    <div class="lbl">Testing</div>       <input type="number" id="tl-7" value="1" min="0" step="0.5" oninput="updateAll()"></div>
            <div class="tl-mini va">    <div class="lbl">Packing</div>       <input type="number" id="tl-8" value="1" min="0" step="0.5" oninput="updateAll()"></div>
            <div class="tl-mini nva">   <div class="lbl">Shipping</div>      <input type="number" id="tl-9" value="1" min="0" step="0.5" oninput="updateAll()"></div>
          </div>
        </div>
      </div>

    </div>{{-- /sidebar --}}
  </div>{{-- /body --}}
</div>{{-- /root --}}

<script>
const STEPS     = ["Customer Order","Planning","Cutting","Terminals","Sub-Assembly","Assembly","Looming","Testing","Packing","Shipping"];
const STEP_TYPE = ["trigger","nva","va","va","va","va","va","va","va","nva"];
const STEP_FILL = {trigger:"#dbeafe",va:"#dcfce7",nva:"#fef9c3"};
const STEP_STR  = {trigger:"#3b82f6",va:"#22c55e",nva:"#eab308"};
const FG_LBL    = ["FG1","FG2","FG3","FG4","FG5","FG6"];
const NS        = "http://www.w3.org/2000/svg";

const $   = id => document.getElementById(id);
const tv  = id => { const e=$(id); return e?.type==="number"?(parseFloat(e.value)||0):e?.value||""; };
const st  = (id,v) => { const e=$(id); if(e) e.textContent=v; };
const mk  = (t,a) => { const e=document.createElementNS(NS,t); Object.entries(a).forEach(([k,v])=>e.setAttribute(k,v)); return e; };
const mkt = (t,a) => { const e=mk("text",a); e.textContent=t; return e; };

const uFill   = u => u>=95?"#e8f5e9":u>=85?"#fff8e1":"#ffebee";
const uStroke = u => u>=95?"#4caf50":u>=85?"#ff9800":"#f44336";

/* ── Acordeón ── */
function toggleAcc(h) {
  const b=h.nextElementSibling, a=h.querySelector('.acc-arr');
  const o=b.classList.toggle('open');
  a.classList.toggle('open',o);
}

/* ── Zoom ── */
let zl=1;
function applyZoom(){ const s=$('vsm-svg'); if(s) s.style.transform=`scale(${zl})`; $('zoom-lbl').textContent=Math.round(zl*100)+'%'; }
function zoomVSM(d){ zl=Math.min(2,Math.max(0.25,zl+d)); applyZoom(); }
function zoomFit(){
  const w=$('canvas-wrap'), s=$('vsm-svg');
  if(!w||!s) return;
  const sx=w.clientWidth/1280, sy=w.clientHeight/710;
  zl=Math.min(sx,sy)*0.97;
  applyZoom();
}

/* ── Kanban ── */
function drawKanban(gid,labels,active,colorOn,x,y){
  const g=$(gid); if(!g) return; g.innerHTML="";
  labels.forEach((l,i)=>{
    const on=i<active;
    g.appendChild(mk("rect",{x,y:y+i*16,width:28,height:13,fill:on?colorOn:"white",stroke:"#555","stroke-width":"0.5"}));
    g.appendChild(mkt(l,{x:x+14,y:y+6.5+i*16,"text-anchor":"middle","font-size":"7","dominant-baseline":"central",fill:on?"white":"#333"}));
  });
}

/* ── Timeline ── */
function drawTimeline(){
  const g=$("svg-timeline"); if(!g) return; g.innerHTML="";
  const W=100,GAP=16,sx=22,y=658;
  STEPS.forEach((name,i)=>{
    const x=sx+i*(W+GAP),type=STEP_TYPE[i],days=parseFloat($("tl-"+i)?.value)||0;
    g.appendChild(mk("rect",{x,y,width:W,height:44,fill:STEP_FILL[type],stroke:STEP_STR[type],"stroke-width":"1.5",rx:"4"}));
    g.appendChild(mkt(name,{x:x+W/2,y:y+14,"text-anchor":"middle","font-size":"8","font-weight":"bold",fill:"#1a2533","dominant-baseline":"central"}));
    g.appendChild(mkt(type==="trigger"?"Trigger":`${days} día${days!==1?"s":""}`,{x:x+W/2,y:y+32,"text-anchor":"middle","font-size":"8",fill:"#555","dominant-baseline":"central"}));
    if(i<STEPS.length-1) g.appendChild(mk("path",{d:`M${x+W} ${y+22} L${x+W+GAP} ${y+22}`,stroke:"#666","stroke-width":"1.5",fill:"none","marker-end":"url(#arr)"}));
  });
}

/* ── FG Slots ── */
function drawFGSlots(){
  const g=$("svg-fg-slots"); if(!g) return; g.innerHTML="";
  FG_LBL.forEach((l,i)=>{
    const v=parseInt($("fg-"+i)?.value)||0;
    const pct=Math.min(1,Math.max(0,(v-50)/550));
    const fill=pct>0.7?"#bbf7d0":pct>0.3?"#fef08a":"#fecaca";
    g.appendChild(mk("rect",{x:1185,y:536+i*18,width:92,height:15,fill,stroke:"#aaa","stroke-width":"0.5"}));
    g.appendChild(mkt(l,{x:1192,y:544+i*18,"font-size":"8",fill:"#333","dominant-baseline":"central"}));
    g.appendChild(mkt(v,{x:1272,y:544+i*18,"text-anchor":"end","font-size":"8",fill:"#333","dominant-baseline":"central"}));
  });
}

/* ── updateAll ── */
function updateAll(){
  const aC=tv("f-act-ct"),aW=tv("f-act-wip"),aCo=tv("f-act-co"),aU=tv("f-act-up");
  const sC=tv("f-shr-ct"),sW=tv("f-shr-wip"),sCo=tv("f-shr-co"),sU=tv("f-shr-up");
  const mC=tv("f-asm-ct"),mW=tv("f-asm-wip"),mCo=tv("f-asm-co"),mU=tv("f-asm-up");
  const lC=tv("f-lp-ct"), lW=tv("f-lp-wip"), lCo=tv("f-lp-co"), lU=tv("f-lp-up");
  const dem=tv("f-dem"),takt=tv("f-takt"),wh=tv("f-wh"),lpm=tv("f-lpm"),wpm=tv("f-wpm");

  st("sv-act-ct",aC); st("sv-act-wip",Number(aW).toLocaleString()); st("sv-act-co",aCo); st("sv-act-up",aU);
  st("sv-shr-ct",sC); st("sv-shr-wip",Number(sW).toLocaleString()); st("sv-shr-co",sCo); st("sv-shr-up",sU);
  st("sv-asm-ct",mC); st("sv-asm-wip",Number(mW).toLocaleString()); st("sv-asm-co",mCo); st("sv-asm-up",mU);
  st("sv-lp-ct", lC); st("sv-lp-wip", Number(lW).toLocaleString()); st("sv-lp-co", lCo); st("sv-lp-up", lU);
  st("svg-wh-inv", Number(wh).toLocaleString()+" pz");
  st("svg-loom-pm",Number(lpm).toLocaleString()+" pz");
  st("svg-wire-pm",Number(wpm).toLocaleString()+" pz");
  st("svg-cust-dem",dem+"/day"); st("svg-cust-takt","Takt: "+takt+"s");
  st("svg-mps-takt","Takt: "+takt+"s"); st("svg-mps-dem","Demand: "+dem+"/day");
  st("svg-ps-dem","Demand: "+dem+"/day"); st("svg-mrp-dem","Demand: "+dem+"/day");

  [["box-act",aU],["box-shr",sU],["box-asm",mU],["box-lp",lU]].forEach(([id,u])=>{
    const e=$(id); if(!e) return;
    e.setAttribute("fill",uFill(u)); e.setAttribute("stroke",uStroke(u));
  });

  drawKanban("svg-kanban-sub",["S1","S2","S3","S4","S5","S6","S7","S8","S9","S10"],tv("f-ksub"),"#4caf50",780,508);
  drawKanban("svg-kanban-kit",["K1","K2","K3","K4","K5","K6"],tv("f-kkit"),"#2196f3",854,520);
  drawKanban("svg-kanban-loom",["L1","L2","L3","L4","L5","L6"],tv("f-kloom"),"#9c27b0",1026,520);
  drawTimeline();
  drawFGSlots();

  const vaT=aC+sC+mC+lC;
  const tDays=STEPS.reduce((s,_,i)=>s+(parseFloat($("tl-"+i)?.value)||0),0);
  const eff=takt>0?Math.round(vaT/takt*100):0;
  st("kpi-lt",tDays.toFixed(1)+" días"); st("kpi-va",vaT+"s");
  st("kpi-takt",takt+"s"); st("kpi-eff",eff+"%");
  const ef=$("kpi-eff"); if(ef) ef.className="val"+(eff>110?" crit":eff>95?" warn":"");
}

/* ── Carga desde Laravel ── */
function cargarDesdeLaravel(){
  const dot=$("status-dot"),txt=$("status-txt");
  if(dot) dot.classList.add("loading");
  if(txt) txt.textContent="Consultando base de datos…";

  /* MOCK — reemplaza con fetch real:
  fetch('/api/vsm/runner-greens', {headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}})
    .then(r=>r.json()).then(aplicarDatos).catch(()=>{if(txt)txt.textContent="Error de conexión";});
  return; */

  const mock = {
    procesos:{
      auto_cut:{ct:45,wip:3000,co:"10min",uptime:95},
      shrink:  {ct:30,wip:1500,co:"5min", uptime:98},
      assembly:{ct:120,wip:500,co:"15min",uptime:92},
      looming: {ct:60,wip:300, co:"8min", uptime:95},
    },
    inventarios:{wh:25000,loom_pm:8000,wire_pm:15000},
    cliente:{demanda:1000,takt:28.8},
    kanban:{sub:7,kit:4,loom:5},
    fg:[200,150,300,250,180,220],
    timeline:[1,1,1,1,1,1,1,1,1,1],
  };
  setTimeout(()=>aplicarDatos(mock), 450);
}

function aplicarDatos(data){
  const p=data.procesos;
  [["f-act-ct",p.auto_cut.ct],["f-act-wip",p.auto_cut.wip],["f-act-co",p.auto_cut.co],["f-act-up",p.auto_cut.uptime],
   ["f-shr-ct",p.shrink.ct],  ["f-shr-wip",p.shrink.wip],  ["f-shr-co",p.shrink.co],  ["f-shr-up",p.shrink.uptime],
   ["f-asm-ct",p.assembly.ct],["f-asm-wip",p.assembly.wip],["f-asm-co",p.assembly.co],["f-asm-up",p.assembly.uptime],
   ["f-lp-ct", p.looming.ct], ["f-lp-wip", p.looming.wip], ["f-lp-co", p.looming.co], ["f-lp-up", p.looming.uptime],
  ].forEach(([id,v])=>{const e=$(id);if(e)e.value=v;});
  const inv=data.inventarios,cli=data.cliente;
  [["f-wh",inv.wh],["f-lpm",inv.loom_pm],["f-wpm",inv.wire_pm],
   ["f-dem",cli.demanda],["f-takt",cli.takt]].forEach(([id,v])=>{const e=$(id);if(e)e.value=v;});
  [["f-ksub",data.kanban.sub],["f-kkit",data.kanban.kit],["f-kloom",data.kanban.loom]]
    .forEach(([id,v])=>{const e=$(id);if(e)e.value=v;});
  data.fg.forEach((v,i)=>{const e=$("fg-"+i);if(e)e.value=v;});
  data.timeline.forEach((v,i)=>{const e=$("tl-"+i);if(e)e.value=v;});
  updateAll();
  const dot=$("status-dot"),txt=$("status-txt");
  if(dot) dot.classList.remove("loading");
  if(txt) txt.textContent="Actualizado — "+new Date().toLocaleTimeString();
}

/* ── Inicio ── */
document.addEventListener('DOMContentLoaded',()=>{
  updateAll();
  setTimeout(zoomFit, 80);
});

/* Auto-refresh (descomentar en producción):
   setInterval(cargarDesdeLaravel, 30000); */
</script>

@endsection