<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMS Settings</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary:       #2563EB;
            --primary-dark:  #1D4ED8;
            --primary-bg:    #EFF6FF;
            --success:       #059669;
            --success-bg:    #ECFDF5;
            --danger:        #DC2626;
            --danger-bg:     #FEF2F2;
            --warning:       #D97706;
            --warning-bg:    #FFFBEB;
            --teal:          #0D9488;
            --teal-bg:       #F0FDFA;
            --violet:        #7C3AED;
            --violet-bg:     #F5F3FF;
            --surface:       #fff;
            --bg:            #F1F5F9;
            --border:        #E2E8F0;
            --text:          #0F172A;
            --text-2:        #475569;
            --text-3:        #94A3B8;
            --shadow:        0 1px 3px rgba(0,0,0,.08);
            --shadow-md:     0 4px 14px rgba(0,0,0,.09), 0 2px 4px rgba(0,0,0,.04);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 13.5px;
            min-height: 100vh;
        }

        [x-cloak] { display: none !important; }

        .page-wrap { max-width: 1380px; margin: 0 auto; padding: 20px 16px 60px; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 16px; gap: 10px; flex-wrap: wrap;
        }

        .page-title {
            font-size: 19px; font-weight: 800; color: var(--text);
            display: flex; align-items: center; gap: 10px; letter-spacing: -.3px;
        }

        .page-title-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #2563EB 0%, #60A5FA 100%);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 14px;
            box-shadow: 0 2px 8px rgba(37,99,235,.3);
            flex-shrink: 0;
        }

        .page-sub { font-size: 12.5px; color: var(--text-3); margin-top: 2px; }

        /* ── LAYOUT ── */
        .sms-layout {
            display: grid;
            grid-template-columns: 235px minmax(0, 1fr) 290px;
            gap: 16px;
            align-items: start;
        }

        /* ── TEMPLATE NAV ── */
        .tpl-nav {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-md);
            padding: 8px;
            position: sticky; top: 16px;
        }

        .tpl-nav-title {
            font-size: 11px; font-weight: 700; color: var(--text-3);
            text-transform: uppercase; letter-spacing: .6px;
            padding: 8px 10px 6px;
        }

        .tpl-item {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 9px 10px;
            border: none; background: none; border-radius: 9px;
            font-size: 12.5px; font-weight: 600; font-family: inherit;
            color: var(--text-2); cursor: pointer; text-align: left;
            transition: background .13s, color .13s;
        }

        .tpl-item:hover { background: var(--bg); color: var(--text); }
        .tpl-item.active { background: var(--primary); color: #fff; }
        .tpl-item i { width: 16px; text-align: center; font-size: 12px; opacity: .75; }

        .tpl-count {
            margin-left: auto; flex-shrink: 0;
            font-size: 10px; font-weight: 700;
            background: var(--bg); color: var(--text-3);
            border-radius: 10px; padding: 1px 7px;
        }

        .tpl-item.active .tpl-count { background: rgba(255,255,255,.22); color: #fff; }

        /* ── SECTION CARD ── */
        .editor-col { display: flex; flex-direction: column; gap: 16px; min-width: 0; }

        .section-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            transition: box-shadow .15s, border-color .15s;
        }

        .section-card.focused { border-color: #BFDBFE; box-shadow: 0 0 0 3px rgba(37,99,235,.08), var(--shadow-md); }

        .section-head {
            padding: 13px 18px;
            border-bottom: 1px solid var(--border);
            background: #FAFBFC;
            display: flex; align-items: center; justify-content: space-between;
            gap: 10px; flex-wrap: wrap;
        }

        .section-head-left { display: flex; align-items: center; gap: 11px; min-width: 0; }

        .section-ico {
            width: 34px; height: 34px; border-radius: 9px;
            background: var(--primary-bg); color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; flex-shrink: 0;
        }

        .section-from-label { font-size: 10.5px; font-weight: 700; color: var(--text-3); text-transform: uppercase; letter-spacing: .5px; }
        .section-from { font-size: 14px; font-weight: 800; }

        .tag {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 2px 9px; border-radius: 20px;
            font-size: 10.5px; font-weight: 700; white-space: nowrap;
        }

        .tag-auto { background: var(--violet-bg); color: var(--violet); border: 1px solid #DDD6FE; }
        .tag-hint { background: var(--danger-bg); color: var(--danger); border: 1px solid #FECACA; }

        /* toggle */
        .send-toggle { display: flex; align-items: center; gap: 9px; }
        .send-label { font-size: 12px; font-weight: 700; color: var(--text-2); }

        .switch {
            position: relative; width: 42px; height: 23px;
            border-radius: 20px; border: none; cursor: pointer;
            background: #CBD5E1; transition: background .18s; flex-shrink: 0;
        }

        .switch.on { background: var(--success); }

        .switch::after {
            content: ''; position: absolute; top: 2.5px; left: 3px;
            width: 18px; height: 18px; border-radius: 50%;
            background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,.25);
            transition: left .18s;
        }

        .switch.on::after { left: 21px; }

        .send-state { font-size: 11.5px; font-weight: 700; min-width: 22px; }
        .send-state.yes { color: var(--success); }
        .send-state.no  { color: var(--text-3); }

        .section-body { padding: 18px; }

        /* WHEN row (auto reminders) */
        .when-row {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 14px; flex-wrap: wrap;
            padding: 10px 13px;
            background: var(--violet-bg);
            border: 1px solid #DDD6FE;
            border-radius: 10px;
        }

        .when-row .wl { font-size: 12px; font-weight: 700; color: var(--violet); }

        .when-row input {
            width: 64px; height: 32px; text-align: center;
            border: 1.5px solid #DDD6FE; border-radius: 8px;
            font-size: 13px; font-weight: 700; font-family: inherit;
            color: var(--violet); background: var(--surface);
        }

        .when-row input:focus { outline: none; border-color: var(--violet); }
        .when-row .wt { font-size: 12px; font-weight: 600; color: var(--text-2); }

        .msg-label {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 8px; flex-wrap: wrap; gap: 6px;
        }

        .msg-label .lbl { font-size: 12.5px; font-weight: 700; color: var(--text-2); }
        .msg-label .lbl .req { color: var(--danger); }

        .char-meta { display: flex; align-items: center; gap: 8px; font-size: 11.5px; color: var(--text-3); }

        .char-pill {
            padding: 2px 9px; border-radius: 20px; font-weight: 700;
            background: var(--bg); border: 1px solid var(--border); color: var(--text-2);
            font-variant-numeric: tabular-nums;
        }

        .char-pill.multi { background: var(--warning-bg); border-color: #FDE68A; color: var(--warning); }

        textarea.msg-input {
            width: 100%; min-height: 150px; resize: vertical;
            padding: 13px; border: 1.5px solid var(--border); border-radius: 11px;
            font-size: 14px; font-family: inherit; line-height: 1.7;
            color: var(--text); background: var(--surface);
            transition: border-color .15s, box-shadow .15s;
        }

        textarea.msg-input:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        textarea.msg-input.invalid { border-color: var(--danger); }
        .err-msg { font-size: 11.5px; font-weight: 600; color: var(--danger); margin-top: 6px; }

        /* per-section variable chips */
        .var-row-label {
            font-size: 11px; font-weight: 700; color: var(--text-3);
            text-transform: uppercase; letter-spacing: .5px;
            margin: 12px 0 7px;
            display: flex; align-items: center; gap: 7px;
        }

        .var-row-label i { color: var(--violet); font-size: 10px; }
        .var-row-label .hint { font-weight: 600; text-transform: none; letter-spacing: 0; }

        .var-row { display: flex; flex-wrap: wrap; gap: 6px; }

        .var-chip {
            border: 1px solid #DDD6FE; background: var(--violet-bg); color: var(--violet);
            font-size: 11px; font-weight: 700; font-family: 'Courier New', monospace;
            padding: 3px 8px; border-radius: 7px; cursor: pointer;
            transition: background .13s, color .13s, transform .1s;
        }

        .var-chip:hover { background: var(--violet); color: #fff; }
        .var-chip:active { transform: scale(.95); }

        /* ── ACTIONS ── */
        .section-actions {
            padding: 12px 18px;
            border-top: 1px solid var(--border);
            background: #FAFBFC;
            display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap;
        }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            height: 36px; padding: 0 16px;
            border: none; border-radius: 9px;
            font-size: 13px; font-weight: 600; font-family: inherit;
            cursor: pointer; white-space: nowrap;
            transition: background .15s;
        }

        .btn-reset { background: var(--surface); color: var(--text-2); border: 1.5px solid var(--border); }
        .btn-reset:hover { background: var(--bg); }

        .btn-history { background: var(--teal); color: #fff; box-shadow: 0 2px 8px rgba(13,148,136,.25); }
        .btn-history:hover { background: #0F766E; }

        .btn-submit { background: var(--primary); color: #fff; box-shadow: 0 2px 8px rgba(37,99,235,.28); }
        .btn-submit:hover { background: var(--primary-dark); }

        /* ── RIGHT RAIL (PREVIEW) ── */
        .rail { position: sticky; top: 16px; }

        .rail-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        .rail-head {
            padding: 11px 16px;
            border-bottom: 1px solid var(--border);
            background: #FAFBFC;
            font-size: 12px; font-weight: 700;
            display: flex; align-items: center; gap: 8px;
        }

        .rail-head i { font-size: 11px; color: var(--primary); }
        .rail-head .hint { margin-left: auto; font-size: 10.5px; font-weight: 600; color: var(--text-3); }

        .preview-which {
            padding: 9px 16px; font-size: 11.5px; font-weight: 700;
            color: var(--violet); background: var(--violet-bg);
            border-bottom: 1px solid #DDD6FE;
            display: flex; align-items: center; gap: 7px;
        }

        .phone-wrap { padding: 16px; display: flex; justify-content: center; background: linear-gradient(180deg, #F8FAFC, #EEF2F7); }

        .phone {
            width: 100%; max-width: 235px;
            background: #0F172A; border-radius: 22px; padding: 9px;
            box-shadow: 0 10px 28px rgba(15,23,42,.28);
        }

        .phone-screen {
            background: #E8EDF4; border-radius: 15px; overflow: hidden;
            display: flex; flex-direction: column; min-height: 250px;
        }

        .phone-top {
            background: #fff; padding: 9px 12px;
            display: flex; align-items: center; gap: 8px;
            border-bottom: 1px solid var(--border);
        }

        .phone-avatar {
            width: 24px; height: 24px; border-radius: 50%;
            background: linear-gradient(135deg, #2563EB, #60A5FA);
            color: #fff; font-size: 10px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }

        .phone-sender { font-size: 11px; font-weight: 700; }
        .phone-now    { font-size: 9.5px; color: var(--text-3); }

        .phone-msgs { padding: 12px 10px; flex: 1; }

        .bubble {
            background: #fff; border-radius: 4px 13px 13px 13px;
            padding: 9px 11px; font-size: 11.5px; line-height: 1.65;
            color: var(--text); box-shadow: 0 1px 2px rgba(0,0,0,.07);
            white-space: pre-wrap; word-break: break-word;
        }

        .bubble .var-live { color: var(--primary); font-weight: 700; }
        .bubble-time { font-size: 9px; color: var(--text-3); margin-top: 5px; }

        /* ── HISTORY MODAL ── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 200;
            background: rgba(15,23,42,.45);
            display: flex; align-items: center; justify-content: center;
            padding: 16px;
        }

        .modal-box {
            background: var(--surface); border-radius: 14px;
            box-shadow: 0 20px 50px rgba(0,0,0,.25);
            width: 100%; max-width: 520px;
            overflow: hidden;
        }

        .modal-head {
            padding: 14px 20px; border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            background: #FAFBFC;
        }

        .modal-head .t { font-size: 14px; font-weight: 800; display: flex; align-items: center; gap: 8px; }
        .modal-head .t i { color: var(--teal); }

        .modal-x {
            border: none; background: var(--bg); color: var(--text-2);
            width: 28px; height: 28px; border-radius: 8px; cursor: pointer;
            transition: background .13s;
        }

        .modal-x:hover { background: var(--danger-bg); color: var(--danger); }

        .hist-list { max-height: 380px; overflow-y: auto; padding: 10px 16px; }
        .hist-item { padding: 11px 4px; border-bottom: 1px solid var(--border); }
        .hist-item:last-child { border-bottom: none; }
        .hist-meta { display: flex; align-items: center; gap: 8px; margin-bottom: 5px; }
        .hist-date { font-size: 11px; font-weight: 700; color: var(--text-2); }
        .hist-by   { font-size: 10.5px; color: var(--text-3); }
        .hist-body { font-size: 12px; color: var(--text-2); line-height: 1.55; white-space: pre-wrap; }

        /* ── TOAST ── */
        .toast {
            position: fixed; bottom: 22px; right: 22px; z-index: 300;
            display: flex; align-items: center; gap: 10px;
            background: #0F172A; color: #fff;
            padding: 12px 18px; border-radius: 11px;
            font-size: 13px; font-weight: 600;
            box-shadow: 0 10px 30px rgba(0,0,0,.3);
        }

        .toast i { color: #34D399; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1100px) {
            .sms-layout { grid-template-columns: 205px minmax(0, 1fr); }
            .rail { display: none; }
        }

        @media (max-width: 700px) {
            .page-wrap { padding: 14px 12px 60px; }
            .sms-layout { grid-template-columns: 1fr; }

            .tpl-nav { position: static; display: flex; overflow-x: auto; gap: 4px; padding: 8px; }
            .tpl-nav-title { display: none; }
            .tpl-item { white-space: nowrap; width: auto; flex-shrink: 0; }

            .section-actions .btn { flex: 1; }
        }
    </style>
</head>
<body x-data="smsSettings()" x-cloak>

<div class="page-wrap">

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <div class="page-title-icon"><i class="fa fa-comment-sms"></i></div>
            <div>
                SMS Settings
                <div class="page-sub">Manage notification templates sent to your customers</div>
            </div>
        </h1>
    </div>

    <div class="sms-layout">

        <!-- Template Nav -->
        <nav class="tpl-nav">
            <div class="tpl-nav-title">Templates</div>
            <template x-for="(tpl, key) in templates" :key="key">
                <button class="tpl-item" :class="{ active: current === key }" @click="switchTo(key)">
                    <i class="fa" :class="tpl.icon"></i>
                    <span x-text="tpl.label"></span>
                    <span class="tpl-count" x-text="tpl.sections.length"></span>
                </button>
            </template>
        </nav>

        <!-- Editor column: one card per sub-template -->
        <div class="editor-col">
            <template x-for="(sec, idx) in tpl.sections" :key="current + '-' + idx">
                <div class="section-card" :class="{ focused: activeIdx === idx }">

                    <div class="section-head">
                        <div class="section-head-left">
                            <div class="section-ico"><i class="fa" :class="tpl.icon"></i></div>
                            <div>
                                <div class="section-from-label">From</div>
                                <div class="section-from" x-text="sec.from"></div>
                            </div>
                            <span class="tag tag-auto" x-show="sec.auto">
                                <i class="fa fa-robot"></i> Auto
                            </span>
                            <span class="tag tag-hint" x-show="sec.hint" x-text="sec.hint"></span>
                        </div>
                        <div class="send-toggle">
                            <span class="send-label" x-text="sec.auto ? 'Send SMS?' : 'SMS Send'"></span>
                            <button class="switch" :class="{ on: sec.send }" @click="sec.send = !sec.send"
                                    :title="sec.send ? 'Turn off' : 'Turn on'"></button>
                            <span class="send-state" :class="sec.send ? 'yes' : 'no'" x-text="sec.send ? 'Yes' : 'No'"></span>
                        </div>
                    </div>

                    <div class="section-body">

                        <!-- When? (auto reminders) -->
                        <div class="when-row" x-show="sec.auto">
                            <span class="wl"><i class="fa fa-clock" style="margin-right:5px"></i>When?</span>
                            <input type="number" min="0" max="30" x-model.number="sec.when">
                            <span class="wt">Day(s) Before Payment Deadline</span>
                        </div>

                        <div class="msg-label">
                            <span class="lbl">SMS Message <span class="req">*</span></span>
                            <div class="char-meta">
                                <span x-text="sec.message.length + ' chars'"></span>
                                <span class="char-pill" :class="{ multi: partsOf(sec) > 1 }"
                                      x-text="partsOf(sec) + (partsOf(sec) > 1 ? ' SMS parts' : ' SMS part')"></span>
                            </div>
                        </div>

                        <textarea class="msg-input" :class="{ invalid: sec.error }"
                                  :id="'box-' + current + '-' + idx"
                                  x-model="sec.message"
                                  @focus="activeIdx = idx"
                                  @input="sec.error = ''"
                                  placeholder="Type text here…"></textarea>
                        <div class="err-msg" x-show="sec.error" x-text="sec.error"></div>

                        <div class="var-row-label">
                            <i class="fa fa-code"></i> Variables
                            <span class="hint">— click to insert at cursor</span>
                        </div>
                        <div class="var-row">
                            <template x-for="v in sec.vars" :key="v">
                                <button class="var-chip" x-text="'{' + v + '}'"
                                        :title="samples[v] || ''" @click="insertVar(idx, v)"></button>
                            </template>
                        </div>

                    </div>

                    <div class="section-actions">
                        <button class="btn btn-reset" @click="resetSec(sec)">
                            <i class="fa fa-rotate-left"></i> Reset
                        </button>
                        <button class="btn btn-history" @click="openHistory(sec)">
                            <i class="fa fa-clock-rotate-left"></i> History
                        </button>
                        <button class="btn btn-submit" @click="submitSec(sec)">
                            <i class="fa fa-paper-plane"></i> Submit
                        </button>
                    </div>

                </div>
            </template>
        </div>

        <!-- Right Rail: live preview of the focused sub-template -->
        <div class="rail">
            <div class="rail-card">
                <div class="rail-head">
                    <i class="fa fa-mobile-screen"></i> Live Preview
                    <span class="hint">with sample data</span>
                </div>
                <div class="preview-which">
                    <i class="fa fa-arrow-right"></i>
                    <span x-text="activeSec ? activeSec.from : ''"></span>
                </div>
                <div class="phone-wrap">
                    <div class="phone">
                        <div class="phone-screen">
                            <div class="phone-top">
                                <div class="phone-avatar">YF</div>
                                <div>
                                    <div class="phone-sender">YetFix ISP</div>
                                    <div class="phone-now">now</div>
                                </div>
                            </div>
                            <div class="phone-msgs">
                                <div class="bubble" x-html="previewHtml"></div>
                                <div class="bubble-time">Delivered · SMS</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- History Modal -->
<div class="modal-overlay" x-show="historySec" x-transition.opacity @click.self="historySec = null">
    <div class="modal-box" x-show="historySec" x-transition.scale.origin.center>
        <div class="modal-head">
            <div class="t"><i class="fa fa-clock-rotate-left"></i> <span x-text="(historySec?.from || '') + ' — History'"></span></div>
            <button class="modal-x" @click="historySec = null"><i class="fa fa-xmark"></i></button>
        </div>
        <div class="hist-list">
            <template x-if="historySec && historySec.history.length === 0">
                <div style="padding:30px; text-align:center; color:var(--text-3); font-size:12.5px;">
                    No previous versions saved for this template.
                </div>
            </template>
            <template x-for="(h, i) in (historySec?.history || [])" :key="i">
                <div class="hist-item">
                    <div class="hist-meta">
                        <span class="hist-date" x-text="h.date"></span>
                        <span class="hist-by" x-text="'by ' + h.by"></span>
                    </div>
                    <div class="hist-body" x-text="h.message"></div>
                </div>
            </template>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast" x-show="toast" x-transition.opacity.duration.300ms>
    <i class="fa fa-circle-check"></i>
    <span x-text="toast"></span>
</div>

<script>
function smsSettings() {
    const BASE_VARS    = ['c_id', 'c_code', 'c_name', 'c_username', 'c_password'];
    const COMPANY_VARS = ['company_name', 'company_cell'];
    const BTRC_VARS    = ['BTRC_speed', 'BTRC_rate'];

    return {
        current:    'welcome',
        activeIdx:  0,
        historySec: null,
        toast:      '',

        samples: {
            c_id: '1024', c_code: 'LM2-1024', c_name: 'Abdul Karim',
            c_username: 'karim1024', c_password: 'pass@1024',
            c_package: 'Lalmonirhat-2-Pack-630', c_otc: '500', c_package_price: '630',
            c_expire_date: '30-Jun-2026', c_deadline: '10-Jun-2026',
            c_bill: '630', c_due: '0',
            BTRC_speed: '30 Mbps', BTRC_rate: '630',
            PaymentAmount: '630', MonthlyBill: '630', TotalDue: '630',
            token_no: 'TKT-2048', token_category: 'Internet Issue', token_code: 'TC-77',
            billing_no: '01300532242', 'technical/support_no': '01300532243',
            employee_name: 'Sohel Rana', reporter_contact_no: '01712001001',
            company_name: 'YetFix ISP', company_cell: '01300532242',
        },

        templates: {
            welcome: {
                label: 'Welcome SMS', icon: 'fa-hand-sparkles',
                sections: [
                    {
                        from: 'Add Client', hint: 'Choose by User', auto: false, send: false,
                        message: 'প্রিয় {c_name}\nইউজার আইডি: {c_username}\nপাসওয়ার্ড: {c_password}\nআপনার আইডি সফলভাবে যুক্ত করা হয়েছে। ধন্যবাদ!\n{company_name}\n{company_cell}',
                        vars: [...BASE_VARS, 'c_package', 'c_otc', 'c_package_price', ...BTRC_VARS, ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
            billPayment: {
                label: 'Bill Payment', icon: 'fa-money-bill-wave',
                sections: [
                    {
                        from: 'Bill Payment', hint: 'Choose by User', auto: false, send: false,
                        message: 'প্রিয় গ্রাহক ({c_name}),\nআপনার বিল সঠিক ভাবে সংগৃহিত হয়েছে। সংগৃহিত টাকার পরিমান- TK {PaymentAmount} | যেকোনো তথ্যের জন্য যোগাযোগ {company_cell} | {company_name} এর সাথে থাকার জন্য ধন্যবাদ।',
                        vars: [...BASE_VARS, 'c_expire_date', 'c_package', ...BTRC_VARS, 'PaymentAmount', ...COMPANY_VARS],
                        history: [], error: '',
                    },
                    {
                        from: 'OTC Payment', hint: '', auto: false, send: false,
                        message: 'প্রিয় গ্রাহক ({c_name}),\n{PaymentAmount} টাকা সংগৃহিত হয়েছে OTC পেমেন্ট এর জন্য। যে কোন প্রশ্নের জন্য {company_cell} নম্বরে যোগাযোগ করুন|',
                        vars: [...BASE_VARS, 'c_expire_date', 'c_package', ...BTRC_VARS, 'PaymentAmount', ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
            support: {
                label: 'Support', icon: 'fa-headset',
                sections: [
                    {
                        from: 'Token Create Customer Send Sms', hint: 'For Customer', auto: false, send: false,
                        message: 'প্রিয় গ্রাহক, আপনার সমস্যাটি আমরা অবগত হয়েছি। আপনার টোকেন আইডি {token_no}| যে কোন প্রশ্নের জন্য {company_cell} নম্বরে যোগাযোগ করুন',
                        vars: [...BASE_VARS, 'token_no', 'token_category', 'token_code', 'billing_no', 'technical/support_no', ...COMPANY_VARS],
                        history: [], error: '',
                    },
                    {
                        from: 'Token Assign Employee Send Sms', hint: 'For Employee', auto: false, send: false,
                        message: 'Token {token_no} ({token_code}) Contact: {reporter_contact_no} Solve Quickly',
                        vars: [...BASE_VARS, 'employee_name', 'reporter_contact_no', 'token_no', 'token_code', ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
            generateBill: {
                label: 'Generate Bill', icon: 'fa-file-invoice-dollar',
                sections: [
                    {
                        from: 'Bill Generate', hint: '', auto: false, send: true,
                        message: 'প্রিয় {c_name}\nআপনার {c_package} প্যাকেজের {MonthlyBill} টাকা বিল তৈরি হয়েছে।\nশেষ তারিখ: {c_deadline}\n{company_name}',
                        vars: [...BASE_VARS, 'c_package', 'c_deadline', 'MonthlyBill', 'TotalDue', ...BTRC_VARS, ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
            billReminder: {
                label: 'Bill Reminder', icon: 'fa-bell',
                sections: [
                    {
                        from: '1st reminder', hint: '2 Day Before payment deadline', auto: true, when: 2, send: false,
                        message: 'Dear {c_name}\nLast 2nd day Remaning to Play your internet due bill {TotalDue}Tk\nPlease Pay Your Bill as soon as possible\nThanks\n\n{company_name}\n{company_cell}',
                        vars: [...BASE_VARS, 'c_deadline', 'MonthlyBill', 'TotalDue', ...BTRC_VARS, ...COMPANY_VARS],
                        history: [], error: '',
                    },
                    {
                        from: '2nd reminder', hint: '1-Day Before payment deadline', auto: true, when: 1, send: false,
                        message: 'Dear {c_name}\nLast 1 day Remaning to Play your internet due bill {TotalDue}Tk\nPlease Pay Your Bill as soon as possible\nThanks\n\n{company_name}\n{company_cell}',
                        vars: [...BASE_VARS, 'c_deadline', 'MonthlyBill', 'TotalDue', ...BTRC_VARS, ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
            tempExtend: {
                label: 'Temporary Extend', icon: 'fa-clock',
                sections: [
                    {
                        from: 'Temporary Extend', hint: '', auto: false, send: false,
                        message: 'প্রিয় {c_name}\nআপনার সংযোগ সাময়িকভাবে বাড়ানো হয়েছে: {c_expire_date} পর্যন্ত।\n{company_name}',
                        vars: [...BASE_VARS, 'c_expire_date', ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
            expired: {
                label: 'Expired', icon: 'fa-circle-exclamation',
                sections: [
                    {
                        from: 'Account Expired', hint: '', auto: false, send: true,
                        message: 'প্রিয় {c_name}\nআপনার ইন্টারনেট সংযোগের মেয়াদ শেষ হয়েছে। পুনরায় চালু করতে বিল পরিশোধ করুন।\n{company_name}\n{company_cell}',
                        vars: [...BASE_VARS, 'c_expire_date', 'TotalDue', ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
            rCustomerRecharge: {
                label: 'R.Customer Recharge', icon: 'fa-credit-card',
                sections: [
                    {
                        from: 'Reseller Customer Recharge', hint: '', auto: false, send: false,
                        message: 'প্রিয় {c_name}\nআপনার একাউন্টে {PaymentAmount} টাকা রিচার্জ হয়েছে।\n{company_name}',
                        vars: [...BASE_VARS, 'PaymentAmount', ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
            disable: {
                label: 'Disable', icon: 'fa-ban',
                sections: [
                    {
                        from: 'Account Disable', hint: '', auto: false, send: false,
                        message: 'প্রিয় {c_name}\nআপনার সংযোগটি সাময়িকভাবে বন্ধ করা হয়েছে। বিস্তারিত জানতে কল করুন {company_cell}\n{company_name}',
                        vars: [...BASE_VARS, ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
            resellerRecharge: {
                label: 'Reseller Recharge', icon: 'fa-wallet',
                sections: [
                    {
                        from: 'Reseller Recharge', hint: '', auto: false, send: false,
                        message: 'প্রিয় রিসেলার,\nআপনার ব্যালেন্সে {PaymentAmount} টাকা যোগ হয়েছে।\n{company_name}',
                        vars: ['c_id', 'c_code', 'c_name', 'PaymentAmount', ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
            telegram: {
                label: 'Telegram', icon: 'fa-paper-plane',
                sections: [
                    {
                        from: 'Telegram Bot', hint: '', auto: false, send: false,
                        message: 'নতুন গ্রাহক যুক্ত হয়েছে:\nনাম: {c_name}\nআইডি: {c_username}\nপ্যাকেজ: {c_package}',
                        vars: [...BASE_VARS, 'c_package', ...COMPANY_VARS],
                        history: [], error: '',
                    },
                ],
            },
        },

        get tpl() { return this.templates[this.current]; },

        get activeSec() {
            return this.tpl.sections[this.activeIdx] || this.tpl.sections[0];
        },

        get previewHtml() {
            const sec = this.activeSec;
            if (!sec) return '';
            const esc = s => s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
            let out = esc(sec.message || 'Type a message to preview…');
            Object.keys(this.samples).forEach(k => {
                out = out.split('{' + k + '}')
                         .join('<span class="var-live">' + esc(this.samples[k]) + '</span>');
            });
            return out;
        },

        // Bengali/unicode SMS = 70 chars per part (67 when multipart); GSM-7 = 160/153
        partsOf(sec) {
            const msg = sec.message;
            if (!msg.length) return 0;
            const isUnicode = /[^ -]/.test(msg);
            const single = isUnicode ? 70 : 160;
            const multi  = isUnicode ? 67 : 153;
            return msg.length <= single ? 1 : Math.ceil(msg.length / multi);
        },

        switchTo(key) {
            this.current   = key;
            this.activeIdx = 0;
        },

        insertVar(idx, key) {
            const sec   = this.tpl.sections[idx];
            const box   = document.getElementById('box-' + this.current + '-' + idx);
            const token = '{' + key + '}';
            const start = box?.selectionStart ?? sec.message.length;
            const end   = box?.selectionEnd   ?? sec.message.length;
            sec.message = sec.message.slice(0, start) + token + sec.message.slice(end);
            this.activeIdx = idx;
            this.$nextTick(() => {
                if (!box) return;
                box.focus();
                box.selectionStart = box.selectionEnd = start + token.length;
            });
        },

        submitSec(sec) {
            if (!sec.message.trim()) {
                sec.error = 'SMS message is required';
                return;
            }
            sec.history.unshift({
                date: new Date().toLocaleString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }),
                by: 'admin',
                message: sec.message,
            });
            this.showToast(sec.from + ' template saved');
        },

        resetSec(sec) {
            sec.message = '';
            sec.error   = '';
        },

        openHistory(sec) {
            this.historySec = sec;
        },

        showToast(msg) {
            this.toast = msg;
            setTimeout(() => this.toast = '', 3000);
        },
    };
}
</script>
</body>
</html>
