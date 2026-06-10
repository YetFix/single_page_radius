<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Payment History</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
:root{
  --primary:#6366f1;--primary-dark:#4f46e5;--primary-light:#eef2ff;
  --success:#10b981;--danger:#ef4444;--warning:#f59e0b;--info:#06b6d4;
  --teal:#0d9488;
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
.page-title i{color:var(--primary)}

/* ── stats ── */
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}
.kpi{border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:13px;box-shadow:0 3px 10px rgba(0,0,0,.14);position:relative;overflow:hidden}
.kpi-iw{width:42px;height:42px;border-radius:9px;flex-shrink:0;background:rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;font-size:17px;color:rgba(255,255,255,.92)}
.kpi-body{flex:1;min-width:0}
.kpi-lbl{font-size:10px;font-weight:600;color:rgba(255,255,255,.68);text-transform:uppercase;letter-spacing:.5px}
.kpi-val{font-size:22px;font-weight:800;color:#fff;line-height:1;letter-spacing:-.5px}
.kpi-sub{font-size:11px;color:rgba(255,255,255,.55);margin-top:2px}
.kpi-blue{background:linear-gradient(135deg,#6366f1,#4f46e5)}
.kpi-green{background:linear-gradient(135deg,#10b981,#059669)}
.kpi-amber{background:linear-gradient(135deg,#f59e0b,#d97706)}
.kpi-violet{background:linear-gradient(135deg,#8b5cf6,#7c3aed)}

/* ── filter card ── */
.filter-card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--border);margin-bottom:20px}
.filter-head{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));border-radius:var(--radius) var(--radius) 0 0}
.filter-head i{color:rgba(255,255,255,.85);font-size:13px}
.filter-head span{font-size:13px;font-weight:700;color:#fff}
.filter-body{padding:20px}
.filter-row{display:grid;gap:14px;margin-bottom:14px}
.filter-row.r1{grid-template-columns:repeat(6,1fr)}
.filter-row.r2{grid-template-columns:1fr 1fr auto 1fr}
.filter-row:last-child{margin-bottom:0}
.ff{display:flex;flex-direction:column;gap:5px}
.ff label{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px}
.ff input[type=date],.ff input[type=text],.ff select,.ff .sw-inp{
  padding:8px 11px;border:1.5px solid var(--border);border-radius:8px;
  font-size:13px;color:var(--text);outline:none;transition:.15s;background:#fff;width:100%;font-family:inherit
}
.ff input[type=date]:focus,.ff input[type=text]:focus,.ff select:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1)}
.ff select{appearance:none;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 9px center;padding-right:26px}
.ff select.has-val{border-color:var(--primary);background-color:var(--primary-light)}
/* clearable select wrapper */
.sw-wrap{position:relative;display:flex;align-items:center}
.sw-wrap select{flex:1;padding-right:36px}
.sw-clear{position:absolute;right:20px;background:none;border:none;color:#94a3b8;cursor:pointer;font-size:11px;padding:2px;line-height:1;display:flex;align-items:center;justify-content:center;transition:.12s}
.sw-clear:hover{color:var(--danger)}
/* checkbox row */
.cb-row{display:flex;align-items:center;gap:8px;padding-top:4px}
.cb-row input[type=checkbox]{width:15px;height:15px;accent-color:var(--primary);cursor:pointer;flex-shrink:0}
.cb-row label{font-size:13px;color:var(--text);cursor:pointer;line-height:1.35;font-weight:500}
/* per page with clear */
.perpage-wrap{position:relative}
.perpage-wrap select{padding-right:42px}
.perpage-clear{position:absolute;right:20px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;font-size:11px;padding:2px;transition:.12s}
.perpage-clear:hover{color:var(--danger)}
/* filter buttons */
.filter-btns{display:flex;align-items:flex-end;gap:8px}
.btn-search{display:inline-flex;align-items:center;gap:6px;padding:8px 20px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 3px 10px rgba(99,102,241,.3);transition:.18s;white-space:nowrap}
.btn-search:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(99,102,241,.4)}
.btn-reset{display:inline-flex;align-items:center;gap:6px;padding:8px 18px;background:linear-gradient(135deg,var(--teal),#0f766e);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;box-shadow:0 3px 10px rgba(13,148,136,.25);transition:.18s;white-space:nowrap}
.btn-reset:hover{transform:translateY(-1px)}

/* ── results card ── */
.results-card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--border);overflow:hidden}
.results-head{padding:13px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;background:#fafbff}
.results-meta{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.rh-label{font-size:13px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:7px}
.rh-label i{color:var(--primary)}
.count-chip{display:inline-flex;align-items:center;padding:3px 9px;background:var(--primary-light);color:var(--primary);border-radius:20px;font-size:12px;font-weight:700}
.total-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;background:#d1fae5;color:#065f46;border-radius:20px;font-size:12px;font-weight:700}
.export-btn{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border:1.5px solid var(--border);background:#fff;border-radius:8px;font-size:12px;font-weight:600;color:var(--muted);cursor:pointer;transition:.15s}
.export-btn:hover{border-color:var(--success);color:var(--success)}

/* ── table ── */
.tbl-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch}
table{width:100%;border-collapse:collapse;white-space:nowrap}
thead th{background:#f8fafc;padding:10px 14px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;border-bottom:2px solid var(--border);text-align:left}
tbody tr{border-bottom:1px solid #f1f5f9;transition:background .12s}
tbody tr:hover{background:#fafbff}
tbody tr:last-child{border-bottom:none}
tbody td{padding:11px 14px;font-size:13px;vertical-align:middle}
.tbl-foot-row td{background:#f8fafc;font-weight:700;border-top:2px solid var(--border);border-bottom:none}

/* cells */
.sl-cell{font-size:12px;font-weight:700;color:var(--muted)}
.customer-cell .name{font-weight:600;color:var(--text)}
.customer-cell .phone{font-size:11px;color:var(--muted);margin-top:1px}
.amount-cell{font-size:14px;font-weight:800;color:var(--success)}
.amount-cell.neg{color:var(--danger)}
.date-cell .day{font-size:12px;font-weight:600;color:var(--text)}
.date-cell .time{font-size:11px;color:var(--muted)}

/* payment type badge */
.type-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap}
.tb-cash{background:#d1fae5;color:#065f46}
.tb-bkash{background:#fce7f3;color:#9d174d}
.tb-nagad{background:#fef3c7;color:#92400e}
.tb-online{background:#dbeafe;color:#1e40af}
.tb-bank{background:#f3e8ff;color:#6d28d9}
.tb-other{background:#f1f5f9;color:#475569}

/* status badge */
.status-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600}
.sb-paid{background:#d1fae5;color:#065f46}
.sb-paid::before{content:'';display:inline-block;width:5px;height:5px;border-radius:50%;background:#10b981}
.sb-pending{background:#fef3c7;color:#92400e}
.sb-pending::before{content:'';display:inline-block;width:5px;height:5px;border-radius:50%;background:#f59e0b}

/* small muted text */
.muted-cell{font-size:12px;color:var(--muted)}
.close-id{display:inline-flex;align-items:center;padding:2px 7px;background:#f1f5f9;border-radius:5px;font-family:'SF Mono',monospace;font-size:11px;color:var(--text);border:1px solid var(--border)}

/* action dropdown */
.act-wrap{position:relative}
.act-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border:none;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;transition:.15s}
.act-btn:hover{filter:brightness(1.1)}
.act-btn i{font-size:9px;transition:.18s}
.act-menu{position:absolute;right:0;top:calc(100%+4px);background:#fff;border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,.15);border:1px solid var(--border);min-width:148px;z-index:100;overflow:hidden}
.act-item{display:flex;align-items:center;gap:9px;padding:9px 14px;font-size:13px;cursor:pointer;transition:background .12s;color:var(--text)}
.act-item:hover{background:#f8fafc}
.act-item.danger{color:var(--danger)}
.act-item.danger:hover{background:#fff5f5}
.act-item i{width:14px;text-align:center;font-size:12px}

/* footer / pagination */
.tbl-footer{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
.tbl-info{font-size:12px;color:var(--muted)}
.tbl-info strong{color:var(--text)}
.pagination{display:flex;gap:4px}
.pg-btn{width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:7px;border:1.5px solid var(--border);background:#fff;font-size:12px;font-weight:600;cursor:pointer;color:var(--muted);transition:.15s}
.pg-btn:hover{border-color:var(--primary);color:var(--primary)}
.pg-btn.active{background:var(--primary);border-color:var(--primary);color:#fff}
.pg-btn:disabled{opacity:.4;cursor:not-allowed}

/* empty */
.empty-row td{text-align:center;padding:40px;color:var(--muted);font-size:13px}
.empty-row i{font-size:28px;display:block;margin-bottom:8px;opacity:.25}

/* no-results banner */
.no-search{text-align:center;padding:40px 20px;color:var(--muted)}
.no-search i{font-size:36px;display:block;margin-bottom:10px;opacity:.2}
.no-search p{font-size:14px}

/* toast */
.toast-wrap{position:fixed;bottom:24px;right:24px;z-index:999;pointer-events:none;display:flex;flex-direction:column;gap:8px}
.toast{padding:11px 16px;border-radius:10px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 6px 24px rgba(0,0,0,.18);display:flex;align-items:center;gap:8px;pointer-events:auto}
.toast.success{background:linear-gradient(135deg,#10b981,#059669)}

/* responsive */
@media(max-width:1200px){.filter-row.r1{grid-template-columns:repeat(3,1fr)}.filter-row.r2{grid-template-columns:1fr 1fr 1fr}}
@media(max-width:900px){.stats{grid-template-columns:repeat(2,1fr)}.filter-row.r1{grid-template-columns:repeat(2,1fr)}.filter-row.r2{grid-template-columns:1fr 1fr}}
@media(max-width:600px){
  .stats{grid-template-columns:1fr 1fr}
  .filter-row.r1,.filter-row.r2{grid-template-columns:1fr}
  .filter-btns{flex-direction:row}
  .tbl-footer{flex-direction:column;align-items:flex-start}
}
</style>
</head>
<body>
<div class="page" x-data="payHistApp()" x-cloak>

  <!-- Header -->
  <div class="page-head">
    <div class="page-title"><i class="fa-solid fa-clock-rotate-left"></i> View Payment History</div>
  </div>

  <!-- KPI Cards -->
  <div class="stats">
    <div class="kpi kpi-blue">
      <div class="kpi-iw"><i class="fa-solid fa-receipt"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Total Transactions</div>
        <div class="kpi-val" x-text="results.length"></div>
        <div class="kpi-sub">current filter</div>
      </div>
    </div>
    <div class="kpi kpi-green">
      <div class="kpi-iw"><i class="fa-solid fa-bangladeshi-taka-sign"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Total Amount</div>
        <div class="kpi-val">৳<span x-text="totalAmount.toLocaleString()"></span></div>
        <div class="kpi-sub">collected</div>
      </div>
    </div>
    <div class="kpi kpi-amber">
      <div class="kpi-iw"><i class="fa-solid fa-money-bill-wave"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Cash Total</div>
        <div class="kpi-val">৳<span x-text="cashTotal.toLocaleString()"></span></div>
        <div class="kpi-sub" x-text="results.filter(r=>r.type==='Cash').length + ' payments'"></div>
      </div>
    </div>
    <div class="kpi kpi-violet">
      <div class="kpi-iw"><i class="fa-solid fa-mobile-screen-button"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Online Total</div>
        <div class="kpi-val">৳<span x-text="onlineTotal.toLocaleString()"></span></div>
        <div class="kpi-sub" x-text="results.filter(r=>r.type!=='Cash').length + ' payments'"></div>
      </div>
    </div>
  </div>

  <!-- Filter Card -->
  <div class="filter-card">
    <div class="filter-head">
      <i class="fa-solid fa-filter"></i>
      <span>Search Filters</span>
    </div>
    <div class="filter-body">

      <!-- Row 1 -->
      <div class="filter-row r1">
        <div class="ff">
          <label>From Date</label>
          <input type="date" x-model="filter.fromDate">
        </div>
        <div class="ff">
          <label>To Date</label>
          <input type="date" x-model="filter.toDate">
        </div>
        <div class="ff">
          <label>Select Manager</label>
          <div class="sw-wrap">
            <select x-model="filter.manager" :class="{'has-val':filter.manager}">
              <option value="">Select an option</option>
              <template x-for="m in managers" :key="m"><option :value="m" x-text="m"></option></template>
            </select>
            <button class="sw-clear" x-show="filter.manager" @click.prevent="filter.manager=''" title="Clear"><i class="fa-solid fa-xmark"></i></button>
          </div>
        </div>
        <div class="ff">
          <label>Select Sub-Manager / POP</label>
          <div class="sw-wrap">
            <select x-model="filter.pop" :class="{'has-val':filter.pop}">
              <option value="">All Pops/Sub-managers</option>
              <template x-for="p in pops" :key="p"><option :value="p" x-text="p"></option></template>
            </select>
            <button class="sw-clear" x-show="filter.pop" @click.prevent="filter.pop=''" title="Clear"><i class="fa-solid fa-xmark"></i></button>
          </div>
        </div>
        <div class="ff">
          <label>Select Area</label>
          <div class="sw-wrap">
            <select x-model="filter.area" :class="{'has-val':filter.area}">
              <option value="">Select an option</option>
              <template x-for="a in areas" :key="a"><option :value="a" x-text="a"></option></template>
            </select>
            <button class="sw-clear" x-show="filter.area" @click.prevent="filter.area=''" title="Clear"><i class="fa-solid fa-xmark"></i></button>
          </div>
        </div>
        <div class="ff">
          <label>Collector</label>
          <div class="sw-wrap">
            <select x-model="filter.collector" :class="{'has-val':filter.collector}">
              <option value="">Select an option</option>
              <template x-for="c in collectors" :key="c"><option :value="c" x-text="c"></option></template>
            </select>
            <button class="sw-clear" x-show="filter.collector" @click.prevent="filter.collector=''" title="Clear"><i class="fa-solid fa-xmark"></i></button>
          </div>
        </div>
      </div>

      <!-- Row 2 -->
      <div class="filter-row r2">
        <div class="ff">
          <label>Entry By</label>
          <div class="sw-wrap">
            <select x-model="filter.entryBy" :class="{'has-val':filter.entryBy}">
              <option value="">Select an option</option>
              <template x-for="e in entryByList" :key="e"><option :value="e" x-text="e"></option></template>
            </select>
            <button class="sw-clear" x-show="filter.entryBy" @click.prevent="filter.entryBy=''" title="Clear"><i class="fa-solid fa-xmark"></i></button>
          </div>
        </div>
        <div class="ff">
          <label>Type</label>
          <div class="sw-wrap">
            <select x-model="filter.type" :class="{'has-val':filter.type}">
              <option value="">Select an option</option>
              <option>Cash</option>
              <option>Bkash</option>
              <option>Nagad</option>
              <option>Online</option>
              <option>Bank Transfer</option>
            </select>
            <button class="sw-clear" x-show="filter.type" @click.prevent="filter.type=''" title="Clear"><i class="fa-solid fa-xmark"></i></button>
          </div>
        </div>
        <div style="display:flex;align-items:flex-end;gap:12px;flex-wrap:wrap">
          <div class="cb-row" style="padding-bottom:9px">
            <input type="checkbox" id="closeId" x-model="filter.withCloseId">
            <label for="closeId">Payment Report With Close Id</label>
          </div>
          <div class="ff" style="min-width:120px">
            <label>Per Page</label>
            <div class="perpage-wrap">
              <select x-model.number="filter.perPage">
                <option>10</option>
                <option>25</option>
                <option selected>50</option>
                <option>100</option>
                <option>200</option>
              </select>
            </div>
          </div>
        </div>
        <div class="filter-btns">
          <button class="btn-search" @click="applyFilter()">
            <i class="fa-solid fa-magnifying-glass"></i> Search
          </button>
          <button class="btn-reset" @click="resetFilter()">
            <i class="fa-solid fa-rotate-left"></i> Reset
          </button>
        </div>
      </div>

    </div>
  </div>

  <!-- Results -->
  <div class="results-card">
    <!-- Results header -->
    <div class="results-head">
      <div class="results-meta">
        <div class="rh-label"><i class="fa-solid fa-table-list"></i> Results</div>
        <span class="count-chip" x-text="filtered.length + ' records'"></span>
        <template x-if="filtered.length">
          <span class="total-chip">
            <i class="fa-solid fa-bangladeshi-taka-sign" style="font-size:10px"></i>
            ৳<span x-text="totalAmount.toLocaleString()"></span> total
          </span>
        </template>
        <template x-if="!searched">
          <span style="font-size:12px;color:var(--warning);font-weight:600;display:flex;align-items:center;gap:4px"><i class="fa-solid fa-circle-info"></i> Set filters and click Search</span>
        </template>
      </div>
      <button class="export-btn" @click="showToast('Exporting to CSV…')">
        <i class="fa-solid fa-file-csv"></i> Export CSV
      </button>
    </div>

    <!-- Not yet searched -->
    <template x-if="!searched">
      <div class="no-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <p>Configure filters above and click <strong>Search</strong> to view payment history.</p>
      </div>
    </template>

    <!-- Table -->
    <template x-if="searched">
      <div>
        <div class="tbl-wrap">
          <table>
            <thead>
              <tr>
                <th style="width:52px">SL</th>
                <th>Customer</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Date</th>
                <th>Manager</th>
                <th>POP / Area</th>
                <th>Collector</th>
                <th>Entry By</th>
                <template x-if="active.withCloseId"><th>Close ID</th></template>
                <th>Status</th>
                <th style="text-align:center;width:90px">Action</th>
              </tr>
            </thead>
            <tbody>
              <template x-if="paged.length===0">
                <tr class="empty-row"><td :colspan="active.withCloseId?12:11"><i class="fa-solid fa-receipt"></i>No payments found for selected filters</td></tr>
              </template>
              <template x-for="(r,idx) in paged" :key="r.id">
                <tr>
                  <td><span class="sl-cell" x-text="(page-1)*active.perPage+idx+1"></span></td>
                  <td>
                    <div class="customer-cell">
                      <div class="name" x-text="r.customer"></div>
                      <div class="phone" x-text="r.phone"></div>
                    </div>
                  </td>
                  <td><span class="amount-cell">৳<span x-text="r.amount.toLocaleString()"></span></span></td>
                  <td>
                    <span class="type-badge" :class="typeCls(r.type)" x-text="r.type"></span>
                  </td>
                  <td>
                    <div class="date-cell">
                      <div class="day" x-text="r.date.split(' ')[0]"></div>
                      <div class="time" x-text="r.date.split(' ')[1]"></div>
                    </div>
                  </td>
                  <td><span class="muted-cell" x-text="r.manager"></span></td>
                  <td>
                    <span class="muted-cell" x-text="r.pop"></span>
                    <div style="font-size:11px;color:#94a3b8" x-text="r.area"></div>
                  </td>
                  <td><span class="muted-cell" x-text="r.collector||'—'"></span></td>
                  <td><span class="muted-cell" x-text="r.entryBy"></span></td>
                  <template x-if="active.withCloseId">
                    <td><span class="close-id" x-text="r.closeId||'—'"></span></td>
                  </template>
                  <td>
                    <span class="status-badge" :class="r.status==='Paid'?'sb-paid':'sb-pending'" x-text="r.status"></span>
                  </td>
                  <td style="text-align:center">
                    <div class="act-wrap" x-data="{open:false}" @click.outside="open=false">
                      <button class="act-btn" @click="open=!open">
                        Action <i class="fa-solid fa-chevron-down" :style="open?'transform:rotate(180deg)':''"></i>
                      </button>
                      <div class="act-menu" x-show="open"
                           x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                           x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                        <div class="act-item" @click="showToast('Viewing receipt…');open=false"><i class="fa-solid fa-eye" style="color:var(--primary)"></i> View Receipt</div>
                        <div class="act-item" @click="showToast('Printing…');open=false"><i class="fa-solid fa-print" style="color:var(--info)"></i> Print</div>
                        <div class="act-item danger" @click="open=false"><i class="fa-solid fa-trash-can"></i> Delete</div>
                      </div>
                    </div>
                  </td>
                </tr>
              </template>
              <!-- Summary row -->
              <template x-if="paged.length>0">
                <tr class="tbl-foot-row">
                  <td colspan="2" style="text-align:right;font-size:12px;color:var(--muted)">Page Total</td>
                  <td><span class="amount-cell">৳<span x-text="paged.reduce((s,r)=>s+r.amount,0).toLocaleString()"></span></span></td>
                  <td :colspan="active.withCloseId?8:7"></td>
                  <td></td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>
        <!-- Pagination footer -->
        <div class="tbl-footer">
          <div class="tbl-info">
            Showing <strong x-text="pageStart"></strong>–<strong x-text="pageEnd"></strong>
            of <strong x-text="filtered.length"></strong> entries
          </div>
          <div class="pagination">
            <button class="pg-btn" @click="page--" :disabled="page===1"><i class="fa-solid fa-chevron-left" style="font-size:10px"></i></button>
            <template x-for="p in visiblePages" :key="p">
              <button class="pg-btn" :class="{active:p===page}" @click="p!=='…'&&(page=p)" x-text="p"></button>
            </template>
            <button class="pg-btn" @click="page++" :disabled="page===totalPages"><i class="fa-solid fa-chevron-right" style="font-size:10px"></i></button>
          </div>
        </div>
      </div>
    </template>
  </div>

  <!-- Toast -->
  <div class="toast-wrap">
    <template x-if="toast.show">
      <div class="toast success"><i class="fa-solid fa-circle-check"></i><span x-text="toast.msg"></span></div>
    </template>
  </div>

</div>
<script>
function payHistApp(){

  const ALL_PAYMENTS=[
    {id:1,customer:'Md. Karim Hossain',phone:'01711-223344',amount:500,type:'Cash',date:'2026-06-02 10:15:33',manager:'Afsana Suraya',pop:'Circle Network - POP 1',area:'Mirpur',collector:'Sohel Rana',entryBy:'Sohel Rana',closeId:'CL-1021',status:'Paid'},
    {id:2,customer:'Fatema Begum',phone:'01812-334455',amount:700,type:'Bkash',date:'2026-06-03 11:42:10',manager:'Afsana Suraya',pop:'Circle Network - POP 2',area:'Dhanmondi',collector:'Meraj Rabby',entryBy:'Rased',closeId:'CL-1022',status:'Paid'},
    {id:3,customer:'Rafiqul Islam',phone:'01911-445566',amount:550,type:'Cash',date:'2026-06-04 09:20:05',manager:'Rased',pop:'Delta - POP 1',area:'Gulshan',collector:'Saimon',entryBy:'Saimon',closeId:'CL-1023',status:'Paid'},
    {id:4,customer:'Sadia Akter',phone:'01612-556677',amount:800,type:'Nagad',date:'2026-06-04 14:05:58',manager:'Afsana Suraya',pop:'Circle Network - POP 1',area:'Mirpur',collector:'Sarwar Hossain',entryBy:'Sarwar Hossain',closeId:null,status:'Paid'},
    {id:5,customer:'Jahangir Alam',phone:'01711-667788',amount:500,type:'Cash',date:'2026-06-05 08:45:22',manager:'Rased',pop:'Delta - POP 2',area:'Uttara',collector:'Sohel Rana',entryBy:'Sohel Rana',closeId:'CL-1024',status:'Paid'},
    {id:6,customer:'Nasrin Sultana',phone:'01812-778899',amount:600,type:'Online',date:'2026-06-05 13:30:11',manager:'Afsana Suraya',pop:'Circle Network - POP 3',area:'Banani',collector:null,entryBy:'Rased',closeId:null,status:'Paid'},
    {id:7,customer:'Abul Kalam',phone:'01911-889900',amount:450,type:'Cash',date:'2026-06-06 10:55:48',manager:'Afsana Suraya',pop:'Circle Network - POP 2',area:'Dhanmondi',collector:'Meraj Rabby',entryBy:'Meraj Rabby',closeId:'CL-1025',status:'Paid'},
    {id:8,customer:'Tahmina Khatun',phone:'01711-990011',amount:700,type:'Bkash',date:'2026-06-06 16:20:39',manager:'Rased',pop:'Delta - POP 1',area:'Gulshan',collector:null,entryBy:'Rased',closeId:null,status:'Paid'},
    {id:9,customer:'Mofizur Rahman',phone:'01812-001122',amount:550,type:'Cash',date:'2026-06-07 09:10:17',manager:'Afsana Suraya',pop:'Circle Network - POP 1',area:'Mirpur',collector:'Sarwar Hossain',entryBy:'Sarwar Hossain',closeId:'CL-1026',status:'Paid'},
    {id:10,customer:'Rehana Parvin',phone:'01911-112233',amount:900,type:'Bank Transfer',date:'2026-06-08 14:44:55',manager:'Afsana Suraya',pop:'Circle Network - POP 4',area:'Mohammadpur',collector:null,entryBy:'Tuhin Ahmed Rony',closeId:'CL-1027',status:'Paid'},
    {id:11,customer:'Monir Hossain',phone:'01611-223344',amount:500,type:'Cash',date:'2026-06-09 08:30:20',manager:'Rased',pop:'Delta - POP 2',area:'Uttara',collector:'Sohel Rana',entryBy:'Sohel Rana',closeId:null,status:'Paid'},
    {id:12,customer:'Amina Khatun',phone:'01712-334455',amount:650,type:'Nagad',date:'2026-06-09 11:15:42',manager:'Afsana Suraya',pop:'Circle Network - POP 2',area:'Dhanmondi',collector:'Meraj Rabby',entryBy:'Meraj Rabby',closeId:'CL-1028',status:'Paid'},
    {id:13,customer:'Kamal Uddin',phone:'01813-445566',amount:500,type:'Cash',date:'2026-06-10 10:02:33',manager:'Afsana Suraya',pop:'Circle Network - POP 3',area:'Banani',collector:'Sarwar Hossain',entryBy:'Sarwar Hossain',closeId:'CL-1029',status:'Paid'},
    {id:14,customer:'Shirin Akter',phone:'01912-556677',amount:750,type:'Bkash',date:'2026-06-10 13:50:08',manager:'Rased',pop:'Delta - POP 1',area:'Gulshan',collector:null,entryBy:'Rased',closeId:null,status:'Paid'},
    {id:15,customer:'Halim Mia',phone:'01612-667788',amount:500,type:'Cash',date:'2026-06-10 15:20:47',manager:'Afsana Suraya',pop:'Circle Network - POP 1',area:'Mirpur',collector:'Sohel Rana',entryBy:'Sohel Rana',closeId:'CL-1030',status:'Paid'},
    {id:16,customer:'Rubina Islam',phone:'01711-778900',amount:600,type:'Online',date:'2026-06-11 09:40:15',manager:'Afsana Suraya',pop:'Circle Network - POP 4',area:'Mohammadpur',collector:null,entryBy:'Tuhin Ahmed Rony',closeId:null,status:'Pending'},
    {id:17,customer:'Delwar Hossain',phone:'01812-889011',amount:550,type:'Cash',date:'2026-06-11 10:55:30',manager:'Rased',pop:'Delta - POP 2',area:'Uttara',collector:'Meraj Rabby',entryBy:'Meraj Rabby',closeId:'CL-1031',status:'Paid'},
    {id:18,customer:'Parveen Sultana',phone:'01911-990122',amount:800,type:'Nagad',date:'2026-06-11 14:10:55',manager:'Afsana Suraya',pop:'Circle Network - POP 2',area:'Dhanmondi',collector:null,entryBy:'Rased',closeId:null,status:'Pending'},
  ]

  return {
    allPayments:ALL_PAYMENTS,
    results:ALL_PAYMENTS,
    searched:false,

    managers:[...new Set(ALL_PAYMENTS.map(p=>p.manager))],
    pops:[...new Set(ALL_PAYMENTS.map(p=>p.pop))],
    areas:[...new Set(ALL_PAYMENTS.map(p=>p.area))],
    collectors:[...new Set(ALL_PAYMENTS.filter(p=>p.collector).map(p=>p.collector))],
    entryByList:[...new Set(ALL_PAYMENTS.map(p=>p.entryBy))],

    filter:{fromDate:'2026-06-01',toDate:'2026-06-30',manager:'',pop:'',area:'',collector:'',entryBy:'',type:'',withCloseId:false,perPage:50},
    active:{fromDate:'2026-06-01',toDate:'2026-06-30',manager:'',pop:'',area:'',collector:'',entryBy:'',type:'',withCloseId:false,perPage:50},
    page:1,

    get filtered(){
      return this.results
    },
    get totalAmount(){return this.results.reduce((s,r)=>s+r.amount,0)},
    get cashTotal(){return this.results.filter(r=>r.type==='Cash').reduce((s,r)=>s+r.amount,0)},
    get onlineTotal(){return this.results.filter(r=>r.type!=='Cash').reduce((s,r)=>s+r.amount,0)},

    get totalPages(){return Math.max(1,Math.ceil(this.filtered.length/this.active.perPage))},
    get paged(){return this.filtered.slice((this.page-1)*this.active.perPage,this.page*this.active.perPage)},
    get pageStart(){return this.filtered.length===0?0:(this.page-1)*this.active.perPage+1},
    get pageEnd(){return Math.min(this.page*this.active.perPage,this.filtered.length)},
    get visiblePages(){
      const t=this.totalPages,c=this.page,p=[]
      if(t<=7){for(let i=1;i<=t;i++)p.push(i);return p}
      p.push(1);if(c>3)p.push('…')
      for(let i=Math.max(2,c-1);i<=Math.min(t-1,c+1);i++)p.push(i)
      if(c<t-2)p.push('…');p.push(t);return p
    },

    applyFilter(){
      Object.assign(this.active,JSON.parse(JSON.stringify(this.filter)))
      this.page=1
      this.searched=true
      const a=this.active
      this.results=this.allPayments.filter(p=>{
        if(a.fromDate&&p.date.split(' ')[0]<a.fromDate)return false
        if(a.toDate&&p.date.split(' ')[0]>a.toDate)return false
        if(a.manager&&p.manager!==a.manager)return false
        if(a.pop&&p.pop!==a.pop)return false
        if(a.area&&p.area!==a.area)return false
        if(a.collector&&p.collector!==a.collector)return false
        if(a.entryBy&&p.entryBy!==a.entryBy)return false
        if(a.type&&p.type!==a.type)return false
        if(a.withCloseId&&!p.closeId)return false
        return true
      })
    },

    resetFilter(){
      this.filter={fromDate:'2026-06-01',toDate:'2026-06-30',manager:'',pop:'',area:'',collector:'',entryBy:'',type:'',withCloseId:false,perPage:50}
      this.active={...this.filter}
      this.results=this.allPayments
      this.searched=false
      this.page=1
    },

    typeCls(t){
      return{Cash:'tb-cash',Bkash:'tb-bkash',Nagad:'tb-nagad',Online:'tb-online','Bank Transfer':'tb-bank'}[t]||'tb-other'
    },

    toast:{show:false,msg:''},
    showToast(msg){
      this.toast={show:true,msg}
      setTimeout(()=>this.toast.show=false,2800)
    }
  }
}
</script>
</body>
</html>
