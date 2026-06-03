<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $customer['name'] ?? 'Kamrul Hasan' }} — Customer Profile</title>
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
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: var(--n100);
            color: var(--n800);
            font-size: 15px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── TOP NAV ── */
        .topnav {
            background: var(--primary);
            height: 54px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            position: sticky;
            top: 0;
            z-index: 200;
            box-shadow: 0 2px 8px rgba(15,36,68,.45);
        }
        .topnav-brand {
            font-weight: 800;
            font-size: 16px;
            letter-spacing: -.3px;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .brand-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background: #60A5FA;
        }
        .breadcrumb {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: rgba(255,255,255,.55);
        }
        .breadcrumb a { color: rgba(255,255,255,.7); text-decoration: none; }
        .breadcrumb a:hover { color: #fff; }
        .breadcrumb i { font-size: 9px; }

        /* ── PAGE ── */
        .page { max-width: 1120px; margin: 0 auto; padding: 20px 16px 64px; }

        /* ── HERO CARD ── */
        .hero {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%);
            border-radius: var(--radius-lg);
            padding: 22px 22px 20px;
            color: #fff;
            position: relative;
            overflow: hidden;
            margin-bottom: 14px;
        }
        .hero::before {
            content: '';
            position: absolute; top: -50px; right: -50px;
            width: 220px; height: 220px; border-radius: 50%;
            background: rgba(99,102,241,.18);
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute; bottom: -80px; left: 25%;
            width: 320px; height: 320px; border-radius: 50%;
            background: rgba(255,255,255,.04);
            pointer-events: none;
        }
        .hero-row { display: flex; align-items: flex-start; gap: 16px; position: relative; z-index: 1; }
        .avatar {
            width: 62px; height: 62px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, #3B82F6, #60A5FA);
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; font-weight: 800; color: #fff;
            border: 3px solid rgba(255,255,255,.22);
        }
        .hero-info { flex: 1; }
        .hero-top-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }
        .hero-name { font-size: 22px; font-weight: 800; letter-spacing: -.4px; line-height: 1.2; }
        .status-badge {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 11px; border-radius: 20px;
            font-size: 12px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase;
        }
        .sb-active   { background: rgba(5,150,105,.18);  color: #6EE7B7; border: 1px solid rgba(110,231,183,.25); }
        .sb-expired  { background: rgba(220,38,38,.18);  color: #FCA5A5; border: 1px solid rgba(252,165,165,.25); }
        .sb-deact    { background: rgba(217,119,6,.18);  color: #FCD34D; border: 1px solid rgba(252,211,77,.25); }
        .sb-closed   { background: rgba(100,116,139,.18); color: #CBD5E1; border: 1px solid rgba(203,213,225,.25); }
        .status-dot { width: 7px; height: 7px; border-radius: 50%; background: currentColor; animation: blink 2s infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.35} }
        .hero-meta {
            margin-top: 7px; display: flex; flex-wrap: wrap; gap: 12px;
            font-size: 13px; color: rgba(255,255,255,.6);
        }
        .hero-meta span { display: flex; align-items: center; gap: 5px; }
        .hero-actions { display: flex; gap: 7px; flex-wrap: wrap; margin-top: 16px; position: relative; z-index: 1; }
        .hbtn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 14px; border-radius: 8px; border: none;
            font-size: 13px; font-weight: 500; cursor: pointer;
            transition: all var(--ease); text-decoration: none; font-family: inherit;
        }
        .hbtn-ghost { background: rgba(255,255,255,.1); color: rgba(255,255,255,.9); border: 1px solid rgba(255,255,255,.15); }
        .hbtn-ghost:hover { background: rgba(255,255,255,.2); }
        .hbtn-call { background: rgba(59,130,246,.2); color: #93C5FD; border: 1px solid rgba(147,197,253,.2); }
        .hbtn-call:hover { background: rgba(59,130,246,.35); }
        .hbtn-sms  { background: rgba(34,197,94,.15);  color: #86EFAC; border: 1px solid rgba(134,239,172,.2); }
        .hbtn-sms:hover  { background: rgba(34,197,94,.28); }
        .hbtn-wa   { background: rgba(22,163,74,.18);  color: #4ADE80; border: 1px solid rgba(74,222,128,.2); }
        .hbtn-wa:hover   { background: rgba(22,163,74,.32); }

        /* ── ACTIONS BAR ── */
        .act-bar {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 10px 14px;
            display: flex; flex-wrap: wrap; gap: 7px; justify-content: center;
            margin-bottom: 14px;
            box-shadow: var(--shadow-sm);
        }
        .abtn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 15px; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 500; cursor: pointer;
            transition: all var(--ease); border: none;
            font-family: inherit; white-space: nowrap;
        }
        .abtn i { font-size: 13px; }
        .abtn:hover { transform: translateY(-1px); }
        .abtn-blue   { background: var(--primary-light); color: #fff; }
        .abtn-blue:hover   { background: #1D4ED8; box-shadow: 0 4px 12px rgba(37,99,235,.28); }
        .abtn-green  { background: var(--success); color: #fff; }
        .abtn-green:hover  { background: #047857; box-shadow: 0 4px 12px rgba(5,150,105,.28); }
        .abtn-amber  { background: var(--warning); color: #fff; }
        .abtn-amber:hover  { background: #B45309; }
        .abtn-teal   { background: #0D9488; color: #fff; }
        .abtn-teal:hover   { background: #0F766E; }
        .abtn-purple { background: #7C3AED; color: #fff; }
        .abtn-purple:hover { background: #6D28D9; }
        .abtn-ghost  { background: var(--n100); color: var(--n700); border: 1px solid var(--border); }
        .abtn-ghost:hover  { background: var(--n200); transform: none; }

        /* ── OTHERS DROPDOWN ── */
        .act-dropdown { position: relative; display: inline-flex; }
        .act-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            right: 0;
            min-width: 200px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: 0 8px 24px rgba(0,0,0,.12);
            z-index: 200;
            overflow: hidden;
        }
        .act-dropdown.open .act-dropdown-menu { display: block; }
        .act-dd-item {
            display: flex; align-items: center; gap: 10px;
            width: 100%; padding: 10px 16px;
            background: none; border: none; cursor: pointer;
            font-size: 13.5px; font-weight: 500; color: var(--n700);
            font-family: inherit; text-align: left;
            transition: background var(--ease), color var(--ease);
        }
        .act-dd-item i { width: 16px; text-align: center; color: var(--n400); font-size: 13px; }
        .act-dd-item:hover { background: var(--n50); color: var(--n900); }
        .act-dd-item:hover i { color: var(--primary-light); }
        .act-dd-sep { height: 1px; background: var(--border); margin: 4px 0; }
        .act-dd-item.dd-danger { color: var(--danger); }
        .act-dd-item.dd-danger i { color: var(--danger); }
        .act-dd-item.dd-danger:hover { background: #FEF2F2; }

        /* ── GRID ── */
        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
        }
        @media (min-width: 700px)  { .grid { grid-template-columns: 1fr 1fr; } }
        @media (min-width: 1024px) {
            .grid { grid-template-columns: 5fr 3fr 4fr; }
            .card-span2 { grid-column: 1 / 2; }
        }

        /* ── SECTION CARD ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .card-head {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            background: var(--n50);
            display: flex; align-items: center; gap: 10px;
        }
        .card-icon {
            width: 28px; height: 28px; border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; flex-shrink: 0;
        }
        .ci-blue   { background: var(--accent-light); color: var(--accent); }
        .ci-green  { background: var(--success-light); color: var(--success); }
        .ci-purple { background: #F5F3FF; color: #7C3AED; }
        .card-title { font-size: 13.5px; font-weight: 700; color: var(--n700); letter-spacing: -.1px; }

        /* ── FIELD ROW ── */
        .fr {
            display: flex; align-items: center;
            padding: 9px 16px;
            border-bottom: 1px solid var(--n100);
            gap: 8px;
            transition: background var(--ease);
            min-height: 40px;
        }
        .fr:last-child { border-bottom: none; }
        .fr:hover { background: var(--n50); }
        .fl {
            font-size: 12px; color: var(--n500);
            font-weight: 600; min-width: 112px;
            flex-shrink: 0; text-transform: uppercase; letter-spacing: .3px;
        }
        .fv {
            flex: 1; font-size: 14px; color: var(--n800);
            font-weight: 500; word-break: break-word; min-width: 0;
        }
        .fv-mono { font-family: 'SF Mono','Fira Code',monospace; font-size: 13px; }
        .fa-wrap { display: flex; gap: 3px; flex-shrink: 0; }
        .fb {
            width: 30px; height: 30px; border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; border: none; font-size: 12px;
            transition: all var(--ease); font-family: inherit;
            flex-shrink: 0;
        }
        .fb-blue   { background: var(--accent-light); color: var(--accent); }
        .fb-blue:hover   { background: #DBEAFE; }
        .fb-green  { background: var(--success-light); color: var(--success); }
        .fb-green:hover  { background: #D1FAE5; }
        .fb-red    { background: var(--danger-light); color: var(--danger); }
        .fb-red:hover    { background: #FEE2E2; }
        .fb-purple { background: #F5F3FF; color: #7C3AED; }
        .fb-purple:hover { background: #EDE9FE; }
        .fb-wa     { background: #F0FDF4; color: #16A34A; }
        .fb-wa:hover     { background: #DCFCE7; }
        .fb-amber  { background: var(--warning-light); color: var(--warning); }
        .fb-amber:hover  { background: #FEF3C7; }
        .fb-cyan   { background: #ECFEFF; color: #0891B2; }
        .fb-cyan:hover   { background: #CFFAFE; }
        .copy-btn {
            background: none; border: none; cursor: pointer;
            color: var(--n400); font-size: 10px; padding: 2px 4px;
            border-radius: 3px; transition: color var(--ease);
        }
        .copy-btn:hover { color: var(--accent); }

        /* ── TAGS ── */
        .tag {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 5px; font-size: 12.5px; font-weight: 600;
        }
        .tag-active   { background: #DCFCE7; color: #15803D; }
        .tag-expired  { background: #FEE2E2; color: #B91C1C; }
        .tag-deact    { background: #FEF3C7; color: #92400E; }
        .tag-closed   { background: var(--n100); color: var(--n500); }
        .tag-yes      { background: #DCFCE7; color: #15803D; }
        .tag-no       { background: #FEE2E2; color: #B91C1C; }

        /* ── EXPIRY CHIP ── */
        .exp-chip {
            font-size: 11.5px; padding: 2px 8px; border-radius: 4px;
            margin-left: 6px; font-weight: 600;
        }
        .exp-ok   { background: #DCFCE7; color: #15803D; }
        .exp-soon { background: #FEF3C7; color: #92400E; }
        .exp-over { background: #FEE2E2; color: #B91C1C; }

        /* ── CONNECTION INDICATOR ── */
        .conn-bar {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 16px 8px;
        }
        .conn-dot {
            width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0;
        }
        .conn-dot.online  { background: #10B981; box-shadow: 0 0 0 3px rgba(16,185,129,.2); }
        .conn-dot.offline { background: #EF4444; box-shadow: 0 0 0 3px rgba(239,68,68,.2); }
        .conn-label { font-size: 14px; font-weight: 700; }
        .conn-ip    { font-size: 12.5px; color: var(--n400); font-family: monospace; }
        .sync-btn {
            margin-left: auto;
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 11px; border-radius: 6px;
            background: var(--accent-light); color: var(--accent);
            border: 1px solid rgba(59,130,246,.2);
            font-size: 12.5px; font-weight: 500;
            cursor: pointer; font-family: inherit; transition: all var(--ease);
        }
        .sync-btn:hover { background: #DBEAFE; }
        .sync-btn.syncing i { animation: spin .7s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── BALANCE ── */
        .bal-pos { color: #059669; font-weight: 700; }
        .bal-neg { color: #DC2626; font-weight: 700; }

        /* ── MODALS ── */
        .overlay {
            position: fixed; inset: 0; z-index: 1000;
            background: rgba(15,23,42,.58);
            backdrop-filter: blur(3px);
            display: flex; align-items: flex-end; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity .2s ease;
        }
        .overlay.open { opacity: 1; pointer-events: all; }
        @media (min-width: 600px) {
            .overlay { align-items: center; padding: 24px; }
        }
        .modal {
            background: var(--surface);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            width: 100%; max-width: 460px;
            max-height: 90vh; overflow-y: auto;
            box-shadow: var(--shadow-lg);
            transform: translateY(24px);
            transition: transform .28s cubic-bezier(0.34,1.56,0.64,1);
        }
        .overlay.open .modal { transform: translateY(0); }
        @media (min-width: 600px) { .modal { border-radius: var(--radius-lg); } }
        .modal-wide { max-width: 560px; }
        .mh {
            padding: 16px 18px 12px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; background: var(--surface); z-index: 1;
        }
        .mh-title { font-size: 16px; font-weight: 700; color: var(--n800); display: flex; align-items: center; gap: 8px; }
        .mh-title i { font-size: 15px; }
        .mclose {
            width: 30px; height: 30px; border-radius: 7px; border: none;
            background: var(--n100); color: var(--n500); cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; transition: all var(--ease);
        }
        .mclose:hover { background: var(--danger-light); color: var(--danger); }
        .mbody { padding: 18px; }
        .mfoot {
            padding: 12px 18px; border-top: 1px solid var(--border);
            display: flex; gap: 8px; justify-content: flex-end;
        }

        /* ── FORMS ── */
        .fg { margin-bottom: 15px; }
        .fg:last-child { margin-bottom: 0; }
        .flbl {
            display: block; font-size: 12px; font-weight: 700;
            color: var(--n500); margin-bottom: 5px;
            letter-spacing: .5px; text-transform: uppercase;
        }
        .finput {
            width: 100%; padding: 10px 12px;
            border: 1.5px solid var(--border); border-radius: var(--radius-sm);
            font-size: 14.5px; color: var(--n800);
            background: var(--surface); font-family: inherit;
            outline: none; transition: border-color var(--ease);
        }
        .finput:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(59,130,246,.1); }
        .fselect {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 16px;
            padding-right: 34px;
        }
        .fhint { font-size: 12px; color: var(--n400); margin-top: 4px; }
        .frow { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 10px 18px; border-radius: var(--radius-sm);
            font-size: 14px; font-weight: 500; cursor: pointer;
            transition: all var(--ease); border: none;
            font-family: inherit;
        }
        .btn-sm { padding: 7px 13px; font-size: 13px; }
        .btn-primary { background: var(--primary-light); color: #fff; }
        .btn-primary:hover { background: #1D4ED8; }
        .btn-success { background: var(--success); color: #fff; }
        .btn-success:hover { background: #047857; }
        .btn-danger  { background: var(--danger); color: #fff; }
        .btn-danger:hover  { background: #B91C1C; }
        .btn-outline { background: transparent; color: var(--n600); border: 1.5px solid var(--border); }
        .btn-outline:hover { background: var(--n50); }
        .btn-amber  { background: var(--warning); color: #fff; }
        .btn-amber:hover { background: #B45309; }
        .btn-purple { background: #7C3AED; color: #fff; }
        .btn-purple:hover { background: #6D28D9; }

        /* spinner inside button */
        .loading-spin {
            width: 14px; height: 14px; border: 2px solid rgba(255,255,255,.3);
            border-top-color: #fff; border-radius: 50%;
            animation: spin .55s linear infinite; display: none;
        }
        .is-loading .loading-spin { display: inline-block; }
        .is-loading .btn-txt { opacity: .7; }

        /* ── STATUS SELECTOR ── */
        .status-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .status-opt {
            padding: 16px 10px; border-radius: 10px; cursor: pointer;
            font-weight: 700; font-family: inherit; font-size: 14px;
            display: flex; flex-direction: column; align-items: center; gap: 7px;
            transition: all var(--ease); border: 2px solid var(--border);
            background: var(--n50); color: var(--n600);
        }
        .status-opt i { font-size: 22px; }
        .status-opt:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
        .sopt-active   { border-color: #059669 !important; background: #ECFDF5 !important; color: #065F46 !important; }
        .sopt-active i { color: #059669; }
        .sopt-expired  { border-color: #DC2626 !important; background: #FEF2F2 !important; color: #7F1D1D !important; }
        .sopt-expired i { color: #DC2626; }
        .sopt-deact    { border-color: #D97706 !important; background: #FFFBEB !important; color: #78350F !important; }
        .sopt-deact i  { color: #D97706; }
        .sopt-closed   { border-color: var(--n400) !important; background: var(--n100) !important; color: var(--n600) !important; }
        .sopt-closed i { color: var(--n400); }

        /* ── TABLE ── */
        .mtbl { width: 100%; border-collapse: collapse; font-size: 13.5px; }
        .mtbl thead tr { background: var(--n50); border-bottom: 1px solid var(--border); }
        .mtbl th { padding: 10px 14px; text-align: left; font-size: 11.5px; color: var(--n500); font-weight: 700; text-transform: uppercase; letter-spacing: .4px; }
        .mtbl td { padding: 11px 14px; border-bottom: 1px solid var(--n100); color: var(--n700); }
        .mtbl tbody tr:last-child td { border-bottom: none; }
        .mtbl tbody tr:hover td { background: var(--n50); }

        /* ── TRAFFIC CARD ── */
        .traffic-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px; }
        .traffic-block {
            text-align: center; padding: 16px 10px;
            background: var(--n50); border-radius: 10px;
            border: 1px solid var(--border);
        }
        .traffic-lbl { font-size: 11.5px; color: var(--n500); font-weight: 700; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px; }
        .traffic-val { font-size: 30px; font-weight: 800; line-height: 1; margin-bottom: 2px; }
        .traffic-unit { font-size: 12px; color: var(--n400); font-weight: 500; }
        .tv-down { color: #059669; }
        .tv-up   { color: #2563EB; }

        /* ── TOAST ── */
        .toast-wrap {
            position: fixed; bottom: 18px; right: 18px; z-index: 3000;
            display: flex; flex-direction: column; gap: 7px;
            pointer-events: none;
        }
        .toast {
            padding: 12px 16px; border-radius: var(--radius);
            font-size: 14px; font-weight: 500; color: #fff;
            display: flex; align-items: center; gap: 9px;
            box-shadow: var(--shadow-lg); min-width: 210px;
            animation: slide-in .28s cubic-bezier(0.34,1.56,0.64,1);
            pointer-events: all;
        }
        .toast-success { background: #059669; }
        .toast-error   { background: #DC2626; }
        .toast-info    { background: var(--primary-light); }
        @keyframes slide-in {
            from { opacity: 0; transform: translateX(36px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ── CHOICE PAIR ── */
        .choice-pair { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .choice-opt {
            padding: 20px 12px; border-radius: 10px;
            cursor: pointer; font-weight: 700; font-family: inherit; font-size: 14px;
            display: flex; flex-direction: column; align-items: center; gap: 7px;
            transition: all var(--ease); border: 2px solid var(--border);
            background: var(--n50); color: var(--n700);
        }
        .choice-opt i { font-size: 26px; }
        .choice-opt:hover { transform: translateY(-2px); box-shadow: var(--shadow); }
        .co-yes { border-color: #059669 !important; background: #ECFDF5 !important; color: #065F46 !important; }
        .co-yes i { color: #059669; }
        .co-no  { border-color: #DC2626 !important; background: #FEF2F2 !important; color: #7F1D1D !important; }
        .co-no i  { color: #DC2626; }
        .co-d2d { border-color: #2563EB !important; background: #EFF6FF !important; color: #1E40AF !important; }
        .co-d2d i { color: #2563EB; }
        .co-mo  { border-color: var(--n300) !important; }

        /* ── SESSION / ONU ROW ── */
        .grid-session-onu {
            grid-template-columns: 1fr 1fr;
        }
        @media (max-width: 680px) {
            .grid-session-onu {
                grid-template-columns: 1fr;
            }
        }

        /* ── MOBILE TWEAKS ── */
        @media (max-width: 480px) {
            .hero { padding: 16px; }
            .hero-name { font-size: 19px; }
            .hero-meta { font-size: 12.5px; }
            .hero-actions { gap: 6px; }
            .hbtn { padding: 8px 12px; font-size: 13px; }
            .act-bar { padding: 10px; gap: 6px; }
            .abtn { padding: 10px 13px; font-size: 13.5px; }
            .abtn i { font-size: 12.5px; }
            .fl { min-width: 96px; font-size: 11.5px; }
            .fv { font-size: 13.5px; }
            .fr { min-height: 44px; }
            .fb { width: 34px; height: 34px; font-size: 13px; }
            .card-title { font-size: 13px; }
            .btn { padding: 11px 16px; font-size: 14px; }
            .mh-title { font-size: 15px; }
        }
    </style>
</head>
<body x-data="app()" @keydown.escape.window="closeAll()">



<div class="page">

    <!-- ══════════════════════════════════════════
         HERO  –  Customer identity & contact strip
    ═══════════════════════════════════════════ -->
    <div class="hero">
        <div class="hero-row">
            <div class="avatar">K</div>
            <div class="hero-info">
                <div class="hero-top-row">
                    <h1 class="hero-name">Kamrul Hasan</h1>
                    <span class="status-badge sb-active">
                        <span class="status-dot"></span> Active
                    </span>
                </div>
                <div class="hero-meta">
                    <span><i class="fa fa-user" style="font-size:10px"></i> Kamrul</span>
                    <span><i class="fa fa-wifi" style="font-size:10px"></i>Package - Basic</span>
                    <span><i class="fa fa-building" style="font-size:10px"></i> Pop - Nilkhet</span>
                    <span><i class="fa fa-calendar" style="font-size:10px"></i> Exp. Date - 12 Sep 2026</span>
                    <span><i class="fa fa-user-tie" style="font-size:10px"></i> Reseller - Local</span>
                </div>
            </div>
        </div>
        <div class="hero-actions">
            <a href="tel:01681046437" class="hbtn hbtn-call"><i class="fa fa-phone"></i> Call</a>
            <button class="hbtn hbtn-sms" @click="open('sms')"><i class="fa fa-sms"></i> SMS</button>
            <a href="https://wa.me/8801681046437" target="_blank" class="hbtn hbtn-wa"><i class="fab fa-whatsapp"></i> WhatsApp</a>
            <a href="https://maps.google.com/?q=Bashundhara,Sector+A,Dhaka" target="_blank" class="hbtn hbtn-ghost">
                <i class="fa fa-map-marker-alt"></i> View on Map
            </a>
            <button class="hbtn hbtn-ghost" @click="open('payment')">
                <i class="fa fa-credit-card"></i> Pay Now
            </button>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
         QUICK ACTIONS BAR
    ═══════════════════════════════════════════ -->
    <div class="act-bar">
        <button class="abtn abtn-amber"  @click="open('editCustomer')"><i class="fa fa-edit"></i>           Edit</button>
        <button class="abtn abtn-blue"   @click="open('ticket')">   <i class="fa fa-ticket-alt"></i>     Create Ticket</button>
        <button class="abtn abtn-green"  @click="open('payment')">  <i class="fa fa-money-bill-wave"></i> Payment</button>
        <button class="abtn abtn-ghost"  @click="dlInvoice()">      <i class="fa fa-file-invoice"></i>   Invoice PDF</button>
        <button class="abtn abtn-teal"   @click="open('traffic')">  <i class="fa fa-chart-line"></i>     Live Traffic</button>
        <button class="abtn abtn-ghost"  @click="open('history')">  <i class="fa fa-history"></i>        Pay History</button>
       
        <button class="abtn abtn-purple" @click="open('sms')">        <i class="fa fa-envelope"></i>       Send SMS</button>

        <!-- Others dropdown -->
        <div class="act-dropdown" x-data="{ddOpen:false}" :class="{open:ddOpen}" @click.outside="ddOpen=false">
            <button class="abtn abtn-ghost" @click="ddOpen=!ddOpen">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="flex-shrink:0">
                    <rect x="0.5" y="0.5" width="6.5" height="6.5" rx="1.5" fill="currentColor"/>
                    <rect x="9"   y="0.5" width="6.5" height="6.5" rx="1.5" fill="currentColor"/>
                    <rect x="0.5" y="9"   width="6.5" height="6.5" rx="1.5" fill="currentColor"/>
                    <rect x="9"   y="9"   width="6.5" height="6.5" rx="1"   transform="rotate(45 12.25 12.25)" fill="#0D9488"/>
                </svg>
                Others
                <i class="fa fa-chevron-down" style="font-size:11px; margin-left:2px; transition:transform .2s" :style="ddOpen?'transform:rotate(180deg)':''"></i>
            </button>
            <div class="act-dropdown-menu">
                <button class="act-dd-item" @click="cp(window.location.href); ddOpen=false">
                    <i class="fa fa-link"></i> Copy Payment URL
                </button>
                <button class="act-dd-item" @click="toast('Opening QR print…','info'); ddOpen=false">
                    <i class="fa fa-qrcode"></i> Print QR Code
                </button>
                <div class="act-dd-sep"></div>
                <button class="act-dd-item" @click="open('editCustomer'); ddOpen=false">
                    <i class="fa fa-edit"></i> Edit
                </button>
                <button class="act-dd-item" @click="open('editBillingType'); ddOpen=false">
                    <i class="fa fa-sync-alt"></i> Bill Cycle Change
                </button>
                <button class="act-dd-item" @click="open('editExpiry'); ddOpen=false">
                    <i class="fa fa-calendar-plus"></i> Expire Date Extend
                </button>
                <button class="act-dd-item" @click="open('editExtended'); ddOpen=false">
                    <i class="fa fa-clock"></i> Auto Deactive Date
                </button>
                <button class="act-dd-item" @click="open('editPackage'); ddOpen=false">
                    <i class="fa fa-cube"></i> Package Change
                </button>
                <div class="act-dd-sep"></div>
                <button class="act-dd-item dd-danger" @click="toast('Customer disabled','error'); ddOpen=false">
                    <i class="fa fa-ban"></i> Disable
                </button>
                <button class="act-dd-item dd-danger" @click="setStatus('Deactivated'); ddOpen=false">
                    <i class="fa fa-times-circle"></i> Deactive
                </button>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════
         THREE-COLUMN INFO GRID
    ═══════════════════════════════════════════ -->
    <div class="grid">

        <!-- ─────────────────────────────────────
             CARD 1 · CUSTOMER INFORMATION
        ──────────────────────────────────────── -->
        <div class="card">
            <div class="card-head">
                <div class="card-icon ci-blue"><i class="fa fa-user-circle"></i></div>
                <span class="card-title">Customer Information</span>
            </div>

            <!-- Username -->
            <div class="fr">
                <span class="fl">Username</span>
                <span class="fv fv-mono">Kamrul
                    <button class="copy-btn" @click="cp('Kamrul')" title="Copy"><i class="fa fa-copy"></i></button>
                </span>
            </div>

            <!-- Password -->
            <div class="fr" x-data="{show:false}">
                <span class="fl">Password</span>
                <span class="fv fv-mono">
                    <span x-text="show ? '12345' : '•••••'"></span>
                    <button class="copy-btn" @click="show=!show" :title="show?'Hide':'Show'">
                        <i :class="show ? 'fa fa-eye-slash' : 'fa fa-eye'"></i>
                    </button>
                    <button class="copy-btn" @click="cp('12345')" title="Copy"><i class="fa fa-copy"></i></button>
                </span>
            </div>

            <!-- Contact -->
            <div class="fr">
                <span class="fl">Contact</span>
                <span class="fv">01681046437</span>
                <div class="fa-wrap">
                    <button class="fb fb-blue"   @click="open('editContact')" title="Change"><i class="fa fa-pen"></i></button>
                    <button class="fb fb-cyan"   @click="open('sms')"         title="SMS"><i class="fa fa-sms"></i></button>
                    <a      class="fb fb-wa"     href="https://wa.me/8801681046437" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a      class="fb fb-green"  href="tel:01681046437"       title="Call"><i class="fa fa-phone"></i></a>
                </div>
            </div>

            <!-- Address -->
            <div class="fr">
                <span class="fl">Address</span>
                <span class="fv" style="font-size:12.5px">Flat#3, Road#12, Bashundhara, Sector#A</span>
                <div class="fa-wrap">
                    <a class="fb fb-cyan" href="https://maps.google.com/?q=Bashundhara,Sector+A,Dhaka" target="_blank" title="Map"><i class="fa fa-map-marker-alt"></i></a>
                </div>
            </div>

            <!-- Reseller -->
            <div class="fr">
                <span class="fl">Reseller</span>
                <span class="fv">Local</span>
            </div>

            <!-- POP -->
            <div class="fr">
                <span class="fl">POP Name</span>
                <span class="fv">Nilkhet</span>
                <div class="fa-wrap">
                    <button class="fb fb-purple" @click="open('editPop')" title="Change POP"><i class="fa fa-exchange-alt"></i></button>
                </div>
            </div>

            <!-- Billing Date -->
            <div class="fr">
                <span class="fl">Billing Date</span>
                <span class="fv">12<sup>th</sup> of month</span>
            </div>

            <!-- Balance -->
            <div class="fr">
                <span class="fl">Balance</span>
                <span class="fv"><span class="bal-pos">+500 BDT</span> <span style="font-size:11px;color:var(--n400);font-weight:400">(Advance)</span></span>
                <div class="fa-wrap">
                    <button class="fb fb-green" @click="open('payment')" title="Add Payment"><i class="fa fa-plus"></i></button>
                    <button class="fb fb-amber" @click="open('addbill')" title="Add Bill"><i class="fa fa-receipt"></i></button>
                </div>
            </div>

            <!-- Package -->
            <div class="fr">
                <span class="fl">Package</span>
                <span class="fv">Basic Package</span>
                <div class="fa-wrap">
                    <button class="fb fb-purple" @click="open('editPackage')" title="Change Package"><i class="fa fa-cube"></i></button>
                </div>
            </div>

            <!-- Expiry Date -->
            <div class="fr">
                <span class="fl">Expiry Date</span>
                <span class="fv">
                    2026-09-12
                    <span class="exp-chip exp-ok">99d left</span>
                </span>
                <div class="fa-wrap">
                    <button class="fb fb-blue" @click="open('editExpiry')" title="Change"><i class="fa fa-calendar-alt"></i></button>
                </div>
            </div>

            <!-- Extended Date -->
            <div class="fr">
                <span class="fl">Extended</span>
                <span class="fv">18-Oct-2024</span>
                <div class="fa-wrap">
                    <button class="fb fb-blue" @click="open('editExtended')" title="Change"><i class="fa fa-calendar-plus"></i></button>
                </div>
            </div>

            <!-- Account Status -->
            <div class="fr">
                <span class="fl">Status</span>
                <span class="fv"><span class="tag tag-active">Active</span></span>
                <div class="fa-wrap">
                    <button class="fb fb-amber" @click="open('editStatus')" title="Change Status"><i class="fa fa-toggle-on"></i></button>
                </div>
            </div>
        </div>

        <!-- ─────────────────────────────────────
             CARD 2 · CONNECTION STATUS
        ──────────────────────────────────────── -->
        <div class="card">
            <div class="card-head">
                <div class="card-icon ci-green"><i class="fa fa-satellite-dish"></i></div>
                <span class="card-title">Connection Status</span>
                <button class="sync-btn" :class="{syncing: syncing}" @click="syncMikrotik()">
                    <i class="fa fa-sync-alt"></i>
                    <span x-text="syncing ? 'Syncing…' : 'Sync Mikrotik'"></span>
                </button>
            </div>

            <div class="conn-bar">
                <div class="conn-dot online"></div>
                <span class="conn-label">Online</span>
                <span class="conn-ip">172.0.0.1</span>
            </div>

            <div class="fr">
                <span class="fl">Perm. Discount</span>
                <span class="fv">50 BDT</span>
                <div class="fa-wrap">
                    <button class="fb fb-blue" @click="open('editDiscount')" title="Change"><i class="fa fa-pen"></i></button>
                </div>
            </div>

            <div class="fr">
                <span class="fl">Free Client</span>
                <span class="fv"><span class="tag tag-no">No</span></span>
                <div class="fa-wrap">
                    <button class="fb fb-amber" @click="open('editFreeClient')" title="Change"><i class="fa fa-pen"></i></button>
                </div>
            </div>

            <div class="fr">
                <span class="fl">Billing Type</span>
                <span class="fv">Date2Date</span>
                <div class="fa-wrap">
                    <button class="fb fb-blue" @click="open('editBillingType')" title="Change"><i class="fa fa-pen"></i></button>
                </div>
            </div>
        </div>

        <!-- ─────────────────────────────────────
             CARD 3 · OTHER DETAILS
        ──────────────────────────────────────── -->
        <div class="card">
            <div class="card-head">
                <div class="card-icon ci-purple"><i class="fa fa-id-card"></i></div>
                <span class="card-title">Other Details</span>
            </div>

            <div class="fr">
                <span class="fl">NID</span>
                <span class="fv fv-mono">094543434545
                    <button class="copy-btn" @click="cp('094543434545')"><i class="fa fa-copy"></i></button>
                </span>
            </div>
            <div class="fr">
                <span class="fl">Father Name</span>
                <span class="fv">Mr X</span>
            </div>
            <div class="fr">
                <span class="fl">Date of Birth</span>
                <span class="fv">15-Oct-2024</span>
            </div>
            <div class="fr">
                <span class="fl">Remote User</span>
                <span class="fv fv-mono">admin
                    <button class="copy-btn" @click="cp('admin')"><i class="fa fa-copy"></i></button>
                </span>
            </div>
            <div class="fr">
                <span class="fl">Remote Pass</span>
                <span class="fv fv-mono">admin
                    <button class="copy-btn" @click="cp('admin')"><i class="fa fa-copy"></i></button>
                </span>
            </div>
            <div class="fr">
                <span class="fl">Created</span>
                <span class="fv" style="font-size:12px">15-Oct-2024  12:10:36 PM</span>
            </div>
            <div class="fr">
                <span class="fl">Joining Date</span>
                <span class="fv">15-Oct-2024</span>
            </div>
            <div class="fr">
                <span class="fl">Created By</span>
                <span class="fv">Karim</span>
            </div>
            <div class="fr">
                <span class="fl">Marketed By</span>
                <span class="fv">Rahim</span>
            </div>
            <div class="fr">
                <span class="fl">Referenced By</span>
                <span class="fv">Mr Burhan</span>
            </div>
            <div class="fr">
                <span class="fl">OTC Amount</span>
                <span class="fv" style="font-weight:700; color:var(--n700);">1,000 BDT</span>
            </div>
        </div>

    </div><!-- /.grid -->

    <!-- ══════════════════════════════════════════
         SESSION DETAILS & ONU INFORMATION ROW
    ═══════════════════════════════════════════ -->
    <div class="grid grid-session-onu" style="margin-top:14px;">

        <!-- ─────────────────────────────────────
             SESSION DETAILS
        ──────────────────────────────────────── -->
        <div class="card">
            <div class="card-head">
                <div class="card-icon ci-blue"><i class="fa fa-network-wired"></i></div>
                <span class="card-title">Session Details</span>
            </div>

            <!-- Last Link Up Time -->
            <div class="fr" style="border-left: 3px solid var(--accent); padding-left: 13px;">
                <span class="fl" style="display:flex;align-items:center;gap:5px;">
                    <i class="fa fa-clock" style="color:var(--accent);font-size:11px;"></i> Last Link Up
                </span>
                <span class="fv fv-mono" style="font-size:12.5px;">03/Jun/2026 09:45:16 PM</span>
            </div>

            <!-- Last Logout Time -->
            <div class="fr" style="border-left: 3px solid var(--danger); padding-left: 13px;">
                <span class="fl" style="display:flex;align-items:center;gap:5px;">
                    <i class="fa fa-sign-out-alt" style="color:var(--danger);font-size:11px;"></i> Last Logout
                </span>
                <span class="fv fv-mono" style="font-size:12.5px;">03/Jun/2026 09:44:21 PM</span>
            </div>

            <!-- Client MAC Address -->
            <div class="fr" style="border-left: 3px solid #7C3AED; padding-left: 13px;">
                <span class="fl" style="display:flex;align-items:center;gap:5px;">
                    <i class="fa fa-fingerprint" style="color:#7C3AED;font-size:11px;"></i> Client MAC
                </span>
                <span class="fv fv-mono">5C:62:8B:07:D7:6B
                    <button class="copy-btn" @click="cp('5C:62:8B:07:D7:6B')" title="Copy"><i class="fa fa-copy"></i></button>
                </span>
            </div>

            <!-- Vendor Name -->
            <div class="fr" style="border-left: 3px solid var(--success); padding-left: 13px;">
                <span class="fl" style="display:flex;align-items:center;gap:5px;">
                    <i class="fa fa-store" style="color:var(--success);font-size:11px;"></i> Vendor
                </span>
                <span class="fv">TP-Link Systems Inc</span>
            </div>

            <!-- Download / Upload -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;padding:12px 16px;">
                <div style="background:linear-gradient(135deg,#6366F1,#818CF8);border-radius:10px;padding:14px 10px;text-align:center;color:#fff;">
                    <div style="font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;opacity:.85;margin-bottom:6px;">
                        <i class="fa fa-download" style="margin-right:4px;"></i> Download
                    </div>
                    <div style="font-size:26px;font-weight:800;line-height:1;">0.00 <span style="font-size:12px;font-weight:500;opacity:.8;">GB</span></div>
                </div>
                <div style="background:linear-gradient(135deg,#EC4899,#F87171);border-radius:10px;padding:14px 10px;text-align:center;color:#fff;">
                    <div style="font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;opacity:.85;margin-bottom:6px;">
                        <i class="fa fa-upload" style="margin-right:4px;"></i> Upload
                    </div>
                    <div style="font-size:26px;font-weight:800;line-height:1;">0.00 <span style="font-size:12px;font-weight:500;opacity:.8;">GB</span></div>
                </div>
            </div>
        </div>

        <!-- ─────────────────────────────────────
             ONU INFORMATION
        ──────────────────────────────────────── -->
        <div class="card">
            <div class="card-head">
                <div class="card-icon" style="background:#FFF7ED;color:#EA580C;"><i class="fa fa-broadcast-tower"></i></div>
                <span class="card-title">ONU Information</span>
                <button class="sync-btn" style="margin-left:auto;" title="Refresh ONU">
                    <i class="fa fa-sync-alt"></i> Refresh
                </button>
            </div>

            <div class="fr">
                <span class="fl">OLT</span>
                <span class="fv fv-mono" style="font-size:12.5px;">103.189.158.8 — "Switch"</span>
            </div>

            <div class="fr">
                <span class="fl">ONU Id</span>
                <span class="fv fv-mono">109</span>
            </div>

            <div class="fr">
                <span class="fl">Power (Laser)</span>
                <span class="fv" style="display:flex;align-items:center;gap:8px;">
                    <span style="font-weight:800;font-size:15px;color:var(--success);">-19</span>
                    <button class="fb fb-blue" title="Refresh laser power"><i class="fa fa-sync-alt"></i></button>
                </span>
            </div>

            <div class="fr">
                <span class="fl">Last Update</span>
                <span class="fv fv-mono" style="font-size:12.5px;">04-06-2026 12:20 AM</span>
            </div>

            <div class="fr">
                <span class="fl">PON ID, Vlan</span>
                <span class="fv fv-mono">EPON0/1:24, 221</span>
            </div>

            <div class="fr">
                <span class="fl">Device MAC</span>
                <span class="fv fv-mono">5C::6:2::8B::0:7::D7::6:B
                    <button class="copy-btn" @click="cp('5C::6:2::8B::0:7::D7::6:B')" title="Copy"><i class="fa fa-copy"></i></button>
                </span>
            </div>
        </div>

    </div><!-- /.session-onu-row -->

</div><!-- /.page -->


<!-- ════════════════════════════════════════════
     MODALS
════════════════════════════════════════════ -->

<!-- ── EDIT CUSTOMER ── -->
<div class="overlay" :class="{open: m.editCustomer}" @click.self="close('editCustomer')">
    <div class="modal modal-wide">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-edit" style="color:#D97706"></i> Edit Customer</span>
            <button class="mclose" @click="close('editCustomer')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="frow">
                <div class="fg">
                    <label class="flbl">Full Name</label>
                    <input type="text" class="finput" placeholder="Customer full name" x-model="f.editCustomer.name">
                </div>
                <div class="fg">
                    <label class="flbl">Username</label>
                    <input type="text" class="finput" placeholder="Login username" x-model="f.editCustomer.username">
                </div>
            </div>
            <div class="frow">
                <div class="fg">
                    <label class="flbl">Password</label>
                    <input type="text" class="finput" placeholder="Password" x-model="f.editCustomer.password">
                </div>
                <div class="fg">
                    <label class="flbl">Contact / Phone</label>
                    <input type="tel" class="finput" placeholder="e.g. 01XXXXXXXXX" x-model="f.editCustomer.contact">
                </div>
            </div>
            <div class="fg">
                <label class="flbl">Address</label>
                <input type="text" class="finput" placeholder="Full address" x-model="f.editCustomer.address">
            </div>
            <div class="frow">
                <div class="fg">
                    <label class="flbl">Package</label>
                    <select class="finput fselect" x-model="f.editCustomer.package">
                        <option>Basic Package</option>
                        <option>Standard Package</option>
                        <option>Premium Package</option>
                        <option>Business Package</option>
                    </select>
                </div>
                <div class="fg">
                    <label class="flbl">Reseller</label>
                    <select class="finput fselect" x-model="f.editCustomer.reseller">
                        <option>Local</option>
                        <option>Reseller A</option>
                        <option>Reseller B</option>
                        <option>Direct</option>
                    </select>
                </div>
            </div>
            <div class="frow">
                <div class="fg">
                    <label class="flbl">Billing Date (Day of Month)</label>
                    <select class="finput fselect" x-model="f.editCustomer.billingDate">
                        <template x-for="d in Array.from({length:28}, (_,i)=>(i+1).toString())" :key="d">
                            <option :value="d" x-text="d + (d=='1'||d=='21'?'st':d=='2'||d=='22'?'nd':d=='3'||d=='23'?'rd':'th') + ' of month'"></option>
                        </template>
                    </select>
                </div>
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('editCustomer')">Cancel</button>
            <button class="btn btn-amber" :class="{'is-loading': loading}" @click="submitEditCustomer()">
                <div class="loading-spin"></div>
                <span class="btn-txt"><i class="fa fa-save"></i> Save Changes</span>
            </button>
        </div>
    </div>
</div>

<!-- ── PAYMENT ── -->
<div class="overlay" :class="{open: m.payment}" @click.self="close('payment')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-money-bill-wave" style="color:#059669"></i> Record Payment</span>
            <button class="mclose" @click="close('payment')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="fg">
                <label class="flbl">Amount (BDT)</label>
                <input type="number" class="finput" placeholder="e.g. 700" x-model="f.payment.amount" min="1">
            </div>
            <div class="fg">
                <label class="flbl">Payment Method</label>
                <select class="finput fselect" x-model="f.payment.method">
                    <option value="cash">Cash</option>
                    <option value="bkash">bKash</option>
                    <option value="nagad">Nagad</option>
                    <option value="rocket">Rocket</option>
                    <option value="bank">Bank Transfer</option>
                    <option value="card">Card</option>
                </select>
            </div>
            <div class="fg">
                <label class="flbl">Payment Date</label>
                <input type="date" class="finput" x-model="f.payment.date">
            </div>
            <div class="fg">
                <label class="flbl">Note (Optional)</label>
                <input type="text" class="finput" placeholder="Add a note…" x-model="f.payment.note">
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('payment')">Cancel</button>
            <button class="btn btn-success" :class="{'is-loading': loading}" @click="submitPayment()">
                <div class="loading-spin"></div>
                <span class="btn-txt"><i class="fa fa-check"></i> Confirm</span>
            </button>
        </div>
    </div>
</div>

<!-- ── CREATE TICKET ── -->
<div class="overlay" :class="{open: m.ticket}" @click.self="close('ticket')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-ticket-alt" style="color:#2563EB"></i> Create Support Ticket</span>
            <button class="mclose" @click="close('ticket')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="fg">
                <label class="flbl">Subject</label>
                <input type="text" class="finput" placeholder="Brief issue description" x-model="f.ticket.subject">
            </div>
            <div class="frow">
                <div class="fg">
                    <label class="flbl">Category</label>
                    <select class="finput fselect" x-model="f.ticket.category">
                        <option>Connection Issue</option>
                        <option>Billing Issue</option>
                        <option>Speed Problem</option>
                        <option>Equipment</option>
                        <option>Other</option>
                    </select>
                </div>
                <div class="fg">
                    <label class="flbl">Priority</label>
                    <select class="finput fselect" x-model="f.ticket.priority">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="critical">Critical</option>
                    </select>
                </div>
            </div>
            <div class="fg">
                <label class="flbl">Description</label>
                <textarea class="finput" rows="4" style="resize:vertical" placeholder="Describe the issue in detail…" x-model="f.ticket.description"></textarea>
            </div>
            <div class="fg">
                <label class="flbl">Assign To</label>
                <select class="finput fselect">
                    <option>Auto-assign</option>
                    <option>Karim</option>
                    <option>Rahim</option>
                </select>
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('ticket')">Cancel</button>
            <button class="btn btn-primary" :class="{'is-loading': loading}" @click="submitTicket()">
                <div class="loading-spin"></div>
                <span class="btn-txt"><i class="fa fa-paper-plane"></i> Submit Ticket</span>
            </button>
        </div>
    </div>
</div>

<!-- ── CHANGE PACKAGE ── -->
<div class="overlay" :class="{open: m.editPackage}" @click.self="close('editPackage')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-cube" style="color:#7C3AED"></i> Change Package</span>
            <button class="mclose" @click="close('editPackage')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="fg">
                <label class="flbl">Current Package</label>
                <div class="finput" style="background:var(--n50);color:var(--n500)">Basic Package — 10 Mbps</div>
            </div>
            <div class="fg">
                <label class="flbl">New Package</label>
                <select class="finput fselect">
                    <option>Basic Package — 10 Mbps · 500 BDT</option>
                    <option>Standard Package — 20 Mbps · 700 BDT</option>
                    <option>Premium Package — 50 Mbps · 1,000 BDT</option>
                    <option>Ultra Package — 100 Mbps · 1,500 BDT</option>
                </select>
            </div>
            <div class="fg">
                <label class="flbl">Effective</label>
                <select class="finput fselect">
                    <option>Immediately</option>
                    <option>Next billing cycle</option>
                </select>
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('editPackage')">Cancel</button>
            <button class="btn btn-purple" @click="toast('Package changed!','success'); close('editPackage')"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
</div>

<!-- ── CHANGE STATUS ── -->
<div class="overlay" :class="{open: m.editStatus}" @click.self="close('editStatus')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-toggle-on" style="color:#D97706"></i> Change Account Status</span>
            <button class="mclose" @click="close('editStatus')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="status-grid">
                <button class="status-opt sopt-active"  @click="setStatus('Active')">       <i class="fa fa-check-circle"></i> Active</button>
                <button class="status-opt sopt-expired" @click="setStatus('Expired')">      <i class="fa fa-clock"></i> Expired</button>
                <button class="status-opt sopt-deact"   @click="setStatus('Deactivated')">  <i class="fa fa-ban"></i> Deactivated</button>
                <button class="status-opt sopt-closed"  @click="setStatus('Closed')">       <i class="fa fa-times-circle"></i> Closed</button>
            </div>
        </div>
    </div>
</div>

<!-- ── LIVE TRAFFIC ── -->
<div class="overlay" :class="{open: m.traffic}" @click.self="close('traffic')">
    <div class="modal modal-wide">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-chart-line" style="color:#0D9488"></i> Live Traffic</span>
            <button class="mclose" @click="close('traffic')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="traffic-grid">
                <div class="traffic-block">
                    <div class="traffic-lbl">Download</div>
                    <div class="traffic-val tv-down">3.2</div>
                    <div class="traffic-unit">Mbps</div>
                </div>
                <div class="traffic-block">
                    <div class="traffic-lbl">Upload</div>
                    <div class="traffic-val tv-up">0.8</div>
                    <div class="traffic-unit">Mbps</div>
                </div>
            </div>
            <div style="text-align:center; font-size:12px; color:var(--n400);">
                <i class="fa fa-circle" style="color:#10B981; font-size:8px"></i>
                Live · Updated: <span x-text="now"></span>
            </div>
        </div>
    </div>
</div>

<!-- ── PAYMENT HISTORY ── -->
<div class="overlay" :class="{open: m.history}" @click.self="close('history')">
    <div class="modal modal-wide">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-history" style="color:#2563EB"></i> Payment History</span>
            <button class="mclose" @click="close('history')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody" style="padding:0">
            <table class="mtbl">
                <thead>
                    <tr>
                        <th>Date</th><th>Amount</th><th>Method</th><th>Recorded By</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="p in payHistory" :key="p.id">
                        <tr>
                            <td x-text="p.date"></td>
                            <td style="font-weight:700; color:#059669;" x-text="p.amount + ' BDT'"></td>
                            <td x-text="p.method"></td>
                            <td style="color:var(--n500);" x-text="p.by"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ── SESSIONS ── -->
<div class="overlay" :class="{open: m.sessions}" @click.self="close('sessions')">
    <div class="modal modal-wide">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-network-wired" style="color:#2563EB"></i> Session Details</span>
            <button class="mclose" @click="close('sessions')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody" style="padding:0">
            <table class="mtbl">
                <thead>
                    <tr><th>IP Address</th><th>Started</th><th>Duration</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-family:monospace">172.0.0.1</td>
                        <td>2026-06-03 08:14</td>
                        <td style="font-weight:600">14h 32m</td>
                        <td><span class="tag tag-active">Online</span></td>
                    </tr>
                    <tr>
                        <td style="font-family:monospace">172.0.0.1</td>
                        <td>2026-06-02 09:00</td>
                        <td style="font-weight:600">23h 14m</td>
                        <td><span class="tag tag-closed">Ended</span></td>
                    </tr>
                    <tr>
                        <td style="font-family:monospace">172.0.0.1</td>
                        <td>2026-06-01 07:45</td>
                        <td style="font-weight:600">22h 50m</td>
                        <td><span class="tag tag-closed">Ended</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ── CHANGE EXPIRY ── -->
<div class="overlay" :class="{open: m.editExpiry}" @click.self="close('editExpiry')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-calendar-alt" style="color:#2563EB"></i> Change Expiry Date</span>
            <button class="mclose" @click="close('editExpiry')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="fg">
                <label class="flbl">New Expiry Date</label>
                <input type="date" class="finput" value="2026-09-12">
            </div>
            <div class="fg">
                <label class="flbl">Reason (Optional)</label>
                <input type="text" class="finput" placeholder="Reason for change…">
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('editExpiry')">Cancel</button>
            <button class="btn btn-primary" @click="toast('Expiry date updated!','success'); close('editExpiry')"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
</div>

<!-- ── CHANGE EXTENDED DATE ── -->
<div class="overlay" :class="{open: m.editExtended}" @click.self="close('editExtended')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-calendar-plus" style="color:#2563EB"></i> Change Extended Date</span>
            <button class="mclose" @click="close('editExtended')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="fg">
                <label class="flbl">Extended Date</label>
                <input type="date" class="finput" value="2024-10-18">
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('editExtended')">Cancel</button>
            <button class="btn btn-primary" @click="toast('Extended date updated!','success'); close('editExtended')"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
</div>

<!-- ── ADD BILL ── -->
<div class="overlay" :class="{open: m.addbill}" @click.self="close('addbill')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-receipt" style="color:#D97706"></i> Add Bill / Charge</span>
            <button class="mclose" @click="close('addbill')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="fg">
                <label class="flbl">Bill Type</label>
                <select class="finput fselect">
                    <option>Monthly Fee</option>
                    <option>Late Fee</option>
                    <option>Equipment Charge</option>
                    <option>Setup Fee</option>
                    <option>Custom</option>
                </select>
            </div>
            <div class="fg">
                <label class="flbl">Amount (BDT)</label>
                <input type="number" class="finput" placeholder="Enter amount">
            </div>
            <div class="fg">
                <label class="flbl">Due Date</label>
                <input type="date" class="finput">
            </div>
            <div class="fg">
                <label class="flbl">Description</label>
                <input type="text" class="finput" placeholder="Bill description…">
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('addbill')">Cancel</button>
            <button class="btn btn-amber" @click="toast('Bill added successfully!','success'); close('addbill')"><i class="fa fa-plus"></i> Add Bill</button>
        </div>
    </div>
</div>

<!-- ── CHANGE DISCOUNT ── -->
<div class="overlay" :class="{open: m.editDiscount}" @click.self="close('editDiscount')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-tag" style="color:#2563EB"></i> Permanent Discount</span>
            <button class="mclose" @click="close('editDiscount')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="fg">
                <label class="flbl">Discount Amount (BDT)</label>
                <input type="number" class="finput" value="50" min="0">
                <div class="fhint">Set 0 to remove discount.</div>
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('editDiscount')">Cancel</button>
            <button class="btn btn-primary" @click="toast('Discount updated!','success'); close('editDiscount')"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
</div>

<!-- ── FREE CLIENT ── -->
<div class="overlay" :class="{open: m.editFreeClient}" @click.self="close('editFreeClient')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-gift" style="color:#D97706"></i> Free Client</span>
            <button class="mclose" @click="close('editFreeClient')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="choice-pair">
                <button class="choice-opt co-yes" @click="toast('Marked as Free Client','success'); close('editFreeClient')">
                    <i class="fa fa-check-circle"></i> Yes — Free
                </button>
                <button class="choice-opt co-no" @click="toast('Free Client removed','info'); close('editFreeClient')">
                    <i class="fa fa-times-circle"></i> No — Paid
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ── BILLING TYPE ── -->
<div class="overlay" :class="{open: m.editBillingType}" @click.self="close('editBillingType')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-calendar-check" style="color:#2563EB"></i> Billing Type</span>
            <button class="mclose" @click="close('editBillingType')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="choice-pair">
                <button class="choice-opt co-d2d" @click="toast('Billing: Date2Date','success'); close('editBillingType')">
                    <i class="fa fa-calendar-day"></i> Date2Date
                </button>
                <button class="choice-opt co-mo"  @click="toast('Billing: Monthly','success'); close('editBillingType')">
                    <i class="fa fa-calendar-alt"></i> Monthly
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ── CHANGE POP ── -->
<div class="overlay" :class="{open: m.editPop}" @click.self="close('editPop')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-broadcast-tower" style="color:#7C3AED"></i> Change POP</span>
            <button class="mclose" @click="close('editPop')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="fg">
                <label class="flbl">Select POP</label>
                <select class="finput fselect">
                    <option selected>Nilkhet</option>
                    <option>Dhanmondi</option>
                    <option>Gulshan</option>
                    <option>Uttara</option>
                    <option>Mirpur</option>
                    <option>Motijheel</option>
                </select>
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('editPop')">Cancel</button>
            <button class="btn btn-purple" @click="toast('POP updated!','success'); close('editPop')"><i class="fa fa-save"></i> Save</button>
        </div>
    </div>
</div>

<!-- ── CHANGE CONTACT ── -->
<div class="overlay" :class="{open: m.editContact}" @click.self="close('editContact')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-phone" style="color:#2563EB"></i> Change Contact</span>
            <button class="mclose" @click="close('editContact')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="fg">
                <label class="flbl">New Contact Number</label>
                <input type="tel" class="finput" value="01681046437" placeholder="01XXXXXXXXX">
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('editContact')">Cancel</button>
            <button class="btn btn-primary" @click="toast('Contact updated!','success'); close('editContact')"><i class="fa fa-save"></i> Update</button>
        </div>
    </div>
</div>

<!-- ── SEND SMS ── -->
<div class="overlay" :class="{open: m.sms}" @click.self="close('sms')">
    <div class="modal">
        <div class="mh">
            <span class="mh-title"><i class="fa fa-sms" style="color:#16A34A"></i> Send SMS</span>
            <button class="mclose" @click="close('sms')"><i class="fa fa-times"></i></button>
        </div>
        <div class="mbody">
            <div class="fg">
                <label class="flbl">To</label>
                <input type="tel" class="finput" value="01681046437" readonly
                       style="background:var(--n50);color:var(--n500);cursor:default;">
            </div>
            <div class="fg">
                <label class="flbl">Message</label>
                <textarea class="finput" rows="5" style="resize:vertical"
                          placeholder="Type your SMS message here…"
                          x-model="f.sms.body"
                          maxlength="640"></textarea>
                <div class="fhint" x-text="f.sms.body.length + ' / 640 characters'"></div>
            </div>
        </div>
        <div class="mfoot">
            <button class="btn btn-outline" @click="close('sms')">Cancel</button>
            <button class="btn btn-success" :class="{'is-loading': loading}" @click="submitSMS()">
                <div class="loading-spin"></div>
                <span class="btn-txt"><i class="fa fa-paper-plane"></i> Send SMS</span>
            </button>
        </div>
    </div>
</div>

<!-- ── TOAST CONTAINER ── -->
<div class="toast-wrap">
    <template x-for="t in toasts" :key="t.id">
        <div class="toast" :class="'toast-'+t.type">
            <i :class="t.type === 'success' ? 'fa fa-check-circle' : t.type === 'error' ? 'fa fa-times-circle' : 'fa fa-info-circle'"></i>
            <span x-text="t.msg"></span>
        </div>
    </template>
</div>


<!-- ════════════════════════════════════════════
     ALPINE APP
════════════════════════════════════════════ -->
<script>
function app() {
    return {
        syncing: false,
        loading: false,
        toasts:  [],
        now: new Date().toLocaleTimeString(),

        m: {
            payment:false, ticket:false, traffic:false, history:false,
            sessions:false, addbill:false, editPackage:false, editStatus:false,
            editExpiry:false, editExtended:false, editDiscount:false,
            editFreeClient:false, editBillingType:false, editPop:false,
            editContact:false, sms:false, editCustomer:false,
        },

        f: {
            payment: {
                amount: '',
                method: 'cash',
                date:   new Date().toISOString().split('T')[0],
                note:   '',
            },
            ticket: {
                subject:'', category:'Connection Issue',
                priority:'medium', description:'',
            },
            sms: { body: '' },
            editCustomer: {
                name:        'Kamrul Islam',
                username:    'Kamrul',
                password:    '12345',
                contact:     '01681046437',
                address:     'Flat#3, Road#12, Bashundhara, Sector#A',
                package:     'Basic Package',
                reseller:    'Local',
                billingDate: '12',
            },
        },

        payHistory: [
            { id:1, date:'2026-05-12', amount:'700',  method:'bKash', by:'Admin' },
            { id:2, date:'2026-04-12', amount:'700',  method:'Cash',  by:'Karim' },
            { id:3, date:'2026-03-12', amount:'700',  method:'Nagad', by:'Admin' },
            { id:4, date:'2026-02-12', amount:'1200', method:'Cash',  by:'Rahim' },
            { id:5, date:'2026-01-12', amount:'700',  method:'bKash', by:'Admin' },
        ],

        open(k)  { this.m[k] = true;  document.body.style.overflow = 'hidden'; },
        close(k) { this.m[k] = false; document.body.style.overflow = ''; },
        closeAll() {
            Object.keys(this.m).forEach(k => this.m[k] = false);
            document.body.style.overflow = '';
        },

        toast(msg, type = 'info', ms = 3200) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, msg, type });
            setTimeout(() => { this.toasts = this.toasts.filter(t => t.id !== id); }, ms);
        },

        cp(text) {
            navigator.clipboard?.writeText(text).then(() => this.toast('Copied!', 'info', 1600));
        },

        async syncMikrotik() {
            if (this.syncing) return;
            this.syncing = true;
            /* Real call:
            await fetch('/customers/1/sync-mikrotik', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
            }); */
            await new Promise(r => setTimeout(r, 2000));
            this.syncing = false;
            this.toast('Mikrotik synced!', 'success');
        },

        async submitPayment() {
            if (!this.f.payment.amount) { this.toast('Enter an amount', 'error'); return; }
            this.loading = true;
            try {
                /* Real call:
                const res = await fetch('/customers/1/payments', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.f.payment),
                });
                if (!res.ok) throw new Error(); */
                await new Promise(r => setTimeout(r, 1200));
                this.toast(`${this.f.payment.amount} BDT recorded via ${this.f.payment.method}`, 'success');
                this.close('payment');
                this.f.payment.amount = '';
                this.f.payment.note   = '';
            } catch {
                this.toast('Payment failed. Try again.', 'error');
            } finally {
                this.loading = false;
            }
        },

        async submitTicket() {
            if (!this.f.ticket.subject) { this.toast('Enter a subject', 'error'); return; }
            this.loading = true;
            /* Real call:
            await fetch('/tickets', { method:'POST', … }); */
            await new Promise(r => setTimeout(r, 1100));
            this.toast('Ticket created!', 'success');
            this.close('ticket');
            this.f.ticket.subject = '';
            this.f.ticket.description = '';
            this.loading = false;
        },

        setStatus(s) {
            this.toast(`Status → ${s}`, 'success');
            this.close('editStatus');
        },

        dlInvoice() {
            this.toast('Invoice downloading…', 'info');
            /* window.open('/customers/1/invoice.pdf', '_blank'); */
        },

        async submitSMS() {
            if (!this.f.sms.body.trim()) { this.toast('Please type a message', 'error'); return; }
            this.loading = true;
            try {
                /* Real call:
                await fetch('/customers/1/send-sms', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ to: '01681046437', body: this.f.sms.body }),
                }); */
                await new Promise(r => setTimeout(r, 1000));
                this.toast('SMS sent to 01681046437', 'success');
                this.close('sms');
                this.f.sms.body = '';
            } catch {
                this.toast('Failed to send SMS. Try again.', 'error');
            } finally {
                this.loading = false;
            }
        },

        async submitEditCustomer() {
            if (!this.f.editCustomer.name.trim()) { this.toast('Full name is required', 'error'); return; }
            if (!this.f.editCustomer.contact.trim()) { this.toast('Contact is required', 'error'); return; }
            this.loading = true;
            try {
                /* Real call:
                await fetch('/customers/1', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.f.editCustomer),
                }); */
                await new Promise(r => setTimeout(r, 1000));
                this.toast('Customer updated successfully!', 'success');
                this.close('editCustomer');
            } catch {
                this.toast('Update failed. Try again.', 'error');
            } finally {
                this.loading = false;
            }
        },

        init() {
            setInterval(() => { this.now = new Date().toLocaleTimeString(); }, 1000);
        },
    }
}
</script>
</body>
</html>
