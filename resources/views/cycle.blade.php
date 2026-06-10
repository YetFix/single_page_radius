<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bill Cycle Change</title>
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
            background: linear-gradient(135deg, #D97706 0%, #FBBF24 100%);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 14px;
            box-shadow: 0 2px 8px rgba(217,119,6,.3);
            flex-shrink: 0;
        }

        .page-sub { font-size: 12.5px; color: var(--text-3); margin-top: 2px; }

        /* ── CARD ── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
            margin-bottom: 18px;
        }

        .card-head {
            padding: 13px 20px;
            border-bottom: 1px solid var(--border);
            background: #FAFBFC;
            display: flex; align-items: center; gap: 9px;
            font-size: 13.5px; font-weight: 700;
        }

        .card-head i { color: var(--warning); font-size: 13px; }

        .card-body { padding: 20px; }

        /* ── SEARCH BY ── */
        .searchby-row {
            display: flex; align-items: flex-end; gap: 14px;
            flex-wrap: wrap; margin-bottom: 4px;
        }

        .field { display: flex; flex-direction: column; gap: 6px; }

        .field label {
            font-size: 12px; font-weight: 700; color: var(--text-2);
            letter-spacing: .2px;
        }

        .field label .req { color: var(--danger); }

        .field select,
        .field input {
            height: 38px; padding: 0 12px;
            border: 1.5px solid var(--border); border-radius: 9px;
            font-size: 13px; font-family: inherit;
            color: var(--text); background: var(--surface);
            transition: border-color .15s, box-shadow .15s;
            width: 100%;
        }

        .field select {
            appearance: none; cursor: pointer;
            padding-right: 32px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 3.5L9 1' stroke='%2394A3B8' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 11px center;
        }

        .field select:focus,
        .field input:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }

        .field select:disabled {
            background-color: var(--bg); color: var(--text-3); cursor: not-allowed;
        }

        .field.invalid select { border-color: var(--danger); }
        .field .err-msg { font-size: 11px; font-weight: 600; color: var(--danger); }

        .searchby-field { width: 230px; }

        /* ── FILTER PANEL ── */
        .filter-panel {
            margin-top: 16px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #FAFBFC;
            padding: 16px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 14px;
        }

        .filter-grid .field select,
        .filter-grid .field input { background-color: var(--surface); }

        /* clearable select */
        .clearable { position: relative; }

        .clearable .clear-x {
            position: absolute; right: 30px; top: 50%;
            transform: translateY(-50%);
            width: 18px; height: 18px; border-radius: 50%;
            border: none; background: var(--bg); color: var(--text-3);
            font-size: 10px; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: background .12s, color .12s;
        }

        .clearable .clear-x:hover { background: var(--danger-bg); color: var(--danger); }

        /* ── FORM ACTIONS ── */
        .form-actions {
            display: flex; justify-content: flex-end; gap: 10px;
            margin-top: 18px; flex-wrap: wrap;
        }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            height: 38px; padding: 0 20px;
            border: none; border-radius: 9px;
            font-size: 13.5px; font-weight: 600; font-family: inherit;
            cursor: pointer; white-space: nowrap;
            transition: background .15s, opacity .15s;
        }

        .btn-search {
            background: var(--primary); color: #fff;
            box-shadow: 0 2px 8px rgba(37,99,235,.28);
        }

        .btn-search:hover { background: var(--primary-dark); }

        .btn-reset {
            background: var(--teal); color: #fff;
            box-shadow: 0 2px 8px rgba(13,148,136,.25);
        }

        .btn-reset:hover { background: #0F766E; }

        /* ── RESULTS ── */
        .results-head {
            padding: 13px 20px;
            border-bottom: 1px solid var(--border);
            background: #FAFBFC;
            display: flex; align-items: center; justify-content: space-between;
            gap: 10px; flex-wrap: wrap;
        }

        .results-title { font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 9px; }
        .results-title i { color: var(--primary); }

        .results-count {
            padding: 2px 10px; border-radius: 20px;
            background: var(--primary-bg); color: var(--primary);
            font-size: 11.5px; font-weight: 700;
        }

        .tbl-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }

        table { width: 100%; border-collapse: collapse; font-size: 13px; min-width: 880px; }

        thead th {
            background: var(--th-bg); color: var(--th-text);
            font-size: 11.5px; font-weight: 700;
            letter-spacing: .4px; text-transform: uppercase;
            padding: 11px 14px; text-align: left; white-space: nowrap;
        }

        thead th.col-center { text-align: center; }

        tbody tr { border-bottom: 1px solid var(--border); transition: background .12s; }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: var(--row-hover); }
        tbody tr.row-selected { background: var(--primary-bg); }

        tbody td { padding: 11px 14px; color: var(--text); vertical-align: middle; }
        tbody td.col-center { text-align: center; }

        input[type="checkbox"] {
            width: 16px; height: 16px; accent-color: var(--primary); cursor: pointer;
        }

        .cust-name { font-weight: 700; font-size: 13px; }
        .cust-id   { font-size: 11.5px; color: var(--text-3); margin-top: 1px; }

        .pill {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11.5px; font-weight: 600; white-space: nowrap;
        }

        .pill-cycle  { background: var(--warning-bg); color: var(--warning); border: 1px solid #FDE68A; }
        .pill-active { background: var(--success-bg); color: var(--success); border: 1px solid #A7F3D0; }
        .pill-expired{ background: var(--danger-bg);  color: var(--danger);  border: 1px solid #FECACA; }

        .pkg-tag { font-size: 12.5px; font-weight: 600; color: var(--text-2); }

        .date-chip {
            font-size: 12px; font-weight: 600; color: var(--text-2);
            background: var(--bg); border-radius: 6px;
            padding: 3px 8px; white-space: nowrap; display: inline-block;
        }

        /* ── BULK BAR ── */
        .bulk-bar {
            padding: 13px 20px;
            border-top: 1px solid var(--border);
            background: #FAFBFC;
            display: flex; align-items: center; justify-content: space-between;
            gap: 12px; flex-wrap: wrap;
        }

        .bulk-left { font-size: 12.5px; color: var(--text-2); }
        .bulk-left strong { color: var(--primary); }

        .bulk-right { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

        .bulk-right select {
            height: 36px; padding: 0 32px 0 12px;
            border: 1.5px solid var(--border); border-radius: 9px;
            font-size: 13px; font-family: inherit;
            color: var(--text); background-color: var(--surface);
            appearance: none; cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 3.5L9 1' stroke='%2394A3B8' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 11px center;
        }

        .bulk-right select:focus { outline: none; border-color: var(--primary); }

        .btn-apply {
            background: var(--success); color: #fff;
            box-shadow: 0 2px 8px rgba(5,150,105,.25);
        }

        .btn-apply:hover { background: #047857; }
        .btn-apply:disabled { opacity: .45; cursor: not-allowed; }

        /* ── EMPTY / PLACEHOLDER STATES ── */
        .placeholder {
            padding: 54px 20px; text-align: center; color: var(--text-3);
        }

        .placeholder i { font-size: 30px; opacity: .25; margin-bottom: 12px; display: block; }
        .placeholder .ph-title { font-size: 14px; font-weight: 700; color: var(--text-2); margin-bottom: 4px; }
        .placeholder .ph-text  { font-size: 12.5px; }

        /* ── MODAL ── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 200;
            background: rgba(15,23,42,.45);
            display: flex; align-items: center; justify-content: center;
            padding: 16px;
        }

        .modal-box {
            background: var(--surface); border-radius: 14px;
            box-shadow: 0 20px 50px rgba(0,0,0,.25);
            width: 100%; max-width: 400px;
            padding: 24px; text-align: center;
        }

        .modal-ico {
            width: 52px; height: 52px; border-radius: 50%;
            background: var(--warning-bg); color: var(--warning);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin: 0 auto 14px;
        }

        .modal-title { font-size: 16px; font-weight: 800; margin-bottom: 6px; }
        .modal-text  { font-size: 13px; color: var(--text-2); line-height: 1.55; margin-bottom: 18px; }
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
        .btn-confirm { background: var(--warning); color: #fff; border-color: var(--warning) !important; }
        .btn-confirm:hover { background: #B45309; }

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

        /* ── MOBILE ── */
        @media (max-width: 700px) {
            .page-wrap { padding: 14px 12px 60px; }
            .card-body { padding: 16px 14px; }
            .searchby-field { width: 100%; }
            .filter-grid { grid-template-columns: 1fr 1fr; }
            .form-actions .btn { flex: 1; }
            .bulk-bar { flex-direction: column; align-items: stretch; }
            .bulk-right { width: 100%; }
            .bulk-right select { flex: 1; }
        }

        @media (max-width: 480px) {
            .filter-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body x-data="cyclePage()" x-cloak>

<div class="page-wrap">

    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-left">
            <h1 class="page-title">
                <div class="page-title-icon"><i class="fa fa-arrows-rotate"></i></div>
                <div>
                    Bill Cycle Change
                    <div class="page-sub">Search customers and move them to a new billing cycle</div>
                </div>
            </h1>
        </div>
    </div>

    <!-- Search Card -->
    <div class="card">
        <div class="card-head"><i class="fa fa-filter"></i> Search Customers</div>
        <div class="card-body">

            <!-- Search By -->
            <div class="searchby-row">
                <div class="field searchby-field">
                    <label>Search By</label>
                    <select x-model="searchBy" @change="resetResults()">
                        <option value="batch">Batch</option>
                        <option value="customer">Customer ID</option>
                        <option value="mobile">Mobile Number</option>
                    </select>
                </div>

                <template x-if="searchBy !== 'batch'">
                    <div class="field" style="width:280px">
                        <label x-text="searchBy === 'customer' ? 'Customer ID' : 'Mobile Number'"></label>
                        <input type="text" x-model="singleQuery"
                               :placeholder="searchBy === 'customer' ? 'e.g. CUST-1024' : 'e.g. 01712345678'">
                    </div>
                </template>
            </div>

            <!-- Batch Filter Panel -->
            <div class="filter-panel" x-show="searchBy === 'batch'">
                <div class="filter-grid">

                    <div class="field" :class="{ invalid: errors.manager }">
                        <label>Manager Name <span class="req">*</span></label>
                        <select x-model="filters.manager" @change="filters.pop = ''; errors.manager = false">
                            <option value="">Select an option</option>
                            <template x-for="m in managers" :key="m">
                                <option :value="m" x-text="m"></option>
                            </template>
                        </select>
                        <span class="err-msg" x-show="errors.manager">Manager is required</span>
                    </div>

                    <div class="field" :class="{ invalid: errors.pop }">
                        <label>POP Name <span class="req">*</span></label>
                        <select x-model="filters.pop" :disabled="!filters.manager" @change="errors.pop = false">
                            <option value="">Select an option</option>
                            <template x-for="p in popsForManager" :key="p">
                                <option :value="p" x-text="p"></option>
                            </template>
                        </select>
                        <span class="err-msg" x-show="errors.pop">POP is required</span>
                    </div>

                    <div class="field">
                        <label>Area Name</label>
                        <div class="clearable">
                            <select x-model="filters.area">
                                <option value="">ALL Area</option>
                                <template x-for="a in areas" :key="a">
                                    <option :value="a" x-text="a"></option>
                                </template>
                            </select>
                            <button type="button" class="clear-x" x-show="filters.area" @click="filters.area = ''" title="Clear">
                                <i class="fa fa-xmark"></i>
                            </button>
                        </div>
                    </div>

                    <div class="field">
                        <label>Billing Cycle</label>
                        <select x-model="filters.cycle">
                            <option value="">Select an option</option>
                            <template x-for="c in cycles" :key="c">
                                <option :value="c" x-text="c"></option>
                            </template>
                        </select>
                    </div>

                    <div class="field">
                        <label>User Status</label>
                        <select x-model="filters.status">
                            <option value="">Customer Status</option>
                            <option value="Active">Active</option>
                            <option value="Expired">Expired</option>
                            <option value="Disabled">Disabled</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Package/Sub Package</label>
                        <select x-model="filters.package">
                            <option value="">Select One</option>
                            <template x-for="p in packages" :key="p">
                                <option :value="p" x-text="p"></option>
                            </template>
                        </select>
                    </div>

                    <div class="field">
                        <label>Expire Date</label>
                        <input type="date" x-model="filters.expireDate">
                    </div>

                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <button class="btn btn-search" @click="doSearch()">
                    <i class="fa fa-magnifying-glass"></i> Search
                </button>
                <button class="btn btn-reset" @click="resetAll()">
                    <i class="fa fa-rotate-left"></i> Reset
                </button>
            </div>

        </div>
    </div>

    <!-- Results Card -->
    <div class="card">

        <template x-if="!searched">
            <div class="placeholder">
                <i class="fa fa-magnifying-glass"></i>
                <div class="ph-title">No search performed yet</div>
                <div class="ph-text">Select Manager and POP, then press Search to load customers.</div>
            </div>
        </template>

        <template x-if="searched && results.length === 0">
            <div class="placeholder">
                <i class="fa fa-user-slash"></i>
                <div class="ph-title">No customers matched</div>
                <div class="ph-text">Try widening your filters and search again.</div>
            </div>
        </template>

        <template x-if="searched && results.length > 0">
            <div>
                <div class="results-head">
                    <div class="results-title">
                        <i class="fa fa-users"></i> Matched Customers
                        <span class="results-count" x-text="results.length + ' found'"></span>
                    </div>
                </div>

                <div class="tbl-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th class="col-center" style="width:46px">
                                    <input type="checkbox"
                                           :checked="allSelected"
                                           @change="toggleAll($event.target.checked)">
                                </th>
                                <th>Customer</th>
                                <th>POP / Area</th>
                                <th>Package</th>
                                <th class="col-center">Current Cycle</th>
                                <th class="col-center">Status</th>
                                <th class="col-center">Expire Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="c in results" :key="c.id">
                                <tr :class="{ 'row-selected': selected.includes(c.id) }">
                                    <td class="col-center">
                                        <input type="checkbox"
                                               :checked="selected.includes(c.id)"
                                               @change="toggleOne(c.id)">
                                    </td>
                                    <td>
                                        <div class="cust-name" x-text="c.name"></div>
                                        <div class="cust-id" x-text="c.id + ' · ' + c.mobile"></div>
                                    </td>
                                    <td>
                                        <div class="pkg-tag" x-text="c.pop"></div>
                                        <div class="cust-id" x-text="c.area"></div>
                                    </td>
                                    <td><span class="pkg-tag" x-text="c.package"></span></td>
                                    <td class="col-center">
                                        <span class="pill pill-cycle">
                                            <i class="fa fa-calendar-days"></i>
                                            <span x-text="c.cycle"></span>
                                        </span>
                                    </td>
                                    <td class="col-center">
                                        <span class="pill" :class="c.status === 'Active' ? 'pill-active' : 'pill-expired'">
                                            <i class="fa" :class="c.status === 'Active' ? 'fa-circle-check' : 'fa-circle-xmark'"></i>
                                            <span x-text="c.status"></span>
                                        </span>
                                    </td>
                                    <td class="col-center">
                                        <span class="date-chip" x-text="c.expire"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <!-- Bulk action bar -->
                <div class="bulk-bar">
                    <div class="bulk-left">
                        <strong x-text="selected.length"></strong>
                        of <span x-text="results.length"></span> customers selected
                    </div>
                    <div class="bulk-right">
                        <select x-model="newCycle">
                            <option value="">New Bill Cycle…</option>
                            <template x-for="c in cycles" :key="c">
                                <option :value="c" x-text="c"></option>
                            </template>
                        </select>
                        <button class="btn btn-apply"
                                :disabled="!selected.length || !newCycle"
                                @click="confirmOpen = true">
                            <i class="fa fa-arrows-rotate"></i> Change Bill Cycle
                        </button>
                    </div>
                </div>
            </div>
        </template>

    </div>
</div>

<!-- Confirm Modal -->
<div class="modal-overlay" x-show="confirmOpen" x-transition.opacity @click.self="confirmOpen = false">
    <div class="modal-box" x-show="confirmOpen" x-transition.scale.origin.center>
        <div class="modal-ico"><i class="fa fa-arrows-rotate"></i></div>
        <div class="modal-title">Change bill cycle?</div>
        <div class="modal-text">
            <strong x-text="selected.length"></strong> customer(s) will be moved to the
            <strong x-text="newCycle"></strong> billing cycle. Their next invoices will follow
            the new cycle immediately.
        </div>
        <div class="modal-actions">
            <button class="btn-cancel" @click="confirmOpen = false">Cancel</button>
            <button class="btn-confirm" @click="applyCycle()">Yes, Change</button>
        </div>
    </div>
</div>

<!-- Toast -->
<div class="toast" x-show="toast" x-transition.opacity.duration.300ms>
    <i class="fa fa-circle-check"></i>
    <span x-text="toast"></span>
</div>

<script>
function cyclePage() {
    return {
        searchBy:    'batch',
        singleQuery: '',
        searched:    false,
        results:     [],
        selected:    [],
        newCycle:    '',
        confirmOpen: false,
        toast:       '',
        errors:      { manager: false, pop: false },

        filters: {
            manager: '', pop: '', area: '',
            cycle: '', status: '', package: '', expireDate: '',
        },

        managers: ['LALMONIRHAT-2', 'Uttara-Central', 'Mirpur-North', 'Gulshan Premium'],

        popMap: {
            'LALMONIRHAT-2':   ['Lalmonirhat-2', 'Sohel-Lahirirhat'],
            'Uttara-Central':  ['Uttara-North POP'],
            'Mirpur-North':    ['Mirpur-Central'],
            'Gulshan Premium': ['Gulshan Zone-A'],
        },

        areas:    ['Lalmonirhat Sadar', 'Lahirirhat', 'Uttara Sector 7', 'Mirpur-10', 'Gulshan Circle-2'],
        cycles:   ['Monthly', 'Quarterly', 'Half-Yearly', 'Yearly'],
        packages: [
            'Lalmonirhat-2-Pack-525', 'Lalmonirhat-2-Pack-630', 'Lalmonirhat-2-Pack-735',
            'Lalmonirhat-2-Pack-840', 'Lalmonirhat-2-Pack-1050',
        ],

        customers: [
            { id: 'CUST-1001', name: 'Abdul Karim',    mobile: '01712001001', pop: 'Lalmonirhat-2',    area: 'Lalmonirhat Sadar', package: 'Lalmonirhat-2-Pack-525',  cycle: 'Monthly',   status: 'Active',  expire: '30-Jun-2026' },
            { id: 'CUST-1002', name: 'Rahima Begum',   mobile: '01812002002', pop: 'Lalmonirhat-2',    area: 'Lalmonirhat Sadar', package: 'Lalmonirhat-2-Pack-630',  cycle: 'Monthly',   status: 'Active',  expire: '30-Jun-2026' },
            { id: 'CUST-1003', name: 'Sohel Rana',     mobile: '01912003003', pop: 'Sohel-Lahirirhat', area: 'Lahirirhat',        package: 'Lalmonirhat-2-Pack-735',  cycle: 'Monthly',   status: 'Expired', expire: '31-May-2026' },
            { id: 'CUST-1004', name: 'Mizanur Rahman', mobile: '01612004004', pop: 'Lalmonirhat-2',    area: 'Lalmonirhat Sadar', package: 'Lalmonirhat-2-Pack-840',  cycle: 'Quarterly', status: 'Active',  expire: '31-Aug-2026' },
            { id: 'CUST-1005', name: 'Nasrin Akter',   mobile: '01512005005', pop: 'Sohel-Lahirirhat', area: 'Lahirirhat',        package: 'Lalmonirhat-2-Pack-1050', cycle: 'Monthly',   status: 'Active',  expire: '30-Jun-2026' },
            { id: 'CUST-1006', name: 'Jahangir Alam',  mobile: '01312006006', pop: 'Lalmonirhat-2',    area: 'Lalmonirhat Sadar', package: 'Lalmonirhat-2-Pack-525',  cycle: 'Monthly',   status: 'Expired', expire: '15-May-2026' },
        ],

        get popsForManager() {
            return this.popMap[this.filters.manager] || [];
        },

        get allSelected() {
            return this.results.length > 0 && this.selected.length === this.results.length;
        },

        doSearch() {
            if (this.searchBy === 'batch') {
                this.errors.manager = !this.filters.manager;
                this.errors.pop     = !this.filters.pop;
                if (this.errors.manager || this.errors.pop) return;

                this.results = this.customers.filter(c => {
                    if (!this.popsForManager.includes(c.pop)) return false;
                    if (c.pop !== this.filters.pop) return false;
                    if (this.filters.area    && c.area    !== this.filters.area)    return false;
                    if (this.filters.cycle   && c.cycle   !== this.filters.cycle)   return false;
                    if (this.filters.status  && c.status  !== this.filters.status)  return false;
                    if (this.filters.package && c.package !== this.filters.package) return false;
                    return true;
                });
            } else {
                const q = this.singleQuery.trim().toLowerCase();
                this.results = q
                    ? this.customers.filter(c =>
                        this.searchBy === 'customer'
                            ? c.id.toLowerCase().includes(q)
                            : c.mobile.includes(q))
                    : [];
            }
            this.searched = true;
            this.selected = [];
            this.newCycle = '';
        },

        toggleAll(checked) {
            this.selected = checked ? this.results.map(c => c.id) : [];
        },

        toggleOne(id) {
            this.selected = this.selected.includes(id)
                ? this.selected.filter(x => x !== id)
                : [...this.selected, id];
        },

        applyCycle() {
            const count = this.selected.length;
            this.customers.forEach(c => {
                if (this.selected.includes(c.id)) c.cycle = this.newCycle;
            });
            this.confirmOpen = false;
            this.selected = [];
            this.showToast(`Bill cycle changed to ${this.newCycle} for ${count} customer(s)`);
            this.newCycle = '';
        },

        showToast(msg) {
            this.toast = msg;
            setTimeout(() => this.toast = '', 3200);
        },

        resetResults() {
            this.searched = false;
            this.results  = [];
            this.selected = [];
        },

        resetAll() {
            this.filters = { manager: '', pop: '', area: '', cycle: '', status: '', package: '', expireDate: '' };
            this.errors  = { manager: false, pop: false };
            this.singleQuery = '';
            this.resetResults();
        },
    };
}
</script>
</body>
</html>
