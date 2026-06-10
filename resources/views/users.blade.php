<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>All User List</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
:root{
  --primary:#6366f1;--primary-dark:#4f46e5;--primary-light:#eef2ff;
  --success:#10b981;--danger:#ef4444;--warning:#f59e0b;--info:#06b6d4;
  --text:#1e293b;--muted:#64748b;--border:#e2e8f0;--bg:#f8fafc;--card:#fff;
  --radius:12px;--shadow:0 2px 12px rgba(0,0,0,.07);
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Inter',system-ui,sans-serif;background:var(--bg);color:var(--text);font-size:14px;min-height:100vh}
[x-cloak]{display:none!important}

/* ── layout ── */
.page{max-width:1400px;margin:0 auto;padding:24px 20px}
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;gap:12px;flex-wrap:wrap}
.page-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:9px}
.page-title i{color:var(--primary)}

/* ── add button ── */
.btn-add{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border:none;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;transition:.18s;box-shadow:0 3px 10px rgba(99,102,241,.35)}
.btn-add:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(99,102,241,.45)}

/* ── stat cards ── */
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:22px}
.stat{background:var(--card);border-radius:var(--radius);padding:16px 18px;box-shadow:var(--shadow);display:flex;align-items:center;gap:13px;border:1px solid var(--border);position:relative;overflow:hidden;transition:.2s}
.stat::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:var(--radius) var(--radius) 0 0}
.stat.s-total::before{background:linear-gradient(90deg,var(--primary),#818cf8)}
.stat.s-active::before{background:linear-gradient(90deg,var(--success),#34d399)}
.stat.s-inactive::before{background:linear-gradient(90deg,var(--muted),#94a3b8)}
.stat.s-accounting::before{background:linear-gradient(90deg,var(--warning),#fbbf24)}
.stat-iw{width:40px;height:40px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.stat.s-total .stat-iw{background:var(--primary-light);color:var(--primary)}
.stat.s-active .stat-iw{background:#d1fae5;color:var(--success)}
.stat.s-inactive .stat-iw{background:#f1f5f9;color:var(--muted)}
.stat.s-accounting .stat-iw{background:#fef3c7;color:var(--warning)}
.stat-body{flex:1;min-width:0}
.stat-lbl{font-size:11px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:3px}
.stat-val{font-size:26px;font-weight:800;color:var(--text);line-height:1;letter-spacing:-.5px}

/* ── card ── */
.card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--border);overflow:hidden}
.card-body{padding:18px 20px}

/* ── toolbar ── */
.toolbar{display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;padding:14px 18px;border-bottom:1px solid var(--border)}
.toolbar-left{display:flex;align-items:center;gap:8px}
.show-lbl{font-size:13px;color:var(--muted)}
.show-sel{padding:5px 28px 5px 10px;border:1.5px solid var(--border);border-radius:7px;font-size:13px;color:var(--text);background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 9px center;appearance:none;cursor:pointer;outline:none;transition:.15s}
.show-sel:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.toolbar-right{display:flex;align-items:center;gap:8px}
.search-wrap{position:relative;display:flex;align-items:center}
.search-wrap i{position:absolute;left:10px;color:var(--muted);font-size:13px;pointer-events:none}
.search-inp{padding:7px 12px 7px 32px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;width:220px;outline:none;transition:.2s;color:var(--text)}
.search-inp:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.12);width:270px}
.search-inp::placeholder{color:#94a3b8}

/* ── table ── */
.tbl-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch}
table{width:100%;border-collapse:collapse;white-space:nowrap}
thead th{background:#f8fafc;padding:11px 14px;font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;border-bottom:2px solid var(--border);text-align:left;position:relative}
thead th.sortable{cursor:pointer;user-select:none}
thead th.sortable:hover{color:var(--primary);background:#f0f4ff}
thead th .sort-icon{margin-left:4px;opacity:.5;font-size:10px}
thead th.asc .sort-icon::before{content:'\f0de';font-family:'Font Awesome 6 Free';font-weight:900}
thead th.desc .sort-icon::before{content:'\f0dd';font-family:'Font Awesome 6 Free';font-weight:900}
thead th:not(.asc):not(.desc) .sort-icon::before{content:'\f0dc';font-family:'Font Awesome 6 Free';font-weight:900}
tbody tr{border-bottom:1px solid #f1f5f9;transition:background .12s}
tbody tr:hover{background:#fafbff}
tbody td{padding:12px 14px;font-size:13px;color:var(--text);vertical-align:middle}
tbody tr:last-child{border-bottom:none}

/* ── id cell ── */
.id-cell{font-weight:700;color:var(--muted);font-size:12px}

/* ── user name cell ── */
.user-cell{display:flex;align-items:center;gap:9px}
.avatar{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;text-transform:uppercase}
.user-name{font-weight:600;color:var(--text)}

/* ── email cell ── */
.email-cell{color:var(--muted);font-size:12px;font-family:'SF Mono',monospace}

/* ── company cell ── */
.company-cell{font-size:13px;color:var(--text);white-space:normal;max-width:120px;line-height:1.35}

/* ── role badges ── */
.role-wrap{display:flex;flex-wrap:wrap;gap:4px;max-width:180px}
.role-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 8px;border-radius:20px;font-size:11px;font-weight:600;line-height:1.2;white-space:nowrap}
.rb-admin{background:#ede9fe;color:#6d28d9}
.rb-support{background:#ccfbf1;color:#0f766e}
.rb-accounts{background:#fef3c7;color:#92400e}
.rb-api{background:#dbeafe;color:#1d4ed8}
.rb-billing{background:#fce7f3;color:#9d174d}
.rb-pop{background:#e0f2fe;color:#0369a1}
.rb-default{background:#f1f5f9;color:#475569}

/* ── active state ── */
.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:600}
.badge-active{background:#d1fae5;color:#065f46}
.badge-active::before{content:'';display:inline-block;width:6px;height:6px;border-radius:50%;background:#10b981}
.badge-inactive{background:#f1f5f9;color:#64748b}
.badge-inactive::before{content:'';display:inline-block;width:6px;height:6px;border-radius:50%;background:#94a3b8}

/* ── accounting ── */
.acc-yes{display:inline-flex;align-items:center;gap:4px;font-size:12px;font-weight:600;color:var(--success)}
.acc-no{display:inline-flex;align-items:center;gap:4px;font-size:12px;font-weight:600;color:#ef4444}

/* ── last edit ── */
.edit-by{font-size:12px;color:var(--muted)}

/* ── action dropdown ── */
.act-wrap{position:relative}
.act-btn{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border:none;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;transition:.15s}
.act-btn:hover{filter:brightness(1.1)}
.act-btn i{font-size:10px;transition:.2s}
.act-menu{position:absolute;right:0;top:calc(100% + 4px);background:#fff;border-radius:10px;box-shadow:0 8px 30px rgba(0,0,0,.15);border:1px solid var(--border);min-width:160px;z-index:100;overflow:hidden}
.act-item{display:flex;align-items:center;gap:9px;padding:9px 14px;font-size:13px;cursor:pointer;transition:background .12s;color:var(--text)}
.act-item:hover{background:#f8fafc}
.act-item.danger{color:#ef4444}
.act-item.danger:hover{background:#fff5f5}
.act-item i{width:14px;text-align:center;font-size:12px}

/* ── footer ── */
.tbl-footer{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
.tbl-info{font-size:12px;color:var(--muted)}
.tbl-info strong{color:var(--text)}
.pagination{display:flex;align-items:center;gap:4px}
.pg-btn{width:30px;height:30px;display:flex;align-items:center;justify-content:center;border-radius:7px;border:1.5px solid var(--border);background:#fff;font-size:12px;font-weight:600;cursor:pointer;color:var(--muted);transition:.15s;line-height:1}
.pg-btn:hover{border-color:var(--primary);color:var(--primary)}
.pg-btn.active{background:var(--primary);border-color:var(--primary);color:#fff}
.pg-btn:disabled{opacity:.4;cursor:not-allowed}

/* ── add user modal ── */
.overlay{position:fixed;inset:0;background:rgba(15,23,42,.55);backdrop-filter:blur(3px);display:flex;align-items:center;justify-content:center;z-index:500;padding:20px}
.modal{background:#fff;border-radius:16px;width:100%;max-width:560px;box-shadow:0 20px 60px rgba(0,0,0,.2);overflow:hidden}
.modal-head{padding:18px 22px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));display:flex;align-items:center;justify-content:space-between}
.modal-head h3{font-size:16px;font-weight:700;color:#fff;display:flex;align-items:center;gap:8px}
.modal-close{background:rgba(255,255,255,.18);border:none;color:#fff;width:28px;height:28px;border-radius:50%;cursor:pointer;font-size:14px;display:flex;align-items:center;justify-content:center;transition:.15s}
.modal-close:hover{background:rgba(255,255,255,.3)}
.modal-body{padding:22px}
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-grid .full{grid-column:1/-1}
.ff{display:flex;flex-direction:column;gap:5px}
.ff label{font-size:12px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.3px}
.ff input,.ff select{padding:9px 11px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;color:var(--text);outline:none;transition:.15s;background:#fff;width:100%}
.ff select{appearance:none;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 10px center;padding-right:28px}
.ff input:focus,.ff select:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.12)}
.ff .err{font-size:11px;color:#ef4444;display:none}
.ff.has-err input,.ff.has-err select{border-color:#ef4444}
.ff.has-err .err{display:block}
.modal-foot{display:flex;justify-content:flex-end;gap:9px;padding:14px 22px;border-top:1px solid var(--border);background:#fafbff}
.btn-cancel{padding:8px 16px;border:1.5px solid var(--border);background:#fff;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;color:var(--muted);transition:.15s}
.btn-cancel:hover{border-color:var(--muted);color:var(--text)}
.btn-save{padding:8px 20px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;transition:.18s;box-shadow:0 3px 10px rgba(99,102,241,.3)}
.btn-save:hover{transform:translateY(-1px);box-shadow:0 5px 16px rgba(99,102,241,.4)}

/* ── toast ── */
.toast-wrap{position:fixed;bottom:24px;right:24px;z-index:999;display:flex;flex-direction:column;gap:8px;pointer-events:none}
.toast{padding:11px 16px;border-radius:10px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 6px 24px rgba(0,0,0,.2);display:flex;align-items:center;gap:8px;min-width:220px;pointer-events:auto}
.toast.success{background:linear-gradient(135deg,#10b981,#059669)}
.toast.danger{background:linear-gradient(135deg,#ef4444,#dc2626)}

/* ── empty ── */
.empty-row td{text-align:center;padding:40px;color:var(--muted);font-size:13px}
.empty-row i{font-size:28px;display:block;margin-bottom:8px;opacity:.35}

/* ── responsive ── */
@media(max-width:900px){
  .stats{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:600px){
  .stats{grid-template-columns:1fr 1fr}
  .page-head{flex-direction:column;align-items:flex-start}
  .toolbar{flex-direction:column;align-items:stretch}
  .toolbar-right{justify-content:flex-end}
  .search-inp,.search-inp:focus{width:100%}
  .form-grid{grid-template-columns:1fr}
  .form-grid .full{grid-column:1}
  .tbl-footer{flex-direction:column;align-items:flex-start}
}
</style>
</head>
<body>
<div class="page" x-data="usersApp()" x-cloak>

  <!-- Page Header -->
  <div class="page-head">
    <div class="page-title">
      <i class="fa-solid fa-users"></i>
      All User List
    </div>
    <button class="btn-add" @click="showModal=true">
      <i class="fa-solid fa-plus"></i> Add User
    </button>
  </div>

  <!-- Stats -->
  <div class="stats">
    <div class="stat s-total">
      <div class="stat-iw"><i class="fa-solid fa-users"></i></div>
      <div class="stat-body">
        <div class="stat-lbl">Total Users</div>
        <div class="stat-val" x-text="users.length"></div>
      </div>
    </div>
    <div class="stat s-active">
      <div class="stat-iw"><i class="fa-solid fa-circle-check"></i></div>
      <div class="stat-body">
        <div class="stat-lbl">Active</div>
        <div class="stat-val" x-text="users.filter(u=>u.state==='Active').length"></div>
      </div>
    </div>
    <div class="stat s-inactive">
      <div class="stat-iw"><i class="fa-solid fa-circle-xmark"></i></div>
      <div class="stat-body">
        <div class="stat-lbl">Inactive</div>
        <div class="stat-val" x-text="users.filter(u=>u.state!=='Active').length"></div>
      </div>
    </div>
    <div class="stat s-accounting">
      <div class="stat-iw"><i class="fa-solid fa-calculator"></i></div>
      <div class="stat-body">
        <div class="stat-lbl">Accounting</div>
        <div class="stat-val" x-text="users.filter(u=>u.accounting==='yes').length"></div>
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
          <option>50</option>
          <option selected>100</option>
        </select>
        <span class="show-lbl">entries</span>
      </div>
      <div class="toolbar-right">
        <div class="search-wrap">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input class="search-inp" type="text" placeholder="Search users…"
                 x-model="search" @input="page=1">
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="tbl-wrap">
      <table>
        <thead>
          <tr>
            <th class="sortable" :class="{asc:sortKey==='id'&&sortDir==='asc',desc:sortKey==='id'&&sortDir==='desc'}" @click="cycleSort('id')">
              ID <span class="sort-icon"></span>
            </th>
            <th class="sortable" :class="{asc:sortKey==='name'&&sortDir==='asc',desc:sortKey==='name'&&sortDir==='desc'}" @click="cycleSort('name')">
              User's name <span class="sort-icon"></span>
            </th>
            <th class="sortable" :class="{asc:sortKey==='email'&&sortDir==='asc',desc:sortKey==='email'&&sortDir==='desc'}" @click="cycleSort('email')">
              Email <span class="sort-icon"></span>
            </th>
            <th>Company</th>
            <th>Role</th>
            <th>Active State</th>
            <th>Accounting</th>
            <th>Last Edit By</th>
            <th style="text-align:center">Action</th>
          </tr>
        </thead>
        <tbody>
          <template x-if="paged.length===0">
            <tr class="empty-row">
              <td colspan="9">
                <i class="fa-regular fa-circle-user"></i>
                No users found
              </td>
            </tr>
          </template>
          <template x-for="u in paged" :key="u.id">
            <tr>
              <!-- ID -->
              <td><span class="id-cell" x-text="u.id"></span></td>

              <!-- User name -->
              <td>
                <div class="user-cell">
                  <div class="avatar" :style="`background:${u.avatarBg};color:${u.avatarFg}`" x-text="u.initials"></div>
                  <span class="user-name" x-text="u.name"></span>
                </div>
              </td>

              <!-- Email -->
              <td><span class="email-cell" x-text="u.email"></span></td>

              <!-- Company -->
              <td><span class="company-cell" x-text="u.company||'—'"></span></td>

              <!-- Roles -->
              <td>
                <div class="role-wrap">
                  <template x-for="r in u.roles" :key="r.label">
                    <span class="role-badge" :class="r.cls" x-text="r.label"></span>
                  </template>
                  <template x-if="!u.roles||u.roles.length===0">
                    <span class="role-badge rb-default">—</span>
                  </template>
                </div>
              </td>

              <!-- Active State -->
              <td>
                <span x-show="u.state==='Active'" class="badge badge-active">Active</span>
                <span x-show="u.state!=='Active'" class="badge badge-inactive">Inactive</span>
              </td>

              <!-- Accounting -->
              <td>
                <span x-show="u.accounting==='yes'" class="acc-yes"><i class="fa-solid fa-check"></i> Yes</span>
                <span x-show="u.accounting==='no'" class="acc-no"><i class="fa-solid fa-xmark"></i> No</span>
                <span x-show="u.accounting!=='yes'&&u.accounting!=='no'" class="edit-by">—</span>
              </td>

              <!-- Last edit -->
              <td><span class="edit-by" x-text="u.editBy||'—'"></span></td>

              <!-- Action -->
              <td style="text-align:center">
                <div class="act-wrap" x-data="{open:false}" @click.outside="open=false">
                  <button class="act-btn" @click="open=!open">
                    Action <i class="fa-solid fa-chevron-down" :style="open?'transform:rotate(180deg)':''"></i>
                  </button>
                  <div class="act-menu" x-show="open" x-transition:enter="transition ease-out duration-100"
                       x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                       x-transition:leave="transition ease-in duration-75"
                       x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <div class="act-item" @click="editUser(u);open=false">
                      <i class="fa-solid fa-pen-to-square" style="color:var(--primary)"></i> Edit
                    </div>
                    <div class="act-item" @click="resetPwd(u);open=false">
                      <i class="fa-solid fa-key" style="color:var(--warning)"></i> Reset Password
                    </div>
                    <div class="act-item" @click="toggleState(u);open=false">
                      <i class="fa-solid fa-toggle-on" style="color:var(--success)"></i>
                      <span x-text="u.state==='Active'?'Deactivate':'Activate'"></span>
                    </div>
                    <div class="act-item danger" @click="deleteUser(u.id);open=false">
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
        <template x-if="search"><span style="color:var(--muted)"> (filtered from <strong x-text="users.length"></strong>)</span></template>
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

  <!-- ── Add / Edit Modal ── -->
  <div class="overlay" x-show="showModal" x-transition:enter="transition ease-out duration-200"
       x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
       x-transition:leave="transition ease-in duration-150"
       x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
       @click.self="closeModal()">
    <div class="modal" x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
      <div class="modal-head">
        <h3><i class="fa-solid fa-user-plus"></i> <span x-text="editMode?'Edit User':'Add New User'"></span></h3>
        <button class="modal-close" @click="closeModal()"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body">
        <div class="form-grid">
          <div class="ff" :class="{'has-err':errors.name}">
            <label>Username *</label>
            <input type="text" x-model="form.name" placeholder="e.g. john_doe" @input="errors.name=''">
            <span class="err" x-text="errors.name"></span>
          </div>
          <div class="ff" :class="{'has-err':errors.email}">
            <label>Email *</label>
            <input type="email" x-model="form.email" placeholder="user@example.com" @input="errors.email=''">
            <span class="err" x-text="errors.email"></span>
          </div>
          <div class="ff">
            <label>Company</label>
            <input type="text" x-model="form.company" placeholder="Company name">
          </div>
          <div class="ff">
            <label>Role</label>
            <select x-model="form.role">
              <option value="">— Select role —</option>
              <option value="Admin">Admin</option>
              <option value="Support Executive">Support Executive</option>
              <option value="Accounts Executive">Accounts Executive</option>
              <option value="Billing">Billing</option>
              <option value="Api User">Api User</option>
            </select>
          </div>
          <div class="ff">
            <label>Active State</label>
            <select x-model="form.state">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select>
          </div>
          <div class="ff">
            <label>Accounting</label>
            <select x-model="form.accounting">
              <option value="yes">Yes</option>
              <option value="no">No</option>
            </select>
          </div>
          <template x-if="!editMode">
            <div class="ff full" :class="{'has-err':errors.password}">
              <label>Password *</label>
              <input type="password" x-model="form.password" placeholder="••••••••" @input="errors.password=''">
              <span class="err" x-text="errors.password"></span>
            </div>
          </template>
        </div>
      </div>
      <div class="modal-foot">
        <button class="btn-cancel" @click="closeModal()">Cancel</button>
        <button class="btn-save" @click="saveUser()">
          <i class="fa-solid fa-floppy-disk"></i>
          <span x-text="editMode?'Update User':'Add User'"></span>
        </button>
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
function usersApp(){
  const AVATARS=[
    {bg:'#ddd6fe',fg:'#6d28d9'},{bg:'#ccfbf1',fg:'#0f766e'},{bg:'#fef3c7',fg:'#92400e'},
    {bg:'#dbeafe',fg:'#1d4ed8'},{bg:'#fce7f3',fg:'#9d174d'},{bg:'#e0f2fe',fg:'#0369a1'},
    {bg:'#d1fae5',fg:'#065f46'},{bg:'#fee2e2',fg:'#991b1b'},{bg:'#f3e8ff',fg:'#7e22ce'},
    {bg:'#ecfdf5',fg:'#047857'}
  ]
  function mkAvatar(name,idx){
    const c=AVATARS[idx%AVATARS.length]
    const parts=name.trim().split(/\s+/)
    const initials=parts.length>=2?parts[0][0]+parts[parts.length-1][0]:name.substring(0,2)
    return {avatarBg:c.bg,avatarFg:c.fg,initials:initials.toUpperCase()}
  }
  const ROLE_MAP={
    'Admin':'rb-admin','Support Executive':'rb-support','Accounts Executive':'rb-accounts',
    'Api User':'rb-api','Billing':'rb-billing','pop transfer':'rb-pop','pop tanasfer':'rb-pop'
  }
  function mkRoles(arr){
    return arr.map(r=>({label:r,cls:ROLE_MAP[r]||'rb-default'}))
  }

  const raw=[
    {id:18,name:'Saimon',email:'saimon@delta.com',company:'Delta',roles:['Accounts Executive','pop tanasfer'],state:'Active',accounting:'yes',editBy:'Saimon'},
    {id:17,name:'Rased',email:'rased@yetfix.com',company:'Circle Network',roles:['Support Executive'],state:'Active',accounting:'no',editBy:'Rased'},
    {id:16,name:'bill_pay',email:'bill_pay@demo.com',company:'',roles:[],state:'',accounting:'yes',editBy:''},
    {id:15,name:'bkash',email:'user@bkash.com',company:'Api User',roles:[],state:'Active',accounting:'yes',editBy:''},
    {id:14,name:'Ashikur Rahaman Joy',email:'ashikurrahaman@yetfix.net',company:'Circle Network',roles:['Support Executive'],state:'Active',accounting:'no',editBy:'afsana suraya'},
    {id:13,name:'Tuhin Ahmed Rony',email:'rony@yetfix.com',company:'Circle Network',roles:['Support Executive'],state:'Active',accounting:'no',editBy:'afsana suraya'},
    {id:12,name:'Meraj Rabby',email:'merajrabby@yetfix.net',company:'Circle Network',roles:['Support Executive'],state:'Active',accounting:'yes',editBy:'afsana suraya'},
    {id:11,name:'Sarwar Hossain',email:'sarwar@circlenetworkbd.net',company:'Circle Network',roles:['Support Executive'],state:'Active',accounting:'no',editBy:'afsana suraya'},
    {id:10,name:'Saharear Sumon',email:'shariyersumon@gmail.com',company:'Circle Network',roles:['Support Executive'],state:'Active',accounting:'no',editBy:'afsana suraya'},
    {id:9,name:'Sohel Rana',email:'sohelrana76@yetfix.net',company:'Circle Network',roles:['Support Executive'],state:'Active',accounting:'yes',editBy:'afsana suraya'},
    {id:8,name:'Afsana Suraya',email:'afsana@yetfix.net',company:'Circle Network',roles:['Admin'],state:'Active',accounting:'yes',editBy:'admin'},
    {id:7,name:'Md Rakibul Islam',email:'rakib@circlenetwork.net',company:'Circle Network',roles:['Support Executive'],state:'Active',accounting:'no',editBy:'afsana suraya'},
    {id:6,name:'Tanvir Ahmed',email:'tanvir@yetfix.com',company:'YetFix',roles:['Accounts Executive'],state:'Active',accounting:'yes',editBy:'admin'},
    {id:5,name:'Nusrat Jahan',email:'nusrat@yetfix.com',company:'YetFix',roles:['Billing'],state:'Active',accounting:'yes',editBy:'admin'},
    {id:4,name:'api_gateway',email:'api@demo.com',company:'',roles:['Api User'],state:'Active',accounting:'no',editBy:''},
  ]

  const users=raw.map((u,i)=>({...u,...mkAvatar(u.name,i),roles:mkRoles(u.roles)}))

  return {
    users,
    search:'',
    sortKey:'id',sortDir:'desc',
    page:1,perPage:100,
    showModal:false,editMode:false,editId:null,
    form:{name:'',email:'',company:'',role:'',state:'Active',accounting:'no',password:''},
    errors:{},
    toast:{show:false,msg:'',type:'success'},

    get filtered(){
      let q=this.search.trim().toLowerCase()
      let rows=this.users
      if(q) rows=rows.filter(u=>
        u.name.toLowerCase().includes(q)||
        u.email.toLowerCase().includes(q)||
        u.company.toLowerCase().includes(q)||
        u.roles.some(r=>r.label.toLowerCase().includes(q))||
        (u.editBy||'').toLowerCase().includes(q)
      )
      const k=this.sortKey,d=this.sortDir==='asc'?1:-1
      rows=[...rows].sort((a,b)=>{
        const av=k==='id'?a[k]:String(a[k]).toLowerCase()
        const bv=k==='id'?b[k]:String(b[k]).toLowerCase()
        return av>bv?d:av<bv?-d:0
      })
      return rows
    },
    get totalPages(){return Math.max(1,Math.ceil(this.filtered.length/this.perPage))},
    get paged(){
      const s=(this.page-1)*this.perPage
      return this.filtered.slice(s,s+this.perPage)
    },
    get pageStart(){return this.filtered.length===0?0:(this.page-1)*this.perPage+1},
    get pageEnd(){return Math.min(this.page*this.perPage,this.filtered.length)},
    get visiblePages(){
      const t=this.totalPages,c=this.page,pages=[]
      if(t<=7){for(let i=1;i<=t;i++)pages.push(i);return pages}
      pages.push(1)
      if(c>3)pages.push('…')
      const s=Math.max(2,c-1),e=Math.min(t-1,c+1)
      for(let i=s;i<=e;i++)pages.push(i)
      if(c<t-2)pages.push('…')
      pages.push(t)
      return pages
    },

    cycleSort(k){
      if(this.sortKey===k)this.sortDir=this.sortDir==='asc'?'desc':'asc'
      else{this.sortKey=k;this.sortDir='asc'}
      this.page=1
    },

    editUser(u){
      this.editMode=true;this.editId=u.id
      this.form={
        name:u.name,email:u.email,company:u.company,
        role:u.roles.length?u.roles[0].label:'',
        state:u.state,accounting:u.accounting,password:''
      }
      this.errors={}
      this.showModal=true
    },

    toggleState(u){
      u.state=u.state==='Active'?'Inactive':'Active'
      this.showToast(`${u.name} is now ${u.state}`,'success')
    },

    resetPwd(u){
      this.showToast(`Password reset link sent to ${u.email}`,'success')
    },

    deleteUser(id){
      this.users.splice(this.users.findIndex(u=>u.id===id),1)
      this.showToast('User deleted','danger')
    },

    saveUser(){
      this.errors={}
      if(!this.form.name.trim())this.errors.name='Username is required'
      if(!this.form.email.trim())this.errors.email='Email is required'
      if(!this.editMode&&!this.form.password.trim())this.errors.password='Password is required'
      if(Object.keys(this.errors).length)return

      const ROLE_MAP={'Admin':'rb-admin','Support Executive':'rb-support','Accounts Executive':'rb-accounts','Api User':'rb-api','Billing':'rb-billing'}
      const roles=this.form.role?[{label:this.form.role,cls:ROLE_MAP[this.form.role]||'rb-default'}]:[]

      if(this.editMode){
        const u=this.users.find(u=>u.id===this.editId)
        if(u){Object.assign(u,{name:this.form.name,email:this.form.email,company:this.form.company,roles,state:this.form.state,accounting:this.form.accounting})}
        this.showToast('User updated successfully','success')
      } else {
        const newId=Math.max(0,...this.users.map(u=>u.id))+1
        const avatar=mkAvatar(this.form.name,this.users.length)
        this.users.unshift({id:newId,...avatar,name:this.form.name,email:this.form.email,company:this.form.company,roles,state:this.form.state,accounting:this.form.accounting,editBy:'admin'})
        this.showToast('User added successfully','success')
      }
      this.closeModal()
    },

    closeModal(){
      this.showModal=false;this.editMode=false;this.editId=null
      this.form={name:'',email:'',company:'',role:'',state:'Active',accounting:'no',password:''}
      this.errors={}
    },

    showToast(msg,type='success'){
      this.toast={show:true,msg,type}
      setTimeout(()=>this.toast.show=false,3000)
    },

    init(){
      this.$watch('search',()=>this.page=1)
    }
  }
}
</script>
</body>
</html>
