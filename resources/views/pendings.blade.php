<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Pending Customer List</title>
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
  --warning:#F59E0B; --warning-l:#FEF3C7; --warning-d:#D97706;
  --amber-grad:linear-gradient(135deg,#F59E0B,#EF4444);
  --teal:#0D9488;    --teal-l:#CCFBF1;
  --text:#0F172A; --text2:#1E293B; --muted:#64748B; --light:#94A3B8;
  --border:#E2E8F0; --border-l:#F1F5F9;
  --surface:#FFFFFF; --bg:#F1F5F9; --bg-alt:#F8FAFC;
  --th:#1E293B;
  --sh-sm:0 1px 3px rgba(0,0,0,.06);
  --sh:0 4px 12px rgba(0,0,0,.07);
  --sh-md:0 12px 28px rgba(0,0,0,.12);
  --r:10px; --r-sm:6px; --r-lg:14px;
}
html{font-family:'Inter',sans-serif;font-size:14px}
body{background:var(--bg);color:var(--text);min-height:100vh}
[x-cloak]{display:none!important}

/* ── Page ────────────────────────────────────────── */
.pw{max-width:1700px;margin:0 auto;padding:24px 20px 48px}

/* ── Toast ───────────────────────────────────────── */
.toast{
  position:fixed;top:20px;right:20px;z-index:9999;
  display:flex;align-items:center;gap:10px;
  padding:12px 18px;border-radius:var(--r-sm);
  background:#1E293B;color:#fff;font-size:13px;font-weight:500;
  box-shadow:var(--sh-md);
  transition:all .3s;
}
.toast.success{background:linear-gradient(135deg,#059669,#10B981)}
.toast.danger {background:linear-gradient(135deg,#DC2626,#EF4444)}
.toast i{font-size:15px}

/* ── Confirm modal ───────────────────────────────── */
.overlay{
  position:fixed;inset:0;z-index:9000;
  background:rgba(15,23,42,.55);backdrop-filter:blur(3px);
  display:flex;align-items:center;justify-content:center;
  padding:20px;
}
.modal{
  background:#fff;border-radius:var(--r-lg);padding:32px 28px;
  max-width:400px;width:100%;box-shadow:var(--sh-md);
  text-align:center;
}
.modal-icon{
  width:56px;height:56px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-size:22px;margin:0 auto 16px;
}
.modal-icon.danger{background:var(--danger-l);color:var(--danger)}
.modal h3{font-size:17px;font-weight:700;color:var(--text);margin-bottom:8px}
.modal p{font-size:13px;color:var(--muted);line-height:1.6}
.modal-btns{display:flex;gap:10px;justify-content:center;margin-top:22px}
.mbtn{
  padding:9px 22px;border-radius:var(--r-sm);font-size:13px;font-weight:600;
  cursor:pointer;border:none;transition:all .15s;
}
.mbtn.cancel{background:var(--bg-alt);color:var(--muted);border:1px solid var(--border)}
.mbtn.cancel:hover{color:var(--text);background:var(--border)}
.mbtn.confirm-del{background:var(--danger);color:#fff;box-shadow:0 3px 10px rgba(239,68,68,.3)}
.mbtn.confirm-del:hover{background:var(--danger-d)}

/* ── Header ──────────────────────────────────────── */
.ph{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:22px;flex-wrap:wrap}
.ph-left{display:flex;align-items:center;gap:12px}
.ph-icon{
  width:42px;height:42px;border-radius:11px;flex-shrink:0;
  background:linear-gradient(135deg,#F59E0B 0%,#EF4444 100%);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:17px;
  box-shadow:0 4px 14px rgba(245,158,11,.40);
}
.ph-title{font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
.ph-sub{font-size:12px;color:var(--muted);margin-top:1px}
.pending-count-chip{
  display:inline-flex;align-items:center;gap:6px;
  padding:5px 12px;border-radius:20px;
  background:var(--warning-l);color:var(--warning-d);
  font-size:12px;font-weight:700;
  border:1px solid rgba(245,158,11,.25);
}
.pending-count-chip i{font-size:11px}

/* ── Filter card ─────────────────────────────────── */
.fc{
  background:var(--surface);border-radius:var(--r);padding:18px 20px 16px;
  border:1px solid var(--border);box-shadow:var(--sh-sm);
  margin-bottom:16px;
}
.fc-head{
  display:flex;align-items:center;gap:8px;
  font-size:11px;font-weight:700;color:var(--muted);
  text-transform:uppercase;letter-spacing:.6px;margin-bottom:14px;
}
.fc-head i{color:var(--warning)}
.fc-body{
  display:grid;grid-template-columns:repeat(4,1fr) auto;
  gap:12px;align-items:end;
}
.sg input{
  width:100%;height:40px;padding:0 12px;
  border:1.5px solid var(--border);border-radius:var(--r-sm);
  background:#fff;font-size:13px;font-family:inherit;color:var(--text);
  outline:none;transition:border-color .15s,box-shadow .15s;
}
.sg input:focus{border-color:var(--primary-l);box-shadow:0 0 0 3px rgba(59,130,246,.12)}
.sg input.has-value{border-color:var(--warning);background:#fffbeb}
.sg label{
  display:block;font-size:11px;font-weight:600;
  color:var(--muted);text-transform:uppercase;letter-spacing:.4px;margin-bottom:5px;
}
.sw{position:relative}
.sw select{
  width:100%;height:40px;padding:0 60px 0 12px;
  border:1.5px solid var(--border);border-radius:var(--r-sm);
  background:#fff;font-size:13px;font-family:inherit;color:var(--text);
  appearance:none;-webkit-appearance:none;outline:none;cursor:pointer;
  transition:border-color .15s,box-shadow .15s;
}
.sw select:focus{border-color:var(--primary-l);box-shadow:0 0 0 3px rgba(59,130,246,.12)}
.sw select.has-value{border-color:var(--warning);background:#fffbeb}
.sw .sw-clear{
  position:absolute;right:32px;top:50%;transform:translateY(-50%);
  background:none;border:none;cursor:pointer;
  width:20px;height:20px;display:flex;align-items:center;justify-content:center;
  color:var(--muted);border-radius:50%;transition:all .15s;font-size:11px;
}
.sw .sw-clear:hover{background:var(--danger-l);color:var(--danger)}
.sw .sw-arr{
  position:absolute;right:10px;top:50%;transform:translateY(-50%);
  pointer-events:none;color:var(--muted);font-size:10px;
}
.fc-btns{display:flex;gap:8px;align-self:end}
.btn-search{
  height:40px;padding:0 20px;border:none;border-radius:var(--r-sm);
  background:var(--primary);color:#fff;font-size:13px;font-weight:600;
  cursor:pointer;display:inline-flex;align-items:center;gap:7px;
  box-shadow:0 3px 10px rgba(37,99,235,.3);transition:all .15s;
}
.btn-search:hover{background:var(--primary-d)}
.btn-reset-fc{
  height:40px;padding:0 16px;border:1.5px solid var(--border);border-radius:var(--r-sm);
  background:var(--bg-alt);color:var(--muted);font-size:13px;font-weight:500;
  cursor:pointer;display:inline-flex;align-items:center;gap:6px;
  transition:all .15s;
}
.btn-reset-fc:hover{background:var(--border);color:var(--text)}

/* ── Results card ────────────────────────────────── */
.rc{
  background:var(--surface);border-radius:var(--r-lg);
  border:1px solid var(--border);box-shadow:var(--sh);overflow:hidden;
}
.rc-head{
  display:flex;align-items:center;justify-content:space-between;
  padding:14px 18px;border-bottom:1px solid var(--border-l);
  background:var(--bg-alt);flex-wrap:wrap;gap:10px;
}
.rc-left{display:flex;align-items:center;gap:10px}
.rc-total{
  display:flex;align-items:center;gap:8px;
  font-size:14px;font-weight:700;color:var(--text);
}
.total-num{
  display:inline-flex;align-items:center;justify-content:center;
  min-width:28px;height:24px;padding:0 8px;
  border-radius:12px;background:var(--warning);color:#fff;
  font-size:12px;font-weight:800;
}
.sel-chip{
  display:inline-flex;align-items:center;gap:5px;
  padding:3px 10px;border-radius:20px;
  background:rgba(37,99,235,.1);color:var(--primary);
  font-size:11.5px;font-weight:700;border:1px solid rgba(37,99,235,.2);
}
.rc-actions{display:flex;gap:8px;align-items:center}
.btn-del{
  display:inline-flex;align-items:center;gap:6px;
  padding:8px 16px;border:none;border-radius:var(--r-sm);
  background:var(--danger);color:#fff;font-size:12.5px;font-weight:700;
  cursor:pointer;box-shadow:0 3px 10px rgba(239,68,68,.25);
  transition:all .15s;
}
.btn-del:hover:not([disabled]){background:var(--danger-d)}
.btn-del[disabled]{opacity:.35;cursor:not-allowed;box-shadow:none}
.btn-approve{
  display:inline-flex;align-items:center;gap:6px;
  padding:8px 18px;border:none;border-radius:var(--r-sm);
  background:linear-gradient(135deg,var(--success),var(--success-d));color:#fff;
  font-size:12.5px;font-weight:700;cursor:pointer;
  box-shadow:0 3px 10px rgba(16,185,129,.28);transition:all .15s;
}
.btn-approve:hover:not([disabled]){filter:brightness(1.07)}
.btn-approve[disabled]{opacity:.35;cursor:not-allowed;box-shadow:none}

/* ── Table ───────────────────────────────────────── */
.tscroll{overflow-x:auto}
table{width:100%;border-collapse:collapse;min-width:1400px}
thead th{
  background:var(--th);color:rgba(255,255,255,.82);
  font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;
  padding:11px 13px;text-align:left;white-space:nowrap;
}
thead th.th-cb{width:44px;text-align:center}
tbody tr{border-bottom:1px solid var(--border-l);transition:background .14s}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:rgba(241,245,249,.7)}
tbody tr.sel-row{background:rgba(37,99,235,.04)!important;border-left:3px solid var(--primary)}

tbody td{padding:10px 13px;vertical-align:top;font-size:12.5px}
tbody td.td-cb{text-align:center;padding:10px 0;width:44px}

/* Custom checkbox */
.cb{
  width:16px;height:16px;accent-color:var(--primary);cursor:pointer;
}

/* ID chip */
.id-chip{
  display:inline-flex;align-items:center;justify-content:center;
  padding:2px 8px;border-radius:4px;
  background:var(--th);color:rgba(255,255,255,.8);
  font-size:11px;font-weight:700;font-family:monospace;
}

/* User cell */
.urow{display:flex;align-items:center;gap:7px}
.av{
  width:26px;height:26px;border-radius:50%;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;
  font-size:9.5px;font-weight:800;color:#fff;
  background:linear-gradient(135deg,#F59E0B,#EF4444);
}
.uname{font-size:12.5px;font-weight:700;color:var(--text)}

/* Status badge */
.sbadge{
  display:inline-flex;align-items:center;gap:5px;
  padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700;
}
.sbadge.pending{background:var(--warning-l);color:var(--warning-d)}
.sdot{width:6px;height:6px;border-radius:50%;flex-shrink:0;background:var(--warning)}

/* Expire */
.exp-date{font-size:12.5px;font-weight:600;color:var(--text)}
.exp-bd{font-size:10.5px;color:var(--muted);margin-top:2px}

/* Bill mini */
.brow{display:flex;justify-content:space-between;gap:8px;font-size:11px;margin-bottom:2px}
.bk{color:var(--muted)}
.bv{color:var(--text);font-weight:600}

/* Package pill */
.pkg-pill{
  display:inline-flex;align-items:center;
  padding:3px 8px;border-radius:4px;font-size:10.5px;font-weight:600;color:#0D7A72;
  background:linear-gradient(135deg,rgba(13,148,136,.1),rgba(20,184,166,.06));
  border:1px solid rgba(13,148,136,.2);
  white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:170px;
  margin-bottom:3px;display:block;
}

/* POP/Manager */
.pm-row{display:flex;align-items:flex-start;gap:4px;font-size:11.5px;margin-bottom:3px}
.pm-lbl{font-size:10px;font-weight:700;color:var(--muted);min-width:30px;padding-top:1px}
.pm-val{color:var(--text);font-weight:500;line-height:1.4}

/* Other cells */
.nname{font-size:13px;font-weight:700;color:var(--text)}
.cnum{font-size:12px;font-weight:600;color:var(--text);letter-spacing:.2px;white-space:nowrap}
.uinfo{
  display:inline-flex;align-items:center;gap:4px;
  padding:2px 7px;border-radius:4px;
  background:rgba(99,102,241,.08);color:#4F46E5;
  font-size:10.5px;font-weight:600;border:1px solid rgba(99,102,241,.15);
  white-space:nowrap;
}
.dchip{
  display:inline-flex;align-items:center;gap:4px;
  padding:2px 7px;border-radius:4px;
  background:var(--border-l);color:var(--muted);
  font-size:11px;font-weight:500;white-space:nowrap;
}
.remarks-txt{
  font-size:11.5px;color:var(--muted);
  max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;
}
.remarks-empty{font-size:12px;color:var(--light)}
.by-chip{
  display:inline-flex;align-items:center;gap:4px;
  padding:2px 8px;border-radius:4px;
  background:#F1F5F9;color:var(--muted);
  font-size:11px;font-weight:600;
}
.by-chip i{font-size:9px}

/* Empty state */
.empty-state{text-align:center;padding:56px 24px;color:var(--muted)}
.empty-icon{
  width:64px;height:64px;border-radius:50%;
  background:var(--warning-l);color:var(--warning);
  display:flex;align-items:center;justify-content:center;
  font-size:24px;margin:0 auto 16px;
}
.empty-state h3{font-size:15px;font-weight:700;color:var(--text2);margin-bottom:6px}
.empty-state p{font-size:13px;color:var(--muted)}

/* ── Responsive ──────────────────────────────────── */
@media(max-width:1200px){
  .fc-body{grid-template-columns:repeat(2,1fr)}
  .fc-btns{grid-column:span 2;justify-content:flex-end}
}
@media(max-width:700px){
  .pw{padding:14px 12px 32px}
  .fc-body{grid-template-columns:1fr}
  .fc-btns{grid-column:1;width:100%}
  .btn-search,.btn-reset-fc{flex:1;justify-content:center}
  .ph-title{font-size:17px}
}
</style>
</head>
<body>
<div class="pw" x-data="pendingList()">

  <!-- ── Toast ── -->
  <div class="toast"
    :class="toast.type"
    x-show="toast.show" x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-x-4"
    x-transition:enter-end="opacity-100 translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">
    <i :class="toast.type==='success'?'fa-solid fa-circle-check':'fa-solid fa-circle-exclamation'"></i>
    <span x-text="toast.msg"></span>
  </div>

  <!-- ── Delete confirm modal ── -->
  <div class="overlay" x-show="showConfirm" x-cloak @click.self="showConfirm=false"
    x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100">
    <div class="modal"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 scale-95"
      x-transition:enter-end="opacity-100 scale-100">
      <div class="modal-icon danger"><i class="fa-solid fa-trash-can"></i></div>
      <h3>Confirm Delete</h3>
      <p>You are about to permanently delete <strong x-text="selected.length"></strong> customer request(s). This action cannot be undone.</p>
      <div class="modal-btns">
        <button class="mbtn cancel" @click="showConfirm=false">Cancel</button>
        <button class="mbtn confirm-del" @click="doDelete">
          <i class="fa-solid fa-trash-can"></i> Delete
        </button>
      </div>
    </div>
  </div>

  <!-- ── Header ── -->
  <div class="ph">
    <div class="ph-left">
      <div class="ph-icon"><i class="fa-solid fa-hourglass-half"></i></div>
      <div>
        <div class="ph-title">Pending Customer List</div>
        <div class="ph-sub">Review, approve or reject new customer requests</div>
      </div>
    </div>
    <div class="pending-count-chip">
      <i class="fa-solid fa-clock"></i>
      <span x-text="customers.length + ' awaiting review'"></span>
    </div>
  </div>

  <!-- ── Filter card ── -->
  <div class="fc">
    <div class="fc-head"><i class="fa-solid fa-sliders"></i> Filter Requests</div>
    <div class="fc-body">
      <!-- Manager -->
      <div class="sg">
        <label>Select Manager</label>
        <div class="sw">
          <select x-model="filter.manager" :class="filter.manager?'has-value':''">
            <option value="">Select Manager</option>
            <template x-for="m in managers" :key="m">
              <option :value="m" x-text="m"></option>
            </template>
          </select>
          <button class="sw-clear" x-show="filter.manager" @click.prevent="filter.manager=''" x-cloak>
            <i class="fa-solid fa-xmark"></i>
          </button>
          <i class="fa-solid fa-chevron-down sw-arr"></i>
        </div>
      </div>
      <!-- POP -->
      <div class="sg">
        <label>Select POP</label>
        <div class="sw">
          <select x-model="filter.pop" :class="filter.pop?'has-value':''">
            <option value="">Select One</option>
            <template x-for="p in pops" :key="p">
              <option :value="p" x-text="p"></option>
            </template>
          </select>
          <button class="sw-clear" x-show="filter.pop" @click.prevent="filter.pop=''" x-cloak>
            <i class="fa-solid fa-xmark"></i>
          </button>
          <i class="fa-solid fa-chevron-down sw-arr"></i>
        </div>
      </div>
      <!-- Package -->
      <div class="sg">
        <label>Select Package</label>
        <div class="sw">
          <select x-model="filter.pkg" :class="filter.pkg?'has-value':''">
            <option value="">Select One</option>
            <template x-for="pk in packageList" :key="pk">
              <option :value="pk" x-text="pk"></option>
            </template>
          </select>
          <button class="sw-clear" x-show="filter.pkg" @click.prevent="filter.pkg=''" x-cloak>
            <i class="fa-solid fa-xmark"></i>
          </button>
          <i class="fa-solid fa-chevron-down sw-arr"></i>
        </div>
      </div>
      <!-- Username -->
      <div class="sg">
        <label>Username</label>
        <input type="text" placeholder="Search username…"
          x-model="filter.username"
          :class="filter.username ? 'has-value' : ''">
      </div>
      <!-- Buttons -->
      <div class="fc-btns">
        <button class="btn-search">
          <i class="fa-solid fa-magnifying-glass"></i> Search
        </button>
        <button class="btn-reset-fc" @click="resetFilters">
          <i class="fa-solid fa-rotate-left"></i> Reset
        </button>
      </div>
    </div>
  </div>

  <!-- ── Results card ── -->
  <div class="rc">

    <!-- Results header -->
    <div class="rc-head">
      <div class="rc-left">
        <div class="rc-total">
          Total =
          <span class="total-num" x-text="filtered.length"></span>
        </div>
        <div class="sel-chip" x-show="selected.length > 0" x-cloak>
          <i class="fa-solid fa-check-square"></i>
          <span x-text="selected.length + ' selected'"></span>
        </div>
      </div>
      <div class="rc-actions">
        <button class="btn-del" :disabled="!selected.length" @click="showConfirm=true">
          <i class="fa-solid fa-trash-can"></i> Delete
        </button>
        <button class="btn-approve" :disabled="!selected.length" @click="doApprove">
          <i class="fa-solid fa-check"></i> Approve
        </button>
      </div>
    </div>

    <!-- Table -->
    <div class="tscroll">
      <table>
        <thead>
          <tr>
            <th class="th-cb">
              <input type="checkbox" class="cb"
                :checked="selected.length === filtered.length && filtered.length > 0"
                :indeterminate.prop="selected.length > 0 && selected.length < filtered.length"
                @change="toggleAll">
            </th>
            <th>ID</th>
            <th>User Name</th>
            <th>Status</th>
            <th>Expire</th>
            <th>Bill Info</th>
            <th>Package</th>
            <th>POP / Manager</th>
            <th>Name</th>
            <th>Contact</th>
            <th>Date</th>
            <th>Remarks</th>
            <th>Created By</th>
          </tr>
        </thead>
        <tbody>

          <!-- Empty state -->
          <template x-if="filtered.length === 0">
            <tr>
              <td colspan="13">
                <div class="empty-state">
                  <div class="empty-icon"><i class="fa-solid fa-hourglass-end"></i></div>
                  <h3>No Pending Customers</h3>
                  <p x-show="hasFilter">No results match your current filter. Try adjusting or resetting the filters.</p>
                  <p x-show="!hasFilter">All customer requests have been processed. Nothing pending right now.</p>
                </div>
              </td>
            </tr>
          </template>

          <!-- Data rows -->
          <template x-for="c in filtered" :key="c.id">
            <tr :class="{'sel-row': isSelected(c.id)}">

              <td class="td-cb" data-label="">
                <input type="checkbox" class="cb"
                  :checked="isSelected(c.id)"
                  @change="toggleRow(c.id)">
              </td>

              <td data-label="ID">
                <span class="id-chip" x-text="'#'+c.id"></span>
              </td>

              <td data-label="User Name">
                <div class="urow">
                  <div class="av" x-text="c.username.slice(0,2).toUpperCase()"></div>
                  <span class="uname" x-text="c.username"></span>
                </div>
              </td>

              <td data-label="Status">
                <span class="sbadge pending">
                  <span class="sdot"></span>
                  Pending
                </span>
              </td>

              <td data-label="Expire">
                <div class="exp-date" x-text="c.expireDate"></div>
                <div class="exp-bd" x-text="'BD: ' + c.billDate"></div>
              </td>

              <td data-label="Bill Info">
                <div class="brow"><span class="bk">Rate:</span><span class="bv" x-text="c.packageRate + '.00'"></span></div>
                <div class="brow"><span class="bk">Monthly:</span><span class="bv" x-text="c.monthlyBill"></span></div>
                <div class="brow"><span class="bk">Discount:</span><span class="bv" x-text="c.discount + '.00'"></span></div>
              </td>

              <td data-label="Package">
                <template x-for="p in c.packages" :key="p">
                  <span class="pkg-pill" x-text="p"></span>
                </template>
              </td>

              <td data-label="POP / Manager">
                <div class="pm-row">
                  <span class="pm-lbl">Mgr:</span>
                  <span class="pm-val" x-text="c.manager"></span>
                </div>
                <div class="pm-row">
                  <span class="pm-lbl">POP:</span>
                  <span class="pm-val" x-text="c.pop"></span>
                </div>
              </td>

              <td data-label="Name">
                <span class="nname" x-text="c.name"></span>
              </td>

              <td data-label="Contact">
                <span class="cnum" x-text="c.contact"></span>
              </td>

              <td data-label="Date">
                <span class="dchip">
                  <i class="fa-regular fa-calendar" style="font-size:9px"></i>
                  <span x-text="c.date"></span>
                </span>
              </td>

              <td data-label="Remarks">
                <template x-if="c.remarks">
                  <span class="remarks-txt" :title="c.remarks" x-text="c.remarks"></span>
                </template>
                <template x-if="!c.remarks">
                  <span class="remarks-empty">—</span>
                </template>
              </td>

              <td data-label="Created By">
                <span class="by-chip">
                  <i class="fa-solid fa-user"></i>
                  <span x-text="c.createdBy"></span>
                </span>
              </td>

            </tr>
          </template>

        </tbody>
      </table>
    </div>
  </div><!-- /.rc -->

</div><!-- /.pw -->

<script>
function pendingList() {
  return {
    filter: { manager:'', pop:'', pkg:'', username:'' },
    selected: [],
    showConfirm: false,
    toast: { show:false, msg:'', type:'success' },

    managers: ['LALMONIRHAT-1','LALMONIRHAT-2','RANGPUR-1','RANGPUR-2','SYLHET-1','SYLHET-2'],
    pops: ['Sohel-Lahirirhat (Sub)','North-POP (Main)','Karim-Rangpur (Main)','Main-POP (Sub)','City-POP (Sub)','East-POP (Main)','West-POP (Sub)','Premium-POP (Sub)'],
    packageList: ['Sohel-Pack-300 (300)','Sohel-Pack-525 (525)','LMN-Pack-300 (300)','Rangpur-Pack-400 (400)','Rangpur-Pack-630 (630)','Sylhet-Pack-400 (400)','Sylhet-Pack-525 (525)','Sylhet-Pack-630 (630)'],

    customers: [
      { id:1,  username:'new_karim',    name:'Abdul Karim',    contact:'01712345678', manager:'LALMONIRHAT-2', pop:'Sohel-Lahirirhat (Sub)', packages:['Sohel-Pack-525 (525)'],   expireDate:'01-Jul-2026', billDate:1,  packageRate:525, discount:0,   monthlyBill:525, userInfo:'Fiber - DHCP',      date:'08-Jun-2026', remarks:'New fiber connection', createdBy:'admin' },
      { id:2,  username:'sumaiya_isp',  name:'Sumaiya Begum',  contact:'01856789012', manager:'SYLHET-1',     pop:'Main-POP (Sub)',          packages:['Sylhet-Pack-400 (400)'],  expireDate:'05-Jul-2026', billDate:5,  packageRate:400, discount:0,   monthlyBill:400, userInfo:'Cable - DHCP',      date:'09-Jun-2026', remarks:'',                     createdBy:'operator1' },
      { id:3,  username:'rashed_net',   name:'Rashed Khan',    contact:'01933445566', manager:'RANGPUR-1',    pop:'Karim-Rangpur (Main)',    packages:['Rangpur-Pack-630 (630)'], expireDate:'10-Jul-2026', billDate:10, packageRate:630, discount:0,   monthlyBill:630, userInfo:'Fiber - Static IP',  date:'09-Jun-2026', remarks:'Corporate client',      createdBy:'admin' },
      { id:4,  username:'nafisa2026',   name:'Nafisa Islam',   contact:'01644556677', manager:'LALMONIRHAT-1',pop:'North-POP (Main)',         packages:['LMN-Pack-300 (300)'],     expireDate:'15-Jul-2026', billDate:15, packageRate:300, discount:50,  monthlyBill:300, userInfo:'Cable - DHCP',      date:'10-Jun-2026', remarks:'Student discount',      createdBy:'operator2' },
      { id:5,  username:'masum_bd',     name:'Masum Ahmed',    contact:'01755667788', manager:'SYLHET-1',     pop:'City-POP (Sub)',          packages:['Sylhet-Pack-525 (525)'],  expireDate:'01-Jul-2026', billDate:1,  packageRate:525, discount:0,   monthlyBill:525, userInfo:'Fiber - DHCP',      date:'10-Jun-2026', remarks:'',                     createdBy:'operator1' },
      { id:6,  username:'jolly_usr',    name:'Jolly Akter',    contact:'01822334455', manager:'LALMONIRHAT-2',pop:'East-POP (Main)',          packages:['Sohel-Pack-525 (525)'],   expireDate:'20-Jul-2026', billDate:20, packageRate:525, discount:0,   monthlyBill:525, userInfo:'Fiber - DHCP',      date:'10-Jun-2026', remarks:'Referred by #12',      createdBy:'admin' },
      { id:7,  username:'babu_mia',     name:'Babu Mia',       contact:'01611223344', manager:'RANGPUR-2',    pop:'West-POP (Sub)',          packages:['Rangpur-Pack-400 (400)'], expireDate:'25-Jul-2026', billDate:25, packageRate:400, discount:0,   monthlyBill:400, userInfo:'Cable - DHCP',      date:'11-Jun-2026', remarks:'',                     createdBy:'operator2' },
      { id:8,  username:'kohinoor_net', name:'Kohinoor Banu',  contact:'01977889900', manager:'SYLHET-1',     pop:'Premium-POP (Sub)',       packages:['Sylhet-Pack-630 (630)'],  expireDate:'30-Jul-2026', billDate:30, packageRate:630, discount:100, monthlyBill:630, userInfo:'Fiber - Static IP',  date:'11-Jun-2026', remarks:'Premium package',       createdBy:'admin' },
    ],

    get filtered() {
      const f = this.filter;
      return this.customers.filter(c => {
        if (f.manager  && c.manager !== f.manager) return false;
        if (f.pop      && c.pop     !== f.pop)     return false;
        if (f.pkg      && !c.packages.includes(f.pkg)) return false;
        if (f.username && !c.username.toLowerCase().includes(f.username.toLowerCase())) return false;
        return true;
      });
    },

    get hasFilter() {
      return !!(this.filter.manager || this.filter.pop || this.filter.pkg || this.filter.username);
    },

    isSelected(id) { return this.selected.includes(id); },

    toggleRow(id) {
      if (this.selected.includes(id)) {
        this.selected = this.selected.filter(x => x !== id);
      } else {
        this.selected.push(id);
      }
    },

    toggleAll() {
      if (this.selected.length === this.filtered.length && this.filtered.length > 0) {
        this.selected = [];
      } else {
        this.selected = this.filtered.map(c => c.id);
      }
    },

    doApprove() {
      const count = this.selected.length;
      this.customers = this.customers.filter(c => !this.selected.includes(c.id));
      this.selected = [];
      this.showToast(`${count} customer(s) approved successfully`, 'success');
    },

    doDelete() {
      const count = this.selected.length;
      this.customers = this.customers.filter(c => !this.selected.includes(c.id));
      this.selected = [];
      this.showConfirm = false;
      this.showToast(`${count} customer request(s) deleted`, 'danger');
    },

    resetFilters() {
      this.filter = { manager:'', pop:'', pkg:'', username:'' };
    },

    showToast(msg, type = 'success') {
      this.toast = { show:true, msg, type };
      setTimeout(() => { this.toast.show = false; }, 3200);
    },
  };
}
</script>
</body>
</html>
