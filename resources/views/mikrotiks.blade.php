<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Mikrotiks Information</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
:root{
  --primary:#6366f1;--primary-dark:#4f46e5;--primary-light:#eef2ff;
  --success:#10b981;--danger:#ef4444;--warning:#f59e0b;--info:#06b6d4;
  --violet:#7c3aed;--amber:#d97706;
  --text:#1e293b;--muted:#64748b;--border:#e2e8f0;--bg:#f1f5f9;--card:#fff;
  --radius:12px;--shadow:0 2px 12px rgba(0,0,0,.07);
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--text);font-size:14px;min-height:100vh}
[x-cloak]{display:none!important}
.page{max-width:1500px;margin:0 auto;padding:24px 20px 60px}

/* header */
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px}
.page-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:9px}
.page-title i{color:#f59e0b}
.btn-add{display:inline-flex;align-items:center;gap:7px;padding:9px 20px;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border:none;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 3px 10px rgba(245,158,11,.35);transition:.18s}
.btn-add:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(245,158,11,.45)}

/* stats */
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}
.kpi{border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:13px;box-shadow:0 3px 10px rgba(0,0,0,.12);position:relative;overflow:hidden}
.kpi-iw{width:42px;height:42px;border-radius:9px;flex-shrink:0;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;font-size:17px;color:rgba(255,255,255,.9)}
.kpi-body{flex:1;min-width:0}
.kpi-lbl{font-size:10px;font-weight:600;color:rgba(255,255,255,.65);text-transform:uppercase;letter-spacing:.5px}
.kpi-val{font-size:26px;font-weight:800;color:#fff;line-height:1;letter-spacing:-.5px}
.kpi-sub{font-size:11px;color:rgba(255,255,255,.5);margin-top:2px}
.kpi-slate{background:linear-gradient(135deg,#475569,#334155)}
.kpi-green{background:linear-gradient(135deg,#10b981,#059669)}
.kpi-red{background:linear-gradient(135deg,#ef4444,#dc2626)}
.kpi-amber{background:linear-gradient(135deg,#f59e0b,#d97706)}

/* card / toolbar */
.card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--border);overflow:hidden}
.toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 18px;border-bottom:1px solid var(--border);flex-wrap:wrap}
.toolbar-left{display:flex;align-items:center;gap:8px}
.show-lbl{font-size:13px;color:var(--muted)}
.show-sel{padding:5px 28px 5px 10px;border:1.5px solid var(--border);border-radius:7px;font-size:13px;color:var(--text);background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 9px center;appearance:none;cursor:pointer;outline:none}
.show-sel:focus{border-color:var(--primary)}
.search-wrap{position:relative}
.search-wrap i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:12px;pointer-events:none}
.search-inp{padding:7px 12px 7px 30px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;width:220px;outline:none;transition:.2s;color:var(--text)}
.search-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1);width:260px}
.search-inp::placeholder{color:#94a3b8}

/* table */
.tbl-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch}
table{width:100%;border-collapse:collapse;white-space:nowrap}
thead th{background:#f8fafc;padding:11px 16px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;border-bottom:2px solid var(--border);text-align:left}
tbody tr{border-bottom:1px solid #f1f5f9;transition:background .12s}
tbody tr:hover{background:#fafbff}
tbody tr:last-child{border-bottom:none}
tbody td{padding:12px 16px;font-size:13px;vertical-align:middle}

/* cells */
.id-cell{font-size:12px;font-weight:700;color:var(--muted)}
.ip-cell{font-family:'SF Mono','Fira Code',monospace;font-size:12px;font-weight:600;color:var(--text);background:#f1f5f9;padding:3px 8px;border-radius:6px;border:1px solid var(--border);display:inline-block}
.name-cell{font-weight:600;color:var(--text);font-size:13px}
.desc-cell{color:var(--muted);font-size:12px;max-width:200px;white-space:normal;line-height:1.35}

/* API status badge */
.api-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;white-space:nowrap}
.api-online{background:#d1fae5;color:#065f46;border:1px solid #a7f3d0}
.api-online::before{content:'';display:inline-block;width:7px;height:7px;border-radius:50%;background:#10b981;animation:pulse 1.5s ease-in-out infinite}
.api-offline{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca}
.api-checking{background:#fef3c7;color:#92400e;border:1px solid #fde68a}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}

/* action buttons */
.act-row{display:flex;align-items:center;gap:5px;flex-wrap:wrap}
.ab{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border:none;border-radius:7px;font-size:11px;font-weight:700;cursor:pointer;transition:.15s;white-space:nowrap}
.ab:hover{filter:brightness(1.12);transform:translateY(-1px)}
.ab-analyze{background:linear-gradient(135deg,#1e3a8a,#1d4ed8);color:#fff;box-shadow:0 2px 6px rgba(29,78,216,.3)}
.ab-secrets{background:linear-gradient(135deg,#6d28d9,#7c3aed);color:#fff;box-shadow:0 2px 6px rgba(124,58,237,.3)}
.ab-connections{background:linear-gradient(135deg,#5b21b6,#4c1d95);color:#fff;box-shadow:0 2px 6px rgba(91,33,182,.3)}
.ab-icon{width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:none;border-radius:7px;cursor:pointer;font-size:13px;transition:.15s}
.ab-icon:hover{filter:brightness(1.15);transform:translateY(-1px)}
.ab-edit{background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;box-shadow:0 2px 6px rgba(22,163,74,.3)}
.ab-net{background:linear-gradient(135deg,#d97706,#b45309);color:#fff;box-shadow:0 2px 6px rgba(217,119,6,.3)}
.ab-del{background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;box-shadow:0 2px 6px rgba(239,68,68,.3)}

/* footer / pagination */
.tbl-footer{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
.tbl-info{font-size:12px;color:var(--muted)}
.tbl-info strong{color:var(--text)}
.pagination{display:flex;gap:4px;align-items:center}
.pg-btn{min-width:32px;height:32px;padding:0 10px;display:flex;align-items:center;justify-content:center;border-radius:8px;border:1.5px solid var(--border);background:#fff;font-size:12px;font-weight:600;cursor:pointer;color:var(--muted);transition:.15s}
.pg-btn:hover{border-color:var(--primary);color:var(--primary)}
.pg-btn.active{background:var(--primary);border-color:var(--primary);color:#fff}
.pg-btn:disabled{opacity:.4;cursor:not-allowed}

/* empty */
.empty-row td{text-align:center;padding:50px;color:var(--muted);font-size:13px}
.empty-row i{font-size:32px;display:block;margin-bottom:10px;opacity:.2}

/* ── overlay / modal shared ── */
.overlay{position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;z-index:500;padding:20px}
.modal{background:#fff;border-radius:16px;width:100%;box-shadow:0 24px 64px rgba(0,0,0,.22);overflow:hidden;display:flex;flex-direction:column;max-height:92vh}
.modal-head{padding:16px 22px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.modal-head h3{font-size:15px;font-weight:700;color:#fff;display:flex;align-items:center;gap:8px}
.modal-close{background:rgba(255,255,255,.2);border:none;color:#fff;width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:.15s;flex-shrink:0}
.modal-close:hover{background:rgba(255,255,255,.35)}
.modal-scroll{overflow-y:auto;flex:1}
.modal-foot{padding:13px 22px;border-top:1px solid var(--border);background:#fafbff;display:flex;justify-content:flex-end;gap:9px;flex-shrink:0}
.btn-cancel{padding:8px 16px;border:1.5px solid var(--border);background:#fff;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);transition:.15s}
.btn-cancel:hover{border-color:var(--muted);color:var(--text)}
.btn-save{padding:8px 22px;background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 3px 10px rgba(245,158,11,.3);transition:.18s}
.btn-save:hover{transform:translateY(-1px)}
.btn-test{padding:8px 16px;background:linear-gradient(135deg,var(--info),#0284c7);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:.18s}
.btn-test:hover{transform:translateY(-1px)}

/* ── add/edit modal ── */
.ae-modal{max-width:580px}
.ae-head{background:linear-gradient(135deg,#f59e0b,#d97706)}
.form-body{padding:22px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-grid .full{grid-column:1/-1}
.ff{display:flex;flex-direction:column;gap:5px}
.ff label{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px}
.ff input,.ff select,.ff textarea{padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;color:var(--text);outline:none;transition:.15s;width:100%;font-family:inherit}
.ff select{appearance:none;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 10px center;padding-right:28px}
.ff input:focus,.ff select:focus,.ff textarea:focus{border-color:#f59e0b;box-shadow:0 0 0 3px rgba(245,158,11,.12)}
.ff .err{font-size:11px;color:var(--danger);display:none}
.ff.has-err input{border-color:var(--danger)}
.ff.has-err .err{display:block}
.conn-test-row{display:flex;align-items:center;gap:10px;padding:10px 22px;background:#fafbff;border-top:1px solid var(--border);flex-shrink:0}
.test-result{font-size:12px;font-weight:600;display:flex;align-items:center;gap:5px}
.test-ok{color:var(--success)}
.test-fail{color:var(--danger)}
.test-checking{color:var(--warning)}

/* ── analyze modal ── */
.an-modal{max-width:640px}
.an-head{background:linear-gradient(135deg,#1e3a8a,#1d4ed8)}
.an-body{padding:20px}
.an-section{margin-bottom:18px}
.an-section-title{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.6px;color:var(--muted);margin-bottom:10px;padding-bottom:6px;border-bottom:1px solid var(--border)}
.an-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.an-card{background:#f8fafc;border-radius:9px;padding:12px;border:1px solid var(--border);text-align:center}
.an-card-val{font-size:20px;font-weight:800;color:var(--text);line-height:1}
.an-card-lbl{font-size:11px;color:var(--muted);margin-top:3px;font-weight:500}
.an-card-bar{height:4px;border-radius:4px;margin-top:6px;background:#e2e8f0;overflow:hidden}
.an-card-fill{height:100%;border-radius:4px;transition:width .6s ease}
.iface-list{display:flex;flex-direction:column;gap:6px}
.iface-item{display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:#f8fafc;border-radius:8px;border:1px solid var(--border)}
.iface-name{font-size:12px;font-weight:700;color:var(--text);font-family:'SF Mono',monospace}
.iface-badges{display:flex;gap:5px}
.ib{display:inline-flex;align-items:center;gap:3px;padding:2px 7px;border-radius:5px;font-size:10px;font-weight:700}
.ib-up{background:#d1fae5;color:#065f46}
.ib-down{background:#fee2e2;color:#b91c1c}
.ib-rx{background:#dbeafe;color:#1e40af}
.ib-tx{background:#f3e8ff;color:#6d28d9}

/* ── secrets modal ── */
.sec-modal{max-width:720px}
.sec-head{background:linear-gradient(135deg,#6d28d9,#7c3aed)}
.sec-toolbar{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);background:#fafbff;flex-shrink:0;gap:10px;flex-wrap:wrap}
.sec-search{position:relative}
.sec-search i{position:absolute;left:9px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:11px;pointer-events:none}
.sec-search input{padding:6px 10px 6px 26px;border:1.5px solid var(--border);border-radius:7px;font-size:12px;width:180px;outline:none}
.sec-search input:focus{border-color:#7c3aed}
.sec-count{font-size:12px;color:var(--muted)}
.sec-count strong{color:#7c3aed}
.sec-table-wrap{overflow-x:auto}
.sec-table{width:100%;border-collapse:collapse;white-space:nowrap}
.sec-table thead th{padding:9px 14px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;border-bottom:2px solid var(--border);background:#f8fafc;text-align:left}
.sec-table tbody tr{border-bottom:1px solid #f1f5f9}
.sec-table tbody tr:last-child{border-bottom:none}
.sec-table tbody td{padding:10px 14px;font-size:12px;vertical-align:middle}
.sec-profile{display:inline-flex;padding:2px 8px;border-radius:5px;font-size:11px;font-weight:600;background:var(--primary-light);color:var(--primary)}
.sec-status-on{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:700;color:var(--success)}
.sec-status-off{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:700;color:var(--muted)}

/* ── active connections modal ── */
.conn-modal{max-width:760px}
.conn-head{background:linear-gradient(135deg,#5b21b6,#4c1d95)}
.conn-table{width:100%;border-collapse:collapse;white-space:nowrap}
.conn-table thead th{padding:9px 14px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;border-bottom:2px solid var(--border);background:#f8fafc;text-align:left}
.conn-table tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
.conn-table tbody tr:hover{background:#fafbff}
.conn-table tbody tr:last-child{border-bottom:none}
.conn-table tbody td{padding:10px 14px;font-size:12px;vertical-align:middle}
.uptime-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;background:#fef3c7;color:#92400e;border-radius:5px;font-size:11px;font-weight:700}
.rx-val{color:var(--info);font-weight:600}
.tx-val{color:#8b5cf6;font-weight:600}

/* ── delete confirm ── */
.del-modal{max-width:420px}
.del-head{background:linear-gradient(135deg,var(--danger),#dc2626)}
.del-body{padding:22px;text-align:center}
.del-icon{font-size:40px;color:var(--danger);margin-bottom:10px;opacity:.8}
.del-msg{font-size:14px;color:var(--text);line-height:1.55}
.del-name{display:inline-block;margin-top:6px;padding:3px 10px;background:#fef2f2;border-radius:6px;font-family:'SF Mono','Fira Code',monospace;font-size:13px;font-weight:700;color:var(--danger)}
.btn-danger{padding:8px 20px;background:linear-gradient(135deg,var(--danger),#dc2626);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:.18s;box-shadow:0 3px 10px rgba(239,68,68,.3)}
.btn-danger:hover{transform:translateY(-1px)}

/* toast */
.toast-wrap{position:fixed;bottom:24px;right:24px;z-index:999;pointer-events:none;display:flex;flex-direction:column;gap:8px}
.toast{padding:11px 16px;border-radius:10px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 6px 24px rgba(0,0,0,.18);display:flex;align-items:center;gap:8px;pointer-events:auto}
.toast.success{background:linear-gradient(135deg,#10b981,#059669)}
.toast.info{background:linear-gradient(135deg,var(--info),#0284c7)}
.toast.danger{background:linear-gradient(135deg,var(--danger),#dc2626)}

/* responsive */
@media(max-width:900px){.stats{grid-template-columns:repeat(2,1fr)}}
@media(max-width:600px){
  .stats{grid-template-columns:1fr 1fr}
  .toolbar{flex-direction:column;align-items:stretch}
  .search-inp,.search-inp:focus{width:100%}
  .an-grid{grid-template-columns:repeat(2,1fr)}
  .form-grid{grid-template-columns:1fr}
  .form-grid .full{grid-column:1}
  .tbl-footer{flex-direction:column;align-items:flex-start}
}
</style>
</head>
<body>
<div class="page" x-data="mikrotikApp()" x-cloak>

  <!-- Header -->
  <div class="page-head">
    <div class="page-title"><i class="fa-solid fa-router"></i> Mikrotiks Information</div>
    <button class="btn-add" @click="openAdd()">
      <i class="fa-solid fa-plus"></i> Add Mikrotik
    </button>
  </div>

  <!-- KPI Cards -->
  <div class="stats">
    <div class="kpi kpi-slate">
      <div class="kpi-iw"><i class="fa-solid fa-server"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Total Mikrotiks</div>
        <div class="kpi-val" x-text="mikrotiks.length"></div>
        <div class="kpi-sub">registered devices</div>
      </div>
    </div>
    <div class="kpi kpi-green">
      <div class="kpi-iw"><i class="fa-solid fa-circle-check"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Online</div>
        <div class="kpi-val" x-text="mikrotiks.filter(m=>m.status==='Online').length"></div>
        <div class="kpi-sub">API reachable</div>
      </div>
    </div>
    <div class="kpi kpi-red">
      <div class="kpi-iw"><i class="fa-solid fa-circle-xmark"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Offline</div>
        <div class="kpi-val" x-text="mikrotiks.filter(m=>m.status==='Offline').length"></div>
        <div class="kpi-sub">unreachable</div>
      </div>
    </div>
    <div class="kpi kpi-amber">
      <div class="kpi-iw"><i class="fa-solid fa-plug"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Active Sessions</div>
        <div class="kpi-val" x-text="mikrotiks.reduce((s,m)=>s+(m.activeSessions||0),0)"></div>
        <div class="kpi-sub">total PPPoE</div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="card">
    <div class="toolbar">
      <div class="toolbar-left">
        <span class="show-lbl">Show</span>
        <select class="show-sel" x-model.number="perPage" @change="page=1">
          <option>10</option><option>25</option><option>50</option><option selected>100</option>
        </select>
        <span class="show-lbl">entries</span>
      </div>
      <div class="search-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input class="search-inp" type="text" placeholder="Search mikrotiks…" x-model="search" @input="page=1">
      </div>
    </div>

    <div class="tbl-wrap">
      <table>
        <thead>
          <tr>
            <th style="width:54px">ID</th>
            <th>Mikrotik IP</th>
            <th>Mikrotik Name</th>
            <th style="width:80px">Port</th>
            <th style="width:110px">API Status</th>
            <th style="min-width:360px">Action</th>
          </tr>
        </thead>
        <tbody>
          <template x-if="paged.length===0">
            <tr class="empty-row"><td colspan="6"><i class="fa-solid fa-router"></i>No mikrotik devices found</td></tr>
          </template>
          <template x-for="m in paged" :key="m.id">
            <tr>
              <td><span class="id-cell" x-text="m.id"></span></td>
              <td><span class="ip-cell" x-text="m.ip"></span></td>
              <td>
                <div class="name-cell" x-text="m.name"></div>
                <div style="font-size:11px;color:#94a3b8;margin-top:2px">v<span x-text="m.version"></span></div>
              </td>
              <td><span style="font-size:12px;font-weight:600;color:var(--muted)" x-text="m.port"></span></td>
              <td>
                <span class="api-badge" :class="m.status==='Online'?'api-online':m.status==='Checking'?'api-checking':'api-offline'">
                  <template x-if="m.status==='Offline'"><i class="fa-solid fa-triangle-exclamation" style="font-size:10px"></i></template>
                  <template x-if="m.status==='Online'"><i class="fa-solid fa-circle-check" style="font-size:10px"></i></template>
                  <template x-if="m.status==='Checking'"><i class="fa-solid fa-spinner fa-spin" style="font-size:10px"></i></template>
                  <span x-text="m.status"></span>
                </span>
              </td>
              <td>
                <div class="act-row">
                  <button class="ab ab-analyze" @click="openAnalyze(m)">
                    <i class="fa-solid fa-bolt"></i> Analyze
                  </button>
                  <button class="ab ab-secrets" @click="openSecrets(m)">
                    <i class="fa-solid fa-users"></i> Secrets
                  </button>
                  <button class="ab ab-connections" @click="openConnections(m)">
                    <i class="fa-solid fa-users-line"></i> Active Connections
                  </button>
                  <button class="ab-icon ab-edit" @click="openEdit(m)" title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="ab-icon ab-net" @click="showToast('Opening network interfaces…','info')" title="Interfaces">
                    <i class="fa-solid fa-network-wired"></i>
                  </button>
                  <button class="ab-icon ab-del" @click="openDelete(m)" title="Delete">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <div class="tbl-footer">
      <div class="tbl-info">
        Showing <strong x-text="pageStart"></strong> to <strong x-text="pageEnd"></strong>
        of <strong x-text="filtered.length"></strong> entries
        <template x-if="search"><span style="color:var(--muted)"> (filtered)</span></template>
      </div>
      <div class="pagination">
        <button class="pg-btn" @click="page--" :disabled="page===1">Previous</button>
        <template x-for="p in visiblePages" :key="p">
          <button class="pg-btn" :class="{active:p===page}" @click="p!=='…'&&(page=p)" x-text="p"></button>
        </template>
        <button class="pg-btn" @click="page++" :disabled="page===totalPages">Next</button>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       ADD / EDIT MODAL
  ══════════════════════════════════════════ -->
  <div class="overlay" x-show="modal==='add'||modal==='edit'"
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="modal=''">
    <div class="modal ae-modal"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="modal-head ae-head">
        <h3>
          <i :class="modal==='add'?'fa-solid fa-plus':'fa-solid fa-pen-to-square'"></i>
          <span x-text="modal==='add'?'Add New Mikrotik':'Edit Mikrotik'"></span>
        </h3>
        <button class="modal-close" @click="modal=''"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="form-body">
        <div class="form-grid">
          <div class="ff full" :class="{'has-err':formErr.ip}">
            <label>IP Address *</label>
            <input type="text" x-model="form.ip" placeholder="e.g. 10.10.112.74" @input="formErr.ip=''">
            <span class="err" x-text="formErr.ip"></span>
          </div>
          <div class="ff" :class="{'has-err':formErr.name}">
            <label>Mikrotik Name *</label>
            <input type="text" x-model="form.name" placeholder="e.g. SOHEL-ASHULIA-NET" @input="formErr.name=''">
            <span class="err" x-text="formErr.name"></span>
          </div>
          <div class="ff">
            <label>Description</label>
            <input type="text" x-model="form.description" placeholder="Optional description">
          </div>
          <div class="ff">
            <label>Username</label>
            <input type="text" x-model="form.username" placeholder="admin">
          </div>
          <div class="ff">
            <label>Password</label>
            <input type="password" x-model="form.password" placeholder="••••••••">
          </div>
          <div class="ff">
            <label>API Port</label>
            <input type="text" x-model="form.port" placeholder="8728">
          </div>
          <div class="ff">
            <label>API Type</label>
            <select x-model="form.apiType">
              <option value="API">API</option>
              <option value="SSH">SSH</option>
              <option value="Telnet">Telnet</option>
            </select>
          </div>
          <div class="ff">
            <label>RouterOS Version</label>
            <input type="text" x-model="form.version" placeholder="e.g. 7.14.3">
          </div>
        </div>
      </div>
      <div class="conn-test-row">
        <button class="btn-test" @click="testConn()"><i class="fa-solid fa-plug"></i> Test Connection</button>
        <span class="test-result" x-show="testStatus==='ok'" x-transition><span class="test-ok"><i class="fa-solid fa-circle-check"></i> Connection successful</span></span>
        <span class="test-result" x-show="testStatus==='fail'" x-transition><span class="test-fail"><i class="fa-solid fa-circle-xmark"></i> Connection failed</span></span>
        <span class="test-result" x-show="testStatus==='checking'" x-transition><span class="test-checking"><i class="fa-solid fa-spinner fa-spin"></i> Testing…</span></span>
      </div>
      <div class="modal-foot">
        <button class="btn-cancel" @click="modal=''">Cancel</button>
        <button class="btn-save" @click="saveMikrotik()">
          <i class="fa-solid fa-floppy-disk"></i>
          <span x-text="modal==='add'?'Add Mikrotik':'Update'"></span>
        </button>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       ANALYZE MODAL
  ══════════════════════════════════════════ -->
  <div class="overlay" x-show="modal==='analyze'"
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="modal=''">
    <div class="modal an-modal"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="modal-head an-head">
        <h3><i class="fa-solid fa-bolt"></i> Analyze — <span x-text="selectedMik?.name"></span></h3>
        <button class="modal-close" @click="modal=''"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-scroll">
        <div class="an-body">
          <!-- System info row -->
          <div class="an-section">
            <div class="an-section-title">System Information</div>
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-bottom:10px">
              <div style="background:#f8fafc;border-radius:8px;padding:10px 14px;border:1px solid var(--border)">
                <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.3px">RouterOS Version</div>
                <div style="font-size:14px;font-weight:700;color:var(--text);margin-top:3px" x-text="analyzeData.version"></div>
              </div>
              <div style="background:#f8fafc;border-radius:8px;padding:10px 14px;border:1px solid var(--border)">
                <div style="font-size:11px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.3px">Uptime</div>
                <div style="font-size:14px;font-weight:700;color:var(--success);margin-top:3px" x-text="analyzeData.uptime"></div>
              </div>
            </div>
          </div>
          <!-- Resources -->
          <div class="an-section">
            <div class="an-section-title">Resources</div>
            <div class="an-grid">
              <div class="an-card">
                <div class="an-card-val" :style="`color:${analyzeData.cpu>80?'#ef4444':analyzeData.cpu>50?'#f59e0b':'#10b981'}`" x-text="analyzeData.cpu+'%'"></div>
                <div class="an-card-lbl">CPU Load</div>
                <div class="an-card-bar"><div class="an-card-fill" :style="`width:${analyzeData.cpu}%;background:${analyzeData.cpu>80?'#ef4444':analyzeData.cpu>50?'#f59e0b':'#10b981'}`"></div></div>
              </div>
              <div class="an-card">
                <div class="an-card-val" :style="`color:${analyzeData.ram>80?'#ef4444':analyzeData.ram>50?'#f59e0b':'#10b981'}`" x-text="analyzeData.ram+'%'"></div>
                <div class="an-card-lbl">RAM Used</div>
                <div class="an-card-bar"><div class="an-card-fill" :style="`width:${analyzeData.ram}%;background:${analyzeData.ram>80?'#ef4444':analyzeData.ram>50?'#f59e0b':'#10b981'}`"></div></div>
              </div>
              <div class="an-card">
                <div class="an-card-val" x-text="analyzeData.disk+'%'"></div>
                <div class="an-card-lbl">HDD Used</div>
                <div class="an-card-bar"><div class="an-card-fill" :style="`width:${analyzeData.disk}%;background:#6366f1`"></div></div>
              </div>
              <div class="an-card">
                <div class="an-card-val" style="color:#06b6d4" x-text="analyzeData.temp+'°C'"></div>
                <div class="an-card-lbl">Temperature</div>
              </div>
              <div class="an-card">
                <div class="an-card-val" style="color:#6366f1" x-text="analyzeData.totalUsers"></div>
                <div class="an-card-lbl">PPPoE Users</div>
              </div>
              <div class="an-card">
                <div class="an-card-val" style="color:#10b981" x-text="analyzeData.activeSessions"></div>
                <div class="an-card-lbl">Active Sessions</div>
              </div>
            </div>
          </div>
          <!-- Interfaces -->
          <div class="an-section">
            <div class="an-section-title">Network Interfaces</div>
            <div class="iface-list">
              <template x-for="iface in analyzeData.interfaces" :key="iface.name">
                <div class="iface-item">
                  <div class="iface-name" x-text="iface.name"></div>
                  <div class="iface-badges">
                    <span class="ib" :class="iface.up?'ib-up':'ib-down'" x-text="iface.up?'UP':'DOWN'"></span>
                    <span class="ib ib-rx"><i class="fa-solid fa-arrow-down" style="font-size:9px"></i> <span x-text="iface.rx"></span></span>
                    <span class="ib ib-tx"><i class="fa-solid fa-arrow-up" style="font-size:9px"></i> <span x-text="iface.tx"></span></span>
                  </div>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-foot">
        <button class="btn-cancel" @click="modal=''">Close</button>
        <button class="btn-test" @click="showToast('Refreshing data…','info')"><i class="fa-solid fa-rotate"></i> Refresh</button>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       SECRETS MODAL
  ══════════════════════════════════════════ -->
  <div class="overlay" x-show="modal==='secrets'"
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="modal=''">
    <div class="modal sec-modal"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="modal-head sec-head">
        <h3><i class="fa-solid fa-users"></i> PPPoE Secrets — <span x-text="selectedMik?.name"></span></h3>
        <button class="modal-close" @click="modal=''"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="sec-toolbar">
        <div style="display:flex;align-items:center;gap:8px">
          <div class="sec-count">Total: <strong x-text="filteredSecrets.length"></strong> secrets</div>
        </div>
        <div class="sec-search">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" x-model="secretSearch" placeholder="Search secrets…">
        </div>
      </div>
      <div class="modal-scroll">
        <div class="sec-table-wrap">
          <table class="sec-table">
            <thead>
              <tr>
                <th>Username</th>
                <th>Profile</th>
                <th>IP Address</th>
                <th>Status</th>
                <th>Comment</th>
              </tr>
            </thead>
            <tbody>
              <template x-for="s in filteredSecrets" :key="s.user">
                <tr>
                  <td style="font-weight:600;font-family:'SF Mono',monospace;font-size:12px" x-text="s.user"></td>
                  <td><span class="sec-profile" x-text="s.profile"></span></td>
                  <td style="font-family:'SF Mono',monospace;font-size:11px" x-text="s.ip||'Dynamic'"></td>
                  <td>
                    <span x-show="s.active" class="sec-status-on"><i class="fa-solid fa-circle" style="font-size:7px"></i> Active</span>
                    <span x-show="!s.active" class="sec-status-off"><i class="fa-regular fa-circle" style="font-size:7px"></i> Inactive</span>
                  </td>
                  <td style="font-size:11px;color:var(--muted)" x-text="s.comment||'—'"></td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-foot">
        <button class="btn-cancel" @click="modal=''">Close</button>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       ACTIVE CONNECTIONS MODAL
  ══════════════════════════════════════════ -->
  <div class="overlay" x-show="modal==='connections'"
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="modal=''">
    <div class="modal conn-modal"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="modal-head conn-head">
        <h3><i class="fa-solid fa-users-line"></i> Active Connections — <span x-text="selectedMik?.name"></span>
          <span style="margin-left:6px;background:rgba(255,255,255,.2);padding:2px 8px;border-radius:12px;font-size:12px" x-text="activeConns.length + ' sessions'"></span>
        </h3>
        <button class="modal-close" @click="modal=''"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-scroll">
        <div style="overflow-x:auto">
          <table class="conn-table">
            <thead>
              <tr>
                <th>User</th>
                <th>IP Address</th>
                <th>Service</th>
                <th>Uptime</th>
                <th>RX</th>
                <th>TX</th>
                <th>Caller ID</th>
              </tr>
            </thead>
            <tbody>
              <template x-for="c in activeConns" :key="c.user">
                <tr>
                  <td style="font-weight:700;font-size:12px;font-family:'SF Mono',monospace" x-text="c.user"></td>
                  <td style="font-family:'SF Mono',monospace;font-size:11px" x-text="c.ip"></td>
                  <td style="font-size:11px;font-weight:600;color:var(--muted)" x-text="c.service"></td>
                  <td><span class="uptime-badge"><i class="fa-solid fa-clock" style="font-size:9px"></i> <span x-text="c.uptime"></span></span></td>
                  <td><span class="rx-val" x-text="c.rx"></span></td>
                  <td><span class="tx-val" x-text="c.tx"></span></td>
                  <td style="font-size:11px;color:var(--muted)" x-text="c.callerId"></td>
                </tr>
              </template>
              <template x-if="activeConns.length===0">
                <tr><td colspan="7" style="text-align:center;padding:30px;color:var(--muted);font-size:13px">No active connections</td></tr>
              </template>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-foot">
        <button class="btn-cancel" @click="modal=''">Close</button>
        <button class="btn-test" @click="showToast('Refreshing connections…','info')"><i class="fa-solid fa-rotate"></i> Refresh</button>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       DELETE MODAL
  ══════════════════════════════════════════ -->
  <div class="overlay" x-show="modal==='delete'"
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="modal=''">
    <div class="modal del-modal"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="modal-head del-head">
        <h3><i class="fa-solid fa-triangle-exclamation"></i> Confirm Delete</h3>
        <button class="modal-close" @click="modal=''"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="del-body">
        <div class="del-icon"><i class="fa-solid fa-server"></i></div>
        <div class="del-msg">
          Delete this Mikrotik device?<br>
          <span class="del-name" x-text="selectedMik?.name"></span><br>
          <span style="font-size:12px;color:var(--muted);margin-top:6px;display:block">IP: <strong x-text="selectedMik?.ip"></strong> — This action cannot be undone.</span>
        </div>
      </div>
      <div class="modal-foot">
        <button class="btn-cancel" @click="modal=''">Cancel</button>
        <button class="btn-danger" @click="confirmDelete()"><i class="fa-solid fa-trash-can"></i> Delete</button>
      </div>
    </div>
  </div>

  <!-- Toast -->
  <div class="toast-wrap">
    <template x-if="toast.show">
      <div class="toast" :class="toast.type">
        <i :class="toast.type==='success'?'fa-solid fa-circle-check':toast.type==='danger'?'fa-solid fa-circle-xmark':'fa-solid fa-circle-info'"></i>
        <span x-text="toast.msg"></span>
      </div>
    </template>
  </div>

</div>
<script>
function mikrotikApp(){
  return {
    mikrotiks:[
      {id:2,ip:'10.10.112.74',name:'SOHEL-ASHULIA-NET-RANGPUR-3219',description:'SOHEL-ASHULIA-NET-RANGPUR-ID-3219',port:'8728',apiType:'API',version:'7.14.3',status:'Offline',activeSessions:0,username:'admin'},
      {id:1,ip:'103.180.204.129',name:'Test',description:'nai',port:'8728',apiType:'API',version:'6.49.8',status:'Offline',activeSessions:0,username:'admin'},
      {id:3,ip:'192.168.10.1',name:'CIRCLE-NET-DHAKA-01',description:'Main office router Dhaka',port:'8728',apiType:'API',version:'7.14.3',status:'Online',activeSessions:14,username:'admin'},
      {id:4,ip:'172.16.0.1',name:'DELTA-POP-MIRPUR',description:'Mirpur POP gateway',port:'8728',apiType:'SSH',version:'7.13.5',status:'Online',activeSessions:8,username:'admin'},
    ],

    search:'',page:1,perPage:100,
    modal:'',selectedMik:null,
    form:{ip:'',name:'',description:'',username:'admin',password:'',port:'8728',apiType:'API',version:''},
    formErr:{},
    testStatus:'',
    analyzeData:{},
    activeConns:[],
    secretSearch:'',
    secretsList:[],
    toast:{show:false,msg:'',type:'success'},

    get filtered(){
      const q=this.search.trim().toLowerCase()
      if(!q)return this.mikrotiks
      return this.mikrotiks.filter(m=>m.ip.includes(q)||m.name.toLowerCase().includes(q)||m.description.toLowerCase().includes(q))
    },
    get totalPages(){return Math.max(1,Math.ceil(this.filtered.length/this.perPage))},
    get paged(){return this.filtered.slice((this.page-1)*this.perPage,this.page*this.perPage)},
    get pageStart(){return this.filtered.length===0?0:(this.page-1)*this.perPage+1},
    get pageEnd(){return Math.min(this.page*this.perPage,this.filtered.length)},
    get visiblePages(){
      const t=this.totalPages,c=this.page,p=[]
      if(t<=7){for(let i=1;i<=t;i++)p.push(i);return p}
      p.push(1);if(c>3)p.push('…')
      for(let i=Math.max(2,c-1);i<=Math.min(t-1,c+1);i++)p.push(i)
      if(c<t-2)p.push('…');p.push(t);return p
    },
    get filteredSecrets(){
      const q=this.secretSearch.trim().toLowerCase()
      if(!q)return this.secretsList
      return this.secretsList.filter(s=>s.user.toLowerCase().includes(q)||(s.profile||'').toLowerCase().includes(q))
    },

    openAdd(){
      this.form={ip:'',name:'',description:'',username:'admin',password:'',port:'8728',apiType:'API',version:''}
      this.formErr={};this.testStatus='';this.modal='add'
    },
    openEdit(m){
      this.selectedMik=m
      this.form={ip:m.ip,name:m.name,description:m.description,username:m.username||'admin',password:'',port:m.port,apiType:m.apiType,version:m.version}
      this.formErr={};this.testStatus='';this.modal='edit'
    },
    saveMikrotik(){
      this.formErr={}
      if(!this.form.ip.trim())this.formErr.ip='IP address is required'
      if(!this.form.name.trim())this.formErr.name='Name is required'
      if(Object.keys(this.formErr).length)return
      if(this.modal==='add'){
        const newId=Math.max(0,...this.mikrotiks.map(m=>m.id))+1
        this.mikrotiks.unshift({id:newId,...this.form,status:'Offline',activeSessions:0})
        this.showToast('Mikrotik added successfully','success')
      } else {
        Object.assign(this.selectedMik,{ip:this.form.ip,name:this.form.name,description:this.form.description,port:this.form.port,apiType:this.form.apiType,version:this.form.version})
        this.showToast('Mikrotik updated','success')
      }
      this.modal=''
    },
    testConn(){
      this.testStatus='checking'
      setTimeout(()=>this.testStatus='fail',1800)
    },

    openAnalyze(m){
      this.selectedMik=m
      this.analyzeData={
        version:'RouterOS '+m.version,uptime:'3d 14h 22m',
        cpu:m.status==='Online'?34:0,ram:m.status==='Online'?62:0,disk:m.status==='Online'?18:0,temp:m.status==='Online'?52:0,
        totalUsers:m.status==='Online'?25:0,activeSessions:m.activeSessions,
        interfaces:[
          {name:'ether1-WAN',up:m.status==='Online',rx:'1.2 GB',tx:'4.8 GB'},
          {name:'ether2-LAN',up:m.status==='Online',rx:'3.4 GB',tx:'2.1 GB'},
          {name:'pppoe-out1',up:m.status==='Online',rx:'842 MB',tx:'1.9 GB'},
          {name:'bridge-local',up:m.status==='Online',rx:'2.1 GB',tx:'980 MB'},
        ]
      }
      this.modal='analyze'
    },

    openSecrets(m){
      this.selectedMik=m;this.secretSearch=''
      this.secretsList=m.status==='Online'?[
        {user:'karim_001',profile:'10Mbps',ip:'10.10.1.2',active:true,comment:'Mirpur-2'},
        {user:'fatema_005',profile:'5Mbps',ip:null,active:false,comment:''},
        {user:'rafiq_007',profile:'20Mbps',ip:'10.10.1.8',active:true,comment:'Gulshan'},
        {user:'sadia_012',profile:'10Mbps',ip:null,active:true,comment:''},
        {user:'jahangir_014',profile:'5Mbps',ip:'10.10.1.15',active:false,comment:'Uttara'},
        {user:'nasrin_016',profile:'50Mbps',ip:'10.10.1.17',active:true,comment:'Banani VIP'},
        {user:'abul_018',profile:'10Mbps',ip:null,active:false,comment:''},
        {user:'monir_020',profile:'5Mbps',ip:'10.10.1.21',active:true,comment:''},
      ]:[]
      this.modal='secrets'
    },

    openConnections(m){
      this.selectedMik=m
      this.activeConns=m.status==='Online'?[
        {user:'karim_001',ip:'10.10.1.2',service:'pppoe',uptime:'5h 14m',rx:'342 MB',tx:'1.2 GB',callerId:'AA:BB:CC:11:22:33'},
        {user:'rafiq_007',ip:'10.10.1.8',service:'pppoe',uptime:'2h 08m',rx:'82 MB',tx:'440 MB',callerId:'DD:EE:FF:44:55:66'},
        {user:'sadia_012',ip:'10.10.1.13',service:'pppoe',uptime:'14h 52m',rx:'1.1 GB',tx:'3.8 GB',callerId:'11:22:33:AA:BB:CC'},
        {user:'nasrin_016',ip:'10.10.1.17',service:'pppoe',uptime:'1h 30m',rx:'220 MB',tx:'680 MB',callerId:'55:66:77:DD:EE:FF'},
        {user:'monir_020',ip:'10.10.1.21',service:'pppoe',uptime:'8h 44m',rx:'590 MB',tx:'2.1 GB',callerId:'88:99:AA:11:22:33'},
      ]:[]
      this.modal='connections'
    },

    openDelete(m){this.selectedMik=m;this.modal='delete'},
    confirmDelete(){
      const idx=this.mikrotiks.findIndex(m=>m.id===this.selectedMik.id)
      if(idx!==-1)this.mikrotiks.splice(idx,1)
      this.modal=''
      this.showToast(`${this.selectedMik.name} deleted`,'danger')
    },

    showToast(msg,type='success'){
      this.toast={show:true,msg,type}
      setTimeout(()=>this.toast.show=false,3000)
    },
    init(){this.$watch('search',()=>this.page=1)}
  }
}
</script>
</body>
</html>
