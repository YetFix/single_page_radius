<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Settings</title>
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

/* page */
.page{max-width:1280px;margin:0 auto;padding:24px 20px 60px}

/* header */
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px}
.page-title{font-size:20px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:9px}
.page-title i{color:var(--primary)}

/* tabs */
.tab-bar{display:flex;align-items:center;gap:4px;background:var(--card);border-radius:10px;padding:5px;box-shadow:var(--shadow);margin-bottom:22px;border:1px solid var(--border);flex-wrap:wrap}
.tab-btn{padding:8px 20px;border-radius:8px;border:none;background:transparent;font-size:13px;font-weight:600;color:var(--muted);cursor:pointer;transition:.15s;white-space:nowrap}
.tab-btn:hover{color:var(--text);background:#f8fafc}
.tab-btn.active{background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;box-shadow:0 3px 10px rgba(99,102,241,.3)}

/* section card */
.section{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--border);margin-bottom:18px;overflow:hidden}
.section-head{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:9px;background:#fafbff}
.section-head i{color:var(--primary);font-size:14px;width:18px;text-align:center}
.section-title{font-size:13px;font-weight:700;color:var(--text);letter-spacing:.2px}
.section-body{padding:20px}

/* grid helpers */
.g2{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}
.g3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.g4{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.full{grid-column:1/-1}
.col2{grid-column:span 2}

/* form field */
.ff{display:flex;flex-direction:column;gap:5px}
.ff label{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px}
.ff input[type=text],.ff input[type=email],.ff input[type=tel],.ff input[type=number],.ff input[type=password],.ff input[type=date],.ff select,.ff textarea{
  padding:9px 12px;border:1.5px solid var(--border);border-radius:8px;font-size:13px;color:var(--text);
  outline:none;transition:.15s;background:#fff;width:100%;font-family:inherit
}
.ff input:focus,.ff select:focus,.ff textarea:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1)}
.ff select{appearance:none;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%2364748b'/%3E%3C/svg%3E") no-repeat right 10px center;padding-right:28px}
.ff textarea{resize:vertical;min-height:80px}
.ff input[type=time]{padding:8px 12px}
.ff input:disabled,.ff select:disabled,.ff textarea:disabled{background:#f8fafc;cursor:not-allowed;color:var(--muted)}

/* status indicator */
.status-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700;letter-spacing:.3px}
.chip-no{background:#fee2e2;color:#b91c1c}
.chip-yes{background:#d1fae5;color:#065f46}
.chip-api{background:#fef3c7;color:#92400e}

/* upload zone */
.upload-zone{border:2px dashed var(--border);border-radius:10px;padding:16px;text-align:center;transition:.15s;cursor:pointer;background:#fafbff;position:relative}
.upload-zone:hover{border-color:var(--primary);background:var(--primary-light)}
.upload-zone input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.upload-icon{font-size:22px;color:var(--muted);margin-bottom:6px}
.upload-status{font-size:11px;font-weight:600;padding:2px 8px;border-radius:12px;display:inline-block;margin-bottom:6px}
.upload-status.not-set{background:#fee2e2;color:#b91c1c}
.upload-status.set{background:#d1fae5;color:#065f46}
.upload-filename{font-size:12px;color:var(--muted);margin-top:2px;word-break:break-all}
.upload-hint{font-size:11px;color:#94a3b8;margin-top:3px}
.upload-btn{display:inline-flex;align-items:center;gap:5px;margin-top:8px;padding:5px 12px;background:var(--card);border:1.5px solid var(--border);border-radius:7px;font-size:12px;font-weight:600;color:var(--text);cursor:pointer;pointer-events:none}

/* sync buttons */
.sync-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:10px}
.sync-btn{display:flex;align-items:center;gap:8px;padding:10px 14px;border:1.5px solid var(--border);border-radius:9px;background:#fff;font-size:12px;font-weight:600;color:var(--text);cursor:pointer;transition:.15s}
.sync-btn:hover{border-color:var(--primary);color:var(--primary);background:var(--primary-light)}
.sync-btn i{font-size:13px;color:var(--primary)}

/* connection type block */
.conn-block{display:flex;flex-direction:column;gap:8px}
.conn-lbl{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.4px}
.conn-val{font-size:18px;font-weight:800;color:#ef4444;letter-spacing:.5px}

/* time row */
.time-row{display:flex;align-items:center;gap:8px}
.time-row input{flex:1}
.time-sep{font-weight:700;color:var(--muted)}
.time-lbl{font-size:11px;color:var(--muted);text-align:center;margin-top:2px}

/* payment images grid */
.pay-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
.pay-item{border:1.5px solid var(--border);border-radius:10px;padding:14px;background:#fafbff;position:relative;overflow:hidden}
.pay-item input[type=file]{position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%}
.pay-item-name{font-size:12px;font-weight:700;color:var(--text);margin-bottom:8px}
.pay-item-area{display:flex;flex-direction:column;align-items:center;gap:6px;padding:10px 0}
.pay-item-icon{font-size:24px;color:#cbd5e1}
.pay-item-lbl{font-size:11px;color:var(--muted)}
.pay-item-file{font-size:11px;color:var(--success);font-weight:600}

/* online payment url button */
.pay-url-btn{display:block;width:100%;padding:9px;background:linear-gradient(135deg,var(--info),#0284c7);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;margin-top:8px;text-align:center;transition:.15s}
.pay-url-btn:hover{filter:brightness(1.08)}

/* yetfix notice card */
.notice-card{background:linear-gradient(135deg,#dc2626,#b91c1c);border-radius:12px;padding:22px;color:#fff}
.notice-card .ff label{color:rgba(255,255,255,.75)}
.notice-card input,.notice-card select{background:rgba(255,255,255,.95)}

/* rte */
.rte{border:1.5px solid var(--border);border-radius:8px;overflow:hidden;transition:.15s}
.rte:focus-within{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1)}
.rte-bar{display:flex;align-items:center;gap:1px;padding:5px 7px;background:#f8fafc;border-bottom:1px solid var(--border);flex-wrap:wrap}
.rte-bar button{width:26px;height:26px;border:none;background:transparent;border-radius:5px;cursor:pointer;font-size:11px;color:var(--muted);display:flex;align-items:center;justify-content:center;transition:.12s}
.rte-bar button:hover{background:#e2e8f0;color:var(--text)}
.rte-sep{width:1px;height:16px;background:var(--border);margin:0 3px}
.rte-body{padding:9px 12px;min-height:80px;font-size:13px;color:var(--text);outline:none;line-height:1.5}

/* save button */
.save-row{display:flex;justify-content:flex-end;padding:16px 0 0}
.btn-save{display:inline-flex;align-items:center;gap:7px;padding:11px 28px;background:linear-gradient(135deg,var(--primary),var(--primary-dark));color:#fff;border:none;border-radius:9px;font-size:14px;font-weight:700;cursor:pointer;box-shadow:0 4px 14px rgba(99,102,241,.35);transition:.18s}
.btn-save:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(99,102,241,.45)}

/* inline badge row */
.badge-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}

/* toast */
.toast-wrap{position:fixed;bottom:24px;right:24px;z-index:999;pointer-events:none}
.toast{padding:12px 18px;border-radius:10px;font-size:13px;font-weight:600;color:#fff;box-shadow:0 6px 24px rgba(0,0,0,.2);display:flex;align-items:center;gap:8px;background:linear-gradient(135deg,#10b981,#059669)}

/* third party url */
.url-row{display:flex;align-items:center;gap:10px}
.url-row input{flex:1}
.url-check{display:flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:var(--text);cursor:pointer;white-space:nowrap}
.url-check input[type=checkbox]{width:15px;height:15px;accent-color:var(--primary);cursor:pointer}

/* responsive */
@media(max-width:1024px){.g4{grid-template-columns:repeat(2,1fr)}.pay-grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:700px){
  .g2,.g3,.g4{grid-template-columns:1fr}
  .col2{grid-column:1}
  .sync-grid{grid-template-columns:1fr}
  .pay-grid{grid-template-columns:repeat(2,1fr)}
  .tab-btn{padding:7px 14px;font-size:12px}
  .time-row{flex-wrap:wrap}
}
</style>
</head>
<body>
<div class="page" x-data="settingsApp()" x-cloak>

  <div class="page-head">
    <div class="page-title"><i class="fa-solid fa-gear"></i> Settings</div>
  </div>

  <!-- Tab Bar -->
  <div class="tab-bar">
    <button class="tab-btn" :class="{active:tab==='site'}" @click="tab='site'">
      <i class="fa-solid fa-sliders" style="margin-right:5px"></i> Site Setting
    </button>
    <button class="tab-btn" :class="{active:tab==='payment'}" @click="tab='payment'">
      <i class="fa-solid fa-credit-card" style="margin-right:5px"></i> Payment Button
    </button>
    <button class="tab-btn" :class="{active:tab==='yetfix'}" @click="tab='yetfix'">
      <i class="fa-solid fa-bell" style="margin-right:5px"></i> Yetfix Notice
    </button>
  </div>

  <!-- ══════════════════════════════════════════════
       TAB 1: SITE SETTING
  ══════════════════════════════════════════════ -->
  <div x-show="tab==='site'">

    <!-- Media & Branding -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-image"></i>
        <span class="section-title">Media &amp; Branding</span>
      </div>
      <div class="section-body">
        <div class="g4">

          <!-- Logo -->
          <div>
            <div class="ff" style="margin-bottom:10px">
              <label>Logo</label>
              <div class="upload-zone" @click="$refs.logoInp.click()">
                <div class="upload-icon"><i class="fa-solid fa-image"></i></div>
                <div class="upload-status" :class="files.logo?'set':'not-set'" x-text="files.logo?'Set':'Haven\'t Set'"></div>
                <div class="upload-filename" x-show="files.logo" x-text="files.logo"></div>
                <div class="upload-hint" x-show="!files.logo">Click to upload</div>
                <div class="upload-btn"><i class="fa-solid fa-upload"></i> Choose file</div>
                <input type="file" x-ref="logoInp" accept="image/*" @change="onFile($event,'logo')" style="display:none">
              </div>
            </div>
          </div>

          <!-- Landing Image -->
          <div>
            <div class="ff" style="margin-bottom:10px">
              <label>Landing Image</label>
              <div class="upload-zone" @click="$refs.landInp.click()">
                <div class="upload-icon"><i class="fa-solid fa-panorama"></i></div>
                <div class="upload-status" :class="files.landing?'set':'not-set'" x-text="files.landing?'Set':'Haven\'t Set'"></div>
                <div class="upload-filename" x-show="files.landing" x-text="files.landing"></div>
                <div class="upload-hint" x-show="!files.landing">Click to upload</div>
                <div class="upload-btn"><i class="fa-solid fa-upload"></i> Choose file</div>
                <input type="file" x-ref="landInp" accept="image/*" @change="onFile($event,'landing')" style="display:none">
              </div>
            </div>
            <div class="ff">
              <label>Online Payment URL</label>
              <input type="text" x-model="site.paymentUrl" placeholder="Enter online payment URL">
            </div>
          </div>

          <!-- QR Code -->
          <div>
            <div class="ff" style="margin-bottom:10px">
              <label>QR Code</label>
              <div class="upload-zone" @click="$refs.qrInp.click()">
                <div class="upload-icon"><i class="fa-solid fa-qrcode"></i></div>
                <div class="upload-status" :class="files.qrcode?'set':'not-set'" x-text="files.qrcode?'Set':'Haven\'t Set'"></div>
                <div class="upload-filename" x-show="files.qrcode" x-text="files.qrcode"></div>
                <div class="upload-hint" x-show="!files.qrcode">Click to upload</div>
                <div class="upload-btn"><i class="fa-solid fa-upload"></i> Choose file</div>
                <input type="file" x-ref="qrInp" accept="image/*" @change="onFile($event,'qrcode')" style="display:none">
              </div>
            </div>
            <div class="ff">
              <label>QR Code Info (thank-you text)</label>
              <input type="text" x-model="site.qrInfo" placeholder="Leave empty to show ধন্যবাদ">
            </div>
          </div>

          <!-- Signature -->
          <div>
            <div class="ff">
              <label>Signature</label>
              <div class="upload-zone" @click="$refs.sigInp.click()">
                <div class="upload-icon"><i class="fa-solid fa-signature"></i></div>
                <div class="upload-status" :class="files.signature?'set':'not-set'" x-text="files.signature?'Set':'Haven\'t Set'"></div>
                <div class="upload-filename" x-show="files.signature" x-text="files.signature"></div>
                <div class="upload-hint" x-show="!files.signature">Click to upload</div>
                <div class="upload-btn"><i class="fa-solid fa-upload"></i> Choose file</div>
                <input type="file" x-ref="sigInp" accept="image/*" @change="onFile($event,'signature')" style="display:none">
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Sync & Mikrotik -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-rotate"></i>
        <span class="section-title">Sync &amp; Mikrotik</span>
      </div>
      <div class="section-body">
        <div class="g2">
          <div>
            <div class="ff" style="margin-bottom:12px"><label>Sync Operations</label></div>
            <div class="sync-grid">
              <button class="sync-btn" @click="doSync('ip')"><i class="fa-solid fa-arrow-right-arrow-left"></i> Sync MK Clients IP to Software</button>
              <button class="sync-btn" @click="doSync('mac')"><i class="fa-solid fa-arrow-right-arrow-left"></i> Sync MK Clients MAC to Software</button>
              <button class="sync-btn" @click="doSync('onlinemac')"><i class="fa-solid fa-arrow-right-arrow-left"></i> Sync Online Clients MK MAC to Software</button>
              <button class="sync-btn" @click="doSync('static')"><i class="fa-solid fa-network-wired"></i> Online Client IP Add To Static IP</button>
            </div>
          </div>
          <div class="g2">
            <div class="ff">
              <label>Mikrotik Connection Type</label>
              <div class="conn-block">
                <span class="conn-val" x-text="site.mkType.toUpperCase()"></span>
                <select x-model="site.mkType">
                  <option value="api">API</option>
                  <option value="ssh">SSH</option>
                  <option value="telnet">Telnet</option>
                </select>
              </div>
            </div>
            <div class="ff">
              <label>Show Online / Offline in Top</label>
              <div class="conn-block">
                <span class="status-chip" :class="site.showOnline==='yes'?'chip-yes':'chip-no'" x-text="site.showOnline==='yes'?'YES':'NO'"></span>
                <select x-model="site.showOnline">
                  <option value="yes">Yes</option>
                  <option value="no">No</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Expiry & Billing -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-clock"></i>
        <span class="section-title">Expiry &amp; Billing Settings</span>
      </div>
      <div class="section-body">
        <div class="g3">
          <div class="g2 col2">
            <div class="ff">
              <label>Expire Time</label>
              <div class="time-row">
                <div style="flex:1">
                  <input type="number" x-model.number="site.expireHour" min="0" max="23" placeholder="Hour">
                  <div class="time-lbl">Hour</div>
                </div>
                <span class="time-sep" style="margin-top:-12px">:</span>
                <div style="flex:1">
                  <input type="number" x-model.number="site.expireMin" min="0" max="59" placeholder="Minute">
                  <div class="time-lbl">Minute</div>
                </div>
              </div>
            </div>
            <div class="ff">
              <label>Expire SMS Send Time</label>
              <input type="text" x-model="site.expireSmsTime" placeholder="e.g. 11:30">
            </div>
            <div class="ff">
              <label>Deactive Day after Expire</label>
              <input type="number" x-model.number="site.deactiveDay" min="0" placeholder="0">
            </div>
            <div class="ff">
              <label>Billing Type</label>
              <select x-model="site.billingType">
                <option>Day to Day</option>
                <option>Monthly</option>
                <option>Weekly</option>
              </select>
            </div>
          </div>
          <div>
            <div class="g2">
              <div class="ff">
                <label>Days (Day 2 Day Active After)</label>
                <input type="number" x-model.number="site.d2dDays" min="0" placeholder="0">
              </div>
              <div class="ff">
                <label>D2D After Days Active</label>
                <div class="conn-block">
                  <span class="status-chip" :class="site.d2dActive==='yes'?'chip-yes':'chip-no'" x-text="site.d2dActive==='yes'?'YES':'NO'"></span>
                  <select x-model="site.d2dActive">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Network Settings -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-network-wired"></i>
        <span class="section-title">Network &amp; Sync Config</span>
      </div>
      <div class="section-body">
        <div class="g4">
          <div class="ff">
            <label>Mikrotik Sync Time (sec)</label>
            <input type="number" x-model.number="site.mkSyncTime" placeholder="300">
          </div>
          <div class="ff">
            <label>Max Extended Day</label>
            <input type="number" x-model.number="site.maxExtendedDay" placeholder="30">
          </div>
          <div class="ff">
            <label>Host IP</label>
            <input type="text" x-model="site.hostIp" placeholder="Enter Host IP Address">
          </div>
          <div class="ff">
            <label>Host Port</label>
            <input type="text" x-model="site.hostPort" placeholder="Enter Host Port">
          </div>
        </div>
      </div>
    </div>

    <!-- Company Information -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-building"></i>
        <span class="section-title">Company Information</span>
      </div>
      <div class="section-body">
        <div class="g3">
          <div class="ff">
            <label>Company Name</label>
            <input type="text" x-model="site.company" placeholder="Company Name">
          </div>
          <div class="ff">
            <label>Email Address</label>
            <input type="email" x-model="site.email" placeholder="admin@company.com">
          </div>
          <div class="ff">
            <label>Phone</label>
            <input type="tel" x-model="site.phone" placeholder="0123456789">
          </div>
          <div class="ff">
            <label>Billing Contact No</label>
            <input type="tel" x-model="site.billingContact" placeholder="Enter Billing Contact No">
          </div>
          <div class="ff">
            <label>Technical or Support No</label>
            <input type="tel" x-model="site.supportNo" placeholder="Enter Technical or Support No">
          </div>
        </div>
      </div>
    </div>

    <!-- Links & Rich Text -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-link"></i>
        <span class="section-title">Links &amp; Content</span>
      </div>
      <div class="section-body">
        <div class="g2" style="margin-bottom:16px">
          <div class="ff">
            <label>Additional Link Title</label>
            <input type="text" x-model="site.linkTitle" placeholder="Enter Link Title">
          </div>
          <div class="ff">
            <label>Additional Link URL</label>
            <input type="text" x-model="site.linkUrl" placeholder="Enter Link URL">
          </div>
        </div>
        <div class="g2">
          <div class="ff">
            <label>Address</label>
            <div class="rte">
              <div class="rte-bar">
                <button @click.prevent="fmt('bold')" title="Bold"><i class="fa-solid fa-bold"></i></button>
                <button @click.prevent="fmt('italic')" title="Italic"><i class="fa-solid fa-italic"></i></button>
                <button @click.prevent="fmt('underline')" title="Underline"><i class="fa-solid fa-underline"></i></button>
                <span class="rte-sep"></span>
                <button @click.prevent="fmt('insertUnorderedList')"><i class="fa-solid fa-list-ul"></i></button>
                <button @click.prevent="fmt('insertOrderedList')"><i class="fa-solid fa-list-ol"></i></button>
                <span class="rte-sep"></span>
                <button @click.prevent="fmt('justifyLeft')"><i class="fa-solid fa-align-left"></i></button>
                <button @click.prevent="fmt('justifyCenter')"><i class="fa-solid fa-align-center"></i></button>
                <button @click.prevent="fmt('justifyRight')"><i class="fa-solid fa-align-right"></i></button>
              </div>
              <div class="rte-body" contenteditable="true">Dhaka</div>
            </div>
          </div>
          <div class="ff">
            <label>Invoice Terms</label>
            <div class="rte">
              <div class="rte-bar">
                <button @click.prevent="fmt('bold')"><i class="fa-solid fa-bold"></i></button>
                <button @click.prevent="fmt('italic')"><i class="fa-solid fa-italic"></i></button>
                <button @click.prevent="fmt('underline')"><i class="fa-solid fa-underline"></i></button>
                <span class="rte-sep"></span>
                <button @click.prevent="fmt('insertUnorderedList')"><i class="fa-solid fa-list-ul"></i></button>
                <button @click.prevent="fmt('insertOrderedList')"><i class="fa-solid fa-list-ol"></i></button>
                <span class="rte-sep"></span>
                <button @click.prevent="fmt('justifyLeft')"><i class="fa-solid fa-align-left"></i></button>
                <button @click.prevent="fmt('justifyCenter')"><i class="fa-solid fa-align-center"></i></button>
                <button @click.prevent="fmt('justifyRight')"><i class="fa-solid fa-align-right"></i></button>
              </div>
              <div class="rte-body" contenteditable="true"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Client Notification -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-bell"></i>
        <span class="section-title">Client Notification</span>
      </div>
      <div class="section-body">
        <div class="ff">
          <div class="rte">
            <div class="rte-bar">
              <button @click.prevent="fmt('bold')"><i class="fa-solid fa-bold"></i></button>
              <button @click.prevent="fmt('italic')"><i class="fa-solid fa-italic"></i></button>
              <button @click.prevent="fmt('underline')"><i class="fa-solid fa-underline"></i></button>
              <span class="rte-sep"></span>
              <button @click.prevent="fmt('insertUnorderedList')"><i class="fa-solid fa-list-ul"></i></button>
              <button @click.prevent="fmt('insertOrderedList')"><i class="fa-solid fa-list-ol"></i></button>
              <span class="rte-sep"></span>
              <button @click.prevent="fmt('justifyLeft')"><i class="fa-solid fa-align-left"></i></button>
              <button @click.prevent="fmt('justifyCenter')"><i class="fa-solid fa-align-center"></i></button>
              <button @click.prevent="fmt('justifyRight')"><i class="fa-solid fa-align-right"></i></button>
            </div>
            <div class="rte-body" contenteditable="true" style="min-height:100px"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Billing Dates -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-calendar-days"></i>
        <span class="section-title">Billing Dates &amp; Recharge</span>
      </div>
      <div class="section-body">
        <div class="g3">
          <div class="ff">
            <label>Bill By Payment Start Date</label>
            <input type="date" x-model="site.billStartDate">
          </div>
          <div class="ff">
            <label>Minimum Amount For Online Recharge (Reseller)</label>
            <input type="number" x-model.number="site.minRecharge" min="0" step="0.01" placeholder="0.00">
          </div>
        </div>
      </div>
    </div>

    <!-- Captive Page -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-wifi"></i>
        <span class="section-title">Captive Page Settings</span>
      </div>
      <div class="section-body">
        <div class="g3" style="margin-bottom:16px">
          <div class="ff">
            <label>Captive Page Title</label>
            <input type="text" x-model="site.captiveTitle" placeholder="Enter captive page title">
          </div>
          <div class="ff">
            <label>Captive Page Technical Phone</label>
            <input type="tel" x-model="site.captivePhone" placeholder="">
          </div>
          <div class="ff">
            <label>Captive Page WhatsApp Phone</label>
            <input type="tel" x-model="site.captiveWhatsapp" placeholder="">
          </div>
          <div class="ff">
            <label>Captive Page Port</label>
            <input type="text" x-model="site.captivePort" placeholder="" disabled>
          </div>
          <div class="ff col2">
            <label>Expired Page Background (/expired)</label>
            <div class="upload-zone" @click="$refs.expBgInp.click()">
              <div class="upload-icon"><i class="fa-solid fa-image"></i></div>
              <div class="upload-status" :class="files.expiredBg?'set':'not-set'" x-text="files.expiredBg?'File Set':'No file chosen'"></div>
              <div class="upload-filename" x-show="files.expiredBg" x-text="files.expiredBg"></div>
              <div class="upload-hint">JPEG, PNG, GIF or WebP, max 5 MB. Shown behind the card on the public expired page.</div>
              <div class="upload-btn"><i class="fa-solid fa-upload"></i> Choose file</div>
              <input type="file" x-ref="expBgInp" accept="image/*" @change="onFile($event,'expiredBg')" style="display:none">
            </div>
          </div>
        </div>
        <div class="ff">
          <label>Captive Page Description</label>
          <div class="rte">
            <div class="rte-bar">
              <button @click.prevent="fmt('bold')"><i class="fa-solid fa-bold"></i></button>
              <button @click.prevent="fmt('italic')"><i class="fa-solid fa-italic"></i></button>
              <button @click.prevent="fmt('underline')"><i class="fa-solid fa-underline"></i></button>
              <span class="rte-sep"></span>
              <button @click.prevent="fmt('insertUnorderedList')"><i class="fa-solid fa-list-ul"></i></button>
              <button @click.prevent="fmt('insertOrderedList')"><i class="fa-solid fa-list-ol"></i></button>
              <span class="rte-sep"></span>
              <button @click.prevent="fmt('justifyLeft')"><i class="fa-solid fa-align-left"></i></button>
              <button @click.prevent="fmt('justifyCenter')"><i class="fa-solid fa-align-center"></i></button>
              <button @click.prevent="fmt('justifyRight')"><i class="fa-solid fa-align-right"></i></button>
            </div>
            <div class="rte-body" contenteditable="true" style="min-height:90px"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Telegram -->
    <div class="section">
      <div class="section-head">
        <i class="fa-brands fa-telegram"></i>
        <span class="section-title">General Telegram Setting</span>
      </div>
      <div class="section-body">
        <div class="g3">
          <div class="ff">
            <label>Telegram Group Name</label>
            <input type="text" x-model="site.tgGroup" placeholder="Enter Group Name">
          </div>
          <div class="ff">
            <label>Telegram API</label>
            <input type="text" x-model="site.tgApi" placeholder="Enter Api">
          </div>
          <div class="ff">
            <label>Telegram Chat ID</label>
            <input type="text" x-model="site.tgChatId" placeholder="Enter Chat Id">
          </div>
        </div>
      </div>
    </div>

    <div class="save-row">
      <button class="btn-save" @click="save()"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════
       TAB 2: PAYMENT BUTTON
  ══════════════════════════════════════════════ -->
  <div x-show="tab==='payment'">

    <!-- 3rd Party Payment URL -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-link"></i>
        <span class="section-title">3rd Party Payment URL</span>
      </div>
      <div class="section-body">
        <div class="ff">
          <label>Payment URL</label>
          <div class="url-row">
            <label class="url-check">
              <input type="checkbox" x-model="payment.urlEnabled"> Enable 3rd Party URL
            </label>
            <input type="text" x-model="payment.url" placeholder="Enter payment URL" :disabled="!payment.urlEnabled">
          </div>
        </div>
      </div>
    </div>

    <!-- Payment Provider Images -->
    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-image"></i>
        <span class="section-title">Image For Payment Button</span>
      </div>
      <div class="section-body">
        <div class="pay-grid">
          <template x-for="provider in payProviders" :key="provider.key">
            <div class="pay-item">
              <div class="pay-item-name" x-text="provider.label + ' Image'"></div>
              <div class="pay-item-area">
                <template x-if="!files[provider.key]">
                  <div style="text-align:center">
                    <div class="pay-item-icon"><i class="fa-solid fa-image"></i></div>
                    <div class="pay-item-lbl">No file chosen</div>
                  </div>
                </template>
                <template x-if="files[provider.key]">
                  <div style="text-align:center">
                    <div style="font-size:20px;color:var(--success)"><i class="fa-solid fa-circle-check"></i></div>
                    <div class="pay-item-file" x-text="files[provider.key]"></div>
                  </div>
                </template>
                <label style="margin-top:8px;display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:#fff;border:1.5px solid var(--border);border-radius:7px;font-size:11px;font-weight:600;color:var(--text);cursor:pointer">
                  <i class="fa-solid fa-upload" style="font-size:10px"></i> Choose file
                  <input type="file" accept="image/*" @change="onFile($event, provider.key)" style="display:none">
                </label>
              </div>
            </div>
          </template>
        </div>
      </div>
    </div>

    <div class="save-row">
      <button class="btn-save" @click="save()"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
  </div>

  <!-- ══════════════════════════════════════════════
       TAB 3: YETFIX NOTICE
  ══════════════════════════════════════════════ -->
  <div x-show="tab==='yetfix'">

    <div class="section">
      <div class="section-head">
        <i class="fa-solid fa-shield-halved"></i>
        <span class="section-title">License &amp; Notice Settings</span>
      </div>
      <div class="section-body">
        <div class="notice-card">
          <div class="g2" style="margin-bottom:16px">
            <div class="ff">
              <label>Customer Panel URL</label>
              <input type="text" x-model="yetfix.panelUrl" placeholder="client-list.yetfix.com">
            </div>
            <div class="ff">
              <label>Panel Secret</label>
              <input type="password" x-model="yetfix.panelSecret" placeholder="Enter Panel Secret">
            </div>
          </div>
          <div class="g3">
            <div class="ff">
              <label>Yetfix Notice Show</label>
              <select x-model="yetfix.noticeShow">
                <option value="no">No</option>
                <option value="yes">Yes</option>
              </select>
            </div>
            <div class="ff">
              <label>License Check</label>
              <select x-model="yetfix.licenseCheck">
                <option value="false">False</option>
                <option value="true">True</option>
              </select>
            </div>
            <div class="ff">
              <label>Check Time</label>
              <input type="number" x-model.number="yetfix.checkTime" min="1" placeholder="30">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="save-row">
      <button class="btn-save" @click="save()"><i class="fa-solid fa-floppy-disk"></i> Save Changes</button>
    </div>
  </div>

  <!-- Toast -->
  <template x-if="toast.show">
    <div class="toast-wrap">
      <div class="toast"><i class="fa-solid fa-circle-check"></i> <span x-text="toast.msg"></span></div>
    </div>
  </template>

</div>
<script>
function settingsApp(){
  return {
    tab:'site',
    files:{
      logo:null,landing:null,qrcode:null,signature:null,expiredBg:null,
      bkash:null,ssl:null,nagod:null,upay:null,epspay:null,playstation:null,surjopay:null,uddoktapay:null
    },
    site:{
      paymentUrl:'',qrInfo:'',
      mkType:'api',showOnline:'no',
      expireHour:10,expireMin:0,expireSmsTime:'11:30',
      deactiveDay:0,billingType:'Day to Day',
      d2dDays:0,d2dActive:'no',
      mkSyncTime:300,maxExtendedDay:30,hostIp:'',hostPort:'',
      company:'Company Name',email:'admin@company.com',phone:'0123456789',
      billingContact:'',supportNo:'',
      linkTitle:'',linkUrl:'',
      billStartDate:'2026-06-05',minRecharge:0,
      captiveTitle:'',captivePhone:'',captiveWhatsapp:'',captivePort:'',
      tgGroup:'',tgApi:'',tgChatId:''
    },
    payment:{
      urlEnabled:false,url:''
    },
    payProviders:[
      {key:'bkash',label:'Bkash'},
      {key:'ssl',label:'SSL'},
      {key:'nagod',label:'Nagod'},
      {key:'upay',label:'Upay'},
      {key:'epspay',label:'EPS Pay'},
      {key:'playstation',label:'PayStation'},
      {key:'surjopay',label:'SurjoPay'},
      {key:'uddoktapay',label:'UddoktaPay'},
    ],
    yetfix:{
      panelUrl:'client-list.yetfix.com',panelSecret:'',
      noticeShow:'no',licenseCheck:'false',checkTime:30
    },
    toast:{show:false,msg:''},

    onFile(evt, key){
      const f=evt.target.files[0]
      this.files[key]=f?f.name:null
    },

    fmt(cmd){
      document.execCommand(cmd,false,null)
    },

    doSync(type){
      const labels={ip:'IP sync initiated',mac:'MAC sync initiated',onlinemac:'Online MAC sync initiated',static:'Static IP assignment started'}
      this.showToast(labels[type]||'Sync started')
    },

    save(){
      this.showToast('Settings saved successfully')
    },

    showToast(msg){
      this.toast={show:true,msg}
      setTimeout(()=>this.toast.show=false,2800)
    }
  }
}
</script>
</body>
</html>
