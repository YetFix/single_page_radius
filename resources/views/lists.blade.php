<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Customer List</title>
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
  --danger:#EF4444;  --danger-l:#FEE2E2;
  --warning:#F59E0B; --warning-l:#FEF3C7;
  --teal:#0D9488;    --teal-l:#CCFBF1;
  --purple:#8B5CF6;
  --text:#0F172A; --text2:#1E293B; --muted:#64748B; --light:#94A3B8;
  --border:#E2E8F0; --border-l:#F1F5F9;
  --surface:#FFFFFF; --bg:#F1F5F9; --bg-alt:#F8FAFC;
  --th:#1E293B;
  --sh-sm:0 1px 3px rgba(0,0,0,.06);
  --sh:0 4px 12px rgba(0,0,0,.07);
  --sh-md:0 10px 24px rgba(0,0,0,.09);
  --r:10px; --r-sm:6px; --r-lg:14px;
}
html{font-family:'Inter',sans-serif;font-size:14px}
body{background:var(--bg);color:var(--text);min-height:100vh}
[x-cloak]{display:none!important}

/* ── Page layout ────────────────────────────────── */
.pw{max-width:1700px;margin:0 auto;padding:24px 20px 48px}

/* ── Header ─────────────────────────────────────── */
.ph{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:22px;flex-wrap:wrap}
.ph-left{display:flex;align-items:center;gap:12px}
.ph-icon{
  width:42px;height:42px;border-radius:11px;flex-shrink:0;
  background:linear-gradient(135deg,#2563EB 0%,#7C3AED 100%);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:17px;
  box-shadow:0 4px 14px rgba(37,99,235,.38);
}
.ph-title{font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
.ph-sub{font-size:12px;color:var(--muted);margin-top:1px}
.btn-add{
  display:inline-flex;align-items:center;gap:7px;
  padding:9px 20px;border-radius:var(--r-sm);border:none;
  background:linear-gradient(135deg,#F59E0B,#EF4444);
  color:#fff;font-size:13px;font-weight:700;cursor:pointer;
  box-shadow:0 4px 14px rgba(245,158,11,.35);
  transition:transform .18s,box-shadow .18s;white-space:nowrap;
}
.btn-add:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(245,158,11,.42)}

/* ── Stats strip ─────────────────────────────────── */
.stats{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:18px}
.sc{
  background:var(--surface);border-radius:var(--r);padding:14px 16px;
  display:flex;align-items:center;gap:12px;
  border:1px solid var(--border);box-shadow:var(--sh-sm);
  position:relative;overflow:hidden;
  transition:transform .18s,box-shadow .18s;
}
.sc:hover{transform:translateY(-2px);box-shadow:var(--sh)}
.sc::after{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:10px 10px 0 0}
.sc.s-total::after{background:linear-gradient(90deg,#2563EB,#7C3AED)}
.sc.s-active::after{background:linear-gradient(90deg,#10B981,#059669)}
.sc.s-expired::after{background:linear-gradient(90deg,#EF4444,#DC2626)}
.sc.s-dis::after{background:linear-gradient(90deg,#F59E0B,#D97706)}
.sc.s-deac::after{background:linear-gradient(90deg,#64748B,#475569)}
.sc-icon{
  width:38px;height:38px;border-radius:9px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;font-size:14px;
}
.s-total .sc-icon{background:linear-gradient(135deg,#DBEAFE,#EDE9FE);color:#2563EB}
.s-active .sc-icon{background:var(--success-l);color:var(--success)}
.s-expired .sc-icon{background:var(--danger-l);color:var(--danger)}
.s-dis .sc-icon{background:var(--warning-l);color:var(--warning)}
.s-deac .sc-icon{background:#F1F5F9;color:#64748B}
.sc-body{flex:1;min-width:0}
.sc-lbl{font-size:10.5px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.5px}
.sc-val{font-size:24px;font-weight:800;color:var(--text);line-height:1.2;margin-top:1px}

/* ── Filter bar ─────────────────────────────────── */
.fb{
  background:var(--surface);border-radius:var(--r);padding:14px 16px;
  margin-bottom:14px;border:1px solid var(--border);box-shadow:var(--sh-sm);
}
.fg{display:grid;grid-template-columns:repeat(7,1fr) auto;gap:8px;align-items:end}
.ff label{display:block;font-size:10.5px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px}
.ff input{
  width:100%;height:32px;border:1px solid var(--border);
  border-radius:var(--r-sm);padding:0 9px;
  font-size:12px;font-family:inherit;color:var(--text);
  background:var(--bg-alt);outline:none;
  transition:border-color .15s,box-shadow .15s;
}
.ff input:focus{border-color:var(--primary-l);box-shadow:0 0 0 3px rgba(59,130,246,.13);background:#fff}
.fa-btns{display:flex;gap:6px;align-items:flex-end}
.btn-rst{
  height:32px;padding:0 12px;border:1px solid var(--border);border-radius:var(--r-sm);
  background:var(--bg-alt);color:var(--muted);font-size:12px;font-family:inherit;
  cursor:pointer;display:inline-flex;align-items:center;gap:5px;
  transition:all .15s;
}
.btn-rst:hover{background:var(--border);color:var(--text)}

/* ── Results bar ─────────────────────────────────── */
.rb{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;gap:12px;flex-wrap:wrap}
.rb-info{font-size:12px;color:var(--muted)}
.rb-info strong{color:var(--text);font-weight:600}
.sort-wrap{display:flex;align-items:center;gap:8px}
.sort-lbl{font-size:11px;color:var(--muted);font-weight:500}
.sort-sel{
  height:30px;padding:0 8px;border:1px solid var(--border);border-radius:var(--r-sm);
  font-size:12px;font-family:inherit;color:var(--text);background:var(--surface);
  outline:none;cursor:pointer;
}

/* ── Table wrapper ───────────────────────────────── */
.tw{
  background:var(--surface);border-radius:var(--r-lg);
  box-shadow:var(--sh);border:1px solid var(--border);
  overflow:hidden;
}
.tscroll{overflow-x:auto}
table{width:100%;border-collapse:collapse;min-width:1280px}

/* ── Table head ──────────────────────────────────── */
thead th{
  background:var(--th);color:rgba(255,255,255,.82);
  font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;
  padding:11px 13px;text-align:left;white-space:nowrap;
}
thead th.th-sort{cursor:pointer;user-select:none}
thead th.th-sort:hover{color:#fff}
.si{margin-left:4px;opacity:.45;font-size:10px;transition:opacity .15s}
.th-sort:hover .si{opacity:.75}
.si.on{opacity:1;color:#60A5FA}

/* ── Table body ──────────────────────────────────── */
tbody tr{border-bottom:1px solid var(--border-l);transition:background .14s}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:rgba(241,245,249,.7)}
tbody tr.s-active  {border-left:3px solid var(--success)}
tbody tr.s-expired {border-left:3px solid var(--danger)}
tbody tr.s-disabled{border-left:3px solid var(--warning)}
tbody tr.s-deactive{border-left:3px solid #94A3B8}
tbody td{padding:10px 13px;vertical-align:top;font-size:12.5px}

/* ── Actions cell ────────────────────────────────── */
td.c-act{min-width:92px}
.act-stack{display:flex;flex-direction:column;gap:4px}
.b-pay,.b-det,.b-act,.b-cid{
  display:inline-flex;align-items:center;justify-content:center;
  gap:4px;padding:4px 8px;border-radius:4px;
  font-size:11px;font-weight:600;cursor:pointer;border:none;width:100%;
  transition:filter .15s;
}
.b-pay{background:#EF4444;color:#fff}
.b-pay:hover{filter:brightness(1.1)}
.b-cid{background:linear-gradient(135deg,#0D9488,#14B8A6);color:#fff;cursor:default}
.b-det{background:#3B82F6;color:#fff}
.b-det:hover{filter:brightness(1.1)}
.b-act{background:#475569;color:#fff;border:1px solid #334155}
.b-act:hover{background:#334155}
.act-dd{position:relative;width:100%}
.dd-panel{
  position:absolute;bottom:calc(100% + 3px);left:0;right:0;
  background:#fff;border:1px solid var(--border);border-radius:var(--r-sm);
  box-shadow:var(--sh-md);z-index:200;overflow:hidden;min-width:130px;
}
.dd-item{
  display:flex;align-items:center;gap:8px;
  padding:7px 11px;font-size:11.5px;color:var(--text2);cursor:pointer;
  transition:background .1s;
}
.dd-item:hover{background:var(--bg-alt)}
.dd-item i{width:14px;color:var(--muted);font-size:11px}
.dd-item.del{color:var(--danger)}
.dd-item.del i{color:var(--danger)}

/* ── User cell ───────────────────────────────────── */
td.c-user{min-width:140px}
.user-row{display:flex;align-items:center;gap:7px;margin-bottom:5px}
.user-row:last-child{margin-bottom:0}
.av{
  width:24px;height:24px;border-radius:50%;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;
  font-size:9px;font-weight:800;color:#fff;
}
.av-u{background:linear-gradient(135deg,#6366F1,#8B5CF6)}
.av-p{background:linear-gradient(135deg,#64748B,#475569)}
.uname{font-size:12.5px;font-weight:700;color:var(--text)}
.upass{font-size:11px;color:var(--muted);font-family:ui-monospace,monospace}

/* ── Status badge ────────────────────────────────── */
.sbadge{
  display:inline-flex;align-items:center;gap:5px;
  padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;
  white-space:nowrap;
}
.sbadge.active  {background:var(--success-l);color:#065F46}
.sbadge.expired {background:var(--danger-l);color:#991B1B}
.sbadge.disabled{background:var(--warning-l);color:#92400E}
.sbadge.deactive{background:#F1F5F9;color:#475569}
.sdot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
.sbadge.active .sdot  {background:var(--success)}
.sbadge.expired .sdot {background:var(--danger)}
.sbadge.disabled .sdot{background:var(--warning)}
.sbadge.deactive .sdot{background:#94A3B8}

/* ── Expire cell ─────────────────────────────────── */
td.c-exp{min-width:148px}
.exp-row{display:flex;align-items:center;gap:6px;font-size:11.5px;margin-bottom:3px}
.exp-lbl{font-weight:700;color:var(--muted);font-size:10px;min-width:18px}
.exp-date{color:var(--text);font-weight:500}
.exp-date.past{color:var(--danger);font-weight:600}
.b-chg{
  margin-top:6px;display:inline-flex;align-items:center;gap:4px;
  padding:3px 9px;border-radius:4px;
  background:var(--th);color:rgba(255,255,255,.75);
  border:none;cursor:pointer;font-size:10.5px;font-weight:500;
  transition:all .15s;
}
.b-chg:hover{background:#334155;color:#fff}

/* ── Bill info cell ──────────────────────────────── */
td.c-bill{min-width:168px}
.bill-rows{display:flex;flex-direction:column;gap:2.5px}
.brow{display:flex;justify-content:space-between;gap:8px;font-size:11px}
.bk{color:var(--muted)}
.bv{color:var(--text);font-weight:500}
.bv.red{color:var(--danger)}
.bdiv{border:none;border-top:1px solid var(--border-l);margin:4px 0}
.bal{
  display:flex;align-items:center;justify-content:center;gap:5px;
  padding:4px 10px;border-radius:5px;font-size:12px;font-weight:700;
  margin-top:7px;
}
.bal.adv{background:var(--success);color:#fff}
.bal.due{background:var(--danger);color:#fff}
.bal.zero{background:var(--success-l);color:#065F46}

/* ── Package cell ────────────────────────────────── */
td.c-pkg{min-width:190px}
.pkg-list{display:flex;flex-direction:column;gap:4px;margin-bottom:7px}
.pkg-pill{
  display:inline-flex;align-items:center;gap:5px;
  padding:3px 9px;border-radius:4px;
  background:linear-gradient(135deg,rgba(13,148,136,.1),rgba(20,184,166,.06));
  border:1px solid rgba(13,148,136,.2);
  font-size:10.5px;font-weight:600;color:#0D7A72;
  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:190px;
}
.b-pkg{
  display:inline-flex;align-items:center;gap:5px;
  padding:4px 10px;border-radius:4px;
  background:var(--success);color:#fff;
  border:none;cursor:pointer;font-size:11px;font-weight:600;
  transition:background .15s;
}
.b-pkg:hover{background:var(--success-d)}

/* ── POP / Manager cell ──────────────────────────── */
td.c-pm{min-width:165px}
.pm-row{display:flex;align-items:flex-start;gap:5px;font-size:11.5px;margin-bottom:4px}
.pm-row:last-child{margin-bottom:0}
.pm-lbl{font-size:10px;font-weight:700;color:var(--muted);min-width:50px;flex-shrink:0;padding-top:1px}
.pm-val{color:var(--text);font-weight:500;line-height:1.4}

/* ── Name cell ───────────────────────────────────── */
td.c-name{font-size:13px;font-weight:700;color:var(--text);min-width:90px}

/* ── Contact cell ────────────────────────────────── */
td.c-contact{min-width:130px}
.cnum{font-size:12.5px;font-weight:600;color:var(--text);letter-spacing:.3px}
.wa-chip{
  display:inline-flex;align-items:center;gap:4px;
  padding:3px 9px;border-radius:4px;
  background:#22C55E;color:#fff;
  font-size:10.5px;font-weight:700;
  margin-top:5px;border:none;cursor:pointer;
  transition:background .15s;
}
.wa-chip:hover{background:#16A34A}

/* ── Empty state ─────────────────────────────────── */
.empty{text-align:center;padding:52px 24px;color:var(--muted)}
.empty i{font-size:42px;opacity:.25;display:block;margin-bottom:12px}
.empty p{font-size:13px}

/* ── Pagination ──────────────────────────────────── */
.pbar{
  display:flex;align-items:center;justify-content:space-between;
  padding:13px 16px;border-top:1px solid var(--border);
  background:var(--bg-alt);flex-wrap:wrap;gap:10px;
}
.pinfo{font-size:12px;color:var(--muted)}
.pbtns{display:flex;gap:3px;align-items:center}
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

/* ── Responsive ──────────────────────────────────── */
@media(max-width:1024px){
  .stats{grid-template-columns:repeat(3,1fr)}
  .fg{grid-template-columns:repeat(4,1fr)}
  .fa-btns{grid-column:span 4}
}
@media(max-width:700px){
  .pw{padding:14px 12px 32px}
  .stats{grid-template-columns:repeat(2,1fr)}
  .fg{grid-template-columns:repeat(2,1fr)}
  .fa-btns{grid-column:span 2}
  .ph-title{font-size:17px}
  /* Mobile card layout */
  .tscroll{overflow-x:unset}
  table{min-width:unset}
  thead{display:none}
  tbody tr{
    display:block;border:1px solid var(--border);
    border-radius:var(--r);margin-bottom:10px;
    overflow:hidden;border-left-width:4px!important;
    background:var(--surface);
  }
  tbody td{display:block;padding:9px 13px;border-bottom:1px solid var(--border-l)}
  tbody td:last-child{border-bottom:none}
  tbody td::before{
    content:attr(data-label);
    display:block;font-size:10px;font-weight:700;
    color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:4px;
  }
  tbody td.c-act::before{display:none}
  tbody td.c-act{background:var(--bg-alt)}
  .act-stack{flex-direction:row;flex-wrap:wrap;gap:5px}
  .act-stack > *{width:auto;flex:1;min-width:60px}
  .act-dd{flex:2}
  td.c-name{font-size:14px}
}
@media(max-width:400px){
  .stats{grid-template-columns:1fr 1fr}
  .sc-val{font-size:20px}
}
</style>
</head>
<body>
<div class="pw" x-data="customerList()">

  <!-- ── Header ── -->
  <div class="ph">
    <div class="ph-left">
      <div class="ph-icon"><i class="fa-solid fa-users"></i></div>
      <div>
        <div class="ph-title">Customer List</div>
        <div class="ph-sub">Manage and monitor all ISP subscribers</div>
      </div>
    </div>
    <button class="btn-add"><i class="fa-solid fa-plus"></i> Add Client</button>
  </div>

  <!-- ── Stats ── -->
  <div class="stats">
    <div class="sc s-total">
      <div class="sc-icon"><i class="fa-solid fa-users"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Total</div>
        <div class="sc-val" x-text="stats.total"></div>
      </div>
    </div>
    <div class="sc s-active">
      <div class="sc-icon"><i class="fa-solid fa-circle-check"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Active</div>
        <div class="sc-val" x-text="stats.active"></div>
      </div>
    </div>
    <div class="sc s-expired">
      <div class="sc-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Expired</div>
        <div class="sc-val" x-text="stats.expired"></div>
      </div>
    </div>
    <div class="sc s-dis">
      <div class="sc-icon"><i class="fa-solid fa-ban"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Disable</div>
        <div class="sc-val" x-text="stats.disabled"></div>
      </div>
    </div>
    <div class="sc s-deac">
      <div class="sc-icon"><i class="fa-solid fa-toggle-off"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Deactive</div>
        <div class="sc-val" x-text="stats.deactive"></div>
      </div>
    </div>
  </div>

  <!-- ── Filters ── -->
  <div class="fb">
    <div class="fg">
      <div class="ff"><label>ID</label><input type="text" placeholder="Search ID…" x-model="search.id"></div>
      <div class="ff"><label>Contact</label><input type="text" placeholder="Contact no…" x-model="search.contact"></div>
      <div class="ff"><label>Area</label><input type="text" placeholder="Area…" x-model="search.area"></div>
      <div class="ff"><label>Box</label><input type="text" placeholder="Box…" x-model="search.box"></div>
      <div class="ff"><label>Name / User Info</label><input type="text" placeholder="Name or username…" x-model="search.nameInfo"></div>
      <div class="ff"><label>Code</label><input type="text" placeholder="Code…" x-model="search.code"></div>
      <div class="ff"><label>Username</label><input type="text" placeholder="Username…" x-model="search.username"></div>
      <div class="fa-btns">
        <button class="btn-rst" @click="resetSearch" title="Clear filters">
          <i class="fa-solid fa-rotate-left"></i> Reset
        </button>
      </div>
    </div>
  </div>

  <!-- ── Results bar ── -->
  <div class="rb">
    <div class="rb-info">
      Showing <strong x-text="paginated.length"></strong> of <strong x-text="filtered.length"></strong> customers
    </div>
    <div class="sort-wrap">
      <span class="sort-lbl">Sort:</span>
      <select class="sort-sel" x-model="sortKey">
        <option value="id_asc">ID (ascending)</option>
        <option value="id_desc">ID (descending)</option>
        <option value="name_asc">Name (A–Z)</option>
        <option value="expire_asc">Expire (earliest)</option>
        <option value="expire_desc">Expire (latest)</option>
        <option value="status">Status</option>
        <option value="bill_asc">Monthly Bill (low)</option>
        <option value="bill_desc">Monthly Bill (high)</option>
      </select>
    </div>
  </div>

  <!-- ── Table ── -->
  <div class="tw">
    <div class="tscroll">
      <table>
        <thead>
          <tr>
            <th>Actions</th>
            <th>User Name</th>
            <th>Status</th>
            <th class="th-sort" @click="cycleSort('expire')">
              Expire <i class="fa-solid fa-sort si" :class="{on:sortBy==='expire'}"></i>
            </th>
            <th>Bill Info</th>
            <th>Package</th>
            <th>POP / Manager</th>
            <th class="th-sort" @click="cycleSort('name')">
              Name <i class="fa-solid fa-sort si" :class="{on:sortBy==='name'}"></i>
            </th>
            <th>Contact</th>
          </tr>
        </thead>
        <tbody>
          <template x-if="paginated.length === 0">
            <tr><td colspan="9">
              <div class="empty">
                <i class="fa-solid fa-users-slash"></i>
                <p>No customers match your filters</p>
              </div>
            </td></tr>
          </template>
          <template x-for="c in paginated" :key="c.id">
            <tr :class="`s-${c.status}`">

              <!-- Actions -->
              <td class="c-act" data-label="Actions">
                <div class="act-stack">
                  <button class="b-pay"><i class="fa-solid fa-credit-card" style="font-size:10px"></i> Payment</button>
                  <div class="b-cid"><i class="fa-solid fa-hashtag" style="font-size:9px;opacity:.7"></i>&nbsp;CID:&nbsp;<span x-text="c.id"></span></div>
                  <button class="b-det"><i class="fa-solid fa-eye" style="font-size:10px"></i> Details</button>
                  <div class="act-dd" x-data="{open:false}">
                    <button class="b-act" @click="open=!open" style="width:100%">
                      Action
                      <i class="fa-solid" :class="open?'fa-chevron-up':'fa-chevron-down'" style="font-size:9px;margin-left:3px"></i>
                    </button>
                    <div class="dd-panel" x-show="open" x-cloak @click.outside="open=false"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100">
                      <div class="dd-item" @click="open=false"><i class="fa-solid fa-pen-to-square"></i> Edit</div>
                      <div class="dd-item" @click="open=false"><i class="fa-solid fa-rotate-right"></i> Renew</div>
                      <div class="dd-item" @click="open=false"><i class="fa-solid fa-ban"></i> Disable</div>
                      <div class="dd-item" @click="open=false"><i class="fa-solid fa-wifi"></i> PPPoE</div>
                      <div class="dd-item del" @click="open=false"><i class="fa-solid fa-trash"></i> Delete</div>
                    </div>
                  </div>
                </div>
              </td>

              <!-- Username -->
              <td class="c-user" data-label="User Name">
                <div class="user-row">
                  <div class="av av-u" x-text="c.username.slice(0,2).toUpperCase()"></div>
                  <span class="uname" x-text="c.username"></span>
                </div>
                <div class="user-row">
                  <div class="av av-p"><i class="fa-solid fa-key" style="font-size:8px"></i></div>
                  <span class="upass" x-text="c.password"></span>
                </div>
              </td>

              <!-- Status -->
              <td data-label="Status">
                <span class="sbadge" :class="c.status">
                  <span class="sdot"></span>
                  <span x-text="c.status.charAt(0).toUpperCase()+c.status.slice(1)"></span>
                </span>
              </td>

              <!-- Expire -->
              <td class="c-exp" data-label="Expire">
                <div class="exp-row">
                  <span class="exp-lbl">BD:</span>
                  <span class="exp-date" :class="c.status==='expired'?'past':''" x-text="c.expireBD"></span>
                </div>
                <div class="exp-row">
                  <span class="exp-lbl">PD:</span>
                  <span class="exp-date" :class="c.status==='expired'?'past':''" x-text="c.expirePD"></span>
                </div>
                <button class="b-chg"><i class="fa-solid fa-calendar-days" style="font-size:9px"></i> Change</button>
              </td>

              <!-- Bill Info -->
              <td class="c-bill" data-label="Bill Info">
                <div class="bill-rows">
                  <div class="brow"><span class="bk">Bill Date:</span><span class="bv" x-text="c.billDate"></span></div>
                  <div class="brow"><span class="bk">Package Rate:</span><span class="bv" x-text="c.packageRate+'.00'"></span></div>
                  <div class="brow"><span class="bk">Discount:</span><span class="bv red" x-text="c.discount+'.00'"></span></div>
                  <div class="brow"><span class="bk">Monthly Bill:</span><span class="bv" x-text="c.monthlyBill"></span></div>
                  <div class="brow"><span class="bk">OTC:</span><span class="bv" x-text="c.otc+'.00'"></span></div>
                </div>
                <div class="bal"
                  :class="c.balType==='advance' ? 'adv' : (c.balVal===0 ? 'zero' : 'due')">
                  <i :class="c.balType==='advance'?'fa-solid fa-arrow-trend-up':'fa-solid fa-arrow-trend-down'"></i>
                  <span x-text="(c.balType==='advance'?'Advance: ':'Due: ')+c.balVal+'.00'"></span>
                </div>
              </td>

              <!-- Package -->
              <td class="c-pkg" data-label="Package">
                <div class="pkg-list">
                  <template x-for="p in c.packages" :key="p">
                    <span class="pkg-pill" x-text="p"></span>
                  </template>
                </div>
                <button class="b-pkg"><i class="fa-solid fa-arrows-rotate" style="font-size:10px"></i> Package Change</button>
              </td>

              <!-- POP/Manager -->
              <td class="c-pm" data-label="POP / Manager">
                <div class="pm-row">
                  <span class="pm-lbl">Manager:</span>
                  <span class="pm-val" x-text="c.manager"></span>
                </div>
                <div class="pm-row">
                  <span class="pm-lbl">POP:</span>
                  <span class="pm-val" x-text="c.pop"></span>
                </div>
              </td>

              <!-- Name -->
              <td class="c-name" data-label="Name" x-text="c.name"></td>

              <!-- Contact -->
              <td class="c-contact" data-label="Contact">
                <div class="cnum" x-text="c.contact"></div>
                <button class="wa-chip"><i class="fa-brands fa-whatsapp"></i> WhatsApp</button>
              </td>

            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="pbar">
      <div class="pinfo" x-text="`Page ${page} of ${totalPages} — ${filtered.length} records`"></div>
      <div class="pbtns">
        <button class="pb" @click="page=1" :disabled="page===1"><i class="fa-solid fa-angles-left"></i></button>
        <button class="pb" @click="page--" :disabled="page===1"><i class="fa-solid fa-angle-left"></i></button>
        <template x-for="p in visiblePages" :key="p">
          <button class="pb" :class="{on:page===p}" @click="page=p" x-text="p"></button>
        </template>
        <button class="pb" @click="page++" :disabled="page===totalPages"><i class="fa-solid fa-angle-right"></i></button>
        <button class="pb" @click="page=totalPages" :disabled="page===totalPages"><i class="fa-solid fa-angles-right"></i></button>
      </div>
    </div>
  </div><!-- /.tw -->

</div><!-- /.pw -->

<script>
function customerList() {
  return {
    search: { id:'', contact:'', area:'', box:'', nameInfo:'', code:'', username:'' },
    sortKey: 'id_asc',
    sortBy: '',
    page: 1,
    perPage: 10,

    customers: [
      { id:6,  username:'028maminur',  password:'maya123',    status:'expired',  area:'Lalmonirhat', box:'B01', name:'maminur',  contact:'01709526706', code:'LMN-001', billDate:10, expireBD:'10-May-2026', expirePD:'10-May-2026', packageRate:525, discount:0,   monthlyBill:525, otc:0, balType:'advance', balVal:1,   packages:['Sohel-Pack-525 (525)','Lalmonirhat-2-Pack-525 (525)'], manager:'LALMONIRHAT-2', pop:'Sohel-Lahirirhat (Sub)' },
      { id:7,  username:'028aladil',   password:'Delta123',   status:'expired',  area:'Lalmonirhat', box:'B01', name:'aladil',   contact:'01773089091', code:'LMN-002', billDate:16, expireBD:'16-May-2026', expirePD:'16-May-2026', packageRate:630, discount:0,   monthlyBill:630, otc:0, balType:'due',     balVal:0,   packages:['Sohel-Pack-630 (630)','Lalmonirhat-2-Pack-630 (630)'], manager:'LALMONIRHAT-2', pop:'Sohel-Lahirirhat (Sub)' },
      { id:8,  username:'karim_net',   password:'karimPass',  status:'active',   area:'Rangpur',     box:'B02', name:'karim',    contact:'01812345678', code:'RNG-001', billDate:5,  expireBD:'05-Jul-2026', expirePD:'05-Jul-2026', packageRate:400, discount:50,  monthlyBill:400, otc:0, balType:'advance', balVal:2,   packages:['Rangpur-Pack-400 (400)'],                              manager:'RANGPUR-1',    pop:'Karim-Rangpur (Main)' },
      { id:9,  username:'rahim789',    password:'rahimX99',   status:'active',   area:'Sylhet',      box:'B03', name:'rahim',    contact:'01887654321', code:'SYL-001', billDate:1,  expireBD:'01-Aug-2026', expirePD:'01-Aug-2026', packageRate:525, discount:0,   monthlyBill:525, otc:0, balType:'advance', balVal:5,   packages:['Sylhet-Pack-525 (525)','Premium-525 (525)'],           manager:'SYLHET-1',     pop:'Main-POP (Sub)' },
      { id:10, username:'sumon123',    password:'sumon456',   status:'expired',  area:'Lalmonirhat', box:'B01', name:'sumon',    contact:'01711223344', code:'LMN-003', billDate:20, expireBD:'20-Apr-2026', expirePD:'20-Apr-2026', packageRate:300, discount:0,   monthlyBill:300, otc:0, balType:'due',     balVal:300, packages:['Sohel-Pack-300 (300)'],                                manager:'LALMONIRHAT-1', pop:'North-POP (Main)' },
      { id:11, username:'jahid_net',   password:'jahid789',   status:'active',   area:'Rangpur',     box:'B04', name:'jahid',    contact:'01966778899', code:'RNG-002', billDate:12, expireBD:'12-Jul-2026', expirePD:'12-Jul-2026', packageRate:630, discount:0,   monthlyBill:630, otc:0, balType:'advance', balVal:3,   packages:['Rangpur-Pack-630 (630)'],                              manager:'RANGPUR-1',    pop:'Karim-Rangpur (Main)' },
      { id:12, username:'faruk_isp',   password:'faruk001',   status:'disabled', area:'Sylhet',      box:'B05', name:'faruk',    contact:'01533445566', code:'SYL-002', billDate:8,  expireBD:'08-Jun-2026', expirePD:'08-Jun-2026', packageRate:400, discount:0,   monthlyBill:400, otc:0, balType:'due',     balVal:400, packages:['Sylhet-Pack-400 (400)'],                              manager:'SYLHET-1',     pop:'City-POP (Sub)' },
      { id:13, username:'hasan2026',   password:'hasan_x',    status:'expired',  area:'Lalmonirhat', box:'B02', name:'hasan',    contact:'01622334455', code:'LMN-004', billDate:25, expireBD:'25-May-2026', expirePD:'25-May-2026', packageRate:525, discount:0,   monthlyBill:525, otc:0, balType:'due',     balVal:0,   packages:['Sohel-Pack-525 (525)'],                                manager:'LALMONIRHAT-2', pop:'East-POP (Main)' },
      { id:14, username:'noman_user',  password:'noman456',   status:'deactive', area:'Rangpur',     box:'B03', name:'noman',    contact:'01755667788', code:'RNG-003', billDate:3,  expireBD:'03-Mar-2026', expirePD:'03-Mar-2026', packageRate:300, discount:0,   monthlyBill:300, otc:0, balType:'due',     balVal:300, packages:['Rangpur-Pack-300 (300)'],                              manager:'RANGPUR-2',    pop:'West-POP (Sub)' },
      { id:15, username:'liton_bd',    password:'liton789',   status:'active',   area:'Sylhet',      box:'B06', name:'liton',    contact:'01844556677', code:'SYL-003', billDate:18, expireBD:'18-Aug-2026', expirePD:'18-Aug-2026', packageRate:630, discount:100, monthlyBill:630, otc:0, balType:'advance', balVal:10,  packages:['Sylhet-Pack-630 (630)','Ultra-HD-Pack (630)'],         manager:'SYLHET-2',     pop:'Premium-POP (Sub)' },
      { id:16, username:'rony_isp',    password:'ronyPass',   status:'expired',  area:'Lalmonirhat', box:'B04', name:'rony',     contact:'01911223344', code:'LMN-005', billDate:14, expireBD:'14-May-2026', expirePD:'14-May-2026', packageRate:400, discount:0,   monthlyBill:400, otc:0, balType:'due',     balVal:0,   packages:['LMN-Pack-400 (400)'],                                  manager:'LALMONIRHAT-1', pop:'South-POP (Main)' },
      { id:17, username:'kabir_net',   password:'kabir2026',  status:'active',   area:'Sylhet',      box:'B07', name:'kabir',    contact:'01677889900', code:'SYL-004', billDate:22, expireBD:'22-Jul-2026', expirePD:'22-Jul-2026', packageRate:525, discount:0,   monthlyBill:525, otc:0, balType:'advance', balVal:7,   packages:['Sylhet-Pack-525 (525)'],                               manager:'SYLHET-1',     pop:'Main-POP (Sub)' },
      { id:18, username:'tariq2026',   password:'tariqX1',    status:'expired',  area:'Rangpur',     box:'B05', name:'tariq',    contact:'01799001122', code:'RNG-004', billDate:7,  expireBD:'07-Apr-2026', expirePD:'07-Apr-2026', packageRate:300, discount:0,   monthlyBill:300, otc:0, balType:'due',     balVal:300, packages:['Rangpur-Pack-300 (300)'],                              manager:'RANGPUR-2',    pop:'East-POP (Sub)' },
      { id:19, username:'arif_usr',    password:'arif2025',   status:'active',   area:'Lalmonirhat', box:'B06', name:'arif',     contact:'01600112233', code:'LMN-006', billDate:9,  expireBD:'09-Aug-2026', expirePD:'09-Aug-2026', packageRate:630, discount:50,  monthlyBill:630, otc:0, balType:'advance', balVal:4,   packages:['LMN-Pack-630 (630)','Fast-LMN (630)'],                 manager:'LALMONIRHAT-2', pop:'Sohel-Lahirirhat (Sub)' },
    ],

    init() {
      this.$watch('search', () => { this.page = 1 }, { deep: true });
      this.$watch('sortKey', () => { this.page = 1 });
    },

    get stats() {
      const c = this.customers;
      return {
        total:    c.length,
        active:   c.filter(x => x.status==='active').length,
        expired:  c.filter(x => x.status==='expired').length,
        disabled: c.filter(x => x.status==='disabled').length,
        deactive: c.filter(x => x.status==='deactive').length,
      };
    },

    get filtered() {
      const s = this.search;
      let list = this.customers.filter(c => {
        if (s.id       && !String(c.id).includes(s.id.trim())) return false;
        if (s.contact  && !c.contact.includes(s.contact.trim())) return false;
        if (s.area     && !c.area.toLowerCase().includes(s.area.toLowerCase())) return false;
        if (s.box      && !c.box.toLowerCase().includes(s.box.toLowerCase())) return false;
        if (s.nameInfo && !c.name.toLowerCase().includes(s.nameInfo.toLowerCase())
                       && !c.username.toLowerCase().includes(s.nameInfo.toLowerCase())) return false;
        if (s.code     && !c.code.toLowerCase().includes(s.code.toLowerCase())) return false;
        if (s.username && !c.username.toLowerCase().includes(s.username.toLowerCase())) return false;
        return true;
      });
      const k = this.sortKey;
      return [...list].sort((a,b) => {
        if (k==='id_asc')     return a.id - b.id;
        if (k==='id_desc')    return b.id - a.id;
        if (k==='name_asc')   return a.name.localeCompare(b.name);
        if (k==='expire_asc') return a.expireBD.localeCompare(b.expireBD);
        if (k==='expire_desc')return b.expireBD.localeCompare(a.expireBD);
        if (k==='status')     return a.status.localeCompare(b.status);
        if (k==='bill_asc')   return a.monthlyBill - b.monthlyBill;
        if (k==='bill_desc')  return b.monthlyBill - a.monthlyBill;
        return 0;
      });
    },

    get paginated() {
      const s = (this.page-1)*this.perPage;
      return this.filtered.slice(s, s+this.perPage);
    },

    get totalPages() {
      return Math.max(1, Math.ceil(this.filtered.length/this.perPage));
    },

    get visiblePages() {
      const t = this.totalPages, c = this.page;
      let s = Math.max(1, c-2), e = Math.min(t, s+4);
      if (e-s<4) s = Math.max(1, e-4);
      const ps = [];
      for (let i=s; i<=e; i++) ps.push(i);
      return ps;
    },

    cycleSort(field) {
      if (this.sortBy===field) {
        const cur = this.sortKey.endsWith('desc') ? 'asc' : 'desc';
        this.sortKey = `${field}_${cur}`;
      } else {
        this.sortBy = field;
        this.sortKey = `${field}_asc`;
      }
    },

    resetSearch() {
      this.search = { id:'', contact:'', area:'', box:'', nameInfo:'', code:'', username:'' };
      this.page = 1;
    },
  };
}
</script>
</body>
</html>
