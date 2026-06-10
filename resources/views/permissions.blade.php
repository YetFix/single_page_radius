<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Permissions</title>
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

.page{max-width:1400px;margin:0 auto;padding:24px 20px 60px}

/* header */
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px}
.page-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:9px}
.page-title i{color:var(--primary)}
.btn-add{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 3px 10px rgba(99,102,241,.35);transition:.18s}
.btn-add:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(99,102,241,.45)}

/* stats */
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}
.stat{background:var(--card);border-radius:var(--radius);padding:15px 18px;box-shadow:var(--shadow);border:1px solid var(--border);display:flex;align-items:center;gap:12px;position:relative;overflow:hidden}
.stat::after{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:var(--radius) var(--radius) 0 0}
.stat.s-total::after{background:linear-gradient(90deg,var(--primary),#818cf8)}
.stat.s-groups::after{background:linear-gradient(90deg,var(--info),#22d3ee)}
.stat.s-roles::after{background:linear-gradient(90deg,var(--success),#34d399)}
.stat.s-guard::after{background:linear-gradient(90deg,var(--warning),#fbbf24)}
.stat-iw{width:40px;height:40px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0}
.stat.s-total .stat-iw{background:var(--primary-light);color:var(--primary)}
.stat.s-groups .stat-iw{background:#cffafe;color:var(--info)}
.stat.s-roles .stat-iw{background:#d1fae5;color:var(--success)}
.stat.s-guard .stat-iw{background:#fef3c7;color:var(--warning)}
.stat-lbl{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:2px}
.stat-val{font-size:24px;font-weight:800;color:var(--text);line-height:1}

/* card */
.card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--border);overflow:hidden}

/* toolbar */
.toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 18px;border-bottom:1px solid var(--border);flex-wrap:wrap}
.toolbar-left{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
.show-lbl{font-size:13px;color:var(--muted)}
.show-sel{padding:5px 28px 5px 10px;border:1.5px solid var(--border);border-radius:7px;font-size:13px;color:var(--text);background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 9px center;appearance:none;cursor:pointer;outline:none}
.show-sel:focus{border-color:var(--primary)}
.filter-sep{width:1px;height:20px;background:var(--border)}
.filter-group-sel{padding:5px 28px 5px 10px;border:1.5px solid var(--border);border-radius:7px;font-size:12px;color:var(--text);background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 9px center;appearance:none;cursor:pointer;outline:none;max-width:180px}
.filter-group-sel:focus{border-color:var(--primary)}
.search-wrap{position:relative}
.search-wrap i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:12px;pointer-events:none}
.search-inp{padding:7px 12px 7px 30px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;width:220px;outline:none;transition:.2s;color:var(--text)}
.search-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1);width:260px}
.search-inp::placeholder{color:#94a3b8}

/* table */
.tbl-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch}
table{width:100%;border-collapse:collapse;white-space:nowrap}
thead th{background:#f8fafc;padding:11px 16px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;border-bottom:2px solid var(--border);text-align:left;cursor:pointer;user-select:none;transition:.12s}
thead th:hover{color:var(--primary);background:#f0f4ff}
thead th.asc .sort-ic::after{content:' ↑'}
thead th.desc .sort-ic::after{content:' ↓'}
thead th:not(.asc):not(.desc) .sort-ic::after{content:' ⇅';opacity:.4}
.sort-ic{font-size:11px}
thead th.no-sort{cursor:default}
thead th.no-sort:hover{color:var(--muted);background:#f8fafc}
tbody tr{border-bottom:1px solid #f1f5f9;transition:background .12s}
tbody tr:hover{background:#fafbff}
tbody tr:last-child{border-bottom:none}
tbody td{padding:11px 16px;vertical-align:middle}

/* SL */
.sl-cell{font-size:12px;font-weight:700;color:var(--muted)}

/* permission name */
.perm-name{display:flex;align-items:center;gap:8px}
.perm-name-code{font-family:'SF Mono','Fira Code',monospace;font-size:12px;font-weight:600;color:var(--text);background:#f1f5f9;padding:3px 8px;border-radius:6px;border:1px solid var(--border)}
.perm-name-code:hover{background:var(--primary-light);border-color:var(--primary);color:var(--primary);cursor:default}

/* group badge */
.group-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 9px;border-radius:20px;font-size:11px;font-weight:700;letter-spacing:.2px;white-space:nowrap}
.group-badge .gdot{width:6px;height:6px;border-radius:50%;flex-shrink:0}

/* guard badge */
.guard-badge{display:inline-flex;align-items:center;padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}

/* roles cell */
.roles-cell{max-width:280px;white-space:normal}
.role-chip{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:5px;font-size:11px;font-weight:600;margin:2px;white-space:nowrap}
.rc-0{background:#eef2ff;color:#4338ca}
.rc-1{background:#d1fae5;color:#065f46}
.rc-2{background:#dbeafe;color:#1e40af}
.rc-3{background:#fef3c7;color:#92400e}
.rc-4{background:#fce7f3;color:#9d174d}

/* action */
.act-wrap{position:relative}
.act-btn{display:inline-flex;align-items:center;gap:6px;padding:6px 14px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border:none;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;transition:.15s}
.act-btn:hover{filter:brightness(1.08)}
.act-btn i{font-size:10px;transition:.18s}
.act-menu{position:absolute;right:0;top:calc(100%+4px);background:#fff;border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,.15);border:1px solid var(--border);min-width:150px;z-index:100;overflow:hidden}
.act-item{display:flex;align-items:center;gap:9px;padding:9px 14px;font-size:13px;cursor:pointer;transition:background .12s;color:var(--text)}
.act-item:hover{background:#f8fafc}
.act-item.danger{color:var(--danger)}
.act-item.danger:hover{background:#fff5f5}
.act-item i{width:14px;text-align:center;font-size:12px}

/* footer */
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

/* ── overlay / modal ── */
.overlay{position:fixed;inset:0;background:rgba(15,23,42,.58);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;z-index:500;padding:20px}
.modal{background:#fff;border-radius:16px;width:100%;box-shadow:0 24px 64px rgba(0,0,0,.22);overflow:hidden}
.modal-head{padding:16px 22px;display:flex;align-items:center;justify-content:space-between}
.modal-head h3{font-size:15px;font-weight:700;color:#fff;display:flex;align-items:center;gap:8px}
.modal-close{background:rgba(255,255,255,.2);border:none;color:#fff;width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:.15s}
.modal-close:hover{background:rgba(255,255,255,.35)}
.modal-body{padding:22px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-grid .full{grid-column:1/-1}
.ff{display:flex;flex-direction:column;gap:5px}
.ff label{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px}
.ff input,.ff select{padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;color:var(--text);outline:none;transition:.15s;width:100%}
.ff select{appearance:none;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 10px center;padding-right:28px}
.ff input:focus,.ff select:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1)}
.ff .err{font-size:11px;color:var(--danger);display:none}
.ff.has-err input,.ff.has-err select{border-color:var(--danger)}
.ff.has-err .err{display:block}
.preview-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:6px;font-size:12px;font-weight:600;margin-top:4px;font-family:'SF Mono','Fira Code',monospace}
.modal-foot{display:flex;justify-content:flex-end;gap:9px;padding:14px 22px;border-top:1px solid var(--border);background:#fafbff}
.btn-cancel{padding:8px 16px;border:1.5px solid var(--border);background:#fff;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);transition:.15s}
.btn-cancel:hover{border-color:var(--muted);color:var(--text)}
.btn-save{padding:8px 20px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 3px 10px rgba(99,102,241,.3);transition:.18s}
.btn-save:hover{transform:translateY(-1px)}
.btn-danger{padding:8px 20px;background:linear-gradient(135deg,var(--danger),#dc2626);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 3px 10px rgba(239,68,68,.3);transition:.18s}
.btn-danger:hover{transform:translateY(-1px)}

/* delete confirm modal */
.del-modal{max-width:420px}
.del-head{background:linear-gradient(135deg,var(--danger),#dc2626)}
.del-body{padding:22px;text-align:center}
.del-icon{font-size:40px;color:var(--danger);margin-bottom:10px;opacity:.8}
.del-msg{font-size:14px;color:var(--text);line-height:1.55}
.del-name{display:inline-block;margin-top:6px;padding:3px 10px;background:#fef2f2;border-radius:6px;font-family:'SF Mono','Fira Code',monospace;font-size:13px;font-weight:700;color:var(--danger)}

/* toast */
.toast-wrap{position:fixed;bottom:24px;right:24px;z-index:999;pointer-events:none;display:flex;flex-direction:column;gap:8px}
.toast{padding:11px 16px;border-radius:10px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 6px 24px rgba(0,0,0,.18);display:flex;align-items:center;gap:8px;min-width:220px;pointer-events:auto}
.toast.success{background:linear-gradient(135deg,#10b981,#059669)}
.toast.danger{background:linear-gradient(135deg,var(--danger),#dc2626)}

/* responsive */
@media(max-width:900px){.stats{grid-template-columns:repeat(2,1fr)}}
@media(max-width:600px){
  .stats{grid-template-columns:1fr 1fr}
  .toolbar{flex-direction:column;align-items:stretch}
  .search-inp,.search-inp:focus{width:100%}
  .form-grid{grid-template-columns:1fr}
  .form-grid .full{grid-column:1}
  .tbl-footer{flex-direction:column;align-items:flex-start}
}
</style>
</head>
<body>
<div class="page" x-data="permsApp()" x-cloak>

  <!-- Header -->
  <div class="page-head">
    <div class="page-title"><i class="fa-solid fa-key"></i> All Permissions</div>
    <button class="btn-add" @click="openAdd()">
      <i class="fa-solid fa-plus"></i> Add Permission
    </button>
  </div>

  <!-- Stats -->
  <div class="stats">
    <div class="stat s-total">
      <div class="stat-iw"><i class="fa-solid fa-key"></i></div>
      <div>
        <div class="stat-lbl">Total Permissions</div>
        <div class="stat-val" x-text="permissions.length"></div>
      </div>
    </div>
    <div class="stat s-groups">
      <div class="stat-iw"><i class="fa-solid fa-layer-group"></i></div>
      <div>
        <div class="stat-lbl">Groups</div>
        <div class="stat-val" x-text="groups.length"></div>
      </div>
    </div>
    <div class="stat s-roles">
      <div class="stat-iw"><i class="fa-solid fa-shield-halved"></i></div>
      <div>
        <div class="stat-lbl">Assigned to Roles</div>
        <div class="stat-val" x-text="permissions.filter(p=>p.roles.length>0).length"></div>
      </div>
    </div>
    <div class="stat s-guard">
      <div class="stat-iw"><i class="fa-solid fa-lock"></i></div>
      <div>
        <div class="stat-lbl">Guard</div>
        <div class="stat-val">web</div>
      </div>
    </div>
  </div>

  <!-- Table Card -->
  <div class="card">
    <!-- Toolbar -->
    <div class="toolbar">
      <div class="toolbar-left">
        <span class="show-lbl">Show</span>
        <select class="show-sel" x-model.number="perPage" @change="page=1">
          <option>10</option>
          <option>25</option>
          <option selected>50</option>
          <option>100</option>
        </select>
        <span class="show-lbl">entries</span>
        <span class="filter-sep"></span>
        <select class="filter-group-sel" x-model="filterGroup" @change="page=1">
          <option value="">All Groups</option>
          <template x-for="g in groups" :key="g.name">
            <option :value="g.name" x-text="g.name"></option>
          </template>
        </select>
      </div>
      <div class="search-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input class="search-inp" type="text" placeholder="Search permissions…" x-model="search" @input="page=1">
      </div>
    </div>

    <!-- Table -->
    <div class="tbl-wrap">
      <table>
        <thead>
          <tr>
            <th class="no-sort" style="width:52px">ID</th>
            <th @click="cycleSort('name')" :class="{asc:sortKey==='name'&&sortDir==='asc',desc:sortKey==='name'&&sortDir==='desc'}">
              Permission Name <span class="sort-ic"></span>
            </th>
            <th @click="cycleSort('group')" :class="{asc:sortKey==='group'&&sortDir==='asc',desc:sortKey==='group'&&sortDir==='desc'}">
              Group <span class="sort-ic"></span>
            </th>
            <th class="no-sort">Guard</th>
            <th class="no-sort">Assigned Roles</th>
            <th class="no-sort" style="width:100px;text-align:center">Action</th>
          </tr>
        </thead>
        <tbody>
          <template x-if="paged.length===0">
            <tr class="empty-row">
              <td colspan="6">
                <i class="fa-solid fa-key"></i>
                No permissions found
              </td>
            </tr>
          </template>
          <template x-for="(p,idx) in paged" :key="p.id">
            <tr>
              <!-- ID -->
              <td><span class="sl-cell" x-text="p.id"></span></td>

              <!-- Permission Name -->
              <td>
                <div class="perm-name">
                  <span class="perm-name-code" x-text="p.name"></span>
                </div>
              </td>

              <!-- Group -->
              <td>
                <span class="group-badge" :style="`background:${hexAlpha(p.color,.12)};color:${p.color};border:1px solid ${hexAlpha(p.color,.25)}`">
                  <span class="gdot" :style="`background:${p.color}`"></span>
                  <span x-text="p.group"></span>
                </span>
              </td>

              <!-- Guard -->
              <td><span class="guard-badge">web</span></td>

              <!-- Roles -->
              <td class="roles-cell" style="white-space:normal">
                <template x-if="p.roles.length===0">
                  <span style="font-size:12px;color:#94a3b8">—</span>
                </template>
                <template x-for="(r,ri) in p.roles" :key="r">
                  <span class="role-chip" :class="'rc-'+(ri%5)" x-text="r"></span>
                </template>
              </td>

              <!-- Action -->
              <td style="text-align:center">
                <div class="act-wrap" x-data="{open:false}" @click.outside="open=false">
                  <button class="act-btn" @click="open=!open">
                    Action <i class="fa-solid fa-chevron-down" :style="open?'transform:rotate(180deg)':''"></i>
                  </button>
                  <div class="act-menu" x-show="open"
                       x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                       x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <div class="act-item" @click="openEdit(p);open=false">
                      <i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Edit
                    </div>
                    <div class="act-item danger" @click="openDelete(p);open=false">
                      <i class="fa-solid fa-trash-can"></i> Delete
                    </div>
                  </div>
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
        Showing <strong x-text="pageStart"></strong>–<strong x-text="pageEnd"></strong>
        of <strong x-text="filtered.length"></strong> entries
        <template x-if="search||filterGroup"><span style="color:var(--muted)"> (filtered from <strong x-text="permissions.length"></strong>)</span></template>
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

  <!-- ══════════════════════════════════════════
       ADD / EDIT MODAL
  ══════════════════════════════════════════ -->
  <div class="overlay" x-show="modal==='add'||modal==='edit'"
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="modal=''">
    <div class="modal" style="max-width:500px"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="modal-head" :style="`background:${modal==='add'?'linear-gradient(135deg,var(--primary),var(--primary-dark))':'linear-gradient(135deg,var(--teal),#0f766e)'}`">
        <h3>
          <i :class="modal==='add'?'fa-solid fa-plus':'fa-solid fa-pen-to-square'"></i>
          <span x-text="modal==='add'?'Add New Permission':'Edit Permission'"></span>
        </h3>
        <button class="modal-close" @click="modal=''"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body">
        <div class="form-grid">
          <div class="ff full" :class="{'has-err':formErr.name}">
            <label>Permission Name *</label>
            <input type="text" x-model="form.name" placeholder="e.g. user-registration" @input="formErr.name=''">
            <span class="err" x-text="formErr.name"></span>
            <template x-if="form.name">
              <span class="preview-badge" :style="`background:#f1f5f9;color:var(--text);border:1px solid var(--border)`" x-text="form.name.toLowerCase().replace(/\s+/g,'-')"></span>
            </template>
          </div>
          <div class="ff" :class="{'has-err':formErr.group}">
            <label>Group *</label>
            <select x-model="form.group" @change="formErr.group=''">
              <option value="">— Select group —</option>
              <template x-for="g in groups" :key="g.name">
                <option :value="g.name" x-text="g.name"></option>
              </template>
              <option value="__new__">+ New Group…</option>
            </select>
            <span class="err" x-text="formErr.group"></span>
          </div>
          <div class="ff">
            <label>Guard</label>
            <select>
              <option selected>web</option>
              <option>api</option>
            </select>
          </div>
          <template x-if="form.group==='__new__'">
            <div class="ff full" :class="{'has-err':formErr.newGroup}">
              <label>New Group Name *</label>
              <input type="text" x-model="form.newGroup" placeholder="Enter group name" @input="formErr.newGroup=''">
              <span class="err" x-text="formErr.newGroup"></span>
            </div>
          </template>
        </div>
      </div>
      <div class="modal-foot">
        <button class="btn-cancel" @click="modal=''">Cancel</button>
        <button class="btn-save" @click="savePermission()">
          <i class="fa-solid fa-floppy-disk"></i>
          <span x-text="modal==='add'?'Add Permission':'Update'"></span>
        </button>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       DELETE CONFIRM MODAL
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
        <div class="del-icon"><i class="fa-solid fa-trash-can"></i></div>
        <div class="del-msg">
          Are you sure you want to delete this permission?<br>
          <span class="del-name" x-text="selectedPerm?.name"></span><br>
          <span style="font-size:12px;color:var(--muted);margin-top:6px;display:block">This will remove it from all assigned roles.</span>
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
        <i :class="toast.type==='success'?'fa-solid fa-circle-check':'fa-solid fa-circle-xmark'"></i>
        <span x-text="toast.msg"></span>
      </div>
    </template>
  </div>

</div>
<script>
function permsApp(){

  const GROUPS=[
    {name:'User Management',color:'#6366f1'},
    {name:'Permissions',color:'#8b5cf6'},
    {name:'Roles',color:'#a855f7'},
    {name:'POP & Box',color:'#3b82f6'},
    {name:'Switch',color:'#06b6d4'},
    {name:'Customer',color:'#10b981'},
    {name:'Token',color:'#f59e0b'},
    {name:'Reports',color:'#f97316'},
    {name:'Connection',color:'#ec4899'},
    {name:'Requisition',color:'#14b8a6'},
    {name:'Package & Reseller',color:'#22c55e'},
    {name:'Mikrotik',color:'#ef4444'},
  ]

  const groupColor=n=>GROUPS.find(g=>g.name===n)?.color||'#64748b'

  const RAW_PERMS=[
    // User Management
    {n:'user-registration',g:'User Management',r:['Admin']},
    {n:'password-change',g:'User Management',r:['Admin','Support Executive','Support Manager','Accounts Executive']},
    {n:'user-logout',g:'User Management',r:['Admin','Support Manager']},
    {n:'assign-permission',g:'User Management',r:['Admin']},
    {n:'assign-permission-role',g:'User Management',r:['Admin']},
    {n:'assign-role',g:'User Management',r:['Admin']},
    {n:'assign-user-role',g:'User Management',r:['Admin']},
    {n:'user_index',g:'User Management',r:['Admin','Accounts Executive']},
    // Permissions
    {n:'permission_create',g:'Permissions',r:['Admin']},
    {n:'permission_store',g:'Permissions',r:['Admin']},
    {n:'permission_edit',g:'Permissions',r:['Admin']},
    {n:'permission_update',g:'Permissions',r:['Admin']},
    {n:'permission_index',g:'Permissions',r:['Admin']},
    {n:'permission_destroy',g:'Permissions',r:['Admin']},
    // Roles
    {n:'role_create',g:'Roles',r:['Admin']},
    {n:'role_store',g:'Roles',r:['Admin']},
    {n:'role_edit',g:'Roles',r:['Admin']},
    {n:'role_update',g:'Roles',r:['Admin']},
    {n:'role_index',g:'Roles',r:['Admin']},
    {n:'role_destroy',g:'Roles',r:['Admin']},
    // POP & Box
    {n:'pop_index',g:'POP & Box',r:['Admin','Support Executive','Support Manager']},
    {n:'pop_edit',g:'POP & Box',r:['Admin','Support Executive','Support Manager']},
    {n:'pop_update',g:'POP & Box',r:['Admin']},
    {n:'pop_destroy',g:'POP & Box',r:['Admin']},
    {n:'pop_box',g:'POP & Box',r:['Admin']},
    {n:'pop-name',g:'POP & Box',r:['Admin','Support Executive','Support Manager']},
    {n:'box_index',g:'POP & Box',r:['Admin','Support Manager']},
    {n:'box_create',g:'POP & Box',r:['Admin','Support Manager']},
    {n:'box_store',g:'POP & Box',r:['Admin','Support Manager']},
    {n:'box_edit',g:'POP & Box',r:['Admin','Support Manager']},
    {n:'box_update',g:'POP & Box',r:['Admin','Support Manager']},
    {n:'box_destroy',g:'POP & Box',r:['Admin']},
    {n:'box_switch',g:'POP & Box',r:['Admin','Support Manager']},
    // Switch
    {n:'switch_create',g:'Switch',r:['Admin','Support Manager']},
    {n:'switch_store',g:'Switch',r:['Admin','Support Manager']},
    {n:'switch_index',g:'Switch',r:['Admin','Support Manager']},
    // Customer
    {n:'customer-support',g:'Customer',r:['Admin','Support Executive','Support Manager']},
    {n:'customer-info',g:'Customer',r:['Admin','Support Executive','Support Manager','Accounts Executive']},
    {n:'customer-summary',g:'Customer',r:['Admin','Support Executive','Support Manager','Accounts Executive']},
    {n:'customer-contact-details',g:'Customer',r:['Admin','Support Executive','Support Manager']},
    {n:'customer-technical-details',g:'Customer',r:['Admin','Support Executive','Support Manager']},
    {n:'customer-token-details',g:'Customer',r:['Admin','Support Executive','Support Manager']},
    {n:'customer-accounts',g:'Customer',r:['Admin','Support Manager','Accounts Executive']},
    // Token
    {n:'close-token',g:'Token',r:['Admin','Support Executive','Support Manager']},
    {n:'TokenByPOP',g:'Token',r:['Admin','Support Executive','Support Manager']},
    {n:'assign-token',g:'Token',r:['Admin','Support Executive','Support Manager']},
    {n:'new-token',g:'Token',r:['Admin','Support Executive','Support Manager']},
    {n:'update-token',g:'Token',r:['Admin','Support Executive','Support Manager']},
    {n:'token-category',g:'Token',r:['Admin','Support Executive','Support Manager']},
    {n:'token-code',g:'Token',r:['Admin','Support Executive','Support Manager']},
    {n:'token-report',g:'Token',r:['Admin','Support Executive']},
    {n:'token-search',g:'Token',r:['Admin','Support Executive']},
    {n:'support-token-close',g:'Token',r:['Admin','Support Executive']},
    {n:'TokenById',g:'Token',r:['Admin','Support Executive','Support Manager']},
    // Reports
    {n:'monthly-report',g:'Reports',r:['Admin','Support Executive','Accounts Executive']},
    {n:'connection-history',g:'Reports',r:['Admin','Support Manager']},
    // Connection
    {n:'connection-request',g:'Connection',r:['Admin','Support Manager']},
    {n:'connection-request-list',g:'Connection',r:['Admin','Support Manager']},
    // Requisition
    {n:'requisition_create',g:'Requisition',r:['Admin','Support Executive']},
    {n:'requisition_store',g:'Requisition',r:['Admin','Support Executive']},
    // Package & Reseller
    {n:'package_index',g:'Package & Reseller',r:['Admin','Support Executive','Accounts Executive']},
    {n:'reseller_index',g:'Package & Reseller',r:['Admin','Support Executive']},
    // Mikrotik
    {n:'mikrotik_create',g:'Mikrotik',r:['Admin','Support Executive']},
    {n:'mikrotik_store',g:'Mikrotik',r:['Admin','Support Executive']},
    {n:'mikrotik_index',g:'Mikrotik',r:['Admin','Support Executive']},
    {n:'mikrotik_edit',g:'Mikrotik',r:['Admin','Support Executive']},
  ]

  const permissions=RAW_PERMS.map((p,i)=>({
    id:i+1,name:p.n,group:p.g,guard:'web',roles:p.r,color:groupColor(p.g)
  }))

  return {
    permissions,
    groups:GROUPS,
    search:'',
    filterGroup:'',
    sortKey:'id',sortDir:'asc',
    page:1,perPage:50,

    modal:'',
    selectedPerm:null,
    form:{name:'',group:'',newGroup:''},
    formErr:{},
    toast:{show:false,msg:'',type:'success'},

    get filtered(){
      let rows=this.permissions
      const q=this.search.trim().toLowerCase()
      if(q)rows=rows.filter(p=>p.name.toLowerCase().includes(q)||p.group.toLowerCase().includes(q)||p.roles.some(r=>r.toLowerCase().includes(q)))
      if(this.filterGroup)rows=rows.filter(p=>p.group===this.filterGroup)
      const k=this.sortKey,d=this.sortDir==='asc'?1:-1
      rows=[...rows].sort((a,b)=>{
        const av=k==='id'?a[k]:String(a[k]).toLowerCase()
        const bv=k==='id'?b[k]:String(b[k]).toLowerCase()
        return av>bv?d:av<bv?-d:0
      })
      return rows
    },
    get totalPages(){return Math.max(1,Math.ceil(this.filtered.length/this.perPage))},
    get paged(){return this.filtered.slice((this.page-1)*this.perPage,this.page*this.perPage)},
    get pageStart(){return this.filtered.length===0?0:(this.page-1)*this.perPage+1},
    get pageEnd(){return Math.min(this.page*this.perPage,this.filtered.length)},
    get visiblePages(){
      const t=this.totalPages,c=this.page,p=[]
      if(t<=7){for(let i=1;i<=t;i++)p.push(i);return p}
      p.push(1)
      if(c>3)p.push('…')
      for(let i=Math.max(2,c-1);i<=Math.min(t-1,c+1);i++)p.push(i)
      if(c<t-2)p.push('…')
      p.push(t)
      return p
    },

    cycleSort(k){
      if(this.sortKey===k)this.sortDir=this.sortDir==='asc'?'desc':'asc'
      else{this.sortKey=k;this.sortDir='asc'}
      this.page=1
    },

    hexAlpha(hex,a){
      const r=parseInt(hex.slice(1,3),16),g=parseInt(hex.slice(3,5),16),b=parseInt(hex.slice(5,7),16)
      return `rgba(${r},${g},${b},${a})`
    },

    openAdd(){
      this.selectedPerm=null
      this.form={name:'',group:'',newGroup:''}
      this.formErr={}
      this.modal='add'
    },
    openEdit(p){
      this.selectedPerm=p
      this.form={name:p.name,group:p.group,newGroup:''}
      this.formErr={}
      this.modal='edit'
    },
    savePermission(){
      this.formErr={}
      if(!this.form.name.trim())this.formErr.name='Permission name is required'
      if(!this.form.group)this.formErr.group='Group is required'
      if(this.form.group==='__new__'&&!this.form.newGroup.trim())this.formErr.newGroup='New group name is required'
      if(Object.keys(this.formErr).length)return

      const finalName=this.form.name.trim().toLowerCase().replace(/\s+/g,'-')
      const finalGroup=this.form.group==='__new__'?this.form.newGroup.trim():this.form.group

      if(this.form.group==='__new__'&&!this.groups.find(g=>g.name===finalGroup)){
        this.groups.push({name:finalGroup,color:'#64748b'})
      }

      if(this.modal==='add'){
        const newId=Math.max(0,...this.permissions.map(p=>p.id))+1
        this.permissions.push({id:newId,name:finalName,group:finalGroup,guard:'web',roles:[],color:this.groups.find(g=>g.name===finalGroup)?.color||'#64748b'})
        this.showToast('Permission added successfully','success')
      } else {
        this.selectedPerm.name=finalName
        this.selectedPerm.group=finalGroup
        this.selectedPerm.color=this.groups.find(g=>g.name===finalGroup)?.color||'#64748b'
        this.showToast('Permission updated','success')
      }
      this.modal=''
    },

    openDelete(p){
      this.selectedPerm=p
      this.modal='delete'
    },
    confirmDelete(){
      const idx=this.permissions.findIndex(p=>p.id===this.selectedPerm.id)
      if(idx!==-1)this.permissions.splice(idx,1)
      this.modal=''
      this.showToast(`"${this.selectedPerm.name}" deleted`,'danger')
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
