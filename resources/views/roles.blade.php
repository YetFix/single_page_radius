<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Roles &amp; Permissions</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
:root{
  --primary:#6366f1;--primary-dark:#4f46e5;--primary-light:#eef2ff;
  --teal:#0d9488;--success:#10b981;--danger:#ef4444;--warning:#f59e0b;
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
.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px}
.stat{background:var(--card);border-radius:var(--radius);padding:15px 18px;box-shadow:var(--shadow);border:1px solid var(--border);display:flex;align-items:center;gap:12px}
.stat::before{content:'';display:block;position:absolute}
.stat-iw{width:40px;height:40px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0}
.stat.s-roles .stat-iw{background:#eef2ff;color:var(--primary)}
.stat.s-perms .stat-iw{background:#f0fdf4;color:var(--success)}
.stat.s-total .stat-iw{background:#fef3c7;color:var(--warning)}
.stat-lbl{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:2px}
.stat-val{font-size:24px;font-weight:800;color:var(--text);line-height:1}

/* card */
.card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--border);overflow:hidden}

/* toolbar */
.toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 18px;border-bottom:1px solid var(--border);flex-wrap:wrap}
.toolbar-left{display:flex;align-items:center;gap:8px}
.show-lbl{font-size:13px;color:var(--muted)}
.show-sel{padding:5px 28px 5px 10px;border:1.5px solid var(--border);border-radius:7px;font-size:13px;color:var(--text);background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 9px center;appearance:none;cursor:pointer;outline:none;transition:.15s}
.show-sel:focus{border-color:var(--primary)}
.search-wrap{position:relative}
.search-wrap i{position:absolute;left:10px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:12px;pointer-events:none}
.search-inp{padding:7px 12px 7px 30px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;width:220px;outline:none;transition:.2s;color:var(--text)}
.search-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1);width:260px}
.search-inp::placeholder{color:#94a3b8}

/* table */
.tbl-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch}
table{width:100%;border-collapse:collapse}
thead th{background:#f8fafc;padding:11px 16px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;border-bottom:2px solid var(--border);text-align:left;white-space:nowrap}
tbody tr{border-bottom:1px solid #f1f5f9;transition:background .12s}
tbody tr:hover{background:#fafbff}
tbody tr:last-child{border-bottom:none}
tbody td{padding:14px 16px;vertical-align:top}
.sl-cell{font-size:12px;font-weight:700;color:var(--muted);padding-top:16px;white-space:nowrap}
.role-cell{min-width:130px;padding-top:15px}
.role-name{font-size:14px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:7px}
.role-dot{width:8px;height:8px;border-radius:50%;background:var(--primary);flex-shrink:0}
.role-count{font-size:11px;color:var(--muted);margin-top:3px}

/* permission badges */
.perm-cell{min-width:300px}
.perm-wrap{display:flex;flex-wrap:wrap;gap:5px;align-items:center}
.perm-badge{display:inline-flex;align-items:center;padding:3px 8px;background:#334155;color:#e2e8f0;border-radius:6px;font-size:11px;font-weight:500;letter-spacing:.1px;white-space:nowrap;transition:.12s}
.perm-badge:hover{background:#1e293b;color:#f8fafc}
.perm-more{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;background:var(--primary-light);color:var(--primary);border-radius:6px;font-size:11px;font-weight:700;cursor:pointer;border:1.5px dashed var(--primary);transition:.12s;white-space:nowrap}
.perm-more:hover{background:#e0e7ff}
.perm-less{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;background:#f1f5f9;color:var(--muted);border-radius:6px;font-size:11px;font-weight:700;cursor:pointer;border:1.5px dashed var(--border);transition:.12s;white-space:nowrap;margin-top:4px}
.perm-less:hover{background:#e2e8f0}

/* action column */
.act-cell{white-space:nowrap;vertical-align:top;padding-top:12px}
.act-stack{display:flex;flex-direction:column;gap:6px;min-width:140px}
.act-btn{display:flex;align-items:center;justify-content:center;gap:6px;padding:7px 14px;border:none;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;transition:.15s;width:100%}
.act-btn:hover{filter:brightness(1.1);transform:translateY(-1px)}
.act-assign{background:linear-gradient(135deg,#3b82f6,#2563eb);color:#fff;box-shadow:0 2px 8px rgba(59,130,246,.3)}
.act-edit{background:linear-gradient(135deg,#0d9488,#0f766e);color:#fff;box-shadow:0 2px 8px rgba(13,148,136,.3)}
.act-history{background:linear-gradient(135deg,#16a34a,#15803d);color:#fff;box-shadow:0 2px 8px rgba(22,163,74,.3)}

/* footer */
.tbl-footer{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
.tbl-info{font-size:12px;color:var(--muted)}
.tbl-info strong{color:var(--text)}
.pagination{display:flex;gap:4px}
.pg-btn{width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:7px;border:1.5px solid var(--border);background:#fff;font-size:12px;font-weight:600;cursor:pointer;color:var(--muted);transition:.15s}
.pg-btn:hover{border-color:var(--primary);color:var(--primary)}
.pg-btn.active{background:var(--primary);border-color:var(--primary);color:#fff}
.pg-btn:disabled{opacity:.4;cursor:not-allowed}

/* ── modals shared ── */
.overlay{position:fixed;inset:0;background:rgba(15,23,42,.6);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;z-index:500;padding:20px}
.modal{background:#fff;border-radius:16px;width:100%;box-shadow:0 24px 64px rgba(0,0,0,.22);overflow:hidden;display:flex;flex-direction:column;max-height:90vh}
.modal-head{padding:16px 22px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.modal-head h3{font-size:15px;font-weight:700;color:#fff;display:flex;align-items:center;gap:8px}
.modal-close{background:rgba(255,255,255,.18);border:none;color:#fff;width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:.15s;flex-shrink:0}
.modal-close:hover{background:rgba(255,255,255,.3)}
.modal-scroll{overflow-y:auto;flex:1}
.modal-foot{padding:13px 22px;border-top:1px solid var(--border);background:#fafbff;display:flex;justify-content:flex-end;gap:9px;flex-shrink:0}
.btn-cancel{padding:8px 16px;border:1.5px solid var(--border);background:#fff;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);transition:.15s}
.btn-cancel:hover{border-color:var(--muted);color:var(--text)}
.btn-save{padding:8px 20px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;box-shadow:0 3px 10px rgba(99,102,241,.3);transition:.18s}
.btn-save:hover{transform:translateY(-1px)}

/* assign permission modal */
.ap-modal{max-width:820px}
.ap-head{background:linear-gradient(135deg,#3b82f6,#1d4ed8)}
.ap-meta{padding:12px 22px 0;border-bottom:1px solid var(--border);background:#fafbff;flex-shrink:0}
.ap-meta-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;padding-bottom:12px}
.ap-role-tag{display:inline-flex;align-items:center;gap:6px;padding:5px 12px;background:var(--primary-light);color:var(--primary);border-radius:8px;font-size:13px;font-weight:700}
.ap-counts{font-size:12px;color:var(--muted)}
.ap-counts strong{color:var(--primary)}
.ap-search{position:relative}
.ap-search i{position:absolute;left:9px;top:50%;transform:translateY(-50%);color:var(--muted);font-size:12px;pointer-events:none}
.ap-search input{padding:6px 10px 6px 28px;border:1.5px solid var(--border);border-radius:7px;font-size:12px;width:200px;outline:none}
.ap-search input:focus{border-color:var(--primary)}
.ap-body{padding:16px 22px}
.perm-group{margin-bottom:18px}
.perm-group-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;padding-bottom:6px;border-bottom:1px solid var(--border)}
.perm-group-title{font-size:11px;font-weight:800;text-transform:uppercase;letter-spacing:.5px;display:flex;align-items:center;gap:6px}
.perm-group-dot{width:8px;height:8px;border-radius:50%}
.perm-group-actions{display:flex;gap:8px}
.link-btn{font-size:11px;font-weight:600;color:var(--primary);background:none;border:none;cursor:pointer;padding:0;text-decoration:underline;text-underline-offset:2px}
.link-btn:hover{color:var(--primary-dark)}
.perm-checkgrid{display:flex;flex-wrap:wrap;gap:6px}
.perm-check-item{display:flex;align-items:center;gap:5px;padding:4px 9px;border:1.5px solid var(--border);border-radius:7px;cursor:pointer;transition:.12s;background:#fff}
.perm-check-item:hover{border-color:var(--primary);background:var(--primary-light)}
.perm-check-item.checked{border-color:var(--primary);background:var(--primary-light)}
.perm-check-item input{width:13px;height:13px;accent-color:var(--primary);cursor:pointer;flex-shrink:0}
.perm-check-item span{font-size:11px;font-weight:500;color:var(--text);white-space:nowrap}
.perm-check-item.hidden{display:none}
.select-all-row{display:flex;align-items:center;justify-content:space-between;padding:10px 22px;background:#f8fafc;border-bottom:1px solid var(--border);flex-shrink:0}
.select-all-row label{display:flex;align-items:center;gap:7px;font-size:13px;font-weight:600;color:var(--text);cursor:pointer}
.select-all-row input{width:15px;height:15px;accent-color:var(--primary);cursor:pointer}

/* edit / add role modal */
.er-modal{max-width:440px}
.er-head{background:linear-gradient(135deg,var(--teal),#0f766e)}
.ff{display:flex;flex-direction:column;gap:5px;padding:22px}
.ff label{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:2px}
.ff input{padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;color:var(--text);outline:none;transition:.15s}
.ff input:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1)}
.ff .err{font-size:11px;color:#ef4444;display:none;margin-top:2px}
.ff.has-err input{border-color:#ef4444}
.ff.has-err .err{display:block}

/* history modal */
.hist-modal{max-width:520px}
.hist-head{background:linear-gradient(135deg,#16a34a,#15803d)}
.hist-body{padding:16px 22px}
.hist-item{display:flex;gap:12px;padding:10px 0;border-bottom:1px solid #f1f5f9}
.hist-item:last-child{border-bottom:none}
.hist-icon{width:32px;height:32px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:12px;color:var(--muted)}
.hist-icon.add{background:#d1fae5;color:#059669}
.hist-icon.edit{background:var(--primary-light);color:var(--primary)}
.hist-icon.perm{background:#fef3c7;color:#d97706}
.hist-content{flex:1}
.hist-action{font-size:13px;font-weight:600;color:var(--text)}
.hist-by{font-size:11px;color:var(--muted);margin-top:1px}
.hist-time{font-size:11px;color:#94a3b8;margin-top:1px}

/* empty */
.empty-row td{text-align:center;padding:40px;color:var(--muted);font-size:13px}

/* toast */
.toast-wrap{position:fixed;bottom:24px;right:24px;z-index:999;pointer-events:none;display:flex;flex-direction:column;gap:8px}
.toast{padding:11px 16px;border-radius:10px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 6px 24px rgba(0,0,0,.18);display:flex;align-items:center;gap:8px;min-width:220px;pointer-events:auto}
.toast.success{background:linear-gradient(135deg,#10b981,#059669)}
.toast.danger{background:linear-gradient(135deg,#ef4444,#dc2626)}

/* responsive */
@media(max-width:900px){.stats{grid-template-columns:1fr 1fr}}
@media(max-width:600px){
  .stats{grid-template-columns:1fr}
  .toolbar{flex-direction:column;align-items:stretch}
  .search-inp,.search-inp:focus{width:100%}
  .act-stack{flex-direction:row;flex-wrap:wrap}
  .act-btn{width:auto;flex:1}
}
</style>
</head>
<body>
<div class="page" x-data="rolesApp()" x-cloak>

  <!-- Header -->
  <div class="page-head">
    <div class="page-title"><i class="fa-solid fa-shield-halved"></i> Roles &amp; Permissions</div>
    <button class="btn-add" @click="openAddRole()">
      <i class="fa-solid fa-plus"></i> Add Role
    </button>
  </div>

  <!-- Stats -->
  <div class="stats">
    <div class="stat s-roles">
      <div class="stat-iw"><i class="fa-solid fa-shield-halved"></i></div>
      <div>
        <div class="stat-lbl">Total Roles</div>
        <div class="stat-val" x-text="roles.length"></div>
      </div>
    </div>
    <div class="stat s-perms">
      <div class="stat-iw"><i class="fa-solid fa-key"></i></div>
      <div>
        <div class="stat-lbl">All Permissions</div>
        <div class="stat-val" x-text="allPermItems.length"></div>
      </div>
    </div>
    <div class="stat s-total">
      <div class="stat-iw"><i class="fa-solid fa-layer-group"></i></div>
      <div>
        <div class="stat-lbl">Permission Groups</div>
        <div class="stat-val" x-text="permGroups.length"></div>
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
      </div>
      <div class="search-wrap">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input class="search-inp" type="text" placeholder="Search roles…" x-model="search" @input="page=1">
      </div>
    </div>

    <!-- Table -->
    <div class="tbl-wrap">
      <table>
        <thead>
          <tr>
            <th style="width:52px">SL</th>
            <th style="min-width:130px">Role Name</th>
            <th>Permission List</th>
            <th style="width:150px;text-align:center">Action</th>
          </tr>
        </thead>
        <tbody>
          <template x-if="paged.length===0">
            <tr class="empty-row"><td colspan="4"><i class="fa-solid fa-shield-halved" style="font-size:28px;display:block;margin-bottom:8px;opacity:.25"></i>No roles found</td></tr>
          </template>
          <template x-for="(role,idx) in paged" :key="role.id">
            <tr>
              <!-- SL -->
              <td class="sl-cell" x-text="(page-1)*perPage + idx + 1"></td>

              <!-- Role Name -->
              <td class="role-cell">
                <div class="role-name">
                  <span class="role-dot" :style="`background:${role.color}`"></span>
                  <span x-text="role.name"></span>
                </div>
                <div class="role-count"><span x-text="role.permissions.length"></span> permissions</div>
              </td>

              <!-- Permissions -->
              <td class="perm-cell">
                <div class="perm-wrap">
                  <template x-for="p in (expanded.has(role.id)?role.permissions:role.permissions.slice(0,14))" :key="p">
                    <span class="perm-badge" x-text="p"></span>
                  </template>
                  <template x-if="!expanded.has(role.id) && role.permissions.length > 14">
                    <span class="perm-more" @click="expanded.add(role.id); expanded = new Set(expanded)">
                      <i class="fa-solid fa-plus" style="font-size:9px"></i>
                      <span x-text="role.permissions.length - 14"></span> more
                    </span>
                  </template>
                  <template x-if="expanded.has(role.id) && role.permissions.length > 14">
                    <span class="perm-less" @click="expanded.delete(role.id); expanded = new Set(expanded)">
                      <i class="fa-solid fa-chevron-up" style="font-size:9px"></i> show less
                    </span>
                  </template>
                </div>
              </td>

              <!-- Actions -->
              <td class="act-cell">
                <div class="act-stack">
                  <button class="act-btn act-assign" @click="openAssign(role)">
                    <i class="fa-solid fa-key"></i> Assign Permission
                  </button>
                  <button class="act-btn act-edit" @click="openEdit(role)">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                  </button>
                  <button class="act-btn act-history" @click="openHistory(role)">
                    <i class="fa-solid fa-clock-rotate-left"></i> History
                  </button>
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
        <template x-if="search"><span> (filtered from <strong x-text="roles.length"></strong>)</span></template>
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
       ASSIGN PERMISSION MODAL
  ══════════════════════════════════════════ -->
  <div class="overlay" x-show="modal==='assign'"
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="modal=''">
    <div class="modal ap-modal"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">

      <!-- Head -->
      <div class="modal-head ap-head">
        <h3><i class="fa-solid fa-key"></i> Assign Permissions</h3>
        <button class="modal-close" @click="modal=''"><i class="fa-solid fa-xmark"></i></button>
      </div>

      <!-- Meta bar -->
      <div class="ap-meta">
        <div class="ap-meta-row">
          <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
            <span class="ap-role-tag"><i class="fa-solid fa-shield-halved"></i> <span x-text="selectedRole?.name"></span></span>
            <span class="ap-counts"><strong x-text="assignPerms.length"></strong> / <strong x-text="allPermItems.length"></strong> selected</span>
          </div>
          <div style="display:flex;align-items:center;gap:10px">
            <div class="ap-search">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" x-model="permSearch" placeholder="Filter permissions…">
            </div>
          </div>
        </div>
      </div>

      <!-- Select all row -->
      <div class="select-all-row">
        <label>
          <input type="checkbox" :checked="assignPerms.length===allPermItems.length" :indeterminate.prop="assignPerms.length>0&&assignPerms.length<allPermItems.length" @change="$event.target.checked?assignPerms=[...allPermItems]:assignPerms=[]"> Select All Permissions
        </label>
        <button class="link-btn" @click="assignPerms=[]">Clear All</button>
      </div>

      <!-- Groups -->
      <div class="modal-scroll">
        <div class="ap-body">
          <template x-for="group in permGroups" :key="group.name">
            <div class="perm-group" x-show="group.items.some(p=>p.toLowerCase().includes(permSearch.toLowerCase()))">
              <div class="perm-group-head">
                <div class="perm-group-title">
                  <span class="perm-group-dot" :style="`background:${group.color}`"></span>
                  <span x-text="group.name"></span>
                  <span style="font-size:10px;color:var(--muted);font-weight:500">
                    (<span x-text="group.items.filter(p=>assignPerms.includes(p)).length"></span>/<span x-text="group.items.length"></span>)
                  </span>
                </div>
                <div class="perm-group-actions">
                  <button class="link-btn" @click="group.items.forEach(p=>{if(!assignPerms.includes(p))assignPerms.push(p)})">All</button>
                  <button class="link-btn" style="color:var(--danger)" @click="assignPerms=assignPerms.filter(p=>!group.items.includes(p))">None</button>
                </div>
              </div>
              <div class="perm-checkgrid">
                <template x-for="perm in group.items" :key="perm">
                  <label class="perm-check-item"
                         :class="{checked:assignPerms.includes(perm),hidden:!perm.toLowerCase().includes(permSearch.toLowerCase())}">
                    <input type="checkbox" :value="perm" x-model="assignPerms">
                    <span x-text="perm"></span>
                  </label>
                </template>
              </div>
            </div>
          </template>
        </div>
      </div>

      <div class="modal-foot">
        <button class="btn-cancel" @click="modal=''">Cancel</button>
        <button class="btn-save" @click="saveAssign()"><i class="fa-solid fa-floppy-disk"></i> Save Permissions</button>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       EDIT / ADD ROLE MODAL
  ══════════════════════════════════════════ -->
  <div class="overlay" x-show="modal==='edit'||modal==='add'"
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="modal=''">
    <div class="modal er-modal"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="modal-head er-head">
        <h3>
          <i :class="modal==='add'?'fa-solid fa-plus':'fa-solid fa-pen-to-square'"></i>
          <span x-text="modal==='add'?'Add New Role':'Edit Role'"></span>
        </h3>
        <button class="modal-close" @click="modal=''"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="ff" :class="{'has-err':formErr.name}">
        <label>Role Name *</label>
        <input type="text" x-model="form.name" placeholder="Enter role name" @input="formErr.name=''">
        <span class="err" x-text="formErr.name"></span>
      </div>
      <div class="modal-foot">
        <button class="btn-cancel" @click="modal=''">Cancel</button>
        <button class="btn-save" @click="saveRole()">
          <i class="fa-solid fa-floppy-disk"></i>
          <span x-text="modal==='add'?'Add Role':'Update Role'"></span>
        </button>
      </div>
    </div>
  </div>

  <!-- ══════════════════════════════════════════
       HISTORY MODAL
  ══════════════════════════════════════════ -->
  <div class="overlay" x-show="modal==='history'"
       x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="modal=''">
    <div class="modal hist-modal"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="modal-head hist-head">
        <h3><i class="fa-solid fa-clock-rotate-left"></i> Role History — <span x-text="selectedRole?.name"></span></h3>
        <button class="modal-close" @click="modal=''"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="hist-body modal-scroll">
        <template x-if="!historyItems.length">
          <div style="text-align:center;padding:30px;color:var(--muted);font-size:13px">No history available</div>
        </template>
        <template x-for="h in historyItems" :key="h.id">
          <div class="hist-item">
            <div class="hist-icon" :class="h.type"><i :class="h.icon"></i></div>
            <div class="hist-content">
              <div class="hist-action" x-text="h.action"></div>
              <div class="hist-by">By <strong x-text="h.by"></strong></div>
              <div class="hist-time" x-text="h.time"></div>
            </div>
          </div>
        </template>
      </div>
      <div class="modal-foot">
        <button class="btn-cancel" @click="modal=''">Close</button>
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
function rolesApp(){

  const PERM_GROUPS=[
    {name:'User Management',color:'#6366f1',items:['user-registration','password-change','user-logout','assign-permission','assign-permission-role','assign-role','assign-user-role','user_index']},
    {name:'Permissions',color:'#8b5cf6',items:['permission_create','permission_store','permission_edit','permission_update','permission_index','permission_destroy']},
    {name:'Roles',color:'#a855f7',items:['role_create','role_store','role_edit','role_update','role_index','role_destroy']},
    {name:'POP & Box',color:'#3b82f6',items:['pop_index','pop_edit','pop_update','pop_destroy','pop_box','pop-name','box_index','box_create','box_store','box_edit','box_update','box_destroy','box_switch']},
    {name:'Switch',color:'#06b6d4',items:['switch_create','switch_store','switch_index']},
    {name:'Customer',color:'#10b981',items:['customer-support','customer-info','customer-summary','customer-contact-details','customer-technical-details','customer-token-details','customer-accounts']},
    {name:'Token',color:'#f59e0b',items:['close-token','TokenByPOP','assign-token','new-token','update-token','token-category','token-code','token-report','token-search','support-token-close','TokenById']},
    {name:'Reports',color:'#f97316',items:['monthly-report','connection-history','token-report']},
    {name:'Connection',color:'#ec4899',items:['connection-request','connection-request-list']},
    {name:'Requisition',color:'#14b8a6',items:['requisition_create','requisition_store']},
    {name:'Package & Reseller',color:'#22c55e',items:['package_index','reseller_index']},
    {name:'Mikrotik',color:'#ef4444',items:['mikrotik_create','mikrotik_store','mikrotik_index','mikrotik_edit']},
  ]

  const ALL_ITEMS=PERM_GROUPS.flatMap(g=>g.items)
  const ADMIN_PERMS=ALL_ITEMS
  const SUPPORT_EXEC=['password-change','pop_index','pop_edit','customer-support','close-token','TokenByPOP','assign-token','customer-info','customer-summary','customer-contact-details','customer-technical-details','customer-token-details','TokenById','pop-name','token-category','token-code','new-token','update-token','support-token-close','monthly-report','token-report','token-search','requisition_create','requisition_store','package_index','reseller_index','mikrotik_create','mikrotik_store','mikrotik_index','mikrotik_edit']
  const SUPPORT_MGR=['password-change','user-logout','box_switch','pop_index','box_index','box_create','box_store','box_edit','box_update','switch_create','switch_store','switch_index','connection-request','connection-request-list','customer-support','close-token','TokenByPOP','assign-token','customer-info','customer-summary','customer-contact-details','customer-technical-details','customer-token-details','TokenById','pop-name','token-category','token-code','connection-history','customer-accounts','new-token','update-token']
  const ACCOUNTS=['password-change','user_index','customer-info','customer-summary','customer-accounts','monthly-report','token-report','package_index','reseller_index']
  const BILLING=['password-change','customer-info','customer-summary','customer-accounts','monthly-report','package_index']

  const COLORS=['#6366f1','#10b981','#3b82f6','#f59e0b','#ec4899','#14b8a6','#8b5cf6','#f97316']

  return {
    roles:[
      {id:1,name:'Admin',permissions:[...new Set(ADMIN_PERMS)],color:COLORS[0]},
      {id:2,name:'Support Executive',permissions:[...new Set(SUPPORT_EXEC)],color:COLORS[1]},
      {id:3,name:'Support Manager',permissions:[...new Set(SUPPORT_MGR)],color:COLORS[2]},
      {id:4,name:'Accounts Executive',permissions:[...new Set(ACCOUNTS)],color:COLORS[3]},
      {id:5,name:'Billing',permissions:[...new Set(BILLING)],color:COLORS[4]},
    ],
    permGroups:PERM_GROUPS,
    allPermItems:ALL_ITEMS,

    search:'',
    page:1,perPage:50,
    expanded:new Set(),

    modal:'',
    selectedRole:null,
    assignPerms:[],
    permSearch:'',
    form:{name:''},
    formErr:{},
    historyItems:[],

    toast:{show:false,msg:'',type:'success'},

    get filtered(){
      const q=this.search.trim().toLowerCase()
      if(!q)return this.roles
      return this.roles.filter(r=>r.name.toLowerCase().includes(q)||r.permissions.some(p=>p.toLowerCase().includes(q)))
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

    openAssign(role){
      this.selectedRole=role
      this.assignPerms=[...role.permissions]
      this.permSearch=''
      this.modal='assign'
    },
    saveAssign(){
      this.selectedRole.permissions=[...this.assignPerms]
      this.modal=''
      this.showToast(`Permissions updated for ${this.selectedRole.name}`,'success')
    },

    openEdit(role){
      this.selectedRole=role
      this.form={name:role.name}
      this.formErr={}
      this.modal='edit'
    },
    openAddRole(){
      this.selectedRole=null
      this.form={name:''}
      this.formErr={}
      this.modal='add'
    },
    saveRole(){
      if(!this.form.name.trim()){this.formErr={name:'Role name is required'};return}
      if(this.modal==='edit'){
        this.selectedRole.name=this.form.name.trim()
        this.showToast('Role updated successfully','success')
      } else {
        const newId=Math.max(0,...this.roles.map(r=>r.id))+1
        const color=COLORS[newId%COLORS.length]
        this.roles.push({id:newId,name:this.form.name.trim(),permissions:[],color})
        this.showToast('Role added successfully','success')
      }
      this.modal=''
    },

    openHistory(role){
      this.selectedRole=role
      this.historyItems=[
        {id:1,type:'perm',icon:'fa-solid fa-key',action:`Permissions updated — ${role.permissions.length} permissions assigned`,by:'Admin',time:'2026-06-10 14:32:05'},
        {id:2,type:'edit',icon:'fa-solid fa-pen-to-square',action:`Role name set to "${role.name}"`,by:'Admin',time:'2026-06-08 09:15:42'},
        {id:3,type:'add',icon:'fa-solid fa-plus',action:'Role created',by:'System',time:'2026-06-01 10:00:00'},
      ]
      this.modal='history'
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
