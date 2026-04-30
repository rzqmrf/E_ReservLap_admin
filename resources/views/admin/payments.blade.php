@extends('layouts.admin')

@section('title', 'Kelola Pembayaran')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="features-hero">
    <h1>💳 Kelola Pembayaran</h1>
    <p>Monitor semua transaksi pembayaran via Midtrans</p>
</section>

<section class="fields-section">

    <div id="alert" class="fields-alert d-none"></div>

    {{-- FILTER --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Filter</span>
            <h3>Filter Pembayaran</h3>
        </div>
        <div class="fields-form">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="filter-status" class="form-input" onchange="load()">
                        <option value="">Semua Status</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="paid">Paid</option>
                        <option value="failed">Failed</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Data Pembayaran</span>
            <h3>Riwayat Transaksi</h3>
        </div>
        <div class="table-wrap">
            <table class="fields-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode Booking</th>
                        <th>User</th>
                        <th>Lapangan</th>
                        <th>Metode</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Waktu Bayar</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <tr><td colspan="8" class="empty-state">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

</section>

<style>
.fields-section { padding:64px 80px; display:flex; flex-direction:column; gap:32px; max-width:1400px; margin:0 auto; }
.fields-alert { padding:14px 20px; border-radius:var(--radius-md); font-size:14px; font-weight:600; display:flex; align-items:center; justify-content:space-between; gap:12px; }
.fields-alert.d-none  { display:none; }
.fields-alert.success { background:var(--primary-lt); color:var(--primary-dk); border:1px solid var(--primary); }
.fields-alert.warning { background:#fef3c7; color:#92400e; border:1px solid #f59e0b; }
.fields-alert.danger  { background:#fee2e2; color:#991b1b; border:1px solid #ef4444; }
.alert-close { background:none; border:none; cursor:pointer; font-size:16px; color:inherit; opacity:.7; padding:0 4px; }
.fields-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); overflow:hidden; box-shadow:var(--shadow-sm); }
.fields-card:hover { box-shadow:var(--shadow-md); }
.fields-card-header { padding:28px 32px 0; }
.fields-card-header h3 { font-size:1.15rem; font-weight:700; color:var(--text); margin-top:8px; margin-bottom:24px; }
.fields-form { padding:0 32px 32px; }
.form-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:20px; }
.form-group { display:flex; flex-direction:column; gap:8px; }
.form-label { font-size:13px; font-weight:700; color:var(--text); }
.form-input { width:100%; padding:11px 16px; font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; color:var(--text); background:var(--bg); border:1.5px solid var(--border); border-radius:var(--radius-md); outline:none; transition:border-color var(--transition); }
.form-input:focus { border-color:var(--primary); box-shadow:0 0 0 4px rgba(13,148,136,.1); }
.table-wrap { overflow-x:auto; padding:0 32px 32px; }
.fields-table { width:100%; border-collapse:collapse; font-size:14px; }
.fields-table thead tr { background:var(--bg); border-bottom:2px solid var(--border); }
.fields-table th { padding:12px 16px; text-align:left; font-size:12px; font-weight:700; color:var(--text-2); letter-spacing:.5px; text-transform:uppercase; white-space:nowrap; }
.fields-table td { padding:14px 16px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
.fields-table tbody tr:hover { background:var(--bg); }
.fields-table tbody tr:last-child td { border-bottom:none; }
.badge { display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:100px; font-size:12px; font-weight:700; }
.badge-unpaid { background:#fef3c7; color:#92400e; }
.badge-paid   { background:#dcfce7; color:#166534; }
.badge-failed { background:#fee2e2; color:#991b1b; }
.empty-state { text-align:center; color:var(--text-3); padding:48px 20px; font-size:14px; }
@media (max-width:768px) { .fields-section { padding:32px 20px; } }
</style>

<script>
const CSRF_TOKEN = '{{ csrf_token() }}';

function showAlert(msg, type = 'success') {
    const el = document.getElementById('alert');
    el.className = `fields-alert ${type}`;
    el.innerHTML = `<span>${msg}</span><button class="alert-close" onclick="this.parentElement.className='fields-alert d-none'">✕</button>`;
    if (type === 'success') setTimeout(() => el.className = 'fields-alert d-none', 3000);
}

function formatRupiah(n) {
    return new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', minimumFractionDigits:0 }).format(n);
}

function statusBadge(status) {
    const map = {
        unpaid: '<span class="badge badge-unpaid">⏳ Unpaid</span>',
        paid:   '<span class="badge badge-paid">✅ Paid</span>',
        failed: '<span class="badge badge-failed">❌ Failed</span>',
    };
    return map[status] || status;
}

function methodLabel(method) {
    const map = {
        bank_transfer: '🏦 Transfer Bank',
        e_wallet:      '👛 E-Wallet',
        midtrans:      '💳 Midtrans',
    };
    return map[method] || method;
}

function load() {
    const filterStatus = document.getElementById('filter-status').value;

    fetch('/api/payments')
        .then(r => { if (!r.ok) throw new Error('Gagal memuat data'); return r.json(); })
        .then(data => {
            const filtered = filterStatus ? data.filter(p => p.status === filterStatus) : data;
            let html = '';

            if (filtered.length === 0) {
                html = '<tr><td colspan="8" class="empty-state">Belum ada data pembayaran</td></tr>';
            } else {
                filtered.forEach(p => {
                    const booking = p.booking || {};
                    const user    = booking.user  || {};
                    const field   = booking.field || {};
                    html += `
                    <tr>
                        <td><span style="font-family:'Space Grotesk',monospace;font-weight:600;color:var(--text-3)">#${p.id}</span></td>
                        <td><span style="font-family:'Space Grotesk',monospace;font-weight:700;color:var(--primary)">${booking.booking_code || '-'}</span></td>
                        <td style="font-weight:600">${user.name || '-'}</td>
                        <td>${field.name || '-'}</td>
                        <td>${methodLabel(p.method)}</td>
                        <td style="font-weight:700;color:var(--primary)">${formatRupiah(p.amount)}</td>
                        <td>${statusBadge(p.status)}</td>
                        <td style="color:var(--text-2)">${p.paid_at ? new Date(p.paid_at).toLocaleString('id-ID') : '-'}</td>
                    </tr>`;
                });
            }
            document.getElementById('data').innerHTML = html;
        })
        .catch(err => showAlert(err.message, 'danger'));
}

load();
</script>

@endsection
