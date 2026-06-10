<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>SMS Logs</title>
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
  --teal:#0D9488;    --teal-l:#CCFBF1;   --teal-d:#0F766E;
  --warning:#F59E0B; --warning-l:#FEF3C7;
  --text:#0F172A; --text2:#1E293B; --muted:#64748B; --light:#94A3B8;
  --border:#E2E8F0; --border-l:#F1F5F9;
  --surface:#FFFFFF; --bg:#F1F5F9; --bg-alt:#F8FAFC;
  --th:#1E293B;
  --sh-sm:0 1px 3px rgba(0,0,0,.06);
  --sh:0 4px 12px rgba(0,0,0,.07);
  --sh-md:0 12px 28px rgba(0,0,0,.11);
  --r:10px; --r-sm:6px; --r-lg:14px;
  --mono:ui-monospace,'Cascadia Code','Fira Code',monospace;
}
html{font-family:'Inter',sans-serif;font-size:14px}
body{background:var(--bg);color:var(--text);min-height:100vh}
[x-cloak]{display:none!important}

/* ── Page ────────────────────────────────────────── */
.pw{max-width:1600px;margin:0 auto;padding:24px 20px 48px}

/* ── Header ──────────────────────────────────────── */
.ph{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:22px;flex-wrap:wrap}
.ph-left{display:flex;align-items:center;gap:12px}
.ph-icon{
  width:42px;height:42px;border-radius:11px;flex-shrink:0;
  background:linear-gradient(135deg,#0D9488 0%,#2563EB 100%);
  display:flex;align-items:center;justify-content:center;
  color:#fff;font-size:17px;
  box-shadow:0 4px 14px rgba(13,148,136,.38);
}
.ph-title{font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
.ph-sub{font-size:12px;color:var(--muted);margin-top:1px}

/* ── Stats strip ─────────────────────────────────── */
.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:18px}
.sc{
  background:var(--surface);border-radius:var(--r);padding:14px 18px;
  display:flex;align-items:center;gap:14px;
  border:1px solid var(--border);box-shadow:var(--sh-sm);
  position:relative;overflow:hidden;transition:transform .18s,box-shadow .18s;
}
.sc:hover{transform:translateY(-2px);box-shadow:var(--sh)}
.sc::after{content:'';position:absolute;top:0;left:0;right:0;height:3px;border-radius:10px 10px 0 0}
.sc.s-total::after  {background:linear-gradient(90deg,#0D9488,#2563EB)}
.sc.s-sent::after   {background:linear-gradient(90deg,#2563EB,#3B82F6)}
.sc.s-ok::after     {background:linear-gradient(90deg,#10B981,#059669)}
.sc.s-fail::after   {background:linear-gradient(90deg,#EF4444,#DC2626)}
.sc-icon{
  width:40px;height:40px;border-radius:9px;flex-shrink:0;
  display:flex;align-items:center;justify-content:center;font-size:15px;
}
.s-total .sc-icon{background:linear-gradient(135deg,#CCFBF1,#DBEAFE);color:#0D9488}
.s-sent  .sc-icon{background:linear-gradient(135deg,#DBEAFE,#EDE9FE);color:#2563EB}
.s-ok    .sc-icon{background:var(--success-l);color:var(--success)}
.s-fail  .sc-icon{background:var(--danger-l);color:var(--danger)}
.sc-body{flex:1}
.sc-lbl{font-size:10.5px;font-weight:600;color:var(--muted);text-transform:uppercase;letter-spacing:.5px}
.sc-val{font-size:26px;font-weight:800;color:var(--text);line-height:1.2;margin-top:2px}

/* ── Filter card ─────────────────────────────────── */
.fc{
  background:var(--surface);border-radius:var(--r);padding:16px 18px;
  border:1px solid var(--border);box-shadow:var(--sh-sm);margin-bottom:16px;
}
.fg{display:grid;grid-template-columns:1fr 1fr 1fr 1.4fr auto;gap:12px;align-items:end}
.ff label{
  display:block;font-size:11px;font-weight:700;color:var(--muted);
  text-transform:uppercase;letter-spacing:.4px;margin-bottom:5px;
}
.ff input,.ff select{
  width:100%;height:38px;padding:0 10px;
  border:1.5px solid var(--border);border-radius:var(--r-sm);
  font-size:13px;font-family:inherit;color:var(--text);
  background:#fff;outline:none;
  transition:border-color .15s,box-shadow .15s;
}
.ff select{
  appearance:none;-webkit-appearance:none;cursor:pointer;padding-right:28px;
  background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7' viewBox='0 0 11 7'%3E%3Cpath d='M1 1l4.5 4.5L10 1' stroke='%2364748B' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
  background-repeat:no-repeat;background-position:right 9px center;
}
.ff input:focus,.ff select:focus{
  border-color:var(--teal);box-shadow:0 0 0 3px rgba(13,148,136,.12);
}
.ff-btns{display:flex;gap:8px;align-items:flex-end}
.btn-search{
  height:38px;padding:0 18px;border:none;border-radius:var(--r-sm);
  background:var(--primary);color:#fff;font-size:13px;font-weight:600;
  cursor:pointer;display:inline-flex;align-items:center;gap:6px;
  box-shadow:0 3px 10px rgba(37,99,235,.28);transition:all .15s;
}
.btn-search:hover{background:var(--primary-d)}
.btn-reset{
  height:38px;padding:0 16px;border:1.5px solid var(--teal);border-radius:var(--r-sm);
  background:#fff;color:var(--teal);font-size:13px;font-weight:600;
  cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:all .15s;
}
.btn-reset:hover{background:var(--teal-l)}

/* ── Table card ──────────────────────────────────── */
.card{
  background:var(--surface);border-radius:var(--r-lg);
  border:1px solid var(--border);box-shadow:var(--sh);overflow:hidden;
}
.tscroll{overflow-x:auto;-webkit-overflow-scrolling:touch}
table{width:100%;border-collapse:collapse;min-width:900px}
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

/* ID */
.id-num{
  display:inline-flex;align-items:center;justify-content:center;
  min-width:28px;height:24px;padding:0 7px;border-radius:5px;
  background:var(--th);color:rgba(255,255,255,.78);
  font-size:11px;font-weight:700;font-family:var(--mono);
}

/* Contact */
.contact-num{
  font-size:13px;font-weight:600;color:var(--text);
  letter-spacing:.3px;white-space:nowrap;
}

/* Message */
.msg-txt{
  font-size:12.5px;color:var(--text);
  max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;
}

/* Type badge */
.type-badge{
  display:inline-flex;align-items:center;gap:4px;
  padding:3px 9px;border-radius:4px;font-size:11px;font-weight:700;
  white-space:nowrap;
}
.type-badge.send   {background:rgba(37,99,235,.08);color:#1D4ED8;border:1px solid rgba(37,99,235,.15)}
.type-badge.receive{background:var(--teal-l);color:var(--teal-d);border:1px solid rgba(13,148,136,.2)}

/* Delivery message */
.dlv-wrap{display:flex;flex-direction:column;gap:4px;min-width:200px}
.dlv-status{
  display:inline-flex;align-items:center;gap:5px;
  padding:2px 8px;border-radius:12px;font-size:10.5px;font-weight:700;width:fit-content;
}
.dlv-status.ok   {background:var(--success-l);color:#065F46}
.dlv-status.fail {background:var(--danger-l);color:#991B1B}
.dlv-status.recv {background:var(--teal-l);color:var(--teal-d)}
.dlv-status.unkn {background:#F1F5F9;color:var(--muted)}
.dlv-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
.dlv-status.ok   .dlv-dot{background:var(--success)}
.dlv-status.fail .dlv-dot{background:var(--danger)}
.dlv-status.recv .dlv-dot{background:var(--teal)}
.dlv-status.unkn .dlv-dot{background:var(--light)}
.dlv-mid{font-family:var(--mono);font-size:10px;color:var(--light);letter-spacing:.2px}

/* Date */
.date-wrap{white-space:nowrap}
.date-day{font-size:12.5px;font-weight:600;color:var(--text)}
.date-time{font-size:11px;color:var(--muted);margin-top:1px}

/* Empty state */
.empty{text-align:center;padding:52px 24px;color:var(--muted)}
.empty-icon{
  width:60px;height:60px;border-radius:50%;
  background:var(--teal-l);color:var(--teal);
  display:flex;align-items:center;justify-content:center;
  font-size:22px;margin:0 auto 14px;
}
.empty h3{font-size:15px;font-weight:700;color:var(--text2);margin-bottom:5px}
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
.pb{
  min-width:32px;height:32px;
  display:inline-flex;align-items:center;justify-content:center;
  border-radius:var(--r-sm);border:1px solid var(--border);
  background:var(--surface);color:var(--muted);
  font-size:12px;font-weight:600;cursor:pointer;
  transition:all .15s;padding:0 6px;
}
.pb:hover:not([disabled]){border-color:var(--teal);color:var(--teal);background:var(--teal-l)}
.pb.on{background:var(--teal);border-color:var(--teal);color:#fff}
.pb[disabled]{opacity:.35;cursor:not-allowed}

/* ── Responsive ──────────────────────────────────── */
@media(max-width:1024px){
  .stats{grid-template-columns:repeat(2,1fr)}
  .fg{grid-template-columns:1fr 1fr}
  .ff-btns{grid-column:span 2;justify-content:flex-end}
}
@media(max-width:600px){
  .pw{padding:14px 12px 32px}
  .stats{grid-template-columns:1fr 1fr}
  .fg{grid-template-columns:1fr}
  .ff-btns{grid-column:1;width:100%}
  .btn-search,.btn-reset{flex:1;justify-content:center}
  .ph-title{font-size:17px}
}
</style>
</head>
<body>
<div class="pw" x-data="smsLogs()">

  <!-- ── Header ── -->
  <div class="ph">
    <div class="ph-left">
      <div class="ph-icon"><i class="fa-solid fa-comment-dots"></i></div>
      <div>
        <div class="ph-title">SMS Logs</div>
        <div class="ph-sub">Track all sent and received SMS messages</div>
      </div>
    </div>
  </div>

  <!-- ── Stats ── -->
  <div class="stats">
    <div class="sc s-total">
      <div class="sc-icon"><i class="fa-solid fa-list-ul"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Total Logs</div>
        <div class="sc-val" x-text="logs.length"></div>
      </div>
    </div>
    <div class="sc s-sent">
      <div class="sc-icon"><i class="fa-solid fa-paper-plane"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">SMS Sent</div>
        <div class="sc-val" x-text="logs.filter(l=>l.type==='sms_send').length"></div>
      </div>
    </div>
    <div class="sc s-ok">
      <div class="sc-icon"><i class="fa-solid fa-circle-check"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Accepted</div>
        <div class="sc-val" x-text="logs.filter(l=>dlvStatus(l.delivery)==='ok').length"></div>
      </div>
    </div>
    <div class="sc s-fail">
      <div class="sc-icon"><i class="fa-solid fa-circle-xmark"></i></div>
      <div class="sc-body">
        <div class="sc-lbl">Failed</div>
        <div class="sc-val" x-text="logs.filter(l=>dlvStatus(l.delivery)==='fail').length"></div>
      </div>
    </div>
  </div>

  <!-- ── Filter card ── -->
  <div class="fc">
    <div class="fg">
      <div class="ff">
        <label>From Date</label>
        <input type="date" x-model="filter.fromDate">
      </div>
      <div class="ff">
        <label>To Date</label>
        <input type="date" x-model="filter.toDate">
      </div>
      <div class="ff">
        <label>Type</label>
        <select x-model="filter.type">
          <option value="">Select One</option>
          <option value="sms_send">sms_send</option>
          <option value="sms_receive">sms_receive</option>
        </select>
      </div>
      <div class="ff">
        <label>Contact No</label>
        <input type="text" placeholder="Phone No" x-model="filter.contact">
      </div>
      <div class="ff-btns">
        <button class="btn-search" @click="applyFilter">
          <i class="fa-solid fa-magnifying-glass"></i> Search
        </button>
        <button class="btn-reset" @click="resetFilter">
          <i class="fa-solid fa-rotate-left"></i> Reset
        </button>
      </div>
    </div>
  </div>

  <!-- ── Table card ── -->
  <div class="card">
    <div class="tscroll">
      <table>
        <thead>
          <tr>
            <th class="th-c">ID</th>
            <th>Contact</th>
            <th>Message</th>
            <th>Type</th>
            <th>Delivery Message</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <template x-if="paginated.length === 0">
            <tr>
              <td colspan="6">
                <div class="empty">
                  <div class="empty-icon"><i class="fa-solid fa-comment-slash"></i></div>
                  <h3>No SMS Logs Found</h3>
                  <p x-show="hasFilter">No results match your current filters. Try adjusting them.</p>
                  <p x-show="!hasFilter">No SMS activity recorded yet.</p>
                </div>
              </td>
            </tr>
          </template>
          <template x-for="log in paginated" :key="log.id">
            <tr>

              <!-- ID -->
              <td class="td-c">
                <span class="id-num" x-text="log.id"></span>
              </td>

              <!-- Contact -->
              <td>
                <span class="contact-num" x-text="log.contact"></span>
              </td>

              <!-- Message -->
              <td>
                <span class="msg-txt" x-text="log.message" :title="log.message"></span>
              </td>

              <!-- Type -->
              <td>
                <span class="type-badge" :class="log.type==='sms_send'?'send':'receive'">
                  <i :class="log.type==='sms_send'?'fa-solid fa-arrow-up':'fa-solid fa-arrow-down'" style="font-size:9px"></i>
                  <span x-text="log.type"></span>
                </span>
              </td>

              <!-- Delivery -->
              <td>
                <div class="dlv-wrap">
                  <span class="dlv-status" :class="dlvStatus(log.delivery)">
                    <span class="dlv-dot"></span>
                    <span x-text="dlvText(log.delivery)"></span>
                  </span>
                  <span class="dlv-mid" x-text="'MSG ID: ' + dlvMsgId(log.delivery)"></span>
                </div>
              </td>

              <!-- Date -->
              <td>
                <div class="date-wrap">
                  <div class="date-day" x-text="log.date.split(' ')[0]"></div>
                  <div class="date-time" x-text="log.date.split(' ')[1]"></div>
                </div>
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
        <button class="pb" @click="page=1" :disabled="page===1"><i class="fa-solid fa-angles-left"></i></button>
        <button class="pb" @click="page--" :disabled="page===1"><i class="fa-solid fa-angle-left"></i></button>
        <template x-for="p in visiblePages" :key="p">
          <button class="pb" :class="{on:page===p}" @click="page=p" x-text="p"></button>
        </template>
        <button class="pb" @click="page++" :disabled="page===totalPages"><i class="fa-solid fa-angle-right"></i></button>
        <button class="pb" @click="page=totalPages" :disabled="page===totalPages"><i class="fa-solid fa-angles-right"></i></button>
      </div>
    </div>
  </div>

</div>
<script>
function smsLogs() {
  return {
    filter: { fromDate:'', toDate:'', type:'', contact:'' },
    active: { fromDate:'', toDate:'', type:'', contact:'' },
    page: 1,
    perPage: 10,

    logs: [
      { id:10, contact:'01681046437', message:'ok mask',        type:'sms_send',    delivery:'{"Status":"0","Text":"ACCEPTD","Message_ID":"1118424136"}', date:'2026-06-10 20:16:40' },
      { id:9,  contact:'01681046437', message:'test',           type:'sms_send',    delivery:'{"Status":"0","Text":"ACCEPTD","Message_ID":"1118407338"}', date:'2026-06-10 20:09:14' },
      { id:8,  contact:'01681046437', message:'test mask',      type:'sms_send',    delivery:'{"Status":"0","Text":"ACCEPTD","Message_ID":"1118395842"}', date:'2026-06-10 20:03:55' },
      { id:7,  contact:'01712345678', message:'Bill reminder',  type:'sms_send',    delivery:'{"Status":"0","Text":"ACCEPTD","Message_ID":"1118490123"}', date:'2026-06-11 09:15:22' },
      { id:6,  contact:'01856789012', message:'Account expired',type:'sms_send',    delivery:'{"Status":"1","Text":"FAILED","Message_ID":"1118489001"}',  date:'2026-06-11 09:10:05' },
      { id:5,  contact:'01933445566', message:'Payment received',type:'sms_send',   delivery:'{"Status":"0","Text":"ACCEPTD","Message_ID":"1118475632"}', date:'2026-06-11 08:44:17' },
      { id:4,  contact:'01644556677', message:'Welcome to ISP', type:'sms_send',    delivery:'{"Status":"0","Text":"ACCEPTD","Message_ID":"1118462891"}', date:'2026-06-11 08:30:00' },
      { id:3,  contact:'01755667788', message:'Support request',type:'sms_receive', delivery:'{"Status":"0","Text":"RECEIVED","Message_ID":"1118501234"}',date:'2026-06-11 10:05:33' },
      { id:2,  contact:'01811223344', message:'Renewal notice', type:'sms_send',    delivery:'{"Status":"1","Text":"FAILED","Message_ID":"1118512345"}',  date:'2026-06-11 10:22:14' },
      { id:1,  contact:'01966778899', message:'Package upgrade',type:'sms_send',    delivery:'{"Status":"0","Text":"ACCEPTD","Message_ID":"1118523456"}', date:'2026-06-11 11:00:45' },
      { id:11, contact:'01600112233', message:'Connection issue',type:'sms_receive',delivery:'{"Status":"0","Text":"RECEIVED","Message_ID":"1118534567"}',date:'2026-06-11 11:30:18' },
      { id:12, contact:'01799001122', message:'Expiry warning', type:'sms_send',    delivery:'{"Status":"0","Text":"ACCEPTD","Message_ID":"1118545678"}', date:'2026-06-11 12:05:09' },
      { id:13, contact:'01677889900', message:'OTP: 847291',    type:'sms_send',    delivery:'{"Status":"0","Text":"ACCEPTD","Message_ID":"1118556789"}', date:'2026-06-11 12:44:33' },
      { id:14, contact:'01533445566', message:'Invoice ready',  type:'sms_send',    delivery:'{"Status":"1","Text":"FAILED","Message_ID":"1118567890"}',  date:'2026-06-11 13:10:55' },
      { id:15, contact:'01844556677', message:'Speed boost',    type:'sms_send',    delivery:'{"Status":"0","Text":"ACCEPTD","Message_ID":"1118578901"}', date:'2026-06-11 13:55:20' },
    ],

    get filtered() {
      const a = this.active;
      return this.logs.filter(l => {
        if (a.type    && l.type    !== a.type)    return false;
        if (a.contact && !l.contact.includes(a.contact.trim())) return false;
        if (a.fromDate && l.date.split(' ')[0] < a.fromDate) return false;
        if (a.toDate   && l.date.split(' ')[0] > a.toDate)   return false;
        return true;
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
      const t=this.totalPages, c=this.page;
      let s=Math.max(1,c-2), e=Math.min(t,s+4);
      if(e-s<4) s=Math.max(1,e-4);
      const ps=[]; for(let i=s;i<=e;i++) ps.push(i); return ps;
    },

    get hasFilter() {
      const a=this.active;
      return !!(a.fromDate||a.toDate||a.type||a.contact);
    },

    applyFilter() {
      this.active = { ...this.filter };
      this.page = 1;
    },

    resetFilter() {
      this.filter = { fromDate:'', toDate:'', type:'', contact:'' };
      this.active = { fromDate:'', toDate:'', type:'', contact:'' };
      this.page = 1;
    },

    dlvParse(str) {
      try { return JSON.parse(str); } catch(e) { return {}; }
    },

    dlvStatus(str) {
      const d = this.dlvParse(str);
      if (!d.Text) return 'unkn';
      const t = d.Text.toUpperCase();
      if (t === 'ACCEPTD' || t === 'ACCEPTED') return 'ok';
      if (t === 'FAILED')   return 'fail';
      if (t === 'RECEIVED') return 'recv';
      return 'unkn';
    },

    dlvText(str) {
      return this.dlvParse(str).Text || '—';
    },

    dlvMsgId(str) {
      return this.dlvParse(str).Message_ID || '—';
    },
  };
}
</script>
</body>
</html>
