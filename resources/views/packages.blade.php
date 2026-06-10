<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Packages List</title>
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
            --violet:        #7C3AED;
            --violet-bg:     #F5F3FF;
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

        .page-wrap { max-width: 1320px; margin: 0 auto; padding: 20px 16px 60px; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
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
            background: linear-gradient(135deg, #7C3AED 0%, #A78BFA 100%);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 14px;
            box-shadow: 0 2px 8px rgba(124,58,237,.3);
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

        .total-badge span { color: var(--violet); font-weight: 700; }

        .btn-add-package {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 0 18px; height: 38px;
            background: var(--primary); color: #fff;
            border: none; border-radius: 9px;
            font-size: 13.5px; font-weight: 600; font-family: inherit;
            cursor: pointer; white-space: nowrap;
            box-shadow: 0 2px 8px rgba(37,99,235,.28);
            transition: background .15s;
        }

        .btn-add-package:hover { background: var(--primary-dark); }

        /* ── STAT STRIP ── */
        .stat-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 12px;
            margin-bottom: 16px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 13px 15px;
            display: flex; align-items: center; gap: 12px;
        }

        .stat-icon {
            width: 38px; height: 38px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; flex-shrink: 0;
        }

        .stat-icon.violet  { background: var(--violet-bg);  color: var(--violet); }
        .stat-icon.blue    { background: var(--primary-bg); color: var(--primary); }
        .stat-icon.green   { background: var(--success-bg); color: var(--success); }
        .stat-icon.amber   { background: var(--warning-bg); color: var(--warning); }

        .stat-label { font-size: 11px; font-weight: 600; color: var(--text-3); text-transform: uppercase; letter-spacing: .5px; }
        .stat-value { font-size: 17px; font-weight: 800; color: var(--text); letter-spacing: -.3px; font-variant-numeric: tabular-nums; }
        .stat-value small { font-size: 11.5px; font-weight: 600; color: var(--text-3); }

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
            height: 30px; width: 230px;
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

        table { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 900px; }

        thead th {
            background: var(--th-bg); color: var(--th-text);
            font-size: 11.5px; font-weight: 700;
            letter-spacing: .4px; text-transform: uppercase;
            padding: 11px 14px; text-align: left; white-space: nowrap;
            user-select: none;
        }

        thead th.sortable { cursor: pointer; transition: background .12s; }
        thead th.sortable:hover { background: #3E4C61; }
        thead th .sort-ic { font-size: 9px; margin-left: 5px; opacity: .45; }
        thead th .sort-ic.on { opacity: 1; color: #93C5FD; }
        thead th.col-center { text-align: center; }

        tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--row-hover); }

        tbody td { padding: 12px 14px; color: var(--text); vertical-align: middle; }
        tbody td.col-center { text-align: center; }

        /* ── ID ── */
        .id-cell {
            font-size: 12px; font-weight: 700; color: var(--text-3);
            background: var(--bg); border-radius: 6px;
            padding: 3px 7px; display: inline-block;
        }

        /* ── PACKAGE NAME ── */
        .pkg-cell { display: flex; align-items: center; gap: 11px; }

        .pkg-avatar {
            width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 12.5px; color: #fff;
        }

        .pkg-name { font-weight: 700; color: var(--text); font-size: 13px; line-height: 1.3; }
        .pkg-sub  { font-size: 11.5px; color: var(--text-3); margin-top: 1px; }

        /* Mobile-only ID badge hidden by default */
        .mob-id-badge { display: none; }

        /* ── SPEED CHIP ── */
        .speed-chip {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11.5px; font-weight: 700;
            background: var(--violet-bg); color: var(--violet);
            border: 1px solid #DDD6FE; white-space: nowrap;
        }

        .speed-chip.generic {
            background: var(--bg); color: var(--text-2);
            border-color: var(--border);
        }

        .profile-raw { font-size: 11px; color: var(--text-3); margin-top: 3px; }

        /* ── RATE ── */
        .rate-cell { font-weight: 800; font-size: 14px; font-variant-numeric: tabular-nums; letter-spacing: -.2px; }
        .rate-cell small { font-size: 10.5px; font-weight: 600; color: var(--text-3); margin-right: 2px; }
        .rate-month { font-size: 11px; color: var(--text-3); font-weight: 500; }

        /* ── DATE ── */
        .date-cell { line-height: 1.4; }
        .date-d { font-weight: 600; font-size: 12.5px; color: var(--text); white-space: nowrap; }
        .date-t { font-size: 11.5px; color: var(--text-3); white-space: nowrap; }

        /* ── COMMISSION ── */
        .comm-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 10px; border-radius: 20px;
            font-size: 11.5px; font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        .comm-zero { background: var(--bg); color: var(--text-3); border: 1px solid var(--border); }
        .comm-pos  { background: var(--success-bg); color: var(--success); border: 1px solid #A7F3D0; }

        /* ── TOTAL CUSTOMERS ── */
        .cust-count {
            display: inline-flex; align-items: center; gap: 5px;
            font-weight: 700; font-size: 13px; color: var(--primary);
            font-variant-numeric: tabular-nums;
        }

        .cust-count i { font-size: 10px; opacity: .6; }
        .cust-count.zero { color: var(--text-3); }

        /* ── ACTION BUTTONS ── */
        .row-actions { display: inline-flex; align-items: center; gap: 6px; }

        .btn-ico {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            height: 30px; padding: 0 12px;
            border-radius: 7px; border: 1.5px solid transparent;
            font-size: 12px; font-weight: 600; font-family: inherit;
            cursor: pointer; white-space: nowrap;
            transition: background .13s, color .13s, border-color .13s;
        }

        .btn-edit    { background: var(--primary-bg); color: var(--primary); border-color: #BFDBFE; }
        .btn-edit:hover { background: var(--primary); color: #fff; border-color: var(--primary); }

        .btn-history { background: var(--violet-bg); color: var(--violet); border-color: #DDD6FE; }
        .btn-history:hover { background: var(--violet); color: #fff; border-color: var(--violet); }

        .btn-delete  { background: var(--danger-bg); color: var(--danger); border-color: #FECACA; }
        .btn-delete:hover { background: var(--danger); color: #fff; border-color: var(--danger); }

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

        /* ── DELETE CONFIRM MODAL ── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 200;
            background: rgba(15,23,42,.45);
            display: flex; align-items: center; justify-content: center;
            padding: 16px;
        }

        .modal-box {
            background: var(--surface); border-radius: 14px;
            box-shadow: 0 20px 50px rgba(0,0,0,.25);
            width: 100%; max-width: 380px;
            padding: 24px; text-align: center;
        }

        .modal-ico {
            width: 52px; height: 52px; border-radius: 50%;
            background: var(--danger-bg); color: var(--danger);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin: 0 auto 14px;
        }

        .modal-title { font-size: 16px; font-weight: 800; margin-bottom: 6px; }
        .modal-text  { font-size: 13px; color: var(--text-2); line-height: 1.5; margin-bottom: 18px; }
        .modal-text strong { color: var(--text); }

        .modal-actions { display: flex; gap: 10px; }

        .modal-actions button {
            flex: 1; height: 38px; border-radius: 9px;
            font-size: 13px; font-weight: 600; font-family: inherit;
            cursor: pointer; border: 1.5px solid var(--border);
            transition: background .13s;
        }

        .btn-cancel { background: var(--surface); color: var(--text-2); }
        .btn-cancel:hover { background: var(--bg); }
        .btn-confirm-del { background: var(--danger); color: #fff; border-color: var(--danger) !important; }
        .btn-confirm-del:hover { background: #B91C1C; }

        /* ══════════════════════════════
           MOBILE CARD LAYOUT  ≤ 700px
        ══════════════════════════════ */
        @media (max-width: 700px) {
            .page-wrap { padding: 14px 12px 60px; }
            .page-header { gap: 10px; }
            .btn-add-package { width: 100%; justify-content: center; height: 40px; }

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

            /* Card header: Package Name row */
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

            tbody td.mob-name-td .pkg-cell { flex: 1; }
            tbody td.mob-name-td .pkg-name { color: #fff; font-size: 14px; }
            tbody td.mob-name-td .pkg-sub  { color: rgba(255,255,255,.55); }

            /* Action footer */
            tbody td.mob-action {
                display: flex; justify-content: stretch;
                background: #FAFBFC;
                border-top: 1px solid #F1F5F9;
                padding: 10px 14px;
            }

            tbody td.mob-action::before { display: none; }
            tbody td.mob-action .row-actions { width: 100%; }
            tbody td.mob-action .btn-ico { flex: 1; height: 36px; }

            .tbl-footer { flex-direction: column; align-items: stretch; }
            .pagination { justify-content: center; }
        }
    </style>
</head>
<body x-data="packageList()" x-cloak>

<div class="page-wrap">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">
                <div class="page-title-icon"><i class="fa fa-box-open"></i></div>
                Packages List
            </h1>
            <div class="total-badge">Total Packages: <span x-text="packages.length"></span></div>
        </div>
        <button class="btn-add-package">
            <i class="fa fa-plus"></i> Add Package
        </button>
    </div>

    <!-- Stat Strip -->
    <div class="stat-strip">
        <div class="stat-card">
            <div class="stat-icon violet"><i class="fa fa-box-open"></i></div>
            <div>
                <div class="stat-label">Total Packages</div>
                <div class="stat-value" x-text="packages.length"></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fa fa-gauge-high"></i></div>
            <div>
                <div class="stat-label">Highest Speed</div>
                <div class="stat-value"><span x-text="maxSpeed"></span> <small>Mbps</small></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class="fa fa-bangladeshi-taka-sign"></i></div>
            <div>
                <div class="stat-label">Avg. Rate</div>
                <div class="stat-value"><small>৳</small><span x-text="avgRate"></span></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon amber"><i class="fa fa-hand-holding-dollar"></i></div>
            <div>
                <div class="stat-label">With Commission</div>
                <div class="stat-value" x-text="withCommission"></div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fa fa-users"></i></div>
            <div>
                <div class="stat-label">Total Customers</div>
                <div class="stat-value" x-text="totalCustomers"></div>
            </div>
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
                <input type="text" placeholder="Search package, profile…" x-model="query" @input="currentPage = 1">
            </div>
        </div>

        <!-- Table -->
        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th class="sortable" style="width:60px" @click="sortBy('id')">
                            Id <i class="fa sort-ic" :class="sortIcon('id')"></i>
                        </th>
                        <th class="sortable" @click="sortBy('name')">
                            Package Name <i class="fa sort-ic" :class="sortIcon('name')"></i>
                        </th>
                        <th class="sortable col-center" @click="sortBy('rate')">
                            Package Rate <i class="fa sort-ic" :class="sortIcon('rate')"></i>
                        </th>
                        <th>Profile Name</th>
                        <th class="sortable" @click="sortBy('createdAt')">
                            Create Date <i class="fa sort-ic" :class="sortIcon('createdAt')"></i>
                        </th>
                        <th class="sortable col-center" @click="sortBy('commission')">
                            Commission <i class="fa sort-ic" :class="sortIcon('commission')"></i>
                        </th>
                        <th class="sortable col-center" @click="sortBy('customers')">
                            Total Customers <i class="fa sort-ic" :class="sortIcon('customers')"></i>
                        </th>
                        <th class="col-center" style="width:230px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-if="paginated.length === 0">
                        <tr class="empty-row">
                            <td colspan="8">
                                <i class="fa fa-box-open"></i>
                                No packages found
                            </td>
                        </tr>
                    </template>

                    <template x-for="pkg in paginated" :key="pkg.id">
                        <tr>

                            <!-- ID: visible on desktop, hidden on mobile (badge injected in name cell) -->
                            <td data-label="Id" class="mob-id-td">
                                <span class="id-cell" x-text="pkg.id"></span>
                            </td>

                            <!-- Package Name: card header on mobile -->
                            <td data-label="Package" class="mob-name-td">
                                <span class="mob-id-badge id-cell" x-text="'#' + pkg.id"></span>
                                <div class="pkg-cell">
                                    <div class="pkg-avatar" :style="`background: ${avatarColor(pkg)}`">
                                        <i class="fa fa-wifi"></i>
                                    </div>
                                    <div>
                                        <div class="pkg-name" x-text="pkg.name"></div>
                                        <div class="pkg-sub" x-text="speedOf(pkg) ? speedOf(pkg) + ' Mbps plan' : 'Custom plan'"></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Rate -->
                            <td data-label="Rate" class="col-center">
                                <div class="rate-cell"><small>৳</small><span x-text="pkg.rate.toFixed(2)"></span></div>
                                <div class="rate-month">per month</div>
                            </td>

                            <!-- Profile -->
                            <td data-label="Profile">
                                <span class="speed-chip" :class="{ generic: !speedOf(pkg) }">
                                    <i class="fa" :class="speedOf(pkg) ? 'fa-bolt' : 'fa-tag'"></i>
                                    <span x-text="speedOf(pkg) ? speedOf(pkg) + ' Mbps' : pkg.profile"></span>
                                </span>
                                <div class="profile-raw" x-show="speedOf(pkg)" x-text="pkg.profile"></div>
                            </td>

                            <!-- Create Date -->
                            <td data-label="Created">
                                <div class="date-cell">
                                    <div class="date-d"><i class="fa fa-calendar" style="font-size:10px; color:var(--text-3); margin-right:5px"></i><span x-text="pkg.createdAt"></span></div>
                                    <div class="date-t"><i class="fa fa-clock" style="font-size:10px; margin-right:5px"></i><span x-text="pkg.createdTime"></span></div>
                                </div>
                            </td>

                            <!-- Commission -->
                            <td data-label="Commission" class="col-center">
                                <span class="comm-badge" :class="pkg.commission > 0 ? 'comm-pos' : 'comm-zero'">
                                    <span x-text="pkg.commission.toFixed(2)"></span>
                                </span>
                            </td>

                            <!-- Total Customers -->
                            <td data-label="Customers" class="col-center">
                                <span class="cust-count" :class="{ zero: pkg.customers === 0 }">
                                    <i class="fa fa-user"></i>
                                    <span x-text="pkg.customers"></span>
                                </span>
                            </td>

                            <!-- Action -->
                            <td data-label="Action" class="col-center mob-action">
                                <div class="row-actions">
                                    <button class="btn-ico btn-edit" title="Edit package">
                                        <i class="fa fa-pen-to-square"></i> Edit
                                    </button>
                                    <button class="btn-ico btn-history" title="View history">
                                        <i class="fa fa-clock-rotate-left"></i> History
                                    </button>
                                    <button class="btn-ico btn-delete" title="Delete package" @click="askDelete(pkg)">
                                        <i class="fa fa-trash"></i> Delete
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

<!-- Delete Confirm Modal -->
<div class="modal-overlay" x-show="deleteTarget" x-transition.opacity @click.self="deleteTarget = null">
    <div class="modal-box" x-show="deleteTarget" x-transition.scale.origin.center>
        <div class="modal-ico"><i class="fa fa-trash"></i></div>
        <div class="modal-title">Delete this package?</div>
        <div class="modal-text">
            <strong x-text="deleteTarget?.name"></strong> will be permanently removed.
            This action cannot be undone.
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" @click="deleteTarget = null">Cancel</button>
            <button class="btn-confirm-del" @click="confirmDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
function packageList() {
    return {
        query:        '',
        perPage:      100,
        currentPage:  1,
        sortKey:      'id',
        sortDir:      'desc',
        deleteTarget: null,

        packages: [
            { id: 6, name: 'Lalmonirhat-2-Pack-1050', rate: 1050.00, profile: 'Lalmonirhat-2-Pack-60MB', createdAt: '06-May-2026', createdTime: '20:14:50', commission: 0.00, customers: 18 },
            { id: 5, name: 'Lalmonirhat-2-Pack-840',  rate:  840.00, profile: 'Lalmonirhat-2-Pack-50MB', createdAt: '06-May-2026', createdTime: '20:14:23', commission: 0.00, customers: 36 },
            { id: 4, name: 'Lalmonirhat-2-Pack-735',  rate:  735.00, profile: 'Lalmonirhat-2-Pack-40MB', createdAt: '06-May-2026', createdTime: '20:13:46', commission: 0.00, customers: 52 },
            { id: 3, name: 'Lalmonirhat-2-Pack-630',  rate:  630.00, profile: 'Lalmonirhat-2-Pack-30MB', createdAt: '06-May-2026', createdTime: '20:13:17', commission: 0.00, customers: 87 },
            { id: 2, name: 'Lalmonirhat-2-Pack-525',  rate:  525.00, profile: 'Lalmonirhat-2-Pack-20MB', createdAt: '06-May-2026', createdTime: '20:12:22', commission: 0.00, customers: 64 },
            { id: 1, name: 'Test',                    rate:  100.00, profile: 'test',                    createdAt: '06-May-2026', createdTime: '14:34:49', commission: 0.00, customers: 0 },
        ],

        avatarPalette: [
            'linear-gradient(135deg, #7C3AED, #A78BFA)',
            'linear-gradient(135deg, #2563EB, #60A5FA)',
            'linear-gradient(135deg, #0D9488, #2DD4BF)',
            'linear-gradient(135deg, #D97706, #FBBF24)',
            'linear-gradient(135deg, #DB2777, #F472B6)',
            'linear-gradient(135deg, #4F46E5, #818CF8)',
        ],

        speedOf(pkg) {
            const m = pkg.profile.match(/(\d+)\s*MB/i);
            return m ? parseInt(m[1], 10) : null;
        },

        avatarColor(pkg) {
            return this.avatarPalette[pkg.id % this.avatarPalette.length];
        },

        get maxSpeed() {
            const speeds = this.packages.map(p => this.speedOf(p)).filter(Boolean);
            return speeds.length ? Math.max(...speeds) : 0;
        },

        get avgRate() {
            if (!this.packages.length) return '0';
            const avg = this.packages.reduce((s, p) => s + p.rate, 0) / this.packages.length;
            return Math.round(avg).toLocaleString();
        },

        get withCommission() {
            return this.packages.filter(p => p.commission > 0).length;
        },

        get totalCustomers() {
            return this.packages.reduce((s, p) => s + p.customers, 0).toLocaleString();
        },

        sortBy(key) {
            if (this.sortKey === key) {
                this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
            } else {
                this.sortKey = key;
                this.sortDir = 'asc';
            }
            this.currentPage = 1;
        },

        sortIcon(key) {
            if (this.sortKey !== key) return 'fa-sort';
            return this.sortDir === 'asc' ? 'fa-sort-up on' : 'fa-sort-down on';
        },

        get filtered() {
            let list = this.packages;
            if (this.query.trim()) {
                const q = this.query.toLowerCase();
                list = list.filter(p =>
                    p.name.toLowerCase().includes(q)    ||
                    p.profile.toLowerCase().includes(q) ||
                    String(p.rate).includes(q)          ||
                    String(p.id).includes(q)
                );
            }
            const dir = this.sortDir === 'asc' ? 1 : -1;
            const key = this.sortKey;
            return [...list].sort((a, b) => {
                let va = a[key], vb = b[key];
                if (key === 'createdAt') { va = a.createdAt + ' ' + a.createdTime; vb = b.createdAt + ' ' + b.createdTime; }
                if (typeof va === 'string') return va.localeCompare(vb) * dir;
                return (va - vb) * dir;
            });
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

        askDelete(pkg) {
            this.deleteTarget = pkg;
        },

        confirmDelete() {
            this.packages = this.packages.filter(p => p.id !== this.deleteTarget.id);
            this.deleteTarget = null;
            if (this.currentPage > this.totalPages) this.currentPage = this.totalPages;
        },
    };
}
</script>
</body>
</html>
