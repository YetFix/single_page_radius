<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Token Dashboard</title>
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
  --success:#10B981; --success-l:#D1FAE5;
  --danger:#EF4444;  --danger-l:#FEE2E2;
  --warning:#F59E0B; --warning-l:#FEF3C7;
  --text:#0F172A; --text2:#1E293B; --muted:#64748B; --light:#94A3B8;
  --border:#E2E8F0; --border-l:#F1F5F9;
  --surface:#FFFFFF; --bg:#F1F5F9; --bg-alt:#F8FAFC;
  --th:#1E293B;
  --sh-sm:0 1px 3px rgba(0,0,0,.06);
  --sh:0 4px 14px rgba(0,0,0,.09);
  --sh-lg:0 8px 28px rgba(0,0,0,.12);
  --r:12px; --r-sm:6px; --r-lg:14px;
}
html{font-family:'Inter',sans-serif;font-size:14px}
body{background:var(--bg);color:var(--text);min-height:100vh}
[x-cloak]{display:none!important}

/* ── Page ────────────────────────────────────────── */
.pw{max-width:1600px;margin:0 auto;padding:24px 20px 48px}

/* ── Header ──────────────────────────────────────── */
.ph{display:flex;align-items:center;gap:14px;margin-bottom:24px}
.ph-icon{
  width:44px;height:44px;border-radius:12px;flex-shrink:0;
  background:linear-gradient(135deg,#1E293B 0%,#475569 100%);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:18px;
  box-shadow:0 4px 14px rgba(30,41,59,.35);
}
.ph-title{font-size:22px;font-weight:800;color:var(--text);line-height:1.2}
.ph-sub{font-size:12px;color:var(--muted);margin-top:1px}

/* ── KPI cards ───────────────────────────────────── */
.kpi-grid4{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:10px}
.kpi-grid3{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:24px}

.kpi{
  border-radius:10px;padding:13px 15px;
  display:flex;align-items:center;gap:13px;
  position:relative;overflow:hidden;
  box-shadow:0 3px 10px rgba(0,0,0,.14);
  transition:transform .18s,box-shadow .18s;cursor:default;
}
.kpi:hover{transform:translateY(-2px);box-shadow:0 7px 20px rgba(0,0,0,.2)}
.kpi::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(255,255,255,.13) 0%,transparent 65%);
  pointer-events:none;
}

/* gradients */
.kpi-slate{background:linear-gradient(135deg,#52525B,#3F3F46)}
.kpi-blue {background:linear-gradient(135deg,#2563EB,#1D4ED8)}
.kpi-teal {background:linear-gradient(135deg,#0D9488,#0F766E)}
.kpi-green{background:linear-gradient(135deg,#16A34A,#15803D)}
.kpi-amber{background:linear-gradient(135deg,#D97706,#B45309)}
.kpi-red  {background:linear-gradient(135deg,#DC2626,#B91C1C)}

/* icon box */
.kpi-iw{
  width:42px;height:42px;border-radius:9px;flex-shrink:0;
  background:rgba(255,255,255,.18);
  display:flex;align-items:center;justify-content:center;
  font-size:17px;color:rgba(255,255,255,.92);
}
/* text */
.kpi-body{flex:1;min-width:0}
.kpi-lbl{
  font-size:10px;font-weight:600;color:rgba(255,255,255,.68);
  text-transform:uppercase;letter-spacing:.5px;line-height:1.3;margin-bottom:3px;
}
.kpi-val{font-size:24px;font-weight:800;color:#fff;line-height:1;letter-spacing:-.5px}

/* ── Summary section ─────────────────────────────── */
.section{
  background:var(--surface);border-radius:var(--r-lg);
  border:1px solid var(--border);box-shadow:var(--sh);overflow:hidden;
}
.section-head{
  display:flex;align-items:center;gap:10px;
  padding:14px 18px;
  background:var(--th);color:#fff;
}
.section-head i{font-size:16px;opacity:.8}
.section-head h2{font-size:14px;font-weight:700;letter-spacing:.3px}

/* ── Toolbar ─────────────────────────────────────── */
.tb{
  display:flex;align-items:center;justify-content:space-between;
  padding:14px 18px;border-bottom:1px solid var(--border-l);
  background:var(--bg-alt);flex-wrap:wrap;gap:10px;
}
.tb-left{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted)}
.show-sel{
  height:30px;padding:0 8px;border:1px solid var(--border);border-radius:var(--r-sm);
  font-size:12.5px;font-family:inherit;color:var(--text);
  background:var(--surface);outline:none;cursor:pointer;
}
.tb-right{display:flex;align-items:center;gap:8px;font-size:13px;font-weight:600;color:var(--text2)}
.search-wrap{position:relative}
.search-wrap i{position:absolute;left:9px;top:50%;transform:translateY(-50%);color:var(--light);font-size:11px;pointer-events:none}
.search-input{
  height:30px;padding:0 10px 0 28px;border:1px solid var(--border);border-radius:var(--r-sm);
  font-size:12.5px;font-family:inherit;color:var(--text);
  background:var(--surface);outline:none;width:190px;
  transition:border-color .15s,box-shadow .15s,width .2s;
}
.search-input:focus{
  border-color:var(--primary-l);
  box-shadow:0 0 0 3px rgba(59,130,246,.12);
  width:220px;
}

/* ── Table ───────────────────────────────────────── */
.tscroll{overflow-x:auto;-webkit-overflow-scrolling:touch}
table{width:100%;border-collapse:collapse;min-width:860px}
thead th{
  background:var(--th);color:rgba(255,255,255,.82);
  font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;
  padding:11px 14px;text-align:left;white-space:nowrap;
}
thead th.th-c{text-align:center}
tbody tr{border-bottom:1px solid var(--border-l);transition:background .14s}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:rgba(241,245,249,.8)}
tbody td{padding:12px 14px;vertical-align:middle;font-size:13px}
tbody td.td-c{text-align:center}

.row-num{
  display:inline-flex;align-items:center;justify-content:center;
  width:26px;height:26px;border-radius:6px;
  background:var(--border-l);color:var(--muted);font-size:11.5px;font-weight:700;
}
.pop-name{font-size:13px;font-weight:700;color:var(--text)}

/* stat cells */
.stat-cell{text-align:center;font-size:13px;font-weight:600;color:var(--text)}
.stat-cell.zero{color:var(--light)}
.stat-cell .badge{
  display:inline-flex;align-items:center;justify-content:center;
  min-width:28px;height:22px;padding:0 7px;border-radius:11px;
  font-size:11.5px;font-weight:700;
}
.badge-blue  {background:rgba(37,99,235,.1);color:#1D4ED8}
.badge-green {background:var(--success-l);color:#065F46}
.badge-amber {background:var(--warning-l);color:#92400E}
.badge-red   {background:var(--danger-l);color:#991B1B}
.badge-grey  {background:var(--border-l);color:var(--muted)}

/* Empty state */
.empty{text-align:center;padding:48px 24px;color:var(--muted)}
.empty i{font-size:40px;opacity:.2;display:block;margin-bottom:12px}
.empty p{font-size:13px}

/* ── Pagination ──────────────────────────────────── */
.pbar{
  display:flex;align-items:center;justify-content:space-between;
  padding:12px 18px;border-top:1px solid var(--border-l);
  background:var(--bg-alt);flex-wrap:wrap;gap:10px;
}
.pinfo{font-size:12px;color:var(--muted)}
.pinfo strong{color:var(--text);font-weight:600}
.pbtns{display:flex;gap:3px;align-items:center}
.pb-lbl{height:32px;padding:0 10px;display:inline-flex;align-items:center;font-size:12px;color:var(--muted)}
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
@media(max-width:1100px){
  .kpi-grid4{grid-template-columns:repeat(2,1fr)}
  .kpi-grid3{grid-template-columns:repeat(3,1fr)}
}
@media(max-width:700px){
  .pw{padding:14px 12px 32px}
  .kpi-grid4,.kpi-grid3{grid-template-columns:repeat(2,1fr);gap:8px}
  .kpi{padding:11px 12px;gap:10px}
  .kpi-iw{width:36px;height:36px;font-size:14px;border-radius:7px}
  .kpi-val{font-size:20px}
  .ph-title{font-size:18px}
}
@media(max-width:400px){
  .kpi-grid4,.kpi-grid3{grid-template-columns:1fr}
}
</style>
</head>
<body>
<div class="pw" x-data="tokenDash()">

  <!-- ── Header ── -->
  <div class="ph">
    <div class="ph-icon"><i class="fa-solid fa-ticket"></i></div>
    <div>
      <div class="ph-title">Token Dashboard</div>
      <div class="ph-sub">Overview of support tokens and POP-wise summary</div>
    </div>
  </div>

  <!-- ── KPI row 1 (4 cards) ── -->
  <div class="kpi-grid4">
    <div class="kpi kpi-slate">
      <div class="kpi-iw"><i class="fa-solid fa-calendar-days"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Last Month Total Tokens</div>
        <div class="kpi-val" x-text="stats.lastMonth"></div>
      </div>
    </div>
    <div class="kpi kpi-blue">
      <div class="kpi-iw"><i class="fa-solid fa-calendar"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">This Month Total Tokens</div>
        <div class="kpi-val" x-text="stats.thisMonth"></div>
      </div>
    </div>
    <div class="kpi kpi-teal">
      <div class="kpi-iw"><i class="fa-solid fa-folder-open"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Open Tokens</div>
        <div class="kpi-val" x-text="stats.open"></div>
      </div>
    </div>
    <div class="kpi kpi-green">
      <div class="kpi-iw"><i class="fa-solid fa-user-check"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Assigned (Open)</div>
        <div class="kpi-val" x-text="stats.assigned"></div>
      </div>
    </div>
  </div>

  <!-- ── KPI row 2 (3 cards) ── -->
  <div class="kpi-grid3">
    <div class="kpi kpi-amber">
      <div class="kpi-iw"><i class="fa-solid fa-user-clock"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Unassigned (Open)</div>
        <div class="kpi-val" x-text="stats.unassigned"></div>
      </div>
    </div>
    <div class="kpi kpi-slate">
      <div class="kpi-iw"><i class="fa-solid fa-clock"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">No Update (1hr+)</div>
        <div class="kpi-val" x-text="stats.noUpdate"></div>
      </div>
    </div>
    <div class="kpi kpi-red">
      <div class="kpi-iw"><i class="fa-solid fa-triangle-exclamation"></i></div>
      <div class="kpi-body">
        <div class="kpi-lbl">Due Time Over</div>
        <div class="kpi-val" x-text="stats.dueOver"></div>
      </div>
    </div>
  </div>

  <!-- ── Token Summary by POP ── -->
  <div class="section">

    <!-- Section header -->
    <div class="section-head">
      <i class="fa-solid fa-chart-bar"></i>
      <h2>Token Summary by POP</h2>
    </div>

    <!-- Toolbar -->
    <div class="tb">
      <div class="tb-left">
        <span>Show</span>
        <select class="show-sel" x-model.number="perPage">
          <option value="10">10</option>
          <option value="25">25</option>
          <option value="50">50</option>
          <option value="100">100</option>
          <option value="500">500</option>
        </select>
        <span>entries</span>
      </div>
      <div class="tb-right">
        <span>Search:</span>
        <div class="search-wrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" class="search-input" x-model="search" placeholder="POP name…">
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="tscroll">
      <table>
        <thead>
          <tr>
            <th class="th-c">#</th>
            <th>POP Name</th>
            <th class="th-c">Last Month<br>Total Created</th>
            <th class="th-c">This Month<br>Total Created</th>
            <th class="th-c">Open</th>
            <th class="th-c">Assigned</th>
            <th class="th-c">Unassigned</th>
            <th class="th-c">No Update More<br>Than One Hour</th>
            <th class="th-c">Due Time<br>Over</th>
          </tr>
        </thead>
        <tbody>
          <template x-if="paginated.length === 0">
            <tr>
              <td colspan="9">
                <div class="empty">
                  <i class="fa-solid fa-ticket"></i>
                  <p x-show="search">No POPs match "<span x-text="search"></span>"</p>
                  <p x-show="!search">No POP data available.</p>
                </div>
              </td>
            </tr>
          </template>
          <template x-for="(p, i) in paginated" :key="p.id">
            <tr>
              <td class="td-c">
                <span class="row-num" x-text="p.id"></span>
              </td>
              <td>
                <span class="pop-name" x-text="p.name"></span>
              </td>
              <td class="td-c">
                <span class="stat-cell">
                  <span class="badge badge-grey" x-text="p.lastMonth"></span>
                </span>
              </td>
              <td class="td-c">
                <span class="stat-cell">
                  <span class="badge badge-blue" x-text="p.thisMonth"></span>
                </span>
              </td>
              <td class="td-c">
                <span class="badge" :class="p.open>0?'badge-blue':'badge-grey'" x-text="p.open"></span>
              </td>
              <td class="td-c">
                <span class="badge" :class="p.assigned>0?'badge-green':'badge-grey'" x-text="p.assigned"></span>
              </td>
              <td class="td-c">
                <span class="badge" :class="p.unassigned>0?'badge-amber':'badge-grey'" x-text="p.unassigned"></span>
              </td>
              <td class="td-c">
                <span class="badge" :class="p.noUpdate>0?'badge-amber':'badge-grey'" x-text="p.noUpdate"></span>
              </td>
              <td class="td-c">
                <span class="badge" :class="p.dueOver>0?'badge-red':'badge-grey'" x-text="p.dueOver"></span>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="pbar">
      <div class="pinfo">
        <template x-if="filtered.length === 0">
          <span>No entries</span>
        </template>
        <template x-if="filtered.length > 0">
          <span>
            Showing <strong x-text="(page-1)*perPage+1"></strong>
            to <strong x-text="Math.min(page*perPage, filtered.length)"></strong>
            of <strong x-text="filtered.length"></strong> entries
          </span>
        </template>
      </div>
      <div class="pbtns">
        <span class="pb-lbl">Previous</span>
        <template x-for="p in visiblePages" :key="p">
          <button class="pb" :class="{on:page===p}" @click="page=p" x-text="p"></button>
        </template>
        <span class="pb-lbl">Next</span>
      </div>
    </div>

  </div><!-- /.section -->

</div><!-- /.pw -->

<script>
function tokenDash() {
  return {
    search: '',
    perPage: 500,
    page: 1,

    pops: [
      { id:1, name:'Rangpur-Main',     lastMonth:15, thisMonth:11, open:4, assigned:3, unassigned:1, noUpdate:2, dueOver:0 },
      { id:2, name:'Lalmonirhat-2',    lastMonth:12, thisMonth:8,  open:3, assigned:2, unassigned:1, noUpdate:1, dueOver:0 },
      { id:3, name:'Sohel-Lahirirhat', lastMonth:7,  thisMonth:5,  open:2, assigned:1, unassigned:1, noUpdate:0, dueOver:1 },
      { id:4, name:'Sylhet-Central',   lastMonth:9,  thisMonth:6,  open:1, assigned:1, unassigned:0, noUpdate:0, dueOver:0 },
      { id:5, name:'Dhaka-North',      lastMonth:21, thisMonth:14, open:5, assigned:4, unassigned:1, noUpdate:3, dueOver:1 },
      { id:6, name:'Chittagong-1',     lastMonth:11, thisMonth:7,  open:2, assigned:2, unassigned:0, noUpdate:1, dueOver:0 },
    ],

    init() {
      this.$watch('search', () => { this.page = 1 });
      this.$watch('perPage', () => { this.page = 1 });
    },

    get stats() {
      return this.pops.reduce((acc, p) => ({
        lastMonth:  acc.lastMonth  + p.lastMonth,
        thisMonth:  acc.thisMonth  + p.thisMonth,
        open:       acc.open       + p.open,
        assigned:   acc.assigned   + p.assigned,
        unassigned: acc.unassigned + p.unassigned,
        noUpdate:   acc.noUpdate   + p.noUpdate,
        dueOver:    acc.dueOver    + p.dueOver,
      }), { lastMonth:0, thisMonth:0, open:0, assigned:0, unassigned:0, noUpdate:0, dueOver:0 });
    },

    get filtered() {
      const q = this.search.toLowerCase();
      return q ? this.pops.filter(p => p.name.toLowerCase().includes(q)) : this.pops;
    },

    get paginated() {
      const s = (this.page-1)*this.perPage;
      return this.filtered.slice(s, s+this.perPage);
    },

    get totalPages() {
      return Math.max(1, Math.ceil(this.filtered.length/this.perPage));
    },

    get visiblePages() {
      const t=this.totalPages, c=this.page;
      let s=Math.max(1,c-2), e=Math.min(t,s+4);
      if(e-s<4) s=Math.max(1,e-4);
      const ps=[]; for(let i=s;i<=e;i++) ps.push(i); return ps;
    },
  };
}
</script>
</body>
</html>
