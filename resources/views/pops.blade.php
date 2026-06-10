<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POP / Zone List</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary:       #2563EB;
            --primary-dark:  #1D4ED8;
            --success:       #059669;
            --success-bg:    #ECFDF5;
            --danger:        #DC2626;
            --danger-bg:     #FEF2F2;
            --warning:       #D97706;
            --warning-bg:    #FFFBEB;
            --surface:       #fff;
            --bg:            #F1F5F9;
            --border:        #E2E8F0;
            --text:          #0F172A;
            --text-2:        #475569;
            --text-3:        #94A3B8;
            --th-bg:         #334155;
            --th-text:       #F1F5F9;
            --row-hover:     #F8FAFF;
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

        .page-wrap { max-width: 1500px; margin: 0 auto; padding: 20px 16px 60px; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .page-header-left { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

        .page-title {
            font-size: 19px; font-weight: 800; color: var(--text);
            display: flex; align-items: center; gap: 10px; letter-spacing: -.3px;
        }

        .page-title-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #0D9488 0%, #14B8A6 100%);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 14px;
            box-shadow: 0 2px 8px rgba(13,148,136,.3);
            flex-shrink: 0;
        }

        .total-badge {
            padding: 4px 12px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            font-size: 12.5px; font-weight: 600; color: var(--text-2);
            box-shadow: var(--shadow); white-space: nowrap;
        }

        .total-badge span { color: #0D9488; font-weight: 700; }

        .btn-pop-recharge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 0 18px; height: 38px;
            background: var(--primary); color: #fff;
            border: none; border-radius: 9px;
            font-size: 13.5px; font-weight: 600; font-family: inherit;
            cursor: pointer; white-space: nowrap;
            box-shadow: 0 2px 8px rgba(37,99,235,.28);
            transition: background .15s;
        }

        .btn-pop-recharge:hover { background: var(--primary-dark); }

        .btn-add-pop {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 0 18px; height: 38px;
            background: linear-gradient(135deg, #0D9488, #14B8A6); color: #fff;
            border: none; border-radius: 9px;
            font-size: 13.5px; font-weight: 600; font-family: inherit;
            cursor: pointer; white-space: nowrap;
            box-shadow: 0 2px 8px rgba(13,148,136,.3);
            transition: filter .15s;
        }

        .btn-add-pop:hover { filter: brightness(1.08); }

        /* ── ADD POP MODAL ── */
        .ap-overlay {
            position: fixed; inset: 0;
            background: rgba(15,23,42,.6);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            display: flex; align-items: center; justify-content: center;
            z-index: 500;
            padding: 24px 16px;
        }

        @keyframes ap-pop {
            from { opacity: 0; transform: translateY(14px) scale(.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .ap-modal {
            background: var(--surface);
            border-radius: 18px;
            width: 100%;
            max-width: 880px;
            box-shadow: 0 32px 80px rgba(15,23,42,.32);
            overflow: hidden;
            animation: ap-pop .25s cubic-bezier(.21,1.02,.55,1);
            max-height: 92vh;
            display: flex; flex-direction: column;
        }

        .ap-head {
            display: flex; align-items: center; gap: 14px;
            padding: 20px 24px;
            background: linear-gradient(135deg, #0F766E 0%, #0D9488 60%, #2DD4BF 100%);
            position: relative;
            flex-shrink: 0;
        }

        .ap-head::after {
            content: '';
            position: absolute; right: -30px; top: -40px;
            width: 150px; height: 150px;
            background: rgba(255,255,255,.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .ap-head-icon {
            width: 42px; height: 42px;
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 17px;
            flex-shrink: 0;
        }

        .ap-head-text { flex: 1; min-width: 0; }
        .ap-head-text h2 { font-size: 18px; font-weight: 800; color: #fff; letter-spacing: -.3px; line-height: 1.2; }
        .ap-head-text p  { font-size: 12px; color: rgba(255,255,255,.75); margin-top: 2px; }

        .ap-close {
            background: rgba(255,255,255,.18);
            border: none; cursor: pointer;
            font-size: 14px; color: #fff;
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: background .15s;
            flex-shrink: 0;
            position: relative; z-index: 1;
        }

        .ap-close:hover { background: rgba(255,255,255,.32); }

        .ap-body { padding: 24px; display: flex; flex-direction: column; gap: 18px; overflow-y: auto; }

        .ap-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }

        .ap-field { display: flex; flex-direction: column; gap: 6px; min-width: 0; }

        .ap-field > label {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .6px;
            color: var(--text-2);
        }

        .ap-field > label .req { color: var(--danger); }

        .ap-field select,
        .ap-field input {
            width: 100%;
            height: 46px;
            padding: 0 14px;
            border: 1.5px solid var(--border);
            border-radius: 11px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text);
            background: #F8FAFC;
            outline: none;
            transition: border-color .15s, box-shadow .15s, background .15s;
        }

        .ap-field select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='6' viewBox='0 0 11 6'%3E%3Cpath d='M1 1l4.5 4L10 1' stroke='%2394A3B8' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }

        .ap-field select:focus,
        .ap-field input:focus {
            border-color: #0D9488;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(13,148,136,.12);
        }

        .ap-field.has-err select,
        .ap-field.has-err input { border-color: var(--danger); background: #fff; }

        .ap-err { font-size: 12px; color: var(--danger); display: none; }
        .ap-field.has-err .ap-err { display: block; }

        .ap-divider { border: none; border-top: 1px solid var(--border); margin: 4px 0; }

        .ap-sec-title {
            font-size: 12px; font-weight: 800;
            text-transform: uppercase; letter-spacing: .8px;
            color: var(--text-2);
            display: flex; align-items: center; gap: 8px;
        }

        .ap-sec-title i { color: #0D9488; }

        .ap-foot {
            display: flex; align-items: center; justify-content: flex-end; gap: 10px;
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            background: #FAFBFC;
            flex-shrink: 0;
        }

        .ap-btn-close {
            padding: 0 20px; height: 44px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 11px;
            font-size: 14px; font-weight: 600; font-family: inherit;
            color: var(--text-2);
            cursor: pointer;
            transition: all .15s;
        }

        .ap-btn-close:hover { border-color: var(--text-3); color: var(--text); }

        .ap-btn-save {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 0 28px; height: 44px;
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            border: none;
            border-radius: 11px;
            font-size: 14px; font-weight: 700; font-family: inherit;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37,99,235,.35);
            transition: transform .15s, box-shadow .15s;
        }

        .ap-btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(37,99,235,.45); }

        @media (max-width: 860px) { .ap-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 560px) { .ap-grid { grid-template-columns: 1fr; } }

        /* ── POP RECHARGE MODAL ── */
        .pr-modal { max-width: 540px; }

        .pr-head { background: linear-gradient(135deg, #1D4ED8 0%, #3B82F6 60%, #60A5FA 100%); }

        .pr-modal .ap-field select:focus,
        .pr-modal .ap-field input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37,99,235,.1);
        }

        .pr-balance {
            display: inline-flex; align-items: center; gap: 7px;
            margin-top: 2px;
            padding: 6px 12px;
            background: var(--success-bg);
            border: 1px solid #A7F3D0;
            border-radius: 8px;
            font-size: 12px; font-weight: 600;
            color: var(--success);
            align-self: flex-start;
        }

        .pr-balance.neg { background: var(--danger-bg); border-color: #FECACA; color: var(--danger); }

        .pr-amount-wrap { position: relative; }

        .pr-amount-wrap .cur {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            font-size: 15px; font-weight: 700; color: var(--text-3);
            pointer-events: none;
        }

        .pr-amount-wrap input { padding-left: 34px; font-weight: 600; font-size: 15px; }

        .pr-chips { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }

        .pr-chip {
            padding: 6px 14px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 20px;
            font-size: 12.5px; font-weight: 600; font-family: inherit;
            color: var(--text-2);
            cursor: pointer;
            transition: all .15s;
        }

        .pr-chip:hover { border-color: var(--primary); color: var(--primary); }

        .pr-chip.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 2px 8px rgba(37,99,235,.3);
        }

        .pr-btn-recharge {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 0 26px; height: 44px;
            background: linear-gradient(135deg, #2563EB, #1D4ED8);
            border: none;
            border-radius: 11px;
            font-size: 14px; font-weight: 700; font-family: inherit;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37,99,235,.35);
            transition: transform .15s, box-shadow .15s;
        }

        .pr-btn-recharge:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(37,99,235,.45); }

        /* ── TOAST ── */
        .ap-toast {
            position: fixed; bottom: 24px; right: 24px; z-index: 999;
            padding: 12px 18px;
            background: var(--success);
            color: #fff;
            border-radius: 10px;
            font-size: 13.5px; font-weight: 600;
            box-shadow: 0 6px 24px rgba(0,0,0,.18);
            display: flex; align-items: center; gap: 8px;
        }

        /* ── TABLE CARD ── */
        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        /* ── CONTROLS ── */
        .tbl-controls {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            justify-content: space-between;
            flex-wrap: wrap; gap: 10px;
            background: #FAFBFC;
        }

        .tbl-ctrl-left {
            display: flex; align-items: center; gap: 8px;
            font-size: 13px; color: var(--text-2);
        }

        .tbl-ctrl-left select {
            height: 30px; padding: 0 24px 0 8px;
            border: 1.5px solid var(--border); border-radius: 7px;
            font-size: 12.5px; font-family: inherit;
            color: var(--text); background: var(--surface);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='5' viewBox='0 0 9 5'%3E%3Cpath d='M1 1l3.5 3L8 1' stroke='%2394A3B8' stroke-width='1.4' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 8px center;
            cursor: pointer; transition: border-color .15s;
        }

        .tbl-ctrl-left select:focus { outline: none; border-color: var(--primary); }

        .search-wrap { position: relative; }

        .search-wrap i {
            position: absolute; left: 10px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-3); font-size: 12px; pointer-events: none;
        }

        .search-wrap input {
            height: 30px; width: 220px;
            padding: 0 10px 0 30px;
            border: 1.5px solid var(--border); border-radius: 7px;
            font-size: 12.5px; font-family: inherit;
            color: var(--text); background: var(--surface);
            transition: border-color .15s, box-shadow .15s;
        }

        .search-wrap input:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 2.5px rgba(37,99,235,.1);
        }

        .search-wrap input::placeholder { color: var(--text-3); }

        /* ── TABLE ── */
        .tbl-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 1000px; }

        thead th {
            background: var(--th-bg); color: var(--th-text);
            font-size: 11.5px; font-weight: 700;
            letter-spacing: .4px; text-transform: uppercase;
            padding: 11px 13px; text-align: left; white-space: nowrap;
        }

        thead th.col-center { text-align: center; }

        tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--row-hover); }

        tbody td { padding: 11px 13px; color: var(--text); vertical-align: middle; }
        tbody td.col-center { text-align: center; }
        tbody td.col-muted  { color: var(--text-2); }

        /* ── ID ── */
        .id-cell {
            font-size: 12px; font-weight: 700; color: var(--text-3);
            background: var(--bg); border-radius: 6px;
            padding: 3px 7px; display: inline-block;
        }

        /* ── POP NAME ── */
        .pop-name { font-weight: 700; color: var(--text); font-size: 13px; }

        /* Mobile-only ID badge hidden by default */
        .mob-id-badge { display: none; }

        /* ── MANAGER LINK ── */
        .mgr-link {
            font-weight: 600; font-size: 12.5px;
            color: var(--primary); text-decoration: none;
        }

        .mgr-link:hover { text-decoration: underline; }

        /* ── LOCATION ── */
        .location-cell {
            font-size: 12.5px; color: var(--text-2);
            max-width: 150px; line-height: 1.4;
        }

        /* ── IP ── */
        .ip-cell {
            font-family: 'Courier New', monospace;
            font-size: 12px; font-weight: 600;
            color: var(--text); letter-spacing: -.3px;
            background: var(--bg); padding: 2px 8px;
            border-radius: 5px; white-space: nowrap;
            display: inline-block;
        }

        /* ── YES / NO BADGE ── */
        .yn-yes {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 9px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600;
            background: var(--success-bg); color: var(--success);
            border: 1px solid #A7F3D0;
        }

        .yn-no {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 9px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600;
            background: var(--bg); color: var(--text-3);
            border: 1px solid var(--border);
        }

        /* ── BALANCE ── */
        .balance-cell { font-weight: 700; font-size: 13px; font-variant-numeric: tabular-nums; }
        .balance-zero { color: var(--text-3); }
        .balance-pos  { color: var(--success); }
        .balance-neg  { color: var(--danger); }

        /* ── TOTAL CUSTOMERS ── */
        .cust-count {
            display: inline-flex; align-items: center; gap: 5px;
            font-weight: 700; font-size: 13px; color: var(--primary);
        }

        .cust-count i { font-size: 10px; opacity: .6; }

        /* ── SMS STATUS ── */
        .sms-yes {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 6px;
            font-size: 11.5px; font-weight: 600;
            background: var(--success-bg); color: var(--success);
            border: 1px solid #A7F3D0;
        }

        .sms-no {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 6px;
            font-size: 11.5px; font-weight: 600;
            background: var(--bg); color: var(--text-3);
            border: 1px solid var(--border);
        }

        /* ── ACTION DROPDOWN ── */
        .action-wrap { position: relative; }

        .btn-action {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 0 12px; height: 28px;
            background: var(--primary); color: #fff;
            border: none; border-radius: 7px;
            font-size: 12.5px; font-weight: 600; font-family: inherit;
            cursor: pointer; white-space: nowrap; transition: background .15s;
        }

        .btn-action:hover { background: var(--primary-dark); }
        .btn-action i.chevron { font-size: 9px; opacity: .8; transition: transform .2s; }
        .btn-action.open i.chevron { transform: rotate(180deg); }

        .dropdown-menu {
            position: absolute; right: 0; top: calc(100% + 4px);
            z-index: 100; background: var(--surface);
            border: 1px solid var(--border); border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,.12), 0 2px 8px rgba(0,0,0,.06);
            min-width: 175px; padding: 5px;
        }

        .dd-item {
            display: flex; align-items: center; gap: 9px;
            padding: 8px 11px; border-radius: 7px;
            font-size: 12.5px; font-weight: 500; color: var(--text-2);
            cursor: pointer; border: none; background: none;
            width: 100%; text-align: left; font-family: inherit;
            transition: background .12s, color .12s;
        }

        .dd-item:hover { background: var(--bg); color: var(--text); }
        .dd-item i { width: 14px; text-align: center; font-size: 12px; }
        .dd-item.danger { color: var(--danger); }
        .dd-item.danger:hover { background: var(--danger-bg); }
        .dd-divider { height: 1px; background: var(--border); margin: 4px 0; }
        .dd-overlay { position: fixed; inset: 0; z-index: 99; }

        /* ── EMPTY STATE ── */
        .empty-row td { padding: 50px 20px; text-align: center; color: var(--text-3); font-size: 13.5px; }
        .empty-row td i { display: block; font-size: 28px; opacity: .2; margin-bottom: 10px; }

        /* ── TABLE FOOTER ── */
        .tbl-footer {
            padding: 12px 16px; border-top: 1px solid var(--border);
            background: #FAFBFC;
            display: flex; align-items: center;
            justify-content: space-between; flex-wrap: wrap; gap: 10px;
        }

        .tbl-info { font-size: 12.5px; color: var(--text-2); }

        /* ── PAGINATION ── */
        .pagination { display: flex; align-items: center; gap: 4px; flex-wrap: wrap; }

        .page-btn {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 32px; height: 32px; padding: 0 8px;
            border: 1.5px solid var(--border); border-radius: 7px;
            background: var(--surface); font-size: 12.5px; font-weight: 500;
            font-family: inherit; color: var(--text-2); cursor: pointer;
            transition: background .12s, border-color .12s, color .12s;
        }

        .page-btn:hover:not(:disabled) { background: var(--bg); color: var(--text); border-color: #CBD5E1; }
        .page-btn.active { background: var(--primary); color: #fff; border-color: var(--primary); font-weight: 700; }
        .page-btn:disabled { opacity: .4; cursor: not-allowed; }

        /* ══════════════════════════════
           MOBILE CARD LAYOUT  ≤ 700px
        ══════════════════════════════ */
        @media (max-width: 700px) {
            .page-wrap { padding: 14px 12px 60px; }
            .page-header { gap: 10px; }
            .btn-pop-recharge { width: 100%; justify-content: center; height: 40px; }

            .tbl-controls { flex-direction: column; align-items: stretch; gap: 8px; }
            .tbl-ctrl-left { justify-content: flex-start; }
            .search-wrap { width: 100%; }
            .search-wrap input { width: 100%; }

            .tbl-wrap { overflow-x: unset; }
            table   { min-width: unset; border-collapse: collapse; }
            thead   { display: none; }

            tbody tr {
                display: block;
                border: 1px solid var(--border) !important;
                border-radius: 12px;
                margin: 0 0 12px;
                box-shadow: var(--shadow);
                overflow: hidden;
                border-bottom: 1px solid var(--border) !important;
            }

            tbody td {
                display: flex; align-items: center;
                justify-content: space-between; gap: 10px;
                padding: 9px 14px;
                border-bottom: 1px solid #F1F5F9;
                text-align: right;
            }

            tbody td:last-child { border-bottom: none; }

            tbody td[data-label]::before {
                content: attr(data-label);
                font-size: 11px; font-weight: 700;
                color: var(--text-3);
                text-transform: uppercase; letter-spacing: .5px;
                text-align: left; flex: 1; white-space: nowrap;
            }

            /* Hide redundant ID row in card layout */
            tbody td.mob-id-td { display: none !important; }

            /* Card header: POP Name row */
            tbody td.mob-name-td {
                background: var(--th-bg);
                padding: 11px 14px; gap: 10px;
            }

            tbody td.mob-name-td::before { display: none; }

            tbody td.mob-name-td .mob-id-badge {
                display: inline-block !important;
                background: rgba(255,255,255,.15);
                color: rgba(255,255,255,.7);
                font-size: 11px; flex-shrink: 0;
            }

            tbody td.mob-name-td .pop-name {
                color: #fff; font-size: 14px;
                font-weight: 700; flex: 1;
            }

            /* Action footer */
            tbody td.mob-action {
                display: flex; justify-content: center;
                background: #FAFBFC;
                border-top: 1px solid #F1F5F9;
                padding: 10px 14px;
            }

            tbody td.mob-action::before { display: none; }
            tbody td.mob-action .btn-action { width: 100%; justify-content: center; height: 34px; }
            tbody td.mob-action .action-wrap { width: 100%; }
            tbody td.mob-action .dropdown-menu { left: 0; right: 0; width: 100%; }

            .location-cell { max-width: unset; }

            .tbl-footer { flex-direction: column; align-items: stretch; }
            .pagination { justify-content: center; }
        }
    </style>
</head>
<body x-data="popList()" x-cloak>

<div class="page-wrap">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">
                <div class="page-title-icon"><i class="fa fa-building"></i></div>
                POP / Zone List
            </h1>
            <div class="total-badge">Total POP: <span x-text="pops.length"></span></div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
            <button class="btn-add-pop" @click="openAdd()">
                <i class="fa fa-building"></i> Add Pop
            </button>
            <button class="btn-pop-recharge" @click="openRecharge()">
                <i class="fa fa-credit-card"></i> Pop Recharge
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">

        <!-- Controls -->
        <div class="tbl-controls">
            <div class="tbl-ctrl-left">
                Show
                <select x-model.number="perPage" @change="currentPage = 1">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                entries
            </div>
            <div class="search-wrap">
                <i class="fa fa-search"></i>
                <input type="text" placeholder="Search…" x-model="query" @input="currentPage = 1">
            </div>
        </div>

        <!-- Table -->
        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:50px">Id</th>
                        <th>POP Name</th>
                        <th>Manager Name</th>
                        <th>POP Location</th>
                        <th>NAS Server IP</th>
                        <th>POP Contact</th>
                        <th class="col-center">Sub-Manager</th>
                        <th class="col-center">Bill Generate</th>
                        <th class="col-center">Balance</th>
                        <th class="col-center">Total Customers</th>
                        <th class="col-center">SMS Status</th>
                        <th class="col-center" style="width:100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-if="paginated.length === 0">
                        <tr class="empty-row">
                            <td colspan="12">
                                <i class="fa fa-tower-broadcast"></i>
                                No POP/Zone records found
                            </td>
                        </tr>
                    </template>

                    <template x-for="pop in paginated" :key="pop.id">
                        <tr>

                            <!-- ID: visible on desktop, hidden on mobile (badge injected in name cell) -->
                            <td data-label="Id" class="mob-id-td">
                                <span class="id-cell" x-text="pop.id"></span>
                            </td>

                            <!-- POP Name: card header on mobile -->
                            <td data-label="POP Name" class="mob-name-td">
                                <span class="mob-id-badge id-cell" x-text="'#' + pop.id"></span>
                                <span class="pop-name" x-text="pop.name"></span>
                            </td>

                            <!-- Manager Name -->
                            <td data-label="Manager">
                                <a href="#" class="mgr-link" x-text="pop.manager"></a>
                            </td>

                            <!-- POP Location -->
                            <td data-label="Location">
                                <div class="location-cell" x-text="pop.location"></div>
                            </td>

                            <!-- NAS Server IP -->
                            <td data-label="NAS IP">
                                <span class="ip-cell" x-text="pop.nasIP"></span>
                            </td>

                            <!-- POP Contact -->
                            <td data-label="Contact" x-text="pop.contact"></td>

                            <!-- Sub-Manager -->
                            <td data-label="Sub-Manager" class="col-center">
                                <span :class="pop.subManager ? 'yn-yes' : 'yn-no'">
                                    <i :class="pop.subManager ? 'fa fa-check' : 'fa fa-minus'"></i>
                                    <span x-text="pop.subManager ? 'Yes' : 'No'"></span>
                                </span>
                            </td>

                            <!-- Bill Generate -->
                            <td data-label="Bill Gen." class="col-center">
                                <span :class="pop.billGenerate ? 'yn-yes' : 'yn-no'">
                                    <i :class="pop.billGenerate ? 'fa fa-check' : 'fa fa-minus'"></i>
                                    <span x-text="pop.billGenerate ? 'Yes' : 'No'"></span>
                                </span>
                            </td>

                            <!-- Balance -->
                            <td data-label="Balance" class="col-center">
                                <span
                                    class="balance-cell"
                                    :class="{
                                        'balance-zero': pop.balance == 0,
                                        'balance-pos':  pop.balance > 0,
                                        'balance-neg':  pop.balance < 0
                                    }"
                                    x-text="pop.balance.toFixed(2)"
                                ></span>
                            </td>

                            <!-- Total Customers -->
                            <td data-label="Customers" class="col-center">
                                <span class="cust-count">
                                    <i class="fa fa-user"></i>
                                    <span x-text="pop.totalCustomers"></span>
                                </span>
                            </td>

                            <!-- SMS Status -->
                            <td data-label="SMS" class="col-center">
                                <span :class="pop.smsStatus ? 'sms-yes' : 'sms-no'">
                                    <i class="fa fa-envelope"></i>
                                    <span x-text="pop.smsStatus ? 'Yes' : 'No'"></span>
                                </span>
                            </td>

                            <!-- Action -->
                            <td data-label="Action" class="col-center mob-action">
                                <div class="action-wrap" x-data="{ open: false }">
                                    <div x-show="open" class="dd-overlay" @click="open = false"></div>
                                    <button class="btn-action" :class="{ open }" @click="open = !open">
                                        Action <i class="fa fa-chevron-down chevron"></i>
                                    </button>
                                    <div class="dropdown-menu" x-show="open" x-transition>
                                        <button class="dd-item" @click="open=false"><i class="fa fa-eye"></i> View Details</button>
                                        <button class="dd-item" @click="open=false"><i class="fa fa-pen-to-square"></i> Edit</button>
                                        <button class="dd-item" @click="open=false"><i class="fa fa-users"></i> View Customers</button>
                                        <button class="dd-item" @click="open=false"><i class="fa fa-server"></i> NAS Config</button>
                                        <button class="dd-item" @click="open=false"><i class="fa fa-credit-card"></i> Recharge History</button>
                                        <button class="dd-item" @click="open=false"><i class="fa fa-file-invoice"></i> Billing Report</button>
                                        <div class="dd-divider"></div>
                                        <button class="dd-item danger" @click="open=false"><i class="fa fa-trash"></i> Delete</button>
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
            <div class="tbl-info" x-text="infoText"></div>
            <div class="pagination">
                <button class="page-btn" @click="currentPage--" :disabled="currentPage === 1">
                    <i class="fa fa-chevron-left" style="font-size:10px"></i>
                    <span style="margin-left:2px">Prev</span>
                </button>
                <template x-for="p in totalPages" :key="p">
                    <button
                        class="page-btn"
                        :class="{ active: currentPage === p }"
                        @click="currentPage = p"
                        x-text="p"
                    ></button>
                </template>
                <button class="page-btn" @click="currentPage++" :disabled="currentPage === totalPages">
                    <span style="margin-right:2px">Next</span>
                    <i class="fa fa-chevron-right" style="font-size:10px"></i>
                </button>
            </div>
        </div>

    </div>
</div>

<!-- Add POP/Zone Modal -->
<div class="ap-overlay" x-show="addOpen" x-transition.opacity.duration.200ms @click.self="addOpen = false" @keydown.escape.window="addOpen = false">
    <div class="ap-modal" x-show="addOpen">
        <div class="ap-head">
            <div class="ap-head-icon"><i class="fa fa-tower-broadcast"></i></div>
            <div class="ap-head-text">
                <h2>Add New POP/Zone</h2>
                <p>Create a new point of presence / zone</p>
            </div>
            <button class="ap-close" @click="addOpen = false"><i class="fa fa-xmark"></i></button>
        </div>
        <div class="ap-body">
            <div class="ap-grid">
                <div class="ap-field" :class="{ 'has-err': addErr.name }">
                    <label>POP Name<span class="req">*</span></label>
                    <input type="text" placeholder="Pop/Zone Name" x-model="addForm.name" @input="addErr.name = ''">
                    <span class="ap-err" x-text="addErr.name"></span>
                </div>
                <div class="ap-field" :class="{ 'has-err': addErr.manager }">
                    <label>Manager Name<span class="req">*</span></label>
                    <select x-model="addForm.manager" @change="addErr.manager = ''">
                        <option value="">Select an option</option>
                        <template x-for="m in managerOptions" :key="m">
                            <option :value="m" x-text="m"></option>
                        </template>
                    </select>
                    <span class="ap-err" x-text="addErr.manager"></span>
                </div>
                <div class="ap-field" :class="{ 'has-err': addErr.location }">
                    <label>POP Location<span class="req">*</span></label>
                    <input type="text" placeholder="pop_location" x-model="addForm.location" @input="addErr.location = ''">
                    <span class="ap-err" x-text="addErr.location"></span>
                </div>
                <div class="ap-field" :class="{ 'has-err': addErr.contact }">
                    <label>POP Contact<span class="req">*</span></label>
                    <input type="text" placeholder="pop_contact" x-model="addForm.contact" @input="addErr.contact = ''">
                    <span class="ap-err" x-text="addErr.contact"></span>
                </div>
                <div class="ap-field" :class="{ 'has-err': addErr.mikrotikIP }">
                    <label>Mikrotik IP<span class="req">*</span></label>
                    <select x-model="addForm.mikrotikIP" @change="addErr.mikrotikIP = ''">
                        <option value="">Select an option</option>
                        <template x-for="ip in mikrotikIPs" :key="ip">
                            <option :value="ip" x-text="ip"></option>
                        </template>
                    </select>
                    <span class="ap-err" x-text="addErr.mikrotikIP"></span>
                </div>
                <div class="ap-field" :class="{ 'has-err': addErr.longitude }">
                    <label>Longitude<span class="req">*</span></label>
                    <input type="text" placeholder="YY" x-model="addForm.longitude" @input="addErr.longitude = ''">
                    <span class="ap-err" x-text="addErr.longitude"></span>
                </div>
                <div class="ap-field" :class="{ 'has-err': addErr.latitude }">
                    <label>Latitude<span class="req">*</span></label>
                    <input type="text" placeholder="XX" x-model="addForm.latitude" @input="addErr.latitude = ''">
                    <span class="ap-err" x-text="addErr.latitude"></span>
                </div>
                <div class="ap-field">
                    <label>Sub Manager</label>
                    <select x-model="addForm.subManager">
                        <option value="No">No</option>
                        <option value="Yes">Yes</option>
                    </select>
                </div>
            </div>

            <hr class="ap-divider">

            <div class="ap-sec-title"><i class="fa fa-percent"></i> Gateway Charges In %</div>
            <div class="ap-grid">
                <div class="ap-field">
                    <label>Bkash</label>
                    <input type="number" min="0" step="0.01" placeholder="Bkash Charges" x-model.number="addForm.bkash">
                </div>
                <div class="ap-field">
                    <label>Nagad</label>
                    <input type="number" min="0" step="0.01" placeholder="Nagad Charges" x-model.number="addForm.nagad">
                </div>
                <div class="ap-field">
                    <label>Upay</label>
                    <input type="number" min="0" step="0.01" placeholder="Upay Charges" x-model.number="addForm.upay">
                </div>
            </div>
        </div>
        <div class="ap-foot">
            <button class="ap-btn-close" @click="addOpen = false">Close</button>
            <button class="ap-btn-save" @click="submitAdd()">
                <i class="fa fa-floppy-disk"></i> Save
            </button>
        </div>
    </div>
</div>

<!-- Pop Recharge Modal -->
<div class="ap-overlay" x-show="rcOpen" x-transition.opacity.duration.200ms @click.self="rcOpen = false" @keydown.escape.window="rcOpen = false">
    <div class="ap-modal pr-modal" x-show="rcOpen">
        <div class="ap-head pr-head">
            <div class="ap-head-icon"><i class="fa fa-credit-card"></i></div>
            <div class="ap-head-text">
                <h2>Pop Recharge</h2>
                <p>Add balance to a POP/Zone account</p>
            </div>
            <button class="ap-close" @click="rcOpen = false"><i class="fa fa-xmark"></i></button>
        </div>
        <div class="ap-body">
            <div class="ap-field" :class="{ 'has-err': rcErr.to }">
                <label>Recharge To</label>
                <select x-model="rcForm.to" @change="rcErr.to = ''">
                    <option value="">Select an option</option>
                    <template x-for="p in pops" :key="p.id">
                        <option :value="p.id" x-text="p.name"></option>
                    </template>
                </select>
                <span class="ap-err" x-text="rcErr.to"></span>
                <template x-if="rcPop">
                    <span class="pr-balance" :class="{ neg: rcPop.balance < 0 }">
                        <i class="fa fa-wallet"></i>
                        Current balance: ৳<span x-text="rcPop.balance.toFixed(2)"></span>
                    </span>
                </template>
            </div>
            <div class="ap-field" :class="{ 'has-err': rcErr.amount }">
                <label>Recharge Amount</label>
                <div class="pr-amount-wrap">
                    <span class="cur">৳</span>
                    <input type="number" min="1" placeholder="0.00" x-model.number="rcForm.amount" @input="rcErr.amount = ''">
                </div>
                <span class="ap-err" x-text="rcErr.amount"></span>
                <div class="pr-chips">
                    <template x-for="a in quickAmounts" :key="a">
                        <button type="button" class="pr-chip" :class="{ active: rcForm.amount === a }"
                                @click="rcForm.amount = a; rcErr.amount = ''" x-text="'৳' + a.toLocaleString()"></button>
                    </template>
                </div>
            </div>
            <div class="ap-field">
                <label>Remark</label>
                <input type="text" placeholder="e.g. Monthly bill payment" x-model="rcForm.remark">
            </div>
        </div>
        <div class="ap-foot">
            <button class="ap-btn-close" @click="rcOpen = false">Close</button>
            <button class="pr-btn-recharge" @click="submitRecharge()">
                <i class="fa fa-bolt"></i>
                <span x-text="rcForm.amount > 0 ? 'Recharge ৳' + Number(rcForm.amount).toLocaleString() : 'Recharge'"></span>
            </button>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="ap-toast" x-show="toastMsg" x-transition.opacity>
    <i class="fa fa-circle-check"></i>
    <span x-text="toastMsg"></span>
</div>

<script>
function popList() {
    return {
        query:       '',
        perPage:     100,
        currentPage: 1,

        addOpen:  false,
        addForm:  {},
        addErr:   {},
        toastMsg: '',

        rcOpen: false,
        rcForm: { to: '', amount: '', remark: '' },
        rcErr:  { to: '', amount: '' },
        quickAmounts: [500, 1000, 2000, 5000],

        get rcPop() {
            return this.pops.find(p => p.id == this.rcForm.to) || null;
        },
        mikrotikIPs: ['10.10.112.74', '103.180.204.129', '192.168.10.1', '172.16.0.1'],

        get managerOptions() {
            return [...new Set(this.pops.map(p => p.manager))];
        },

        pops: [
            {
                id: 7, name: 'Uttara-North POP',   manager: 'Uttara-Central',
                location: 'Uttara Sector 7, Dhaka', nasIP: '10.10.10.1',
                contact: '01711223344', subManager: true,  billGenerate: true,
                balance:  1200.00, totalCustomers: 312, smsStatus: true,
            },
            {
                id: 6, name: 'Mirpur-Central',      manager: 'Mirpur-North',
                location: 'Mirpur-10, Dhaka',       nasIP: '10.10.20.5',
                contact: '01812334455', subManager: false, billGenerate: true,
                balance:     0.00, totalCustomers:  74, smsStatus: true,
            },
            {
                id: 5, name: 'Gulshan Zone-A',      manager: 'Gulshan Premium',
                location: 'Gulshan Circle-2, Dhaka',nasIP: '192.168.5.1',
                contact: '01611556677', subManager: true,  billGenerate: true,
                balance:  -500.00, totalCustomers: 421, smsStatus: false,
            },
            {
                id: 4, name: 'Dhanmondi POP',       manager: 'Dhanmondi Hub',
                location: 'Dhanmondi Road 8, Dhaka',nasIP: '172.16.8.10',
                contact: '01912445566', subManager: false, billGenerate: false,
                balance:     0.00, totalCustomers:  58, smsStatus: true,
            },
            {
                id: 3, name: 'Sohel-Lahirirhat',    manager: 'LALMONIRHAT-2',
                location: 'Lahirirhat Rangpur Sadar Rangpur', nasIP: '10.10.112.74',
                contact: '01725672012', subManager: true,  billGenerate: true,
                balance:     0.00, totalCustomers: 137, smsStatus: true,
            },
            {
                id: 2, name: 'Lalmonirhat-2',       manager: 'LALMONIRHAT-2',
                location: 'Lalmonirhat',             nasIP: '103.180.204.129',
                contact: '01300532242', subManager: false, billGenerate: true,
                balance:     0.00, totalCustomers: 203, smsStatus: true,
            },
            {
                id: 1, name: 'Wari Zone',           manager: 'Wari Old Dhaka',
                location: 'Wari, Old Dhaka',         nasIP: '10.0.1.254',
                contact: '01500112233', subManager: false, billGenerate: true,
                balance:    80.00, totalCustomers:  49, smsStatus: false,
            },
        ],

        get filtered() {
            if (!this.query.trim()) return this.pops;
            const q = this.query.toLowerCase();
            return this.pops.filter(p =>
                p.name.toLowerCase().includes(q)     ||
                p.manager.toLowerCase().includes(q)  ||
                p.location.toLowerCase().includes(q) ||
                p.nasIP.includes(q)                  ||
                p.contact.includes(q)                ||
                String(p.id).includes(q)
            );
        },

        get totalPages() {
            return Math.max(1, Math.ceil(this.filtered.length / this.perPage));
        },

        get paginated() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filtered.slice(start, start + this.perPage);
        },

        get infoText() {
            if (this.filtered.length === 0) return 'No entries found';
            const start = (this.currentPage - 1) * this.perPage + 1;
            const end   = Math.min(this.currentPage * this.perPage, this.filtered.length);
            return `Showing ${start} to ${end} of ${this.filtered.length} entries`;
        },

        openAdd() {
            this.addForm = {
                name: '', manager: '', location: '', contact: '',
                mikrotikIP: '', longitude: '', latitude: '', subManager: 'No',
                bkash: '', nagad: '', upay: '',
            };
            this.addErr  = {};
            this.addOpen = true;
        },

        submitAdd() {
            const f = this.addForm;
            const err = {};
            if (!f.name.trim())      err.name       = 'POP name is required';
            if (!f.manager)          err.manager    = 'Please select a manager';
            if (!f.location.trim())  err.location   = 'Location is required';
            if (!f.contact.trim())   err.contact    = 'Contact is required';
            if (!f.mikrotikIP)       err.mikrotikIP = 'Please select a Mikrotik IP';
            if (!f.longitude.trim()) err.longitude  = 'Longitude is required';
            if (!f.latitude.trim())  err.latitude   = 'Latitude is required';
            this.addErr = err;
            if (Object.keys(err).length) return;

            this.pops.unshift({
                id: Math.max(0, ...this.pops.map(p => p.id)) + 1,
                name: f.name.trim(),
                manager: f.manager,
                location: f.location.trim(),
                nasIP: f.mikrotikIP,
                contact: f.contact.trim(),
                subManager: f.subManager === 'Yes',
                billGenerate: true,
                balance: 0,
                totalCustomers: 0,
                smsStatus: true,
            });
            this.addOpen = false;
            this.showToast(`POP "${f.name.trim()}" added`);
        },

        openRecharge() {
            this.rcForm = { to: '', amount: '', remark: '' };
            this.rcErr  = { to: '', amount: '' };
            this.rcOpen = true;
        },

        submitRecharge() {
            const f = this.rcForm;
            const err = {};
            if (!f.to)                              err.to = 'Please select a POP';
            if (!f.amount || Number(f.amount) <= 0) err.amount = 'Enter a valid amount';
            this.rcErr = err;
            if (Object.keys(err).length) return;

            const pop = this.pops.find(p => p.id == f.to);
            if (pop) pop.balance += Number(f.amount);
            this.rcOpen = false;
            this.showToast(`${pop ? pop.name : 'POP'} recharged ৳${Number(f.amount).toFixed(2)}`);
        },

        showToast(msg) {
            this.toastMsg = msg;
            setTimeout(() => { this.toastMsg = ''; }, 2800);
        },
    };
}
</script>
</body>
</html>
