<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* ── DESIGN TOKENS ── */
        :root {
            --primary:        #1E3A5F;
            --primary-light:  #2563EB;
            --primary-dark:   #0F2444;
            --accent:         #3B82F6;
            --accent-light:   #EFF6FF;
            --success:        #059669;
            --success-light:  #ECFDF5;
            --warning:        #D97706;
            --warning-light:  #FFFBEB;
            --danger:         #DC2626;
            --danger-light:   #FEF2F2;
            --n50:  #F8FAFC; --n100: #F1F5F9; --n200: #E2E8F0;
            --n300: #CBD5E1; --n400: #94A3B8; --n500: #64748B;
            --n600: #475569; --n700: #334155; --n800: #1E293B; --n900: #0F172A;
            --surface: #FFFFFF;
            --border:  #E2E8F0;
            --radius-sm: 6px; --radius: 10px; --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow:    0 4px 12px rgba(0,0,0,.08), 0 1px 3px rgba(0,0,0,.05);
            --shadow-lg: 0 10px 30px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
            --ease: 0.18s cubic-bezier(0.4,0,0.2,1);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--n100);
            color: var(--n800);
            font-size: 15px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── SECTION NAV ── */
        .snav {
            background: var(--surface);
            border-bottom: 2px solid var(--border);
            position: sticky; top: 0; z-index: 200;
            padding: 0 16px;
            display: flex; gap: 0; justify-content: center;
            overflow-x: auto; scrollbar-width: none;
            box-shadow: var(--shadow-sm);
        }
        .snav::-webkit-scrollbar { display: none; }
        .snav-item {
            display: flex; align-items: center; gap: 6px;
            padding: 11px 16px;
            font-size: 13px; font-weight: 600; color: var(--n400);
            white-space: nowrap; cursor: pointer;
            border-bottom: 2px solid transparent; margin-bottom: -2px;
            transition: all var(--ease); text-decoration: none; flex-shrink: 0;
        }
        .snav-item i { font-size: 11.5px; }
        .snav-item:hover { color: var(--n700); }
        .snav-item.is-active { color: var(--primary-light); border-bottom-color: var(--primary-light); }
        .snav-count {
            display: inline-flex; align-items: center; justify-content: center;
            width: 15px; height: 15px; border-radius: 50%;
            background: var(--danger); color: #fff; font-size: 8.5px; font-weight: 800;
        }

        /* ── PAGE ── */
        .page { max-width: 1160px; margin: 0 auto; padding: 18px 16px 110px; }

        /* ── SECTION CARD ── */
        .fsec {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 16px;
            scroll-margin-top: 56px;
        }
        /* Colored section header gradients */
        .sh-0 { background: linear-gradient(135deg, #0f2444 0%, #2563EB 100%); }
        .sh-1 { background: linear-gradient(135deg, #2e1065 0%, #7C3AED 100%); }
        .sh-2 { background: linear-gradient(135deg, #052e16 0%, #059669 100%); }
        .sh-3 { background: linear-gradient(135deg, #431407 0%, #ea580c 100%); }
        .sh-4 { background: linear-gradient(135deg, #042f2e 0%, #0D9488 100%); }
        .sh-5 { background: linear-gradient(135deg, #082f49 0%, #0284C7 100%); }

        .fsec-head {
            padding: 14px 18px;
            border-bottom: none;
            display: flex; align-items: center; gap: 12px;
        }
        .fsec-icon {
            width: 34px; height: 34px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; flex-shrink: 0;
            background: rgba(255,255,255,.15) !important;
            color: #fff !important;
            border: 1px solid rgba(255,255,255,.2);
        }
        .fsec-title { font-size: 14.5px; font-weight: 800; color: #fff; letter-spacing: -.2px; flex: 1; }
        .fsec-tag {
            font-size: 10.5px; font-weight: 700; padding: 3px 10px; border-radius: 20px;
            letter-spacing: .5px; text-transform: uppercase;
            background: rgba(255,255,255,.15); color: rgba(255,255,255,.9);
            border: 1px solid rgba(255,255,255,.2);
        }
        .ftag-req { background: rgba(255,255,255,.2); color: #fff; border-color: rgba(255,255,255,.3); }
        .ftag-opt { background: rgba(255,255,255,.1); color: rgba(255,255,255,.8); border-color: rgba(255,255,255,.15); }
        .fsec-body { padding: 18px; display: flex; flex-direction: column; gap: 14px; }

        /* ── FIELD ── */
        .ff { display: flex; flex-direction: column; gap: 5px; min-width: 0; }
        .ff-lbl {
            font-size: 12px; font-weight: 700; color: var(--n600);
            letter-spacing: .4px; text-transform: uppercase;
            display: flex; align-items: center; gap: 4px;
        }
        .req { color: var(--danger); }
        .ff-in {
            height: 40px; padding: 0 11px;
            border: 1.5px solid var(--border); border-radius: var(--radius-sm);
            font-size: 14.5px; color: var(--n800);
            background: var(--surface); font-family: inherit;
            outline: none; width: 100%;
            transition: border-color var(--ease), box-shadow var(--ease);
        }
        .ff-in:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,.1); }
        .ff-in::placeholder { color: var(--n300); font-size: 14px; }
        .ff-in:read-only { background: var(--n50); cursor: default; color: var(--primary-light); font-weight: 700; }
        .ff-sel {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%2394A3B8' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
            background-size: 15px;
            padding-right: 30px;
            cursor: pointer;
        }
        .ff-ta {
            padding: 10px 11px; min-height: 96px; resize: vertical;
            border: 1.5px solid var(--border); border-radius: var(--radius-sm);
            font-size: 14.5px; color: var(--n800);
            background: var(--surface); font-family: inherit;
            outline: none; width: 100%;
            transition: border-color var(--ease);
        }
        .ff-ta:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,.1); }
        .ff-hint { font-size: 12px; color: var(--n400); margin-top: 1px; }

        /* checkbox */
        .ff-chk {
            display: flex; align-items: center; gap: 8px;
            height: 40px; padding: 0 11px;
            border: 1.5px solid var(--border); border-radius: var(--radius-sm);
            background: var(--surface); cursor: pointer;
            transition: border-color var(--ease);
        }
        .ff-chk:hover { border-color: var(--accent); }
        .ff-chk input[type=checkbox] { width: 16px; height: 16px; cursor: pointer; accent-color: var(--primary-light); }
        .ff-chk-txt { font-size: 14.5px; color: var(--n700); font-weight: 500; }

        /* input + add button group */
        .ff-grp { display: flex; gap: 5px; }
        .ff-grp .ff-in { flex: 1; }
        .ff-add {
            height: 40px; padding: 0 11px; flex-shrink: 0;
            border-radius: var(--radius-sm); border: 1.5px solid var(--primary-light);
            background: var(--accent-light); color: var(--primary-light);
            font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit;
            display: flex; align-items: center; gap: 4px;
            transition: all var(--ease);
        }
        .ff-add:hover { background: var(--primary-light); color: #fff; }

        /* ── GRIDS ── */
        .g2 { display: grid; grid-template-columns: 1fr 1fr;             gap: 12px; }
        .g3 { display: grid; grid-template-columns: 1fr 1fr 1fr;         gap: 12px; }
        .g4 { display: grid; grid-template-columns: 1fr 1fr 1fr 1fr;     gap: 12px; }
        .g6 { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1.6fr; gap: 8px; }

        @media (max-width: 1060px) {
            .g4 { grid-template-columns: 1fr 1fr 1fr; }
            .g6 { grid-template-columns: 1fr 1fr 1fr; }
        }
        @media (max-width: 720px) {
            .g4, .g3 { grid-template-columns: 1fr 1fr; }
            .g6 { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 480px) {
            .g4, .g3, .g2, .g6 { grid-template-columns: 1fr; }
            .fsec-body { padding: 12px; gap: 10px; }
        }

        /* ── SUB-LABEL ── */
        .sub-label {
            font-size: 11.5px; font-weight: 800; color: var(--n600);
            text-transform: uppercase; letter-spacing: .6px;
            display: flex; align-items: center; gap: 8px; margin-top: 4px;
        }
        .sub-label::before {
            content: ''; display: inline-block;
            width: 3px; height: 13px; border-radius: 2px;
            background: var(--primary-light); flex-shrink: 0;
        }
        .sub-label::after { content: ''; flex: 1; height: 1.5px; background: var(--n200); }

        /* ── ACTION BAR ── */
        .abar {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 400;
            background: rgba(255,255,255,.97);
            border-top: 1px solid var(--border);
            box-shadow: 0 -4px 24px rgba(0,0,0,.09);
            padding: 11px 20px;
            display: flex; align-items: center;
            backdrop-filter: blur(8px);
        }
        .abar-progress { display: flex; align-items: center; gap: 10px; }
        .abar-info { font-size: 12px; color: var(--n500); white-space: nowrap; }
        .pbar { width: 140px; height: 5px; background: var(--n200); border-radius: 3px; overflow: hidden; }
        .pbar-fill {
            height: 100%; background: linear-gradient(90deg, var(--primary-light), #60A5FA);
            border-radius: 3px; transition: width .4s ease;
        }
        .abar-pct { font-size: 12px; font-weight: 800; color: var(--primary-light); min-width: 30px; }
        .abar-actions { margin-left: auto; display: flex; gap: 8px; }
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; border-radius: var(--radius-sm);
            font-size: 13.5px; font-weight: 600; cursor: pointer;
            transition: all var(--ease); border: none; font-family: inherit;
        }
        .btn-ghost { background: transparent; color: var(--n600); border: 1.5px solid var(--border); }
        .btn-ghost:hover { background: var(--n50); }
        .btn-save { background: var(--primary-light); color: #fff; }
        .btn-save:hover { background: #1D4ED8; box-shadow: 0 4px 14px rgba(37,99,235,.35); }
        .loading-spin {
            width: 13px; height: 13px; border: 2px solid rgba(255,255,255,.3);
            border-top-color: #fff; border-radius: 50%;
            animation: spin .5s linear infinite; display: none;
        }
        .is-loading .loading-spin { display: inline-block; }
        .is-loading .btn-txt { opacity: .7; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── TOAST ── */
        .toast-wrap {
            position: fixed; bottom: 72px; right: 18px; z-index: 5000;
            display: flex; flex-direction: column; gap: 7px; pointer-events: none;
        }
        .toast {
            padding: 11px 15px; border-radius: var(--radius);
            font-size: 13.5px; font-weight: 500; color: #fff;
            display: flex; align-items: center; gap: 8px;
            box-shadow: var(--shadow-lg); min-width: 200px;
            animation: slide-in .25s cubic-bezier(0.34,1.56,0.64,1);
            pointer-events: all;
        }
        .toast-success { background: #059669; }
        .toast-error   { background: #DC2626; }
        .toast-info    { background: var(--primary-light); }
        @keyframes slide-in {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 520px) {
            .abar-progress { display: none; }
            .abar { justify-content: flex-end; }
        }
    </style>
</head>
<body x-data="addCustomer()">

<!-- ══════════ SECTION NAV ══════════ -->
<nav class="snav" id="snav">
    <a class="snav-item" href="#sec-service"    data-idx="0"><i class="fa fa-server"></i> Service</a>
    <a class="snav-item" href="#sec-basic"      data-idx="1"><i class="fa fa-user"></i> Basic Info</a>
    <a class="snav-item" href="#sec-address"    data-idx="2"><i class="fa fa-map-marker-alt"></i> Address</a>
    <a class="snav-item" href="#sec-building"   data-idx="3"><i class="fa fa-building"></i> Building</a>
    <a class="snav-item" href="#sec-connection" data-idx="4"><i class="fa fa-plug"></i> Connection</a>
    <a class="snav-item" href="#sec-remarks"    data-idx="5"><i class="fa fa-comment-alt"></i> Remarks</a>
</nav>

<!-- ══════════ MAIN CONTENT ══════════ -->
<div class="page">

    <!-- ─────────────────────────────────────
         SERVICE INFORMATION
    ──────────────────────────────────────── -->
    <div class="fsec" id="sec-service">
        <div class="fsec-head sh-0">
            <div class="fsec-icon"><i class="fa fa-server"></i></div>
            <span class="fsec-title">Service Information</span>
            <span class="fsec-tag ftag-req">Required</span>
        </div>
        <div class="fsec-body">

            <div class="g4">
                <div class="ff">
                    <label class="ff-lbl">PPPoE Username <span class="req">*</span></label>
                    <input class="ff-in" type="text" placeholder="e.g. client001" x-model="f.pppoeUser">
                </div>
                <div class="ff">
                    <label class="ff-lbl">PPPoE Password <span class="req">*</span></label>
                    <input class="ff-in" type="text" placeholder="Password" x-model="f.pppoePass">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Pop / Zone Name <span class="req">*</span></label>
                    <select class="ff-in ff-sel" x-model="f.popZone">
                        <option value="">Select zone…</option>
                        <option>Nilkhet</option>
                        <option>Dhanmondi</option>
                        <option>Gulshan</option>
                        <option>Uttara</option>
                        <option>Mirpur</option>
                        <option>Motijheel</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-lbl">Billing Cycle (Day) <span class="req">*</span></label>
                    <select class="ff-in ff-sel" x-model="f.billingCycle">
                        <option value="">Select day…</option>
                        <template x-for="d in Array.from({length:28},(_,i)=>i+1)" :key="d">
                            <option :value="d" x-text="d"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="g4">
                <div class="ff">
                    <label class="ff-lbl">Package Name <span class="req">*</span></label>
                    <select class="ff-in ff-sel" x-model="f.package">
                        <option value="">Select package…</option>
                        <option>5 Mbps – 500 BDT</option>
                        <option>10 Mbps – 700 BDT</option>
                        <option>20 Mbps – 1,000 BDT</option>
                        <option>50 Mbps – 1,500 BDT</option>
                        <option>100 Mbps – 2,000 BDT</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-lbl">
                        Static IP
                        <span style="font-size:9.5px;color:var(--n400);font-weight:500;text-transform:none;letter-spacing:0">(optional)</span>
                    </label>
                    <label class="ff-chk">
                        <input type="checkbox" x-model="f.staticIp">
                        <span class="ff-chk-txt">Enable static IP</span>
                    </label>
                </div>
                <div class="ff">
                    <label class="ff-lbl">Static IPv6</label>
                    <input class="ff-in" type="text" placeholder="e.g. 2001:db8::1" x-model="f.staticIpv6">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Enable MAC</label>
                    <input class="ff-in" type="text" placeholder="AA:BB:CC:DD:EE:FF" x-model="f.enableMac">
                </div>
            </div>

            <div class="g3">
                <div class="ff">
                    <label class="ff-lbl">Distribution Point</label>
                    <select class="ff-in ff-sel" x-model="f.distPoint">
                        <option value="">Select point…</option>
                        <option>DP-01</option>
                        <option>DP-02</option>
                        <option>DP-03</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-lbl">Connection Type</label>
                    <select class="ff-in ff-sel" x-model="f.connType">
                        <option value="">Select type…</option>
                        <option>Fiber</option>
                        <option>ADSL</option>
                        <option>Cable</option>
                        <option>Wireless</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-lbl">Client Type</label>
                    <select class="ff-in ff-sel" x-model="f.clientType">
                        <option value="">Select type…</option>
                        <option>Residential</option>
                        <option>Corporate</option>
                        <option>Student</option>
                        <option>Government</option>
                    </select>
                </div>
            </div>

        </div>
    </div>

    <!-- ─────────────────────────────────────
         BASIC INFORMATION
    ──────────────────────────────────────── -->
    <div class="fsec" id="sec-basic">
        <div class="fsec-head sh-1">
            <div class="fsec-icon"><i class="fa fa-user"></i></div>
            <span class="fsec-title">Basic Information</span>
            <span class="fsec-tag ftag-req">Required</span>
        </div>
        <div class="fsec-body">

            <div class="g4">
                <div class="ff">
                    <label class="ff-lbl">Client Name <span class="req">*</span></label>
                    <input class="ff-in" type="text" placeholder="Full legal name" x-model="f.clientName">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Occupation</label>
                    <input class="ff-in" type="text" placeholder="e.g. Engineer" x-model="f.occupation">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Company Name</label>
                    <input class="ff-in" type="text" placeholder="Employer / Company" x-model="f.company">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Designation</label>
                    <input class="ff-in" type="text" placeholder="Job title" x-model="f.designation">
                </div>
            </div>

            <div class="g4">
                <div class="ff">
                    <label class="ff-lbl">Date of Birth</label>
                    <input class="ff-in" type="date" x-model="f.dob">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Father Name <span class="req">*</span></label>
                    <input class="ff-in" type="text" placeholder="Father's full name" x-model="f.fatherName">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Mother Name <span class="req">*</span></label>
                    <input class="ff-in" type="text" placeholder="Mother's full name" x-model="f.motherName">
                </div>
                <div class="ff">
                    <label class="ff-lbl">National ID <span class="req">*</span></label>
                    <input class="ff-in" type="text" placeholder="NID number" x-model="f.nid">
                </div>
            </div>

            <div class="g4">
                <div class="ff">
                    <label class="ff-lbl">Passport No</label>
                    <input class="ff-in" type="text" placeholder="Passport number" x-model="f.passport">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Contact No. <span class="req">*</span></label>
                    <input class="ff-in" type="tel" placeholder="01XXXXXXXXX" x-model="f.contact">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Other Contact</label>
                    <input class="ff-in" type="tel" placeholder="Alternate number" x-model="f.otherContact">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Email</label>
                    <input class="ff-in" type="email" placeholder="client@example.com" x-model="f.email">
                </div>
            </div>

        </div>
    </div>

    <!-- ─────────────────────────────────────
         ADDRESS
    ──────────────────────────────────────── -->
    <div class="fsec" id="sec-address">
        <div class="fsec-head sh-2">
            <div class="fsec-icon"><i class="fa fa-map-marker-alt"></i></div>
            <span class="fsec-title">Address</span>
            <span class="fsec-tag ftag-req">Required</span>
        </div>
        <div class="fsec-body">

            <div class="g4">
                <div class="ff">
                    <label class="ff-lbl">Division <span class="req">*</span></label>
                    <select class="ff-in ff-sel" x-model="f.division">
                        <option value="">Select division…</option>
                        <option>Dhaka</option>
                        <option>Chittagong</option>
                        <option>Rajshahi</option>
                        <option>Khulna</option>
                        <option>Sylhet</option>
                        <option>Barisal</option>
                        <option>Rangpur</option>
                        <option>Mymensingh</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-lbl">District <span class="req">*</span></label>
                    <select class="ff-in ff-sel" x-model="f.district">
                        <option value="">Select district…</option>
                        <option>Dhaka</option>
                        <option>Gazipur</option>
                        <option>Narayanganj</option>
                        <option>Chittagong</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-lbl">Upazila <span class="req">*</span></label>
                    <div class="ff-grp">
                        <select class="ff-in ff-sel" x-model="f.upazila">
                            <option value="">Select…</option>
                            <option>Dhanmondi</option>
                            <option>Gulshan</option>
                            <option>Mohammadpur</option>
                            <option>Mirpur</option>
                        </select>
                        <button class="ff-add" type="button" title="Add Upazila"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="ff">
                    <label class="ff-lbl">Thana <span class="req">*</span></label>
                    <div class="ff-grp">
                        <select class="ff-in ff-sel" x-model="f.thana">
                            <option value="">Select…</option>
                            <option>Dhanmondi</option>
                            <option>New Market</option>
                            <option>Hazaribagh</option>
                            <option>Lalbagh</option>
                        </select>
                        <button class="ff-add" type="button" title="Add Thana"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
            </div>

            <div class="g4">
                <div class="ff">
                    <label class="ff-lbl">Area / Union Parishad</label>
                    <select class="ff-in ff-sel" x-model="f.area">
                        <option value="">Select area…</option>
                        <option>Bashundhara</option>
                        <option>Banani</option>
                        <option>Baridhara</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-lbl">Block / Sector / Post Office</label>
                    <input class="ff-in" type="text" placeholder="Block A, Sector 3…" x-model="f.block">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Road Name / Village</label>
                    <input class="ff-in" type="text" placeholder="Road or village name" x-model="f.roadName">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Road No / Ward No</label>
                    <input class="ff-in" type="text" placeholder="e.g. Road 12, Ward 5" x-model="f.roadNo">
                </div>
            </div>

            <div class="g4">
                <div class="ff">
                    <label class="ff-lbl">Building Name</label>
                    <input class="ff-in" type="text" placeholder="Building name" x-model="f.buildingName">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Building No</label>
                    <input class="ff-in" type="text" placeholder="e.g. 12" x-model="f.buildingNo">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Flat / Level No</label>
                    <input class="ff-in" type="text" placeholder="e.g. 3B" x-model="f.flatNo">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Box</label>
                    <input class="ff-in" type="text" placeholder="Box number" x-model="f.box">
                </div>
            </div>

            <div class="g2">
                <div class="ff">
                    <label class="ff-lbl">Latitude</label>
                    <input class="ff-in" type="text" placeholder="e.g. 23.8103" x-model="f.lat">
                    <span class="ff-hint"><i class="fa fa-crosshairs" style="font-size:10px"></i> GPS decimal degrees</span>
                </div>
                <div class="ff">
                    <label class="ff-lbl">Longitude</label>
                    <input class="ff-in" type="text" placeholder="e.g. 90.4125" x-model="f.lng">
                    <span class="ff-hint"><i class="fa fa-crosshairs" style="font-size:10px"></i> GPS decimal degrees</span>
                </div>
            </div>

        </div>
    </div>

    <!-- ─────────────────────────────────────
         BUILDING OWNER CONTACT
    ──────────────────────────────────────── -->
    <div class="fsec" id="sec-building">
        <div class="fsec-head sh-3">
            <div class="fsec-icon"><i class="fa fa-building"></i></div>
            <span class="fsec-title">Building Owner Contact</span>
            <span class="fsec-tag ftag-opt">Optional</span>
        </div>
        <div class="fsec-body">
            <div class="g2">
                <div class="ff">
                    <label class="ff-lbl">House Owner Name</label>
                    <input class="ff-in" type="text" placeholder="Owner's full name" x-model="f.ownerName">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Owner Contact</label>
                    <input class="ff-in" type="tel" placeholder="01XXXXXXXXX" x-model="f.ownerContact">
                </div>
            </div>
        </div>
    </div>

    <!-- ─────────────────────────────────────
         CONNECTION INFORMATION
    ──────────────────────────────────────── -->
    <div class="fsec" id="sec-connection">
        <div class="fsec-head sh-4">
            <div class="fsec-icon"><i class="fa fa-plug"></i></div>
            <span class="fsec-title">Connection Information</span>
            <span class="fsec-tag ftag-opt">Optional</span>
        </div>
        <div class="fsec-body">

            <p class="sub-label">Cable Run</p>

            <div class="g6">
                <div class="ff">
                    <label class="ff-lbl">Cable Type</label>
                    <select class="ff-in ff-sel" x-model="f.cableType">
                        <option value="">Select…</option>
                        <option>CAT-5</option>
                        <option>CAT-5E</option>
                        <option>CAT-6</option>
                        <option>Fiber</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-lbl">From (Start)</label>
                    <input class="ff-in" type="number" placeholder="0" x-model="f.cableFrom" min="0" @input="calcCable()">
                </div>
                <div class="ff">
                    <label class="ff-lbl">To (End)</label>
                    <input class="ff-in" type="number" placeholder="0" x-model="f.cableTo" min="0" @input="calcCable()">
                </div>
                <div class="ff">
                    <label class="ff-lbl">From 2nd</label>
                    <input class="ff-in" type="number" placeholder="0" x-model="f.cableFrom2" min="0" @input="calcCable()">
                </div>
                <div class="ff">
                    <label class="ff-lbl">To 2nd</label>
                    <input class="ff-in" type="number" placeholder="0" x-model="f.cableTo2" min="0" @input="calcCable()">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Total Cable (m)</label>
                    <input class="ff-in" type="number" :value="totalCable" readonly>
                    <span class="ff-hint">Auto-calculated</span>
                </div>
            </div>

            <p class="sub-label">Cable Details</p>

            <div class="g4">
                <div class="ff">
                    <label class="ff-lbl">Cable ID</label>
                    <input class="ff-in" type="text" placeholder="Cable ID" x-model="f.cableId">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Cable (CAT-5/CAT-6)</label>
                    <select class="ff-in ff-sel" x-model="f.cableCat">
                        <option value="">Select…</option>
                        <option>CAT-5</option>
                        <option>CAT-5E</option>
                        <option>CAT-6</option>
                        <option>CAT-6A</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-lbl">Cable (CAT-5/CAT-6) Meter</label>
                    <input class="ff-in" type="number" placeholder="0" x-model="f.cableMeter" min="0">
                </div>
                <div class="ff">
                    <label class="ff-lbl">Customer OTC</label>
                    <input class="ff-in" type="number" placeholder="0" x-model="f.otc" min="0">
                    <span class="ff-hint">One-time charge (BDT)</span>
                </div>
            </div>

            <p class="sub-label">Remote Access</p>

            <div class="g4">
                <div class="ff">
                    <label class="ff-lbl">Remote Access</label>
                    <select class="ff-in ff-sel" x-model="f.remoteAccess">
                        <option value="no">No</option>
                        <option value="yes">Yes</option>
                    </select>
                </div>
                <div class="ff" x-show="f.remoteAccess === 'yes'" x-transition.opacity>
                    <label class="ff-lbl">Remote Username</label>
                    <input class="ff-in" type="text" placeholder="Username" x-model="f.remoteUser">
                </div>
                <div class="ff" x-show="f.remoteAccess === 'yes'" x-transition.opacity>
                    <label class="ff-lbl">Remote Password</label>
                    <input class="ff-in" type="text" placeholder="Password" x-model="f.remotePass">
                </div>
                <div class="ff" x-show="f.remoteAccess === 'yes'" x-transition.opacity>
                    <label class="ff-lbl">Remote Port</label>
                    <input class="ff-in" type="text" placeholder="e.g. 22" x-model="f.remotePort">
                </div>
            </div>

        </div>
    </div>

    <!-- ─────────────────────────────────────
         REMARKS
    ──────────────────────────────────────── -->
    <div class="fsec" id="sec-remarks">
        <div class="fsec-head sh-5">
            <div class="fsec-icon"><i class="fa fa-comment-alt"></i></div>
            <span class="fsec-title">Remarks</span>
            <span class="fsec-tag ftag-opt">Optional</span>
        </div>
        <div class="fsec-body">
            <div class="ff">
                <label class="ff-lbl">Notes / Remarks</label>
                <textarea class="ff-ta" rows="4"
                          placeholder="Any additional notes about this customer…"
                          x-model="f.remarks" maxlength="1000"></textarea>
                <span class="ff-hint" x-text="f.remarks.length + ' / 1000 characters'"></span>
            </div>
        </div>
    </div>

</div><!-- /.page -->


<!-- ══════════ STICKY ACTION BAR ══════════ -->
<div class="abar">
    <div class="abar-progress">
        <span class="abar-info" x-text="filledCount + ' of ' + totalFields + ' fields filled'"></span>
        <div class="pbar">
            <div class="pbar-fill" :style="'width:' + progressPct + '%'"></div>
        </div>
        <span class="abar-pct" x-text="progressPct + '%'"></span>
    </div>
    <div class="abar-actions">
        <a href="/" class="btn btn-ghost"><i class="fa fa-times"></i> Cancel</a>
        <button class="btn btn-save" :class="{'is-loading': loading}" @click="submit()">
            <div class="loading-spin"></div>
            <span class="btn-txt"><i class="fa fa-save"></i> Save Customer</span>
        </button>
    </div>
</div>

<!-- ══════════ TOASTS ══════════ -->
<div class="toast-wrap">
    <template x-for="t in toasts" :key="t.id">
        <div class="toast" :class="'toast-' + t.type">
            <i :class="t.type === 'success' ? 'fa fa-check-circle' : t.type === 'error' ? 'fa fa-times-circle' : 'fa fa-info-circle'"></i>
            <span x-text="t.msg"></span>
        </div>
    </template>
</div>


<script>
function addCustomer() {
    return {
        loading: false,
        toasts:  [],
        activeSection: 0,
        totalCable: 0,

        sectionDone: [false, false, false, false, false, false],

        f: {
            /* Service */
            pppoeUser: '', pppoePass: '', popZone: '', billingCycle: '',
            package: '', staticIp: false, staticIpv6: '', enableMac: '',
            distPoint: '', connType: '', clientType: '',
            /* Basic */
            clientName: '', occupation: '', company: '', designation: '',
            dob: '', fatherName: '', motherName: '', nid: '',
            passport: '', contact: '', otherContact: '', email: '',
            /* Address */
            division: '', district: '', upazila: '', thana: '',
            area: '', block: '', roadName: '', roadNo: '',
            buildingName: '', buildingNo: '', flatNo: '', box: '',
            lat: '', lng: '',
            /* Building owner */
            ownerName: '', ownerContact: '',
            /* Connection */
            cableType: '', cableFrom: '', cableTo: '', cableFrom2: '', cableTo2: '',
            cableId: '', cableCat: '', cableMeter: '', otc: '',
            remoteAccess: 'no', remoteUser: '', remotePass: '', remotePort: '',
            /* Remarks */
            remarks: '',
        },

        get totalFields() {
            return Object.keys(this.f).filter(k => k !== 'staticIp' && k !== 'remoteAccess').length;
        },

        get filledCount() {
            return Object.entries(this.f).filter(([k, v]) => {
                if (k === 'staticIp' || k === 'remoteAccess') return false;
                return v !== '' && v !== null && v !== undefined;
            }).length;
        },

        get progressPct() {
            return Math.round((this.filledCount / this.totalFields) * 100);
        },

        calcCable() {
            const a = Math.max(0, (parseInt(this.f.cableTo)    || 0) - (parseInt(this.f.cableFrom)  || 0));
            const b = Math.max(0, (parseInt(this.f.cableTo2)   || 0) - (parseInt(this.f.cableFrom2) || 0));
            this.totalCable = a + b;
        },

        toast(msg, type = 'info', ms = 3200) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, msg, type });
            setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, ms);
        },

        validate() {
            const checks = [
                [this.f.pppoeUser,     'PPPoE Username',  'sec-service'],
                [this.f.pppoePass,     'PPPoE Password',  'sec-service'],
                [this.f.popZone,       'Pop/Zone Name',   'sec-service'],
                [this.f.billingCycle,  'Billing Cycle',   'sec-service'],
                [this.f.package,       'Package Name',    'sec-service'],
                [this.f.clientName,    'Client Name',     'sec-basic'],
                [this.f.fatherName,    'Father Name',     'sec-basic'],
                [this.f.motherName,    'Mother Name',     'sec-basic'],
                [this.f.nid,           'National ID',     'sec-basic'],
                [this.f.contact,       'Contact Number',  'sec-basic'],
                [this.f.division,      'Division',        'sec-address'],
                [this.f.district,      'District',        'sec-address'],
                [this.f.upazila,       'Upazila',         'sec-address'],
                [this.f.thana,         'Thana',           'sec-address'],
            ];
            for (const [val, label, secId] of checks) {
                if (!val || !val.toString().trim()) {
                    this.toast(`${label} is required`, 'error');
                    document.getElementById(secId)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    return false;
                }
            }
            return true;
        },

        async submit() {
            if (!this.validate()) return;
            this.loading = true;
            try {
                /* Real API call:
                const res = await fetch('/customers', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ ...this.f, totalCable: this.totalCable }),
                });
                if (!res.ok) throw new Error();
                */
                await new Promise(r => setTimeout(r, 1400));
                this.toast('Customer added successfully!', 'success');
                setTimeout(() => { window.location.href = '/'; }, 1300);
            } catch {
                this.toast('Failed to save. Please try again.', 'error');
            } finally {
                this.loading = false;
            }
        },

        init() {
            const ids     = ['sec-service','sec-basic','sec-address','sec-building','sec-connection','sec-remarks'];
            const navEls  = document.querySelectorAll('.snav-item');

            const obs = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const idx = ids.indexOf(entry.target.id);
                        if (idx >= 0) {
                            this.activeSection = idx;
                            navEls.forEach((el, i) => el.classList.toggle('is-active', i === idx));
                        }
                    }
                });
            }, { rootMargin: '-108px 0px -65% 0px', threshold: 0 });

            ids.forEach(id => {
                const el = document.getElementById(id);
                if (el) obs.observe(el);
            });

            if (navEls.length) navEls[0].classList.add('is-active');
        },
    };
}
</script>
</body>
</html>
