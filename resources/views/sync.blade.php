<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Mikrotik Sync</title>
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
.page-title i{color:var(--warning)}

/* card */
.card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--border);overflow:hidden}

/* mikrotik select */
.mik-select-wrap{padding:26px 22px 6px;display:flex;flex-direction:column;align-items:center}
.mik-select-inner{width:100%;max-width:560px}
.mik-label{font-size:15px;font-weight:700;color:var(--text);display:block;margin-bottom:8px}
.mik-label .req{color:var(--warning);margin-left:3px}
.mik-sel{width:100%;padding:12px 36px 12px 14px;border:1.5px solid var(--border);border-radius:9px;font-size:14px;color:var(--text);outline:none;appearance:none;cursor:pointer;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='7'%3E%3Cpath d='M0 0l6 7 6-7z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 13px center;transition:.15s}
.mik-sel:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1)}

/* action bar */
.action-bar{display:flex;align-items:center;justify-content:space-between;gap:10px;padding:16px 22px;flex-wrap:wrap}
.action-right{display:flex;gap:10px;flex-wrap:wrap}
.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border:none;border-radius:9px;font-size:13px;font-weight:700;cursor:pointer;transition:.18s;white-space:nowrap}
.btn:hover{transform:translateY(-1px);filter:brightness(1.08)}
.btn:disabled{opacity:.55;cursor:not-allowed;transform:none;filter:none}
.btn-csv{background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;box-shadow:0 3px 10px rgba(59,130,246,.35)}
.btn-sync{background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;box-shadow:0 3px 10px rgba(245,158,11,.35)}
.btn-delall{background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;box-shadow:0 3px 10px rgba(239,68,68,.35)}

/* toolbar */
.toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 22px;border-top:1px solid var(--border);border-bottom:1px solid var(--border);flex-wrap:wrap}
.toolbar-left{display:flex;align-items:center;gap:8px}
.show-lbl{font-size:13px;color:var(--muted);font-weight:600}
.show-sel{padding:5px 28px 5px 10px;border:1.5px solid var(--border);border-radius:7px;font-size:13px;color:var(--text);background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 9px center;appearance:none;cursor:pointer;outline:none}
.show-sel:focus{border-color:var(--primary)}
.search-wrap{display:flex;align-items:center;gap:8px}
.search-wrap .search-lbl{font-size:13px;color:var(--muted);font-weight:600}
.search-inp{padding:7px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;width:220px;outline:none;transition:.2s;color:var(--text)}
.search-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1)}
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
.user-cell{font-weight:600;color:var(--text);font-size:13px}
.pass-cell{font-family:'SF Mono','Fira Code',monospace;font-size:12px;font-weight:600;color:var(--text);background:#f1f5f9;padding:3px 8px;border-radius:6px;border:1px solid var(--border);display:inline-block}
.profile-badge{display:inline-flex;padding:3px 9px;border-radius:6px;font-size:11px;font-weight:700;background:var(--primary-light);color:var(--primary)}
.comment-cell{color:var(--muted);font-size:12px;max-width:200px;white-space:normal;line-height:1.35}
.cycle-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:5px;font-size:11px;font-weight:700;background:#fef3c7;color:#92400e}

/* action buttons */
.act-row{display:flex;align-items:center;gap:5px}
.ab-icon{width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;border:none;border-radius:7px;cursor:pointer;font-size:13px;transition:.15s;color:#fff}
.ab-icon:hover{filter:brightness(1.15);transform:translateY(-1px)}
.ab-edit{background:linear-gradient(135deg,#16a34a,#15803d);box-shadow:0 2px 6px rgba(22,163,74,.3)}
.ab-del{background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 2px 6px rgba(239,68,68,.3)}

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

/* delete confirm modal */
.overlay{position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;z-index:500;padding:20px}
.modal{background:#fff;border-radius:16px;width:100%;box-shadow:0 24px 64px rgba(0,0,0,.22);overflow:hidden;display:flex;flex-direction:column}
.del-modal{max-width:440px}
.modal-head{padding:16px 22px;display:flex;align-items:center;justify-content:space-between}
.del-head{background:linear-gradient(135deg,var(--danger),#dc2626)}
.modal-head h3{font-size:15px;font-weight:700;color:#fff;display:flex;align-items:center;gap:8px}
.modal-close{background:rgba(255,255,255,.2);border:none;color:#fff;width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:.15s}
.modal-close:hover{background:rgba(255,255,255,.35)}
.del-body{padding:22px;text-align:center}
.del-icon{font-size:40px;color:var(--danger);margin-bottom:10px;opacity:.8}
.del-msg{font-size:14px;color:var(--text);line-height:1.55}
.del-name{display:inline-block;margin-top:6px;padding:3px 10px;background:#fef2f2;border-radius:6px;font-family:'SF Mono','Fira Code',monospace;font-size:13px;font-weight:700;color:var(--danger)}
.modal-foot{padding:13px 22px;border-top:1px solid var(--border);background:#fafbff;display:flex;justify-content:flex-end;gap:9px}
.btn-cancel{padding:8px 16px;border:1.5px solid var(--border);background:#fff;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);transition:.15s}
.btn-cancel:hover{border-color:var(--muted);color:var(--text)}
.btn-danger{padding:8px 20px;background:linear-gradient(135deg,var(--danger),#dc2626);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;transition:.18s;box-shadow:0 3px 10px rgba(239,68,68,.3)}
.btn-danger:hover{transform:translateY(-1px)}

/* toast */
.toast-wrap{position:fixed;bottom:24px;right:24px;z-index:999;pointer-events:none;display:flex;flex-direction:column;gap:8px}
.toast{padding:11px 16px;border-radius:10px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 6px 24px rgba(0,0,0,.18);display:flex;align-items:center;gap:8px;pointer-events:auto}
.toast.success{background:linear-gradient(135deg,#10b981,#059669)}
.toast.info{background:linear-gradient(135deg,var(--info),#0284c7)}
.toast.danger{background:linear-gradient(135deg,var(--danger),#dc2626)}

/* responsive */
@media(max-width:600px){
  .toolbar{flex-direction:column;align-items:stretch}
  .search-inp{width:100%}
  .action-bar{flex-direction:column;align-items:stretch}
  .action-right{justify-content:flex-end}
  .tbl-footer{flex-direction:column;align-items:flex-start}
}
</style>
</head>
<body>
<div class="page" x-data="syncApp()" x-cloak>

  <!-- Header -->
  <div class="page-head">
    <div class="page-title"><i class="fa-solid fa-rotate"></i> Mikrotik Sync</div>
  </div>

  <!-- Card -->
  <div class="card">

    <!-- Mikrotik select -->
    <div class="mik-select-wrap">
      <div class="mik-select-inner">
        <label class="mik-label">Mikrotik Name<span class="req">*</span></label>
        <select class="mik-sel" x-model="selectedMik" @change="onMikChange()">
          <option value="">Select mikrotik</option>
          <template x-for="m in mikrotiks" :key="m.id">
            <option :value="m.id" x-text="m.name"></option>
          </template>
        </select>
      </div>
    </div>

    <!-- Action bar -->
    <div class="action-bar">
      <button class="btn btn-csv" @click="downloadCsv()" :disabled="filtered.length===0">
        <i class="fa-solid fa-print"></i> Download CSV
      </button>
      <div class="action-right">
        <button class="btn btn-sync" @click="syncNow()" :disabled="!selectedMik||syncing">
          <i class="fa-solid fa-rotate" :class="{'fa-spin':syncing}"></i>
          <span x-text="syncing?'Syncing…':'Sync'"></span>
        </button>
        <button class="btn btn-delall" @click="modal='deleteAll'" :disabled="rows.length===0">
          <i class="fa-solid fa-trash-can"></i> Delete All
        </button>
      </div>
    </div>

    <!-- Toolbar -->
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

    <!-- Table -->
    <div class="tbl-wrap">
      <table>
        <thead>
          <tr>
            <th style="width:54px">Id</th>
            <th>User name</th>
            <th>Password</th>
            <th>Profile Name</th>
            <th>Comment</th>
            <th>Reseller Name</th>
            <th>Pop Name</th>
            <th>Package Name</th>
            <th>Billing Cycle</th>
            <th style="width:100px">Action</th>
          </tr>
        </thead>
        <tbody>
          <template x-if="paged.length===0">
            <tr class="empty-row"><td colspan="10"><i class="fa-solid fa-database"></i>No data available in table</td></tr>
          </template>
          <template x-for="r in paged" :key="r.id">
            <tr>
              <td><span class="id-cell" x-text="r.id"></span></td>
              <td><span class="user-cell" x-text="r.username"></span></td>
              <td><span class="pass-cell" x-text="r.password"></span></td>
              <td><span class="profile-badge" x-text="r.profile"></span></td>
              <td><span class="comment-cell" x-text="r.comment"></span></td>
              <td x-text="r.reseller"></td>
              <td x-text="r.pop"></td>
              <td x-text="r.package"></td>
              <td><span class="cycle-badge" x-text="r.billingCycle"></span></td>
              <td>
                <div class="act-row">
                  <button class="ab-icon ab-edit" title="Edit" @click="toast('Edit '+r.username,'info')"><i class="fa-solid fa-pen"></i></button>
                  <button class="ab-icon ab-del" title="Delete" @click="deleteRow(r)"><i class="fa-solid fa-trash"></i></button>
                </div>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>

    <!-- Footer -->
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

  <!-- Delete All confirm -->
  <div class="overlay" x-show="modal==='deleteAll'" @click.self="modal=''">
    <div class="modal del-modal">
      <div class="modal-head del-head">
        <h3><i class="fa-solid fa-trash-can"></i> Delete All Records</h3>
        <button class="modal-close" @click="modal=''"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="del-body">
        <div class="del-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div class="del-msg">
          This will permanently delete <strong x-text="rows.length"></strong> synced record(s) for
          <span class="del-name" x-text="selectedMikName||'—'"></span>
          <br>This action cannot be undone.
        </div>
      </div>
      <div class="modal-foot">
        <button class="btn-cancel" @click="modal=''">Cancel</button>
        <button class="btn-danger" @click="deleteAll()"><i class="fa-solid fa-trash"></i> Delete All</button>
      </div>
    </div>
  </div>

  <!-- Toasts -->
  <div class="toast-wrap">
    <template x-for="t in toasts" :key="t.id">
      <div class="toast" :class="t.type">
        <i :class="t.type==='success'?'fa-solid fa-circle-check':t.type==='danger'?'fa-solid fa-circle-xmark':'fa-solid fa-circle-info'"></i>
        <span x-text="t.msg"></span>
      </div>
    </template>
  </div>

</div>

<script>
function syncApp(){
  return {
    mikrotiks:[
      {id:1,name:'Test'},
      {id:2,name:'SOHEL-ASHULIA-NET-RANGPUR-3219'},
      {id:3,name:'CIRCLE-NET-DHAKA-01'},
      {id:4,name:'DELTA-POP-MIRPUR'},
    ],
    sampleData:{
      3:[
        {id:1,username:'rahim01',password:'rh@2024',profile:'10Mbps',comment:'Home user',reseller:'Karim Traders',pop:'Dhaka POP-1',package:'Home 10M',billingCycle:'Monthly'},
        {id:2,username:'fahad22',password:'fd#9911',profile:'20Mbps',comment:'Office line',reseller:'Karim Traders',pop:'Dhaka POP-1',package:'Office 20M',billingCycle:'Monthly'},
        {id:3,username:'sumon_x',password:'sm77pass',profile:'5Mbps',comment:'',reseller:'Net Vision',pop:'Dhaka POP-2',package:'Lite 5M',billingCycle:'Monthly'},
        {id:4,username:'akash99',password:'ak!4521',profile:'50Mbps',comment:'Corporate client',reseller:'Net Vision',pop:'Dhaka POP-2',package:'Corporate 50M',billingCycle:'Quarterly'},
      ],
      4:[
        {id:1,username:'mirpur_user1',password:'mp@1111',profile:'10Mbps',comment:'New connection',reseller:'Delta ISP',pop:'Mirpur POP',package:'Home 10M',billingCycle:'Monthly'},
        {id:2,username:'mirpur_user2',password:'mp@2222',profile:'15Mbps',comment:'',reseller:'Delta ISP',pop:'Mirpur POP',package:'Home 15M',billingCycle:'Monthly'},
      ],
    },
    rows:[],
    selectedMik:'',
    syncing:false,
    search:'',
    page:1,
    perPage:100,
    modal:'',
    toasts:[],
    toastId:0,

    get selectedMikName(){
      const m=this.mikrotiks.find(m=>m.id==this.selectedMik)
      return m?m.name:''
    },
    get filtered(){
      const q=this.search.trim().toLowerCase()
      if(!q) return this.rows
      return this.rows.filter(r=>
        r.username.toLowerCase().includes(q)||r.profile.toLowerCase().includes(q)||
        r.comment.toLowerCase().includes(q)||r.reseller.toLowerCase().includes(q)||
        r.pop.toLowerCase().includes(q)||r.package.toLowerCase().includes(q)||
        r.billingCycle.toLowerCase().includes(q)
      )
    },
    get totalPages(){ return Math.max(1,Math.ceil(this.filtered.length/this.perPage)) },
    get paged(){
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

    onMikChange(){
      this.rows=[]
      this.search=''
      this.page=1
    },
    syncNow(){
      if(!this.selectedMik) return
      this.syncing=true
      setTimeout(()=>{
        this.rows=(this.sampleData[this.selectedMik]||[]).map(r=>({...r}))
        this.syncing=false
        this.page=1
        if(this.rows.length===0) this.toast('Sync complete — no secrets found on '+this.selectedMikName,'info')
        else this.toast(this.rows.length+' record(s) synced from '+this.selectedMikName,'success')
      },1200)
    },
    deleteRow(r){
      this.rows=this.rows.filter(x=>x.id!==r.id)
      if(this.page>this.totalPages) this.page=this.totalPages
      this.toast('Deleted '+r.username,'danger')
    },
    deleteAll(){
      const n=this.rows.length
      this.rows=[]
      this.page=1
      this.modal=''
      this.toast(n+' record(s) deleted','danger')
    },
    downloadCsv(){
      if(this.filtered.length===0) return
      const head=['Id','User name','Password','Profile Name','Comment','Reseller Name','Pop Name','Package Name','Billing Cycle']
      const esc=v=>'"'+String(v??'').replace(/"/g,'""')+'"'
      const lines=[head.map(esc).join(',')]
      this.filtered.forEach(r=>lines.push([r.id,r.username,r.password,r.profile,r.comment,r.reseller,r.pop,r.package,r.billingCycle].map(esc).join(',')))
      const blob=new Blob([lines.join('\n')],{type:'text/csv'})
      const a=document.createElement('a')
      a.href=URL.createObjectURL(blob)
      a.download='sync-'+(this.selectedMikName||'export')+'.csv'
      a.click()
      URL.revokeObjectURL(a.href)
      this.toast('CSV downloaded','success')
    },
    toast(msg,type='success'){
      const id=++this.toastId
      this.toasts.push({id,msg,type})
      setTimeout(()=>{ this.toasts=this.toasts.filter(t=>t.id!==id) },2800)
    },
  }
}
</script>
</body>
</html>
