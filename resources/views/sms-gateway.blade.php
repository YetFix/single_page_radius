<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>SMS Gateway</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
/* ── Reset & tokens ─────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --primary:#2563EB; --primary-l:#3B82F6; --primary-d:#1D4ED8;
  --success:#10B981; --success-l:#D1FAE5; --success-d:#059669;
  --danger:#EF4444;  --danger-l:#FEE2E2;  --danger-d:#DC2626;
  --violet:#7C3AED;  --violet-l:#EDE9FE;
  --text:#0F172A; --text2:#1E293B; --muted:#64748B; --light:#94A3B8;
  --border:#E2E8F0; --border-l:#F1F5F9;
  --surface:#FFFFFF; --bg:#F1F5F9; --bg-alt:#F8FAFC;
  --th:#1E293B;
  --sh-sm:0 1px 3px rgba(0,0,0,.06);
  --sh:0 4px 12px rgba(0,0,0,.07);
  --sh-md:0 12px 28px rgba(0,0,0,.12);
  --r:10px; --r-sm:6px; --r-lg:14px;
  --mono:ui-monospace,'Cascadia Code','Fira Code',monospace;
}
html{font-family:'Inter',sans-serif;font-size:14px}
body{background:var(--bg);color:var(--text);min-height:100vh}
[x-cloak]{display:none!important}

/* ── Page ────────────────────────────────────────── */
.pw{max-width:1600px;margin:0 auto;padding:24px 20px 48px}

/* ── Toast ───────────────────────────────────────── */
.toast{
  position:fixed;top:20px;right:20px;z-index:9999;
  display:flex;align-items:center;gap:9px;
  padding:10px 16px;border-radius:var(--r-sm);
  background:#1E293B;color:#fff;font-size:12.5px;font-weight:500;
  box-shadow:var(--sh-md);pointer-events:none;
}
.toast.ok{background:linear-gradient(135deg,#059669,#10B981)}

/* ── Header ──────────────────────────────────────── */
.ph{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:22px;flex-wrap:wrap}
.ph-left{display:flex;align-items:center;gap:12px}
.ph-icon{
  width:42px;height:42px;border-radius:11px;flex-shrink:0;
  background:linear-gradient(135deg,#7C3AED 0%,#2563EB 100%);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:17px;
  box-shadow:0 4px 14px rgba(124,58,237,.38);
}
.ph-title{font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
.ph-sub{font-size:12px;color:var(--muted);margin-top:1px}
.btn-add-gw{
  display:inline-flex;align-items:center;gap:7px;
  padding:9px 20px;border-radius:var(--r-sm);border:none;
  background:var(--primary);color:#fff;
  font-size:13px;font-weight:700;cursor:pointer;
  box-shadow:0 4px 14px rgba(37,99,235,.32);
  transition:transform .18s,box-shadow .18s,background .15s;
  white-space:nowrap;
}
.btn-add-gw:hover{background:var(--primary-d);transform:translateY(-1px);box-shadow:0 6px 20px rgba(37,99,235,.38)}

/* ── Stats strip ─────────────────────────────────── */
.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:18px}
.sc{
  background:var(--surface);border-radius:var(--r);padding:14px 18px;
  display:flex;align-items:center;gap:14px;
  border:1px solid var(--border);box-shadow:var(--sh-sm);
  position:relative;overflow:hidden;transition:transform .18s,box-shadow .18s;
}
.sc:hover{transform:translateY(-2px);box-shadow:var(--sh)}
.sc::after{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:10px 10px 0 0}
.sc.s-all::after  {background:linear-gradient(90deg,#7C3AED,#2563EB)}
.sc.s-on::after   {background:linear-gradient(90deg,#10B981,#059669)}
.sc.s-off::after  {background:linear-gradient(90deg,#EF4444,#DC2626)}
.sc-icon{
  width:40px;height:40px;border-radius:9px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;font-size:15px;
}
.s-all .sc-icon{background:linear-gradient(135deg,#EDE9FE,#DBEAFE);color:#7C3AED}
.s-on  .sc-icon{background:var(--success-l);color:var(--success)}
.s-off .sc-icon{background:var(--danger-l);color:var(--danger)}
.sc-body{flex:1}
.sc-lbl{font-size:10.5px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.5px}
.sc-val{font-size:26px;font-weight:800;color:var(--text);line-height:1.2;margin-top:2px}

/* ── Card wrapper ────────────────────────────────── */
.card{
  background:var(--surface);border-radius:var(--r-lg);
  border:1px solid var(--border);box-shadow:var(--sh);overflow:hidden;
}

/* ── Toolbar ─────────────────────────────────────── */
.tb{
  display:flex;align-items:center;justify-content:space-between;
  padding:14px 18px;border-bottom:1px solid var(--border-l);
  background:var(--bg-alt);flex-wrap:wrap;gap:12px;
}
.tb-left{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted)}
.tb-left label{font-weight:500}
.show-sel{
  height:32px;padding:0 8px;border:1px solid var(--border);border-radius:var(--r-sm);
  font-size:12.5px;font-family:inherit;color:var(--text);background:var(--surface);
  outline:none;cursor:pointer;
}
.tb-right{display:flex;align-items:center;gap:10px}
.search-wrap{position:relative;display:flex;align-items:center}
.search-wrap i{
  position:absolute;left:10px;color:var(--light);font-size:12px;pointer-events:none;
}
.search-input{
  height:32px;padding:0 10px 0 30px;
  border:1px solid var(--border);border-radius:var(--r-sm);
  font-size:12.5px;font-family:inherit;color:var(--text);
  background:var(--surface);outline:none;width:200px;
  transition:border-color .15s,box-shadow .15s,width .2s;
}
.search-input:focus{
  border-color:var(--primary-l);
  box-shadow:0 0 0 3px rgba(59,130,246,.12);
  width:240px;
}

/* ── Table ───────────────────────────────────────── */
.tscroll{overflow-x:auto;-webkit-overflow-scrolling:touch}
table{width:100%;border-collapse:collapse;min-width:1100px}
thead th{
  background:var(--th);color:rgba(255,255,255,.82);
  font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;
  padding:11px 14px;text-align:left;white-space:nowrap;
}
thead th.th-c{text-align:center}
tbody tr{border-bottom:1px solid var(--border-l);transition:background .14s}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:rgba(241,245,249,.8)}
tbody td{padding:11px 14px;vertical-align:middle;font-size:13px}
tbody td.td-c{text-align:center}

/* Row number */
.row-num{
  display:inline-flex;align-items:center;justify-content:center;
  width:26px;height:26px;border-radius:6px;
  background:var(--border-l);color:var(--muted);
  font-size:11.5px;font-weight:700;
}

/* Gateway name */
.gw-name{font-size:13px;font-weight:700;color:var(--text)}

/* API key */
.api-wrap{display:flex;align-items:center;gap:6px}
.api-key{
  font-family:var(--mono);font-size:11.5px;font-weight:500;
  color:#4F46E5;background:rgba(99,102,241,.08);
  border:1px solid rgba(99,102,241,.15);
  padding:2px 7px;border-radius:4px;
  white-space:nowrap;
}

/* Sender badge */
.sender-badge{
  display:inline-flex;align-items:center;
  padding:3px 9px;border-radius:4px;
  background:linear-gradient(135deg,rgba(124,58,237,.1),rgba(37,99,235,.06));
  border:1px solid rgba(124,58,237,.18);
  font-size:11px;font-weight:700;color:#5B21B6;
  white-space:nowrap;
}

/* URL cells */
.url-wrap{display:flex;align-items:center;gap:6px;max-width:260px}
.url-txt{
  font-family:var(--mono);font-size:10.5px;color:var(--muted);
  overflow:hidden;text-overflow:ellipsis;white-space:nowrap;
  flex:1;min-width:0;
}
.btn-copy{
  flex-shrink:0;width:22px;height:22px;border-radius:4px;border:none;
  background:var(--border-l);color:var(--light);
  display:flex;align-items:center;justify-content:center;
  cursor:pointer;font-size:10px;transition:all .15s;
}
.btn-copy:hover{background:rgba(37,99,235,.1);color:var(--primary)}
.btn-copy.copied{background:var(--success-l);color:var(--success)}

/* Status badge */
.sbadge{
  display:inline-flex;align-items:center;gap:5px;
  padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;
  cursor:pointer;transition:all .2s;user-select:none;
}
.sbadge.enabled {background:var(--success-l);color:#065F46;border:1px solid rgba(16,185,129,.2)}
.sbadge.disabled{background:var(--danger-l); color:#991B1B;border:1px solid rgba(239,68,68,.2)}
.sbadge:hover{filter:brightness(.95)}
.sdot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
.sbadge.enabled  .sdot{background:var(--success)}
.sbadge.disabled .sdot{background:var(--danger)}

/* Action buttons */
.act-wrap{display:flex;gap:5px}
.btn-edit,.btn-hist{
  display:inline-flex;align-items:center;gap:4px;
  padding:5px 11px;border-radius:var(--r-sm);border:none;
  font-size:11.5px;font-weight:600;cursor:pointer;transition:all .15s;
}
.btn-edit{background:var(--primary);color:#fff}
.btn-edit:hover{background:var(--primary-d)}
.btn-hist{background:#475569;color:#fff}
.btn-hist:hover{background:#334155}

/* ── Table footer ────────────────────────────────── */
.tf{
  display:flex;align-items:center;justify-content:space-between;
  padding:12px 18px;border-top:1px solid var(--border-l);
  background:var(--bg-alt);flex-wrap:wrap;gap:10px;
}
.tf-info{font-size:12px;color:var(--muted)}
.tf-info strong{color:var(--text);font-weight:600}
.pbtns{display:flex;gap:3px}
.pb{
  min-width:32px;height:32px;
  display:inline-flex;align-items:center;justify-content:center;
  border-radius:var(--r-sm);border:1px solid var(--border);
  background:var(--surface);color:var(--muted);
  font-size:12px;font-weight:600;cursor:pointer;
  transition:all .15s;padding:0 6px;
}
.pb:hover:not([disabled]){border-color:var(--primary-l);color:var(--primary);background:rgba(59,130,246,.06)}
.pb.on{background:var(--primary);border-color:var(--primary);color:#fff}
.pb[disabled]{opacity:.35;cursor:not-allowed}
.pb-lbl{
  height:32px;padding:0 10px;
  display:inline-flex;align-items:center;
  font-size:12px;color:var(--muted);
}

/* ── Empty state ─────────────────────────────────── */
.empty{text-align:center;padding:52px 24px;color:var(--muted)}
.empty-icon{
  width:60px;height:60px;border-radius:50%;
  background:var(--violet-l);color:var(--violet);
  display:flex;align-items:center;justify-content:center;
  font-size:22px;margin:0 auto 14px;
}
.empty h3{font-size:15px;font-weight:700;color:var(--text2);margin-bottom:5px}
.empty p{font-size:13px}

/* ── Add Gateway Modal ───────────────────────────── */
.overlay{
  position:fixed;inset:0;z-index:9000;
  background:rgba(15,23,42,.6);backdrop-filter:blur(4px);
  display:flex;align-items:center;justify-content:center;padding:20px;
}
.modal{
  background:#fff;border-radius:var(--r-lg);
  width:100%;max-width:580px;box-shadow:var(--sh-md);overflow:hidden;
}
.modal-head{
  display:flex;align-items:center;justify-content:space-between;
  padding:18px 22px;
  background:linear-gradient(135deg,#7C3AED 0%,#2563EB 100%);
}
.modal-head-left{display:flex;align-items:center;gap:10px}
.modal-head-icon{
  width:34px;height:34px;border-radius:8px;
  background:rgba(255,255,255,.18);color:#fff;
  display:flex;align-items:center;justify-content:center;font-size:15px;
}
.modal-head h3{font-size:15px;font-weight:700;color:#fff}
.modal-head p{font-size:11.5px;color:rgba(255,255,255,.72);margin-top:1px}
.btn-close-modal{
  width:30px;height:30px;border-radius:6px;border:none;
  background:rgba(255,255,255,.15);color:#fff;cursor:pointer;
  display:flex;align-items:center;justify-content:center;
  font-size:13px;transition:background .15s;flex-shrink:0;
}
.btn-close-modal:hover{background:rgba(255,255,255,.28)}
.modal-body{padding:22px 22px 16px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.fg-full{grid-column:span 2}
.ff label{
  display:block;font-size:10.5px;font-weight:700;
  color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:5px;
}
.ff label .req{color:var(--danger)}
.ff input,.ff select,.ff textarea{
  width:100%;border:1.5px solid var(--border);border-radius:var(--r-sm);
  padding:9px 11px;font-size:13px;font-family:inherit;color:var(--text);
  background:#fff;outline:none;resize:vertical;
  transition:border-color .15s,box-shadow .15s;
}
.ff input:focus,.ff select,.ff textarea:focus{
  border-color:var(--primary-l);
  box-shadow:0 0 0 3px rgba(59,130,246,.12);
}
.ff select{cursor:pointer;appearance:none;background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2364748B' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right 10px center;padding-right:32px}
.ff input.has-err,.ff textarea.has-err{border-color:var(--danger)!important}
.ff .err-msg{font-size:11px;color:var(--danger);margin-top:4px;display:flex;align-items:center;gap:4px}
.ff .err-msg i{font-size:10px}
.modal-foot{
  display:flex;align-items:center;justify-content:flex-end;gap:10px;
  padding:14px 22px;border-top:1px solid var(--border-l);background:var(--bg-alt);
}
.btn-cancel-m{
  padding:9px 18px;border-radius:var(--r-sm);
  border:1.5px solid var(--border);background:var(--bg-alt);
  color:var(--muted);font-size:13px;font-weight:500;cursor:pointer;
  transition:all .15s;
}
.btn-cancel-m:hover{background:var(--border);color:var(--text)}
.btn-save-gw{
  display:inline-flex;align-items:center;gap:7px;
  padding:9px 22px;border-radius:var(--r-sm);border:none;
  background:linear-gradient(135deg,#7C3AED,#2563EB);color:#fff;
  font-size:13px;font-weight:700;cursor:pointer;
  box-shadow:0 3px 12px rgba(124,58,237,.32);transition:filter .15s;
}
.btn-save-gw:hover{filter:brightness(1.08)}

/* ── Responsive ──────────────────────────────────── */
@media(max-width:900px){
  .stats{grid-template-columns:repeat(3,1fr)}
  .search-input{width:160px}
  .search-input:focus{width:180px}
}
@media(max-width:600px){
  .pw{padding:14px 12px 32px}
  .stats{grid-template-columns:1fr 1fr}
  .sc.s-off{display:none}
  .tb{flex-direction:column;align-items:stretch}
  .tb-right{justify-content:space-between}
  .search-input,.search-input:focus{width:100%}
  .ph{flex-wrap:wrap}
  .ph-title{font-size:17px}
}
</style>
</head>
<body>
<div class="pw" x-data="smsGateway()">

  <!-- ── Toast ── -->
  <div class="toast ok"
    x-show="toast.show" x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-x-3"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">
    <i class="fa-solid fa-clipboard-check"></i>
    <span x-text="toast.msg"></span>
  </div>

  <!-- ── Add Gateway Modal ── -->
  <div class="overlay" x-show="showModal" x-cloak @click.self="closeModal"
    x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-120"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">
    <div class="modal"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100">

      <!-- Modal head -->
      <div class="modal-head">
        <div class="modal-head-left">
          <div class="modal-head-icon"><i class="fa-solid fa-tower-broadcast"></i></div>
          <div>
            <h3>Add SMS Gateway</h3>
            <p>Configure a new SMS provider connection</p>
          </div>
        </div>
        <button class="btn-close-modal" @click="closeModal">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-grid">

          <div class="ff">
            <label>Gateway Name <span class="req">*</span></label>
            <input type="text" placeholder="e.g. Delta_masking"
              x-model="form.name" :class="errors.name ? 'has-err' : ''"
              @input="errors.name = false">
            <div class="err-msg" x-show="errors.name" x-cloak>
              <i class="fa-solid fa-circle-exclamation"></i> Name is required
            </div>
          </div>

          <div class="ff">
            <label>Sender ID <span class="req">*</span></label>
            <input type="text" placeholder="e.g. DELTA NET"
              x-model="form.sender" :class="errors.sender ? 'has-err' : ''"
              @input="errors.sender = false">
            <div class="err-msg" x-show="errors.sender" x-cloak>
              <i class="fa-solid fa-circle-exclamation"></i> Sender ID is required
            </div>
          </div>

          <div class="ff">
            <label>API Key <span class="req">*</span></label>
            <input type="text" placeholder="e.g. f6d01b412d27a544"
              x-model="form.apiKey" :class="errors.apiKey ? 'has-err' : ''"
              @input="errors.apiKey = false"
              style="font-family:var(--mono);font-size:12.5px;letter-spacing:.3px">
            <div class="err-msg" x-show="errors.apiKey" x-cloak>
              <i class="fa-solid fa-circle-exclamation"></i> API Key is required
            </div>
          </div>

          <div class="ff">
            <label>Secret Key</label>
            <input type="text" placeholder="e.g. 6d6d4e71"
              x-model="form.secretKey"
              style="font-family:var(--mono);font-size:12.5px;letter-spacing:.3px">
          </div>

          <div class="ff fg-full">
            <label>API URL <span class="req">*</span></label>
            <textarea rows="3"
              placeholder="https://provider.com/send?apikey={apiKey}&to={contactNumber}&message={messageBody}"
              x-model="form.url" :class="errors.url ? 'has-err' : ''"
              @input="errors.url = false"
              style="font-family:var(--mono);font-size:11.5px"></textarea>
            <div class="err-msg" x-show="errors.url" x-cloak>
              <i class="fa-solid fa-circle-exclamation"></i> API URL is required
            </div>
          </div>

          <div class="ff fg-full">
            <label>Balance URL <span style="color:var(--light);font-weight:400;text-transform:none;letter-spacing:0">(optional)</span></label>
            <textarea rows="2"
              placeholder="https://provider.com/balance?apikey={apiKey}"
              x-model="form.balanceUrl"
              style="font-family:var(--mono);font-size:11.5px"></textarea>
          </div>

          <div class="ff">
            <label>Status</label>
            <select x-model="form.status">
              <option value="enabled">Enabled</option>
              <option value="disabled">Disabled</option>
            </select>
          </div>

        </div>
      </div>

      <!-- Modal foot -->
      <div class="modal-foot">
        <button class="btn-cancel-m" @click="closeModal">Cancel</button>
        <button class="btn-save-gw" @click="addGateway">
          <i class="fa-solid fa-floppy-disk"></i> Save Gateway
        </button>
      </div>

    </div>
  </div>

  <!-- ── Header ── -->
  <div class="ph">
    <div class="ph-left">
      <div class="ph-icon"><i class="fa-solid fa-tower-broadcast"></i></div>
      <div>
        <div class="ph-title">SMS Gateway</div>
        <div class="ph-sub">Manage SMS provider connections and API configurations</div>
      </div>
    </div>
    <button class="btn-add-gw" @click="showModal=true">
      <i class="fa-solid fa-plus"></i> Add SMS Gateway
    </button>
  </div>

  <!-- ── Stats ── -->
  <div class="stats">
    <div class="sc s-all">
      <div class="sc-icon"><i class="fa-solid fa-tower-broadcast"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Total Gateways</div>
        <div class="sc-val" x-text="gateways.length"></div>
      </div>
    </div>
    <div class="sc s-on">
      <div class="sc-icon"><i class="fa-solid fa-signal"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Enabled</div>
        <div class="sc-val" x-text="gateways.filter(g=>g.status==='enabled').length"></div>
      </div>
    </div>
    <div class="sc s-off">
      <div class="sc-icon"><i class="fa-solid fa-ban"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Disabled</div>
        <div class="sc-val" x-text="gateways.filter(g=>g.status==='disabled').length"></div>
      </div>
    </div>
  </div>

  <!-- ── Main card ── -->
  <div class="card">

    <!-- Toolbar -->
    <div class="tb">
      <div class="tb-left">
        <label for="show-sel">Show</label>
        <select id="show-sel" class="show-sel" x-model.number="perPage">
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
        </select>
        <span>entries</span>
      </div>
      <div class="tb-right">
        <div class="search-wrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" class="search-input" placeholder="Search…" x-model="search">
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="tscroll">
      <table>
        <thead>
          <tr>
            <th class="th-c">#</th>
            <th>Name</th>
            <th>API Key</th>
            <th>Sender</th>
            <th>URL</th>
            <th>Balance URL</th>
            <th class="th-c">Status</th>
            <th class="th-c">Action</th>
          </tr>
        </thead>
        <tbody>
          <template x-if="paginated.length === 0">
            <tr>
              <td colspan="8">
                <div class="empty">
                  <div class="empty-icon"><i class="fa-solid fa-tower-broadcast"></i></div>
                  <h3>No Gateways Found</h3>
                  <p x-show="search">No results match "<span x-text="search"></span>". Try a different search.</p>
                  <p x-show="!search">No SMS gateways configured yet. Add one to get started.</p>
                </div>
              </td>
            </tr>
          </template>
          <template x-for="(g, i) in paginated" :key="g.id">
            <tr>

              <!-- # -->
              <td class="td-c">
                <span class="row-num" x-text="(page-1)*perPage + i + 1"></span>
              </td>

              <!-- Name -->
              <td>
                <span class="gw-name" x-text="g.name"></span>
              </td>

              <!-- API Key -->
              <td>
                <div class="api-wrap">
                  <span class="api-key" x-text="g.apiKey"></span>
                  <button class="btn-copy" :class="{copied: isCopied(g.id,'key')}"
                    @click="copy(g.apiKey, g.id, 'key')" title="Copy API key">
                    <i class="fa-solid" :class="isCopied(g.id,'key') ? 'fa-check' : 'fa-copy'"></i>
                  </button>
                </div>
              </td>

              <!-- Sender -->
              <td>
                <span class="sender-badge" x-text="g.sender"></span>
              </td>

              <!-- URL -->
              <td>
                <div class="url-wrap">
                  <span class="url-txt" x-text="g.url" :title="g.url"></span>
                  <button class="btn-copy" :class="{copied: isCopied(g.id,'url')}"
                    @click="copy(g.url, g.id, 'url')" title="Copy URL">
                    <i class="fa-solid" :class="isCopied(g.id,'url') ? 'fa-check' : 'fa-copy'"></i>
                  </button>
                </div>
              </td>

              <!-- Balance URL -->
              <td>
                <div class="url-wrap">
                  <span class="url-txt" x-text="g.balanceUrl" :title="g.balanceUrl"></span>
                  <button class="btn-copy" :class="{copied: isCopied(g.id,'bal')}"
                    @click="copy(g.balanceUrl, g.id, 'bal')" title="Copy Balance URL">
                    <i class="fa-solid" :class="isCopied(g.id,'bal') ? 'fa-check' : 'fa-copy'"></i>
                  </button>
                </div>
              </td>

              <!-- Status -->
              <td class="td-c">
                <span class="sbadge" :class="g.status" @click="toggleStatus(g.id)">
                  <span class="sdot"></span>
                  <span x-text="g.status === 'enabled' ? 'Enabled' : 'Disabled'"></span>
                </span>
              </td>

              <!-- Action -->
              <td class="td-c">
                <div class="act-wrap" style="justify-content:center">
                  <button class="btn-edit">
                    <i class="fa-solid fa-pen" style="font-size:10px"></i> Edit
                  </button>
                  <button class="btn-hist">
                    <i class="fa-solid fa-clock-rotate-left" style="font-size:10px"></i> History
                  </button>
                </div>
              </td>

            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- Footer -->
    <div class="tf">
      <div class="tf-info">
        <template x-if="filtered.length === 0">
          <span>Showing <strong>0</strong> entries</span>
        </template>
        <template x-if="filtered.length > 0">
          <span>
            Showing <strong x-text="(page-1)*perPage+1"></strong>
            to <strong x-text="Math.min(page*perPage, filtered.length)"></strong>
            of <strong x-text="filtered.length"></strong> entries
            <template x-if="search">
              <span style="color:var(--light)"> (filtered from <strong x-text="gateways.length"></strong> total)</span>
            </template>
          </span>
        </template>
      </div>
      <div class="pbtns">
        <span class="pb-lbl">Previous</span>
        <template x-for="p in visiblePages" :key="p">
          <button class="pb" :class="{on: page===p}" @click="page=p" x-text="p"></button>
        </template>
        <span class="pb-lbl">Next</span>
      </div>
    </div>

  </div><!-- /.card -->

</div><!-- /.pw -->

<script>
function smsGateway() {
  return {
    search: '',
    perPage: 10,
    page: 1,
    copiedMap: {},
    toast: { show: false, msg: '' },
    showModal: false,
    form: { name:'', apiKey:'', secretKey:'', sender:'', url:'', balanceUrl:'', status:'enabled' },
    errors: {},

    gateways: [
      { id:1, name:'Delta_masking', apiKey:'f6d01b412d27a544', sender:'DELTA NET', url:'https://smpp.revesms.com:7790/sendtext?apikey=f6d01b412d27a544&secretkey=6d6d4e71&callerID=DELTA%20NET&toUser={contactNumber}&messageContent={messageBody}', balanceUrl:'https://smpp.revesms.com/sms/smsConfiguration/smsClientBalance.jsp?client=delta_masking', status:'enabled' },
      { id:2, name:'BulkSMS_Pro',   apiKey:'a1b2c3d4e5f67890', sender:'BULKSMS',   url:'https://api.bulksmsbd.net/api/smsapi?api_key=a1b2c3d4e5f67890&type=text&number={contactNumber}&senderid=BULKSMS&message={messageBody}', balanceUrl:'https://api.bulksmsbd.net/api/getBalance?api_key=a1b2c3d4e5f67890', status:'enabled' },
      { id:3, name:'SMS_World',      apiKey:'9876543210abcdef', sender:'SMSWORLD',  url:'https://smsworld.com/api/send?token=9876543210abcdef&to={contactNumber}&from=SMSWORLD&text={messageBody}', balanceUrl:'https://smsworld.com/api/balance?token=9876543210abcdef', status:'disabled' },
      { id:4, name:'FastSMS_BD',     apiKey:'fast123xyz789abc', sender:'FASTSMS',   url:'https://fastsms.com.bd/smsapi?api_key=fast123xyz789abc&senderid=FASTSMS&number={contactNumber}&message={messageBody}&type=text', balanceUrl:'https://fastsms.com.bd/api/getBalance?api_key=fast123xyz789abc', status:'enabled' },
      { id:5, name:'SMS_Net_BD',     apiKey:'smsnet98765xyz12', sender:'SMSNET',    url:'https://smsnet.com.bd/api/v2/SendSMS?ApiKey=smsnet98765xyz12&ClientId=NET001&SenderId=SMSNET&Message={messageBody}&MobileNumbers={contactNumber}', balanceUrl:'https://smsnet.com.bd/api/v2/Balance?ApiKey=smsnet98765xyz12', status:'enabled' },
      { id:6, name:'BD_Telecom',     apiKey:'bdtel44332211xyz0', sender:'BDTEL',    url:'https://api.bdtelecom.net/sms/send?api_key=bdtel44332211xyz0&from=BDTEL&to={contactNumber}&text={messageBody}', balanceUrl:'https://api.bdtelecom.net/sms/balance?api_key=bdtel44332211xyz0', status:'disabled' },
    ],

    init() {
      this.$watch('search',  () => { this.page = 1 });
      this.$watch('perPage', () => { this.page = 1 });
    },

    get filtered() {
      const q = this.search.toLowerCase();
      if (!q) return this.gateways;
      return this.gateways.filter(g =>
        g.name.toLowerCase().includes(q)   ||
        g.apiKey.toLowerCase().includes(q) ||
        g.sender.toLowerCase().includes(q) ||
        g.url.toLowerCase().includes(q)    ||
        g.status.includes(q)
      );
    },

    get paginated() {
      const s = (this.page - 1) * this.perPage;
      return this.filtered.slice(s, s + this.perPage);
    },

    get totalPages() {
      return Math.max(1, Math.ceil(this.filtered.length / this.perPage));
    },

    get visiblePages() {
      const t = this.totalPages, c = this.page;
      let s = Math.max(1, c - 2), e = Math.min(t, s + 4);
      if (e - s < 4) s = Math.max(1, e - 4);
      const ps = [];
      for (let i = s; i <= e; i++) ps.push(i);
      return ps;
    },

    isCopied(id, type) {
      return !!this.copiedMap[`${id}_${type}`];
    },

    copy(text, id, type) {
      try {
        navigator.clipboard.writeText(text);
      } catch(e) {
        const el = document.createElement('textarea');
        el.value = text; document.body.appendChild(el);
        el.select(); document.execCommand('copy');
        document.body.removeChild(el);
      }
      const key = `${id}_${type}`;
      this.copiedMap = { ...this.copiedMap, [key]: true };
      this.toast = { show: true, msg: 'Copied to clipboard' };
      setTimeout(() => {
        this.copiedMap = { ...this.copiedMap, [key]: false };
        this.toast.show = false;
      }, 2000);
    },

    toggleStatus(id) {
      const gw = this.gateways.find(g => g.id === id);
      if (gw) gw.status = gw.status === 'enabled' ? 'disabled' : 'enabled';
    },

    closeModal() {
      this.showModal = false;
      this.form   = { name:'', apiKey:'', secretKey:'', sender:'', url:'', balanceUrl:'', status:'enabled' };
      this.errors = {};
    },

    addGateway() {
      this.errors = {};
      if (!this.form.name.trim())   this.errors.name   = true;
      if (!this.form.apiKey.trim()) this.errors.apiKey = true;
      if (!this.form.sender.trim()) this.errors.sender = true;
      if (!this.form.url.trim())    this.errors.url    = true;
      if (Object.keys(this.errors).length) return;

      const name = this.form.name.trim();
      const newId = Math.max(0, ...this.gateways.map(g => g.id)) + 1;
      this.gateways.push({
        id: newId,
        name,
        apiKey:     this.form.apiKey.trim(),
        secretKey:  this.form.secretKey.trim(),
        sender:     this.form.sender.trim(),
        url:        this.form.url.trim(),
        balanceUrl: this.form.balanceUrl.trim(),
        status:     this.form.status,
      });
      this.closeModal();
      this.toast = { show: true, msg: `"${name}" added successfully` };
      setTimeout(() => { this.toast.show = false; }, 2500);
    },
  };
}
</script>
</body>
</html>
