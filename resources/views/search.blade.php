<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Client Search</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root {
            --primary:       #2563EB;
            --primary-light: #3B82F6;
            --primary-dark:  #1D4ED8;
            --danger:        #DC2626;
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
            font-size: 13px;
            min-height: 100vh;
        }

        [x-cloak] { display: none !important; }

        /* ── PAGE ── */
        .page-wrap { max-width: 1400px; margin: 0 auto; padding: 22px 20px 60px; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .page-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 9px;
            letter-spacing: -.3px;
        }

        .page-title-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #1D4ED8 0%, #3B82F6 100%);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 13px;
            box-shadow: 0 2px 8px rgba(37,99,235,.3);
            flex-shrink: 0;
        }

        .result-badge {
            padding: 5px 13px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-2);
            box-shadow: var(--shadow);
        }

        .result-badge span { color: var(--primary); }

        /* ── FILTER CARD ── */
        .filter-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            overflow: hidden;
        }

        /* ── ACTIVE FILTERS STRIP ── */
        .af-strip {
            padding: 6px 16px;
            border-bottom: 1px solid var(--border);
            background: #F5F8FF;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .af-label {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--text-3);
            flex-shrink: 0;
        }

        .af-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 7px 2px 8px;
            background: #EFF6FF;
            border: 1px solid #BFDBFE;
            color: #1D4ED8;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
        }

        .af-chip button {
            background: none; border: none;
            color: #3B82F6; cursor: pointer;
            padding: 0 1px; font-size: 9.5px;
            opacity: .7; line-height: 1;
            transition: opacity .15s;
        }

        .af-chip button:hover { opacity: 1; }

        .af-clear {
            margin-left: auto;
            background: none; border: none;
            color: var(--danger); font-size: 11.5px;
            font-weight: 600; cursor: pointer;
            padding: 3px 8px; border-radius: 6px;
            flex-shrink: 0; transition: background .15s;
            font-family: inherit;
        }

        .af-clear:hover { background: #FEF2F2; }

        /* ── FILTER BODY ── */
        .filter-body {
            padding: 14px 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* ── GRID ── */
        .g6 {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
        }

        @media (max-width: 1100px) { .g6 { grid-template-columns: repeat(4, 1fr); } }
        @media (max-width:  800px) { .g6 { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width:  560px) { .g6 { grid-template-columns: repeat(2, 1fr); } }

        /* ── FORM FIELD ── */
        .ff { display: flex; flex-direction: column; gap: 4px; }

        .ff-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--text-2);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ff input,
        .ff select {
            height: 32px;
            padding: 0 9px;
            border: 1.5px solid var(--border);
            border-radius: 7px;
            font-size: 12.5px;
            font-family: inherit;
            color: var(--text);
            background: var(--surface);
            width: 100%;
            transition: border-color .15s, box-shadow .15s, background .15s;
            appearance: none;
        }

        .ff select {
            padding-right: 24px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='5' viewBox='0 0 9 5'%3E%3Cpath d='M1 1l3.5 3L8 1' stroke='%2394A3B8' stroke-width='1.4' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 9px center;
            cursor: pointer;
        }

        .ff input:focus,
        .ff select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2.5px rgba(37,99,235,.11);
        }

        .ff input::placeholder { color: var(--text-3); font-size: 12px; }
        .ff input[type="date"] { color: var(--text-2); }

        .ff input.is-filled,
        .ff select.is-filled {
            border-color: var(--primary-light);
            background: #F0F7FF;
        }

        /* ── MINI TOGGLE ── */
        .ff-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            height: 32px;
            padding: 0 10px;
            border: 1.5px solid var(--border);
            border-radius: 7px;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            user-select: none;
        }

        .ff-toggle:hover { border-color: #CBD5E1; }
        .ff-toggle.on { border-color: var(--primary-light); background: #EFF6FF; }

        .tog-track {
            width: 30px; height: 16px;
            border-radius: 8px;
            background: var(--border);
            position: relative;
            flex-shrink: 0;
            transition: background .2s;
        }

        .tog-track.on { background: var(--primary); }

        .tog-thumb {
            position: absolute;
            top: 2px; left: 2px;
            width: 12px; height: 12px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,.22);
            transition: transform .18s cubic-bezier(.4,0,.2,1);
        }

        .tog-track.on .tog-thumb { transform: translateX(14px); }

        .tog-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-2);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ff-toggle.on .tog-label { color: var(--primary-dark); font-weight: 600; }

        /* ── ACTION ROW ── */
        .action-row {
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }

        /* last row: 4 fields + action area */
        .last-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr) auto;
            gap: 10px;
            align-items: end;
        }

        .last-row-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 1px;
            justify-content: flex-end;
            grid-column: 5;
        }

        @media (max-width: 1100px) {
            .last-row { grid-template-columns: repeat(3, 1fr); }
            .last-row-actions { grid-column: 1 / -1; justify-content: flex-end; }
        }

        @media (max-width: 800px) {
            .last-row { grid-template-columns: repeat(2, 1fr); }
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 0 18px;
            height: 32px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            border: none;
            white-space: nowrap;
            transition: background .15s, transform .1s, box-shadow .15s;
        }

        .btn:active { transform: scale(.97); }

        .btn-primary {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 2px 6px rgba(37,99,235,.28);
        }

        .btn-primary:hover { background: var(--primary-dark); }

        .btn-reset {
            background: #0D9488;
            color: #fff;
            box-shadow: 0 2px 6px rgba(13,148,136,.25);
        }

        .btn-reset:hover { background: #0F766E; }

        /* ── FILTER FOOTER ── */
        .filter-footer {
            padding: 10px 16px;
            border-top: 1px solid var(--border);
            background: #F8FAFC;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-summary {
            flex: 1;
            font-size: 12px;
            color: var(--text-2);
        }

        .footer-summary strong { color: var(--primary); font-weight: 700; }

        /* ── RESULTS AREA ── */
        .results-area {
            margin-top: 18px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--text-3);
            font-size: 13.5px;
            box-shadow: var(--shadow);
        }

        .results-area i { font-size: 28px; opacity: .2; }
    </style>
</head>
<body x-data="clientSearch()" x-cloak>

<div class="page-wrap">

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <div class="page-title-icon"><i class="fa fa-magnifying-glass"></i></div>
            Client Search
        </h1>
        <div class="result-badge">
            <span x-text="resultCount.toLocaleString()"></span> customers found
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">

        <!-- Active Filters Strip -->
        <div class="af-strip" x-show="activeCount > 0" x-transition>
            <span class="af-label">Active</span>
            <template x-for="chip in activeChips" :key="chip.key">
                <span class="af-chip">
                    <span x-text="chip.label"></span>
                    <button @click="clearFilter(chip.key)" title="Remove"><i class="fa fa-times"></i></button>
                </span>
            </template>
            <button class="af-clear" @click="resetAll()">
                <i class="fa fa-rotate-left"></i> Clear all
            </button>
        </div>

        <!-- Filter Body -->
        <div class="filter-body">

            <!-- Row 1: Manager, POP, Area, Billing Cycle, User State, Cable Type -->
            <div class="g6">
                <div class="ff">
                    <label class="ff-label">Manager Name</label>
                    <select x-model="f.manager" :class="{'is-filled': f.manager}">
                        <option value="">ALL Manager</option>
                        <option>Manager A</option>
                        <option>Manager B</option>
                        <option>Manager C</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-label">POP Name</label>
                    <select x-model="f.pop" :class="{'is-filled': f.pop}">
                        <option value="">ALL POP</option>
                        <option>POP-01</option>
                        <option>POP-02</option>
                        <option>POP-03</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-label">Select Area</label>
                    <select x-model="f.area" :class="{'is-filled': f.area}">
                        <option value="">Select an option</option>
                        <option>Mirpur</option>
                        <option>Uttara</option>
                        <option>Dhanmondi</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-label">Billing Cycle</label>
                    <select x-model="f.billingCycle" :class="{'is-filled': f.billingCycle}">
                        <option value="">ALL Billing Cycle</option>
                        <option>Monthly</option>
                        <option>Quarterly</option>
                        <option>Half-Yearly</option>
                        <option>Yearly</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-label">User State</label>
                    <select x-model="f.userState" :class="{'is-filled': f.userState}">
                        <option value="">ALL Customer Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                        <option>Suspended</option>
                        <option>Expired</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-label">Cable Type</label>
                    <select x-model="f.cableType" :class="{'is-filled': f.cableType}">
                        <option value="">Select an option</option>
                        <option>Fiber</option>
                        <option>Coaxial</option>
                        <option>CAT6</option>
                        <option>CAT5e</option>
                    </select>
                </div>
            </div>

            <!-- Row 2: Package, CID, Username, Name, Building Name, Contact -->
            <div class="g6">
                <div class="ff">
                    <label class="ff-label">Select Packages</label>
                    <select x-model="f.package" :class="{'is-filled': f.package}">
                        <option value="">Select an option</option>
                        <option>10 Mbps</option>
                        <option>20 Mbps</option>
                        <option>50 Mbps</option>
                        <option>100 Mbps</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-label">Search By CID</label>
                    <input type="text" placeholder="CID" x-model="f.cid" :class="{'is-filled': f.cid}">
                </div>
                <div class="ff">
                    <label class="ff-label">Search By Username</label>
                    <input type="text" placeholder="Username" x-model="f.username" :class="{'is-filled': f.username}">
                </div>
                <div class="ff">
                    <label class="ff-label">Search By Name</label>
                    <input type="text" placeholder="Name" x-model="f.name" :class="{'is-filled': f.name}">
                </div>
                <div class="ff">
                    <label class="ff-label">Search By Building Name</label>
                    <input type="text" placeholder="Building name" x-model="f.building" :class="{'is-filled': f.building}">
                </div>
                <div class="ff">
                    <label class="ff-label">Search By Contact</label>
                    <input type="text" placeholder="01234567891" x-model="f.contact" :class="{'is-filled': f.contact}">
                </div>
            </div>

            <!-- Row 3: Box, Expire From, Expire To, Account Status, Static IP, All Static IP -->
            <div class="g6">
                <div class="ff">
                    <label class="ff-label">Search By Box</label>
                    <input type="text" placeholder="Box ID" x-model="f.box" :class="{'is-filled': f.box}">
                </div>
                <div class="ff">
                    <label class="ff-label">Search By Expire Date From</label>
                    <input type="date" x-model="f.expireFrom" :class="{'is-filled': f.expireFrom}">
                </div>
                <div class="ff">
                    <label class="ff-label">Search By Expire Date To</label>
                    <input type="date" x-model="f.expireTo" :class="{'is-filled': f.expireTo}">
                </div>
                <div class="ff">
                    <label class="ff-label">Accounts Status</label>
                    <select x-model="f.accountStatus" :class="{'is-filled': f.accountStatus}">
                        <option value="">Select an option</option>
                        <option>Paid</option>
                        <option>Unpaid</option>
                        <option>Overdue</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-label">Static IP</label>
                    <input type="text" placeholder="e.g. 192.168.1.1" x-model="f.staticIP" :class="{'is-filled': f.staticIP}">
                </div>
                <div class="ff">
                    <label class="ff-label">All Static IP User</label>
                    <div class="ff-toggle" :class="{'on': f.allStaticIP}" @click="f.allStaticIP = !f.allStaticIP">
                        <div class="tog-track" :class="{'on': f.allStaticIP}">
                            <div class="tog-thumb"></div>
                        </div>
                        <span class="tog-label" x-text="f.allStaticIP ? 'Enabled' : 'Disabled'"></span>
                    </div>
                </div>
            </div>

            <!-- Row 4: All Remote Access, Usage, Customer Type, Payment Deadline + buttons -->
            <div class="last-row">
                <div class="ff">
                    <label class="ff-label">All Remote Access User</label>
                    <div class="ff-toggle" :class="{'on': f.allRemoteAccess}" @click="f.allRemoteAccess = !f.allRemoteAccess">
                        <div class="tog-track" :class="{'on': f.allRemoteAccess}">
                            <div class="tog-thumb"></div>
                        </div>
                        <span class="tog-label" x-text="f.allRemoteAccess ? 'Enabled' : 'Disabled'"></span>
                    </div>
                </div>
                <div class="ff">
                    <label class="ff-label">Search By Usage</label>
                    <input type="number" placeholder="Usage in GB" x-model="f.usage" :class="{'is-filled': f.usage}" min="0">
                </div>
                <div class="ff">
                    <label class="ff-label">Customer Type</label>
                    <select x-model="f.customerType" :class="{'is-filled': f.customerType}">
                        <option value="">Select an option</option>
                        <option>Residential</option>
                        <option>Commercial</option>
                        <option>Corporate</option>
                    </select>
                </div>
                <div class="ff">
                    <label class="ff-label">Payment Deadline (Days)</label>
                    <input type="number" placeholder="Days" x-model="f.paymentDeadline" :class="{'is-filled': f.paymentDeadline}" min="0">
                </div>
                <div class="last-row-actions">
                    <button class="btn btn-primary" @click="doSearch()">
                        <i class="fa fa-search"></i> Search
                    </button>
                    <button class="btn btn-reset" @click="resetAll()">
                        Reset
                    </button>
                </div>
            </div>

        </div><!-- /.filter-body -->

    </div><!-- /.filter-card -->

    <!-- Results Area -->
    <div class="results-area">
        <i class="fa fa-table-list"></i>
        <span>Search results will appear here</span>
    </div>

</div>

<script>
function clientSearch() {
    return {
        resultCount: 0,

        f: {
            manager: '', pop: '', area: '', billingCycle: '', userState: '', cableType: '',
            package: '', cid: '', username: '', name: '', building: '', contact: '',
            box: '', expireFrom: '', expireTo: '', accountStatus: '', staticIP: '',
            usage: '', customerType: '', paymentDeadline: '',
            allStaticIP: false, allRemoteAccess: false,
        },

        get activeCount() {
            let n = 0;
            for (const [, v] of Object.entries(this.f)) {
                if (typeof v === 'boolean') { if (v) n++; }
                else if (v !== '') n++;
            }
            return n;
        },

        get activeChips() {
            const labels = {
                manager: 'Manager', pop: 'POP', area: 'Area',
                billingCycle: 'Billing', userState: 'User State', cableType: 'Cable',
                package: 'Package', cid: 'CID', username: 'Username',
                name: 'Name', building: 'Building', contact: 'Contact',
                box: 'Box', expireFrom: 'Expire From', expireTo: 'Expire To',
                accountStatus: 'Account', staticIP: 'Static IP',
                usage: 'Usage (GB)', customerType: 'Type', paymentDeadline: 'Pay Days',
                allStaticIP: 'All Static IP', allRemoteAccess: 'All Remote Access',
            };
            return Object.entries(this.f)
                .filter(([, v]) => v !== '' && v !== false)
                .map(([k, v]) => ({
                    key: k,
                    label: typeof v === 'boolean' ? labels[k] : `${labels[k]}: ${v}`,
                }));
        },

        clearFilter(key) {
            this.f[key] = typeof this.f[key] === 'boolean' ? false : '';
        },

        resetAll() {
            for (const k in this.f) {
                this.f[k] = typeof this.f[k] === 'boolean' ? false : '';
            }
        },

        doSearch() {
            console.log('Search:', this.f);
        },
    };
}
</script>
</body>
</html>
