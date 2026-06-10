<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manager List</title>
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

        /* ── PAGE ── */
        .page-wrap { max-width: 1440px; margin: 0 auto; padding: 20px 16px 60px; }

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
            font-size: 19px;
            font-weight: 800;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: -.3px;
        }

        .page-title-icon {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #1D4ED8 0%, #3B82F6 100%);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 14px;
            box-shadow: 0 2px 8px rgba(37,99,235,.3);
            flex-shrink: 0;
        }

        .total-badge {
            padding: 4px 12px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-2);
            box-shadow: var(--shadow);
            white-space: nowrap;
        }

        .total-badge span { color: var(--primary); font-weight: 700; }

        .btn-mgr-recharge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0 18px;
            height: 38px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(37,99,235,.28);
            transition: background .15s;
            white-space: nowrap;
        }

        .btn-mgr-recharge:hover { background: var(--primary-dark); }

        .btn-add-mgr {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0 18px;
            height: 38px;
            background: var(--success);
            color: #fff;
            border: none;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(5,150,105,.28);
            transition: filter .15s;
            white-space: nowrap;
        }

        .btn-add-mgr:hover { filter: brightness(1.08); }

        /* ── MAIN CARD ── */
        .table-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        /* ── TABLE CONTROLS ── */
        .tbl-controls {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            background: #FAFBFC;
        }

        .tbl-ctrl-left {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-2);
        }

        .tbl-ctrl-left select {
            height: 30px;
            padding: 0 24px 0 8px;
            border: 1.5px solid var(--border);
            border-radius: 7px;
            font-size: 12.5px;
            font-family: inherit;
            color: var(--text);
            background: var(--surface);
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='5' viewBox='0 0 9 5'%3E%3Cpath d='M1 1l3.5 3L8 1' stroke='%2394A3B8' stroke-width='1.4' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
            cursor: pointer;
            transition: border-color .15s;
        }

        .tbl-ctrl-left select:focus { outline: none; border-color: var(--primary); }

        .search-wrap { position: relative; }

        .search-wrap i {
            position: absolute;
            left: 10px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-3); font-size: 12px;
            pointer-events: none;
        }

        .search-wrap input {
            height: 30px;
            width: 220px;
            padding: 0 10px 0 30px;
            border: 1.5px solid var(--border);
            border-radius: 7px;
            font-size: 12.5px;
            font-family: inherit;
            color: var(--text);
            background: var(--surface);
            transition: border-color .15s, box-shadow .15s;
        }

        .search-wrap input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2.5px rgba(37,99,235,.1);
        }

        .search-wrap input::placeholder { color: var(--text-3); }

        /* ══════════════════════════════
           DESKTOP TABLE
        ══════════════════════════════ */
        .tbl-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 860px; }

        thead th {
            background: var(--th-bg);
            color: var(--th-text);
            font-size: 11.5px;
            font-weight: 700;
            letter-spacing: .4px;
            text-transform: uppercase;
            padding: 11px 14px;
            text-align: left;
            white-space: nowrap;
        }

        thead th.col-center { text-align: center; }

        tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--row-hover); }

        tbody td { padding: 11px 14px; color: var(--text); vertical-align: middle; }
        tbody td.col-center { text-align: center; }
        tbody td.col-muted  { color: var(--text-2); }

        /* ── SHARED COMPONENTS ── */
        .id-cell {
            font-size: 12px; font-weight: 700; color: var(--text-3);
            background: var(--bg); border-radius: 6px;
            padding: 3px 7px; display: inline-block;
        }

        .mgr-name { font-weight: 600; color: var(--text); font-size: 13px; }

        .btn-recharge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 0 11px; height: 26px;
            background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);
            color: #fff; border: none; border-radius: 6px;
            font-size: 11.5px; font-weight: 600; font-family: inherit;
            cursor: pointer; white-space: nowrap;
            box-shadow: 0 1px 4px rgba(220,38,38,.3);
            transition: filter .15s, transform .1s;
        }

        .btn-recharge:hover  { filter: brightness(1.08); }
        .btn-recharge:active { transform: scale(.96); }

        .type-badge {
            display: inline-flex; align-items: center;
            padding: 2px 9px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600; text-transform: capitalize;
        }

        .type-own    { background: #EFF6FF; color: #2563EB; border: 1px solid #BFDBFE; }
        .type-other  { background: #F5F3FF; color: #7C3AED; border: 1px solid #DDD6FE; }
        .type-resell { background: #FFF7ED; color: #EA580C; border: 1px solid #FED7AA; }

        .balance-cell { font-weight: 600; font-size: 13px; font-variant-numeric: tabular-nums; }
        .balance-zero { color: var(--text-3); }
        .balance-pos  { color: var(--success); }
        .balance-neg  { color: var(--danger); }

        .cust-count { display: inline-flex; align-items: center; gap: 5px; font-weight: 700; font-size: 13px; color: var(--primary); }
        .cust-count i { font-size: 10px; opacity: .6; }

        .status-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600;
        }

        .status-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .st-active    { background: var(--success-bg); color: var(--success);  border: 1px solid #A7F3D0; }
        .st-active::before    { background: var(--success); }
        .st-inactive  { background: var(--danger-bg);  color: var(--danger);   border: 1px solid #FECACA; }
        .st-inactive::before  { background: var(--danger); }
        .st-suspended { background: var(--warning-bg); color: var(--warning);  border: 1px solid #FDE68A; }
        .st-suspended::before { background: var(--warning); }

        .remark-cell {
            max-width: 160px; overflow: hidden;
            text-overflow: ellipsis; white-space: nowrap;
            color: var(--text-2); font-size: 12.5px;
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
            min-width: 170px; padding: 5px;
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
        .empty-row td {
            padding: 50px 20px; text-align: center;
            color: var(--text-3); font-size: 13.5px;
        }

        .empty-row td i { display: block; font-size: 28px; opacity: .2; margin-bottom: 10px; }

        /* ── TABLE FOOTER ── */
        .tbl-footer {
            padding: 12px 16px;
            border-top: 1px solid var(--border);
            background: #FAFBFC;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
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
           MOBILE: CARD LAYOUT  ≤ 700px
        ══════════════════════════════ */
        @media (max-width: 700px) {

            .page-wrap { padding: 14px 12px 60px; }

            /* Header: stack title-group and button */
            .page-header { gap: 10px; }
            .btn-mgr-recharge { width: 100%; justify-content: center; height: 40px; }

            /* Controls: stack show + search */
            .tbl-controls { flex-direction: column; align-items: stretch; gap: 8px; }
            .tbl-ctrl-left { justify-content: flex-start; }
            .search-wrap { width: 100%; }
            .search-wrap input { width: 100%; }

            /* Switch from scroll-table to card list */
            .tbl-wrap { overflow-x: unset; }
            table   { min-width: unset; border-collapse: collapse; }
            thead   { display: none; }

            /* Each row = a card */
            tbody tr {
                display: block;
                border: 1px solid var(--border);
                border-radius: 12px;
                margin: 0 0 12px;
                box-shadow: var(--shadow);
                overflow: hidden;
                border-bottom: 1px solid var(--border) !important;
            }

            /* All cells: key-value rows */
            tbody td {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
                padding: 9px 14px;
                border-bottom: 1px solid #F1F5F9;
                text-align: right;
            }

            tbody td:last-child { border-bottom: none; }

            /* Label from data-label */
            tbody td[data-label]::before {
                content: attr(data-label);
                font-size: 11px;
                font-weight: 700;
                color: var(--text-3);
                text-transform: uppercase;
                letter-spacing: .5px;
                text-align: left;
                flex: 1;
                white-space: nowrap;
            }

            /* Card header row: ID + Manager Name */
            tbody td.mob-head {
                background: var(--th-bg);
                padding: 11px 14px;
                gap: 10px;
            }

            tbody td.mob-head::before { display: none; }

            tbody td.mob-head .id-cell {
                background: rgba(255,255,255,.15);
                color: rgba(255,255,255,.7);
                font-size: 11px;
                flex-shrink: 0;
            }

            tbody td.mob-head .mgr-name {
                color: #fff;
                font-size: 14px;
                font-weight: 700;
                flex: 1;
            }

            /* Status badge in the header row */
            tbody td.mob-head .status-badge {
                flex-shrink: 0;
            }

            /* Recharge + Action footer: side-by-side */
            tbody td.mob-recharge,
            tbody td.mob-action {
                display: inline-flex;
                width: 50%;
                padding: 10px 12px;
                border-bottom: none;
                justify-content: center;
                align-items: center;
                background: #FAFBFC;
            }

            tbody td.mob-recharge {
                border-right: 1px solid #F1F5F9;
                border-top: 1px solid #F1F5F9;
            }

            tbody td.mob-action {
                border-top: 1px solid #F1F5F9;
            }

            tbody td.mob-recharge::before,
            tbody td.mob-action::before { display: none; }

            tbody td.mob-recharge .btn-recharge {
                width: 100%; justify-content: center; height: 32px;
            }

            tbody td.mob-action .btn-action {
                width: 100%; justify-content: center; height: 32px;
            }

            tbody td.mob-action .action-wrap { width: 100%; }
            tbody td.mob-action .dropdown-menu { left: 0; right: 0; width: 100%; }

            /* Remark: allow wrap on mobile */
            .remark-cell { max-width: unset; white-space: normal; }

            /* Footer: stack info + pagination */
            .tbl-footer { flex-direction: column; align-items: stretch; }
            .pagination { justify-content: center; }
        }

        /* ── TABLET: just scroll ── */
        @media (min-width: 701px) and (max-width: 1024px) {
            .tbl-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
            .search-wrap input { width: 180px; }
        }
        /* ── RECHARGE MODAL ── */
        .rc-overlay {
            position: fixed; inset: 0;
            background: rgba(15,23,42,.6);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            display: flex; align-items: center; justify-content: center;
            z-index: 500;
            padding: 24px 16px;
        }

        @keyframes rc-pop {
            from { opacity: 0; transform: translateY(14px) scale(.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .rc-modal {
            background: var(--surface);
            border-radius: 18px;
            width: 100%;
            max-width: 540px;
            box-shadow: 0 32px 80px rgba(15,23,42,.32);
            overflow: hidden;
            animation: rc-pop .25s cubic-bezier(.21,1.02,.55,1);
            max-height: 92vh;
            display: flex; flex-direction: column;
        }

        .rc-head {
            display: flex; align-items: center; gap: 14px;
            padding: 20px 24px;
            background: linear-gradient(135deg, #1D4ED8 0%, #3B82F6 60%, #60A5FA 100%);
            position: relative;
            flex-shrink: 0;
        }

        .rc-head::after {
            content: '';
            position: absolute; right: -30px; top: -40px;
            width: 150px; height: 150px;
            background: rgba(255,255,255,.08);
            border-radius: 50%;
            pointer-events: none;
        }

        .rc-head-icon {
            width: 42px; height: 42px;
            background: rgba(255,255,255,.18);
            border: 1px solid rgba(255,255,255,.25);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 17px;
            flex-shrink: 0;
        }

        .rc-head-text { flex: 1; min-width: 0; }
        .rc-head-text h2 { font-size: 18px; font-weight: 800; color: #fff; letter-spacing: -.3px; line-height: 1.2; }
        .rc-head-text p  { font-size: 12px; color: rgba(255,255,255,.75); margin-top: 2px; }

        .rc-close {
            background: rgba(255,255,255,.18);
            border: none; cursor: pointer;
            font-size: 14px; color: #fff;
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            transition: background .15s;
            flex-shrink: 0;
            position: relative; z-index: 1;
        }

        .rc-close:hover { background: rgba(255,255,255,.32); }

        .rc-body { padding: 24px; display: flex; flex-direction: column; gap: 18px; overflow-y: auto; }

        .rc-field { display: flex; flex-direction: column; gap: 6px; min-width: 0; }

        .rc-field > label {
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .6px;
            color: var(--text-2);
        }

        .rc-field > label .req { color: var(--danger); }

        .rc-field select,
        .rc-field input {
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

        .rc-field select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='6' viewBox='0 0 11 6'%3E%3Cpath d='M1 1l4.5 4L10 1' stroke='%2394A3B8' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }

        .rc-field select:focus,
        .rc-field input:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37,99,235,.1);
        }

        .rc-field.has-err select,
        .rc-field.has-err input { border-color: var(--danger); background: #fff; }

        .rc-err { font-size: 12px; color: var(--danger); display: none; }
        .rc-field.has-err .rc-err { display: block; }

        /* balance preview chip */
        .rc-balance {
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

        .rc-balance.neg { background: var(--danger-bg); border-color: #FECACA; color: var(--danger); }

        /* amount with currency prefix */
        .rc-amount-wrap { position: relative; }

        .rc-amount-wrap .cur {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            font-size: 15px; font-weight: 700; color: var(--text-3);
            pointer-events: none;
        }

        .rc-amount-wrap input { padding-left: 34px; font-weight: 600; font-size: 15px; }

        /* quick amount chips */
        .rc-chips { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }

        .rc-chip {
            padding: 6px 14px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 20px;
            font-size: 12.5px; font-weight: 600; font-family: inherit;
            color: var(--text-2);
            cursor: pointer;
            transition: all .15s;
        }

        .rc-chip:hover { border-color: var(--primary); color: var(--primary); }

        .rc-chip.active {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            box-shadow: 0 2px 8px rgba(37,99,235,.3);
        }

        .rc-foot {
            display: flex; align-items: center; justify-content: flex-end; gap: 10px;
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            background: #FAFBFC;
            flex-shrink: 0;
        }

        .rc-btn-close {
            padding: 0 20px; height: 44px;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 11px;
            font-size: 14px; font-weight: 600; font-family: inherit;
            color: var(--text-2);
            cursor: pointer;
            transition: all .15s;
        }

        .rc-btn-close:hover { border-color: var(--text-3); color: var(--text); }

        .rc-btn-recharge {
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

        .rc-btn-recharge:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(37,99,235,.45); }
        .rc-btn-recharge:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        /* ── ADD MANAGER MODAL ── */
        .am-modal { max-width: 880px; }

        .am-head { background: linear-gradient(135deg, #047857 0%, #059669 60%, #34D399 100%); }

        .am-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }

        .am-divider { border: none; border-top: 1px solid var(--border); margin: 4px 0; }

        .am-sec-title {
            font-size: 12px; font-weight: 800;
            text-transform: uppercase; letter-spacing: .8px;
            color: var(--text-2);
            display: flex; align-items: center; gap: 8px;
        }

        .am-sec-title i { color: var(--success); }

        .rc-field input[type="file"] {
            padding: 0;
            background: #F8FAFC;
            cursor: pointer;
            display: flex; align-items: center;
        }

        .rc-field input[type="file"]::file-selector-button {
            height: 100%;
            padding: 0 14px;
            margin-right: 12px;
            border: none;
            border-right: 1.5px solid var(--border);
            background: var(--surface);
            font-size: 13px; font-weight: 600; font-family: inherit;
            color: var(--text-2);
            cursor: pointer;
            transition: background .15s;
        }

        .rc-field input[type="file"]::file-selector-button:hover { background: var(--bg); }

        .am-btn-save {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 0 26px; height: 44px;
            background: linear-gradient(135deg, #059669, #047857);
            border: none;
            border-radius: 11px;
            font-size: 14px; font-weight: 700; font-family: inherit;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(5,150,105,.35);
            transition: transform .15s, box-shadow .15s;
        }

        .am-btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(5,150,105,.45); }

        .am-btn-reset {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 0 20px; height: 44px;
            background: linear-gradient(135deg, #14B8A6, #0D9488);
            border: none;
            border-radius: 11px;
            font-size: 14px; font-weight: 600; font-family: inherit;
            color: #fff;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(20,184,166,.3);
            transition: transform .15s;
        }

        .am-btn-reset:hover { transform: translateY(-1px); }

        @media (max-width: 860px) { .am-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 560px) { .am-grid { grid-template-columns: 1fr; } }

        /* ── TOAST ── */
        .rc-toast {
            position: fixed; bottom: 24px; right: 24px; z-index: 999;
            padding: 12px 18px;
            background: var(--success);
            color: #fff;
            border-radius: 10px;
            font-size: 13.5px; font-weight: 600;
            box-shadow: 0 6px 24px rgba(0,0,0,.18);
            display: flex; align-items: center; gap: 8px;
        }
    </style>
</head>
<body x-data="managerList()" x-cloak>

<div class="page-wrap">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">
                <div class="page-title-icon"><i class="fa fa-users-gear"></i></div>
                Manager List
            </h1>
            <div class="total-badge">Total Manager: <span x-text="managers.length"></span></div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
            <button class="btn-add-mgr" @click="openAdd()">
                <i class="fa fa-user-plus"></i> Add Manager
            </button>
            <button class="btn-mgr-recharge" @click="openRecharge()">
                <i class="fa fa-credit-card"></i> Manager Recharge
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
                        <th style="width:52px">ID</th>
                        <th>Manager Name</th>
                        <th style="width:145px">Online Recharge</th>
                        <th>Reseller Type</th>
                        <th>Address</th>
                        <th>Contact No</th>
                        <th class="col-center">Balance</th>
                        <th class="col-center">Total Customers</th>
                        <th>Remark</th>
                        <th class="col-center">Status</th>
                        <th class="col-center" style="width:100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-if="paginated.length === 0">
                        <tr class="empty-row">
                            <td colspan="11">
                                <i class="fa fa-users-slash"></i>
                                No managers found
                            </td>
                        </tr>
                    </template>

                    <template x-for="mgr in paginated" :key="mgr.id">
                        <tr>

                            <!-- ID — on mobile merged into mob-head, hidden separately -->
                            <td data-label="ID" class="mob-head" style="display:none">
                                <!-- spacer: mob-head td below holds both -->
                            </td>

                            <!-- Manager Name + ID badge (card header on mobile) -->
                            <td data-label="Manager" class="mob-head">
                                <span class="id-cell" x-text="'#' + mgr.id"></span>
                                <span class="mgr-name" x-text="mgr.name"></span>
                                <!-- Status shown in header on mobile only -->
                                <span
                                    class="status-badge"
                                    :class="{
                                        'st-active':    mgr.status === 'Active',
                                        'st-inactive':  mgr.status === 'Inactive',
                                        'st-suspended': mgr.status === 'Suspended'
                                    }"
                                    x-text="mgr.status"
                                    style="display:none"
                                ></span>
                            </td>

                            <!-- Online Recharge -->
                            <td data-label="Recharge" class="mob-recharge">
                                <button class="btn-recharge">
                                    <i class="fa fa-bolt"></i> Online Recharge
                                </button>
                            </td>

                            <!-- Reseller Type -->
                            <td data-label="Type">
                                <span
                                    class="type-badge"
                                    :class="{
                                        'type-own':    mgr.type === 'own',
                                        'type-other':  mgr.type === 'other',
                                        'type-resell': mgr.type === 'reseller'
                                    }"
                                    x-text="mgr.type"
                                ></span>
                            </td>

                            <!-- Address -->
                            <td data-label="Address" class="col-muted" x-text="mgr.address"></td>

                            <!-- Contact -->
                            <td data-label="Contact" x-text="mgr.contact"></td>

                            <!-- Balance -->
                            <td data-label="Balance" class="col-center">
                                <span
                                    class="balance-cell"
                                    :class="{
                                        'balance-zero': mgr.balance == 0,
                                        'balance-pos':  mgr.balance > 0,
                                        'balance-neg':  mgr.balance < 0
                                    }"
                                    x-text="mgr.balance.toFixed(2)"
                                ></span>
                            </td>

                            <!-- Total Customers -->
                            <td data-label="Customers" class="col-center">
                                <span class="cust-count">
                                    <i class="fa fa-user"></i>
                                    <span x-text="mgr.totalCustomers"></span>
                                </span>
                            </td>

                            <!-- Remark -->
                            <td data-label="Remark">
                                <div class="remark-cell" :title="mgr.remark" x-text="mgr.remark || '—'"></div>
                            </td>

                            <!-- Status (desktop only — on mobile shown in mob-head) -->
                            <td data-label="Status" class="col-center mob-status-desktop">
                                <span
                                    class="status-badge"
                                    :class="{
                                        'st-active':    mgr.status === 'Active',
                                        'st-inactive':  mgr.status === 'Inactive',
                                        'st-suspended': mgr.status === 'Suspended'
                                    }"
                                    x-text="mgr.status"
                                ></span>
                            </td>

                            <!-- Action -->
                            <td data-label="Action" class="col-center mob-action">
                                <div class="action-wrap" x-data="{ open: false }">
                                    <div x-show="open" class="dd-overlay" @click="open = false"></div>
                                    <button
                                        class="btn-action"
                                        :class="{ open }"
                                        @click="open = !open"
                                    >
                                        Action <i class="fa fa-chevron-down chevron"></i>
                                    </button>
                                    <div class="dropdown-menu" x-show="open" x-transition>
                                        <button class="dd-item" @click="open=false"><i class="fa fa-eye"></i> View Details</button>
                                        <button class="dd-item" @click="open=false"><i class="fa fa-pen-to-square"></i> Edit</button>
                                        <button class="dd-item" @click="open=false"><i class="fa fa-users"></i> View Customers</button>
                                        <button class="dd-item" @click="open=false"><i class="fa fa-credit-card"></i> Recharge History</button>
                                        <div class="dd-divider"></div>
                                        <button class="dd-item" @click="open=false">
                                            <i class="fa fa-toggle-off"></i>
                                            <span x-text="mgr.status === 'Active' ? 'Deactivate' : 'Activate'"></span>
                                        </button>
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

<!-- Manager Recharge Modal -->
<div class="rc-overlay" x-show="rechargeOpen" x-transition.opacity.duration.200ms @click.self="rechargeOpen = false" @keydown.escape.window="rechargeOpen = false">
    <div class="rc-modal" x-show="rechargeOpen">
        <div class="rc-head">
            <div class="rc-head-icon"><i class="fa fa-credit-card"></i></div>
            <div class="rc-head-text">
                <h2>Manager Recharge</h2>
                <p>Add balance to a manager's account</p>
            </div>
            <button class="rc-close" @click="rechargeOpen = false"><i class="fa fa-xmark"></i></button>
        </div>
        <div class="rc-body">
            <div class="rc-field" :class="{ 'has-err': rechargeErr.to }">
                <label>Recharge To</label>
                <select x-model="rechargeForm.to" @change="rechargeErr.to = ''">
                    <option value="">Select an option</option>
                    <template x-for="m in managers" :key="m.id">
                        <option :value="m.id" x-text="m.name"></option>
                    </template>
                </select>
                <span class="rc-err" x-text="rechargeErr.to"></span>
                <template x-if="rechargeManager">
                    <span class="rc-balance" :class="{ neg: rechargeManager.balance < 0 }">
                        <i class="fa fa-wallet"></i>
                        Current balance: ৳<span x-text="rechargeManager.balance.toFixed(2)"></span>
                    </span>
                </template>
            </div>
            <div class="rc-field" :class="{ 'has-err': rechargeErr.amount }">
                <label>Recharge Amount</label>
                <div class="rc-amount-wrap">
                    <span class="cur">৳</span>
                    <input type="number" min="1" placeholder="0.00" x-model.number="rechargeForm.amount" @input="rechargeErr.amount = ''">
                </div>
                <span class="rc-err" x-text="rechargeErr.amount"></span>
                <div class="rc-chips">
                    <template x-for="a in quickAmounts" :key="a">
                        <button type="button" class="rc-chip" :class="{ active: rechargeForm.amount === a }"
                                @click="rechargeForm.amount = a; rechargeErr.amount = ''" x-text="'৳' + a.toLocaleString()"></button>
                    </template>
                </div>
            </div>
            <div class="rc-field" :class="{ 'has-err': rechargeErr.remark }">
                <label>Remark<span class="req">*</span></label>
                <input type="text" placeholder="e.g. Monthly bill payment" x-model="rechargeForm.remark" @input="rechargeErr.remark = ''">
                <span class="rc-err" x-text="rechargeErr.remark"></span>
            </div>
        </div>
        <div class="rc-foot">
            <button class="rc-btn-close" @click="rechargeOpen = false">Close</button>
            <button class="rc-btn-recharge" @click="submitRecharge()">
                <i class="fa fa-bolt"></i>
                <span x-text="rechargeForm.amount > 0 ? 'Recharge ৳' + Number(rechargeForm.amount).toLocaleString() : 'Recharge'"></span>
            </button>
        </div>
    </div>
</div>

<!-- Add Manager Modal -->
<div class="rc-overlay" x-show="addOpen" x-transition.opacity.duration.200ms @click.self="addOpen = false" @keydown.escape.window="addOpen = false">
    <div class="rc-modal am-modal" x-show="addOpen">
        <div class="rc-head am-head">
            <div class="rc-head-icon"><i class="fa fa-user-plus"></i></div>
            <div class="rc-head-text">
                <h2>Add New Manager</h2>
                <p>Create a new manager / reseller account</p>
            </div>
            <button class="rc-close" @click="addOpen = false"><i class="fa fa-xmark"></i></button>
        </div>
        <div class="rc-body">
            <div class="am-grid">
                <div class="rc-field" :class="{ 'has-err': addErr.name }">
                    <label>Manager Name<span class="req">*</span></label>
                    <input type="text" placeholder="Manager Name" x-model="addForm.name" @input="addErr.name = ''">
                    <span class="rc-err" x-text="addErr.name"></span>
                </div>
                <div class="rc-field" :class="{ 'has-err': addErr.type }">
                    <label>Manager Type<span class="req">*</span></label>
                    <select x-model="addForm.type" @change="addErr.type = ''">
                        <option value="">Select an option</option>
                        <option value="own">Own</option>
                        <option value="reseller">Reseller</option>
                        <option value="other">Other</option>
                    </select>
                    <span class="rc-err" x-text="addErr.type"></span>
                </div>
                <div class="rc-field" :class="{ 'has-err': addErr.contact }">
                    <label>Contact<span class="req">*</span></label>
                    <input type="text" placeholder="Contact" x-model="addForm.contact" @input="addErr.contact = ''">
                    <span class="rc-err" x-text="addErr.contact"></span>
                </div>
                <div class="rc-field" :class="{ 'has-err': addErr.address }">
                    <label>Address<span class="req">*</span></label>
                    <input type="text" placeholder="Address" x-model="addForm.address" @input="addErr.address = ''">
                    <span class="rc-err" x-text="addErr.address"></span>
                </div>
                <div class="rc-field">
                    <label>Remark</label>
                    <input type="text" placeholder="remark" x-model="addForm.remark">
                </div>
                <div class="rc-field">
                    <label>Upload File</label>
                    <input type="file">
                </div>
                <div class="rc-field">
                    <label>Manager Miscellaneous Expense</label>
                    <input type="number" min="0" placeholder="Commission in percentage" x-model.number="addForm.expense">
                </div>
                <div class="rc-field">
                    <label>Bank Name</label>
                    <input type="text" placeholder="Bank Name" x-model="addForm.bankName">
                </div>
                <div class="rc-field">
                    <label>Branch Name</label>
                    <input type="text" placeholder="Branch Name" x-model="addForm.branchName">
                </div>
                <div class="rc-field">
                    <label>Routing Number</label>
                    <input type="text" placeholder="Routing Number" x-model="addForm.routingNo">
                </div>
                <div class="rc-field">
                    <label>Bank Account No</label>
                    <input type="text" placeholder="Bank Account No" x-model="addForm.accountNo">
                </div>
                <div class="rc-field">
                    <label>Account Name</label>
                    <input type="text" placeholder="Account Name" x-model="addForm.accountName">
                </div>
            </div>

            <hr class="am-divider">

            <div class="am-sec-title"><i class="fa fa-percent"></i> Gateway Charges In %</div>
            <div class="am-grid">
                <div class="rc-field">
                    <label>Bkash</label>
                    <input type="number" min="0" step="0.01" placeholder="Bkash Charges" x-model.number="addForm.bkash">
                </div>
                <div class="rc-field">
                    <label>Nagad</label>
                    <input type="number" min="0" step="0.01" placeholder="Nagad Charges" x-model.number="addForm.nagad">
                </div>
                <div class="rc-field">
                    <label>Upay</label>
                    <input type="number" min="0" step="0.01" placeholder="Upay Charges" x-model.number="addForm.upay">
                </div>
            </div>
        </div>
        <div class="rc-foot">
            <button class="am-btn-reset" @click="resetAdd()">
                <i class="fa fa-rotate-left"></i> Reset
            </button>
            <button class="am-btn-save" @click="submitAdd()">
                <i class="fa fa-floppy-disk"></i> Save
            </button>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="rc-toast" x-show="toastMsg" x-transition.opacity>
    <i class="fa fa-circle-check"></i>
    <span x-text="toastMsg"></span>
</div>

<style>
    /* Show status badge in mob-head only on mobile */
    @media (max-width: 700px) {
        tbody td.mob-head .status-badge { display: inline-flex !important; }
        tbody td.mob-status-desktop { display: none !important; }
        /* Hide the redundant first ID cell */
        tbody td[data-label="ID"] { display: none !important; }
    }
</style>

<script>
function managerList() {
    return {
        query:       '',
        perPage:     100,
        currentPage: 1,

        rechargeOpen: false,
        rechargeForm: { to: '', amount: '', remark: '' },
        rechargeErr:  { to: '', amount: '', remark: '' },
        quickAmounts: [500, 1000, 2000, 5000],
        toastMsg:     '',

        addOpen: false,
        addForm: {},
        addErr:  {},

        get rechargeManager() {
            return this.managers.find(m => m.id == this.rechargeForm.to) || null;
        },

        managers: [
            { id: 8, name: 'Uttara-Central',  type: 'own',      address: 'Uttara Sector 7',      contact: '01711223344', balance:  2500.00, totalCustomers: 312, remark: 'High traffic zone',    status: 'Active'    },
            { id: 7, name: 'Mirpur-North',     type: 'reseller', address: 'Mirpur-12, Dhaka',     contact: '01812334455', balance:   750.50, totalCustomers: 198, remark: 'Needs router upgrade', status: 'Active'    },
            { id: 6, name: 'Dhanmondi Hub',    type: 'own',      address: 'Dhanmondi Road 8',     contact: '01912445566', balance:     0.00, totalCustomers:  87, remark: '',                     status: 'Suspended' },
            { id: 5, name: 'Gulshan Premium',  type: 'reseller', address: 'Gulshan Avenue',       contact: '01611556677', balance: -1200.00, totalCustomers: 421, remark: 'Payment overdue',      status: 'Active'    },
            { id: 4, name: 'Demo Other',       type: 'other',    address: 'Nabonagar',            contact: '01681046437', balance:     0.00, totalCustomers:  24, remark: 'remarks',              status: 'Active'    },
            { id: 3, name: 'Dacey Morris',     type: 'own',      address: 'Mollit ut culpa ali',  contact: '01681046437', balance:     0.00, totalCustomers:  87, remark: 'Reprehenderit earum',  status: 'Active'    },
            { id: 2, name: 'LALMONIRHAT-2',    type: 'own',      address: 'Lalmonirhat',          contact: '01300532242', balance:     0.00, totalCustomers: 156, remark: 'Zzz',                  status: 'Active'    },
            { id: 1, name: 'Wari Old Dhaka',   type: 'other',    address: 'Wari, Dhaka',          contact: '01500112233', balance:   180.00, totalCustomers:  63, remark: '',                     status: 'Inactive'  },
        ],

        get filtered() {
            if (!this.query.trim()) return this.managers;
            const q = this.query.toLowerCase();
            return this.managers.filter(m =>
                m.name.toLowerCase().includes(q)    ||
                m.address.toLowerCase().includes(q) ||
                m.contact.includes(q)               ||
                m.type.toLowerCase().includes(q)    ||
                m.status.toLowerCase().includes(q)  ||
                String(m.id).includes(q)
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

        openRecharge() {
            this.rechargeForm = { to: '', amount: '', remark: '' };
            this.rechargeErr  = { to: '', amount: '', remark: '' };
            this.rechargeOpen = true;
        },

        submitRecharge() {
            const f = this.rechargeForm;
            let ok = true;
            if (!f.to)                              { this.rechargeErr.to = 'Please select a manager';  ok = false; }
            if (!f.amount || Number(f.amount) <= 0) { this.rechargeErr.amount = 'Enter a valid amount'; ok = false; }
            if (!f.remark.trim())                   { this.rechargeErr.remark = 'Remark is required';   ok = false; }
            if (!ok) return;

            const mgr = this.managers.find(m => m.id == f.to);
            if (mgr) mgr.balance += Number(f.amount);
            this.rechargeOpen = false;
            this.showToast(`${mgr ? mgr.name : 'Manager'} recharged ${Number(f.amount).toFixed(2)}`);
        },

        showToast(msg) {
            this.toastMsg = msg;
            setTimeout(() => { this.toastMsg = ''; }, 2800);
        },

        blankAddForm() {
            return {
                name: '', type: '', contact: '', address: '', remark: '',
                expense: '', bankName: '', branchName: '', routingNo: '',
                accountNo: '', accountName: '', bkash: '', nagad: '', upay: '',
            };
        },

        openAdd() {
            this.addForm = this.blankAddForm();
            this.addErr  = {};
            this.addOpen = true;
        },

        resetAdd() {
            this.addForm = this.blankAddForm();
            this.addErr  = {};
        },

        submitAdd() {
            const f = this.addForm;
            const err = {};
            if (!f.name.trim())    err.name    = 'Manager name is required';
            if (!f.type)           err.type    = 'Please select a type';
            if (!f.contact.trim()) err.contact = 'Contact is required';
            if (!f.address.trim()) err.address = 'Address is required';
            this.addErr = err;
            if (Object.keys(err).length) return;

            this.managers.unshift({
                id: Math.max(0, ...this.managers.map(m => m.id)) + 1,
                name: f.name.trim(),
                type: f.type,
                address: f.address.trim(),
                contact: f.contact.trim(),
                balance: 0,
                totalCustomers: 0,
                remark: f.remark.trim(),
                status: 'Active',
            });
            this.addOpen = false;
            this.showToast(`Manager "${f.name.trim()}" added`);
        },
    };
}
</script>
</body>
</html>
