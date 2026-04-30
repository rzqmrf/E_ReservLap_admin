@extends('layouts.admin')

@section('title', 'Kelola Booking')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="features-hero">
    <h1>📋 Kelola Booking</h1>
    <p>Monitor semua reservasi lapangan yang masuk</p>
</section>

<section class="fields-section">

    <div id="alert" class="fields-alert d-none"></div>

    {{-- FILTER --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Filter</span>
            <h3>Filter Booking</h3>
        </div>
        <div class="fields-form">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="filter-status" class="form-input" onchange="load()">
                        <option value="">Semua Status</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Data Booking</span>
            <h3>Daftar Reservasi</h3>
        </div>
        <div class="table-wrap">
            <table class="fields-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>User</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Durasi</th>
                        <th>Total</th>
                        <th>Status</th>
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
.badge-pending  { background:#fef3c7; color:#92400e; }
.badge-approved { background:#dcfce7; color:#166534; }
.badge-rejected { background:#fee2e2; color:#991b1b; }
.empty-state { text-align:center; color:var(--text-3); padding:48px 20px; font-size:14px; }
@media (max-width:768px) { .fields-section { padding:32px 20px; } .form-grid { grid-template-columns:1fr; } }
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
        pending:  '<span class="badge badge-pending">⏳ Pending</span>',
        approved: '<span class="badge badge-approved">✅ Approved</span>',
        rejected: '<span class="badge badge-rejected">❌ Rejected</span>',
    };
    return map[status] || status;
}

function load() {
    const filterStatus = document.getElementById('filter-status').value;

    fetch('/api/bookings')
        .then(r => { if (!r.ok) throw new Error('Gagal memuat data'); return r.json(); })
        .then(data => {
            const filtered = filterStatus ? data.filter(b => b.status === filterStatus) : data;
            let html = '';

            if (filtered.length === 0) {
                html = '<tr><td colspan="8" class="empty-state">Belum ada data booking</td></tr>';
            } else {
                filtered.forEach(b => {
                    html += `
                    <tr>
                        <td><span style="font-family:'Space Grotesk',monospace;font-weight:700;color:var(--primary)">${b.booking_code}</span></td>
                        <td style="font-weight:600">${b.user ? b.user.name : '-'}</td>
                        <td>${b.field ? b.field.name : '-'}</td>
                        <td>${b.date}</td>
                        <td>${b.start_time} – ${b.end_time}</td>
                        <td>${b.duration_hours} jam</td>
                        <td style="font-weight:700;color:var(--primary)">${formatRupiah(b.total_price)}</td>
                        <td>${statusBadge(b.status)}</td>
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
