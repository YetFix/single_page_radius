<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Online Customer List</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
:root{
  --primary:#6366f1;--primary-dark:#4f46e5;--primary-light:#eef2ff;
  --success:#10b981;--danger:#ef4444;--warning:#f59e0b;--info:#06b6d4;
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
.page-title i{color:var(--success)}

/* card */
.card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--border);overflow:hidden}

/* filter card */
.filter-card{padding:22px;margin-bottom:18px}
.filter-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:12px}
.ff{display:flex;flex-direction:column;gap:7px}
.ff label{font-size:13px;font-weight:700;color:var(--text)}
.ff select,.ff input{padding:9px 10px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;color:var(--text);outline:none;transition:.15s;width:100%;background:#fff;min-width:0}
.ff select{appearance:none;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 10px center;padding-right:26px;cursor:pointer}
.ff select:focus,.ff input:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1)}
.ff input::placeholder{color:#94a3b8}
.filter-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px}
.btn{display:inline-flex;align-items:center;gap:7px;padding:10px 22px;border:none;border-radius:9px;font-size:14px;font-weight:700;cursor:pointer;transition:.18s;white-space:nowrap}
.btn:hover{transform:translateY(-1px);filter:brightness(1.08)}
.btn:disabled{opacity:.55;cursor:not-allowed;transform:none;filter:none}
.btn-search{background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;box-shadow:0 3px 10px rgba(59,130,246,.35)}
.btn-reset{background:linear-gradient(135deg,#64748b,#475569);color:#fff;box-shadow:0 3px 10px rgba(100,116,139,.3)}

/* note banner */
.note-banner{display:flex;align-items:flex-start;gap:10px;background:#fbbf24;border:1px solid #f59e0b;border-radius:10px;padding:14px 18px;margin-bottom:18px;font-size:14px;line-height:1.6;color:#451a03}
.note-banner i{color:#b91c1c;font-size:15px;margin-top:3px;flex-shrink:0}
.note-banner strong{font-weight:800}

/* toolbar */
.toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 22px;border-bottom:1px solid var(--border);flex-wrap:wrap}
.toolbar-left{display:flex;align-items:center;gap:8px}
.show-lbl{font-size:13px;color:var(--muted);font-weight:600}
.show-sel{padding:5px 28px 5px 10px;border:1.5px solid var(--border);border-radius:7px;font-size:13px;color:var(--text);background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 9px center;appearance:none;cursor:pointer;outline:none}
.show-sel:focus{border-color:var(--primary)}
.search-wrap{display:flex;align-items:center;gap:8px}
.search-wrap .search-lbl{font-size:13px;color:var(--muted);font-weight:600}
.search-inp{padding:7px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;width:220px;outline:none;transition:.2s;color:var(--text)}
.search-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1)}

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
.user-cell{font-weight:600;color:var(--text);font-size:13px}
.ip-cell{font-family:'SF Mono','Fira Code',monospace;font-size:12px;font-weight:600;color:var(--text);background:#f1f5f9;padding:3px 8px;border-radius:6px;border:1px solid var(--border);display:inline-block}
.mac-cell{font-family:'SF Mono','Fira Code',monospace;font-size:11px;color:var(--muted)}
.uptime-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;background:#fef3c7;color:#92400e;border-radius:5px;font-size:11px;font-weight:700}
.rx-val{color:var(--info);font-weight:600;font-size:12px}
.tx-val{color:#8b5cf6;font-weight:600;font-size:12px}
.status-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;white-space:nowrap}
.st-online{background:#d1fae5;color:#065f46;border:1px solid #a7f3d0}
.st-online::before{content:'';display:inline-block;width:7px;height:7px;border-radius:50%;background:#10b981;animation:pulse 1.5s ease-in-out infinite}
.st-offline{background:#fee2e2;color:#b91c1c;border:1px solid #fecaca}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}

/* footer / pagination */
.tbl-footer{display:flex;align-items:center;justify-content:space-between;padding:12px 22px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
.tbl-info{font-size:12px;color:var(--muted)}
.tbl-info strong{color:var(--text)}
.pagination{display:flex;gap:4px;align-items:center}
.pg-btn{min-width:32px;height:32px;padding:0 12px;display:flex;align-items:center;justify-content:center;border-radius:8px;border:1.5px solid var(--border);background:#fff;font-size:12px;font-weight:600;cursor:pointer;color:var(--muted);transition:.15s}
.pg-btn:hover{border-color:var(--primary);color:var(--primary)}
.pg-btn.active{background:var(--primary);border-color:var(--primary);color:#fff}
.pg-btn:disabled{opacity:.4;cursor:not-allowed}

/* empty */
.empty-row td{text-align:center;padding:50px;color:var(--muted);font-size:13px}
.empty-row i{font-size:32px;display:block;margin-bottom:10px;opacity:.2}

/* searching spinner */
.searching-row td{text-align:center;padding:50px;color:var(--muted);font-size:13px}
.searching-row i{font-size:26px;display:block;margin-bottom:10px;color:var(--primary)}

/* responsive */
@media(max-width:1100px){.filter-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:850px){.filter-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:600px){
  .filter-grid{grid-template-columns:1fr}
  .toolbar{flex-direction:column;align-items:stretch}
  .search-inp{width:100%}
  .tbl-footer{flex-direction:column;align-items:flex-start}
  .filter-actions{flex-direction:column}
}
</style>
</head>
<body>
<div class="page" x-data="onlineApp()" x-cloak>

  <!-- Header -->
  <div class="page-head">
    <div class="page-title"><i class="fa-solid fa-wifi"></i> Online Customer List</div>
  </div>

  <!-- Filter Card -->
  <div class="card filter-card">
    <div class="filter-grid">
      <div class="ff">
        <label>Select Manager</label>
        <select x-model="filters.manager">
          <option value="">Select an option</option>
          <template x-for="m in managers" :key="m"><option :value="m" x-text="m"></option></template>
        </select>
      </div>
      <div class="ff">
        <label>Select POP</label>
        <select x-model="filters.pop">
          <option value="">Select an option</option>
          <template x-for="p in pops" :key="p"><option :value="p" x-text="p"></option></template>
        </select>
      </div>
      <div class="ff">
        <label>Select Area</label>
        <select x-model="filters.area">
          <option value="">Select an option</option>
          <template x-for="a in areas" :key="a"><option :value="a" x-text="a"></option></template>
        </select>
      </div>
      <div class="ff">
        <label>Status</label>
        <select x-model="filters.status">
          <option value="">Select an option</option>
          <option value="Online">Online</option>
          <option value="Offline">Offline</option>
        </select>
      </div>
      <div class="ff">
        <label>Username</label>
        <input type="text" x-model="filters.username" placeholder="Enter username" @keydown.enter="doSearch()">
      </div>
    </div>
    <div class="filter-actions">
      <button class="btn btn-search" @click="doSearch()" :disabled="searching">
        <i class="fa-solid fa-magnifying-glass"></i> Search
      </button>
      <button class="btn btn-reset" @click="doReset()">
        <i class="fa-solid fa-rotate-left"></i> Reset
      </button>
    </div>
  </div>

  <!-- Note banner -->
  <div class="note-banner">
    <i class="fa-solid fa-triangle-exclamation"></i>
    <div><strong>Note:</strong> যদি অনলাইন রেজাল্ট না দেখায়, তাহলে POP-এর MikroTik সফটওয়্যারের সাথে সংযুক্ত আছে কিনা তা চেক করুন। সমস্যা সমাধান না হলে নেটওয়ার্ক ইঞ্জিনিয়ারের সাথে যোগাযোগ করুন।</div>
  </div>

  <!-- Results Card -->
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
        <span class="search-lbl">Search:</span>
        <input class="search-inp" type="text" x-model="search" @input="page=1">
      </div>
    </div>

    <div class="tbl-wrap">
      <table>
        <thead>
          <tr>
            <th style="width:54px">Id</th>
            <th>Username</th>
            <th>IP Address</th>
            <th>MAC Address</th>
            <th>Manager</th>
            <th>POP</th>
            <th>Area</th>
            <th>Uptime</th>
            <th>Download</th>
            <th>Upload</th>
            <th style="width:100px">Status</th>
          </tr>
        </thead>
        <tbody>
          <template x-if="searching">
            <tr class="searching-row"><td colspan="11"><i class="fa-solid fa-spinner fa-spin"></i>Searching online customers…</td></tr>
          </template>
          <template x-if="!searching && paged.length===0">
            <tr class="empty-row"><td colspan="11"><i class="fa-solid fa-wifi"></i>No data available in table</td></tr>
          </template>
          <template x-for="r in paged" :key="r.id">
            <tr>
              <td><span class="id-cell" x-text="r.id"></span></td>
              <td><span class="user-cell" x-text="r.username"></span></td>
              <td><span class="ip-cell" x-text="r.ip"></span></td>
              <td><span class="mac-cell" x-text="r.mac"></span></td>
              <td x-text="r.manager"></td>
              <td x-text="r.pop"></td>
              <td x-text="r.area"></td>
              <td><span class="uptime-badge"><i class="fa-regular fa-clock"></i><span x-text="r.uptime"></span></span></td>
              <td><span class="rx-val"><i class="fa-solid fa-arrow-down" style="font-size:10px"></i> <span x-text="r.download"></span></span></td>
              <td><span class="tx-val"><i class="fa-solid fa-arrow-up" style="font-size:10px"></i> <span x-text="r.upload"></span></span></td>
              <td>
                <span class="status-badge" :class="r.status==='Online'?'st-online':'st-offline'" x-text="r.status"></span>
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
        <button class="pg-btn" @click="page--" :disabled="page<=1">Previous</button>
        <template x-for="p in visiblePages" :key="p">
          <button class="pg-btn" :class="{active:p===page}" @click="p!=='…'&&(page=p)" x-text="p"></button>
        </template>
        <button class="pg-btn" @click="page++" :disabled="page>=totalPages">Next</button>
      </div>
    </div>
  </div>

</div>

<script>
function onlineApp(){
  return {
    managers:['Karim Traders','Net Vision','Delta ISP'],
    pops:['Dhaka POP-1','Dhaka POP-2','Mirpur POP','Rangpur POP'],
    areas:['Dhanmondi','Mirpur-10','Ashulia','Rangpur Sadar'],
    allCustomers:[
      {id:1,username:'rahim01',ip:'10.10.1.21',mac:'D4:CA:6D:11:2A:31',manager:'Karim Traders',pop:'Dhaka POP-1',area:'Dhanmondi',uptime:'2d 14h 22m',download:'1.2 GB',upload:'310 MB',status:'Online'},
      {id:2,username:'fahad22',ip:'10.10.1.45',mac:'D4:CA:6D:43:9B:02',manager:'Karim Traders',pop:'Dhaka POP-1',area:'Dhanmondi',uptime:'11h 05m',download:'640 MB',upload:'120 MB',status:'Online'},
      {id:3,username:'sumon_x',ip:'10.10.2.18',mac:'48:8F:5A:77:C1:9D',manager:'Net Vision',pop:'Dhaka POP-2',area:'Mirpur-10',uptime:'5d 02h 41m',download:'8.4 GB',upload:'1.1 GB',status:'Online'},
      {id:4,username:'akash99',ip:'10.10.2.77',mac:'48:8F:5A:12:F4:60',manager:'Net Vision',pop:'Dhaka POP-2',area:'Mirpur-10',uptime:'—',download:'—',upload:'—',status:'Offline'},
      {id:5,username:'mirpur_user1',ip:'172.16.5.11',mac:'CC:2D:E0:55:8A:13',manager:'Delta ISP',pop:'Mirpur POP',area:'Mirpur-10',uptime:'1d 03h 09m',download:'2.9 GB',upload:'540 MB',status:'Online'},
      {id:6,username:'mirpur_user2',ip:'172.16.5.32',mac:'CC:2D:E0:91:0C:77',manager:'Delta ISP',pop:'Mirpur POP',area:'Mirpur-10',uptime:'—',download:'—',upload:'—',status:'Offline'},
      {id:7,username:'sohel_rng',ip:'10.10.9.14',mac:'E4:8D:8C:33:51:AB',manager:'Karim Traders',pop:'Rangpur POP',area:'Rangpur Sadar',uptime:'7d 19h 55m',download:'14.7 GB',upload:'2.3 GB',status:'Online'},
      {id:8,username:'ashulia_n1',ip:'10.10.9.61',mac:'E4:8D:8C:02:7E:44',manager:'Net Vision',pop:'Rangpur POP',area:'Ashulia',uptime:'9h 47m',download:'410 MB',upload:'95 MB',status:'Online'},
    ],
    rows:[],
    filters:{manager:'',pop:'',area:'',status:'',username:''},
    searching:false,
    searched:false,
    search:'',
    page:1,
    perPage:100,

    get filtered(){
      const q=this.search.trim().toLowerCase()
      if(!q) return this.rows
      return this.rows.filter(r=>
        r.username.toLowerCase().includes(q)||r.ip.includes(q)||r.mac.toLowerCase().includes(q)||
        r.manager.toLowerCase().includes(q)||r.pop.toLowerCase().includes(q)||
        r.area.toLowerCase().includes(q)||r.status.toLowerCase().includes(q)
      )
    },
    get totalPages(){ return Math.max(1,Math.ceil(this.filtered.length/this.perPage)) },
    get paged(){
      if(this.searching) return []
      const s=(this.page-1)*this.perPage
      return this.filtered.slice(s,s+this.perPage)
    },
    get pageStart(){ return this.filtered.length===0?0:(this.page-1)*this.perPage+1 },
    get pageEnd(){ return Math.min(this.page*this.perPage,this.filtered.length) },
    get visiblePages(){
      const t=this.totalPages,c=this.page,out=[]
      if(t<=7){ for(let i=1;i<=t;i++) out.push(i); return out }
      out.push(1)
      if(c>3) out.push('…')
      for(let i=Math.max(2,c-1);i<=Math.min(t-1,c+1);i++) out.push(i)
      if(c<t-2) out.push('…')
      out.push(t)
      return out
    },

    doSearch(){
      this.searching=true
      this.search=''
      this.page=1
      setTimeout(()=>{
        const f=this.filters
        const uq=f.username.trim().toLowerCase()
        this.rows=this.allCustomers.filter(c=>
          (!f.manager||c.manager===f.manager)&&
          (!f.pop||c.pop===f.pop)&&
          (!f.area||c.area===f.area)&&
          (!f.status||c.status===f.status)&&
          (!uq||c.username.toLowerCase().includes(uq))
        )
        this.searching=false
        this.searched=true
      },800)
    },
    doReset(){
      this.filters={manager:'',pop:'',area:'',status:'',username:''}
      this.rows=[]
      this.search=''
      this.page=1
      this.searched=false
    },
  }
}
</script>
</body>
</html>
