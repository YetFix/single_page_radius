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
                <div class="page-title-icon"><i class="fa fa-tower-broadcast"></i></div>
                POP / Zone List
            </h1>
            <div class="total-badge">Total POP: <span x-text="pops.length"></span></div>
        </div>
        <button class="btn-pop-recharge">
            <i class="fa fa-credit-card"></i> Pop Recharge
        </button>
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

<script>
function popList() {
    return {
        query:       '',
        perPage:     100,
        currentPage: 1,

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
    };
}
</script>
</body>
</html>
