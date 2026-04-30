@extends('layouts.admin')

@section('title', 'Kelola Slot')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="features-hero">
    <h1>🕐 Kelola Slot</h1>
    <p>Atur slot jam ketersediaan lapangan per tanggal</p>
</section>

<section class="fields-section">

    <div id="alert" class="fields-alert d-none"></div>

    {{-- GENERATE SLOT --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Generate Otomatis</span>
            <h3>Generate Slot dari Jadwal</h3>
        </div>
        <div class="fields-form">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Lapangan</label>
                    <select id="gen-field" class="form-input">
                        <option value="">-- Pilih Lapangan --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" id="gen-date" class="form-input">
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" onclick="generate()">⚡ Generate Slot Otomatis</button>
            </div>
        </div>
    </div>

    {{-- FORM MANUAL --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Form Input</span>
            <h3 id="form-title">Tambah Slot Manual</h3>
        </div>
        <div class="fields-form">
            <input type="hidden" id="id">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Lapangan</label>
                    <select id="field_id" class="form-input">
                        <option value="">-- Pilih Lapangan --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" id="date" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Mulai</label>
                    <input type="time" id="start_time" class="form-input" value="08:00">
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Selesai</label>
                    <input type="time" id="end_time" class="form-input" value="09:00">
                </div>
                <div class="form-group">
                    <label class="form-label">Kapasitas</label>
                    <input type="number" id="capacity" class="form-input" placeholder="10" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="is_available" class="form-input">
                        <option value="1">Tersedia</option>
                        <option value="0">Tidak Tersedia</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" onclick="save()">💾 Simpan</button>
                <button class="btn btn-outline" onclick="resetForm()">🔄 Reset</button>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Filter</span>
            <h3>Filter Slot</h3>
        </div>
        <div class="fields-form">
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Lapangan</label>
                    <select id="filter-field" class="form-input" onchange="load()">
                        <option value="">Semua Lapangan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal</label>
                    <input type="date" id="filter-date" class="form-input" onchange="load()">
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Data Slot</span>
            <h3>Daftar Slot Terdaftar</h3>
        </div>
        <div class="table-wrap">
            <table class="fields-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Kapasitas</th>
                        <th>Terisi</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <tr><td colspan="9" class="empty-state">Memuat data...</td></tr>
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
.form-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:20px; margin-bottom:24px; }
.form-group { display:flex; flex-direction:column; gap:8px; }
.form-label { font-size:13px; font-weight:700; color:var(--text); }
.form-input { width:100%; padding:11px 16px; font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; color:var(--text); background:var(--bg); border:1.5px solid var(--border); border-radius:var(--radius-md); outline:none; transition:border-color var(--transition); }
.form-input:focus { border-color:var(--primary); box-shadow:0 0 0 4px rgba(13,148,136,.1); }
.form-actions { display:flex; gap:12px; }
.table-wrap { overflow-x:auto; padding:0 32px 32px; }
.fields-table { width:100%; border-collapse:collapse; font-size:14px; }
.fields-table thead tr { background:var(--bg); border-bottom:2px solid var(--border); }
.fields-table th { padding:12px 16px; text-align:left; font-size:12px; font-weight:700; color:var(--text-2); letter-spacing:.5px; text-transform:uppercase; white-space:nowrap; }
.fields-table td { padding:14px 16px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
.fields-table tbody tr:hover { background:var(--bg); }
.fields-table tbody tr:last-child td { border-bottom:none; }
.badge { display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:100px; font-size:12px; font-weight:700; }
.badge-available { background:var(--primary-lt); color:var(--primary-dk); }
.badge-full      { background:#fee2e2; color:#991b1b; }
.badge-closed    { background:#f3f4f6; color:#6b7280; }
.action-btns { display:flex; gap:8px; }
.btn-edit   { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; font-size:12px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; border-radius:var(--radius-sm); border:1.5px solid #f59e0b; background:#fef3c7; color:#92400e; cursor:pointer; transition:background var(--transition),transform var(--transition); }
.btn-edit:hover { background:#fde68a; transform:translateY(-1px); }
.btn-delete { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; font-size:12px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; border-radius:var(--radius-sm); border:1.5px solid #ef4444; background:#fee2e2; color:#991b1b; cursor:pointer; transition:background var(--transition),transform var(--transition); }
.btn-delete:hover { background:#fecaca; transform:translateY(-1px); }
.empty-state { text-align:center; color:var(--text-3); padding:48px 20px; font-size:14px; }
.capacity-bar { width:80px; height:6px; background:#e5e7eb; border-radius:4px; overflow:hidden; margin-top:4px; }
.capacity-fill { height:100%; border-radius:4px; }
@media (max-width:768px) { .fields-section { padding:32px 20px; } .form-grid { grid-template-columns:1fr; } }
</style>

<script>
let cache = {};
const CSRF_TOKEN = '{{ csrf_token() }}';

function showAlert(msg, type = 'success') {
    const el = document.getElementById('alert');
    el.className = `fields-alert ${type}`;
    el.innerHTML = `<span>${msg}</span><button class="alert-close" onclick="this.parentElement.className='fields-alert d-none'">✕</button>`;
    if (type === 'success') setTimeout(() => el.className = 'fields-alert d-none', 3000);
    el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function resetForm() {
    ['id','start_time','end_time','capacity'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('start_time').value  = '08:00';
    document.getElementById('end_time').value    = '09:00';
    document.getElementById('is_available').value = '1';
    document.getElementById('field_id').value    = '';
    document.getElementById('date').value        = '';
    document.getElementById('form-title').textContent = 'Tambah Slot Manual';
}

function loadFields() {
    fetch('/api/fields')
        .then(r => r.json())
        .then(fields => {
            ['field_id','gen-field','filter-field'].forEach(id => {
                const sel = document.getElementById(id);
                if (!sel) return;
                // hapus option lama kecuali pertama
                while (sel.options.length > 1) sel.remove(1);
                fields.forEach(f => {
                    const opt = document.createElement('option');
                    opt.value = f.id;
                    opt.textContent = f.name;
                    sel.appendChild(opt);
                });
            });
        });
}

function load() {
    const filterField = document.getElementById('filter-field').value;
    const filterDate  = document.getElementById('filter-date').value;

    let url = '/api/slots';
    if (filterField && filterDate) {
        url = `/api/fields/${filterField}/slots?date=${filterDate}`;
    }

    fetch(url)
        .then(r => { if (!r.ok) throw new Error('Gagal memuat data'); return r.json(); })
        .then(data => {
            cache = {};
            let html = '';
            if (data.length === 0) {
                html = '<tr><td colspan="9" class="empty-state">Belum ada slot</td></tr>';
            } else {
                data.forEach(s => {
                    cache[s.id] = s;
                    const remaining = (s.remaining_capacity !== undefined) ? s.remaining_capacity : (s.capacity - s.booked_count);
                    const pct       = s.capacity > 0 ? (s.booked_count / s.capacity) * 100 : 0;
                    const fillColor = pct >= 100 ? '#ef4444' : pct >= 70 ? '#f59e0b' : '#22c55e';
                    const isFull    = s.booked_count >= s.capacity;
                    const badge     = !s.is_available
                        ? '<span class="badge badge-closed">● Tutup</span>'
                        : isFull
                            ? '<span class="badge badge-full">● Penuh</span>'
                            : '<span class="badge badge-available">● Tersedia</span>';

                    html += `
                    <tr>
                        <td><span style="font-family:'Space Grotesk',monospace;font-weight:600;color:var(--text-3)">#${s.id}</span></td>
                        <td style="font-weight:600">${s.field ? s.field.name : '-'}</td>
                        <td>${s.date}</td>
                        <td style="font-weight:600">${s.start_time} – ${s.end_time}</td>
                        <td>${s.capacity}</td>
                        <td>
                            ${s.booked_count}
                            <div class="capacity-bar">
                                <div class="capacity-fill" style="width:${pct}%;background:${fillColor}"></div>
                            </div>
                        </td>
                        <td style="font-weight:700;color:${remaining > 0 ? 'var(--primary)' : '#ef4444'}">${remaining}</td>
                        <td>${badge}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-edit" onclick="edit(${s.id})">✏️ Edit</button>
                                <button class="btn-delete" onclick="hapus(${s.id})">🗑️ Hapus</button>
                            </div>
                        </td>
                    </tr>`;
                });
            }
            document.getElementById('data').innerHTML = html;
        })
        .catch(err => showAlert(err.message, 'danger'));
}

function generate() {
    const fieldId = document.getElementById('gen-field').value;
    const date    = document.getElementById('gen-date').value;
    if (!fieldId || !date) { showAlert('Pilih lapangan dan tanggal terlebih dahulu!', 'warning'); return; }

    fetch('/api/slots/generate', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ field_id: fieldId, date })
    })
    .then(r => r.json())
    .then(res => { showAlert('⚡ ' + res.message); load(); })
    .catch(err => showAlert(err.message, 'danger'));
}

function save() {
    const id          = document.getElementById('id').value;
    const field_id    = document.getElementById('field_id').value;
    const date        = document.getElementById('date').value;
    const start_time  = document.getElementById('start_time').value;
    const end_time    = document.getElementById('end_time').value;
    const capacity    = document.getElementById('capacity').value;
    const is_available = document.getElementById('is_available').value;

    if (!field_id || !date || !start_time || !end_time || !capacity) {
        showAlert('Semua field wajib diisi!', 'warning'); return;
    }

    const isUpdate = !!id;
    fetch(isUpdate ? `/api/slots/${id}` : '/api/slots', {
        method: isUpdate ? 'PUT' : 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ field_id, date, start_time, end_time, capacity: parseInt(capacity), is_available: is_available == '1' })
    })
    .then(r => { if (!r.ok) return r.json().then(e => { throw new Error(e.message || 'Gagal') }); return r.json(); })
    .then(() => { showAlert(isUpdate ? '✅ Slot diperbarui!' : '✅ Slot ditambahkan!'); resetForm(); load(); })
    .catch(err => showAlert(err.message, 'danger'));
}

function edit(id) {
    const s = cache[id];
    if (!s) return;
    document.getElementById('id').value          = s.id;
    document.getElementById('field_id').value    = s.field_id;
    document.getElementById('date').value        = s.date;
    document.getElementById('start_time').value  = s.start_time;
    document.getElementById('end_time').value    = s.end_time;
    document.getElementById('capacity').value    = s.capacity;
    document.getElementById('is_available').value = s.is_available ? '1' : '0';
    document.getElementById('form-title').textContent = `Edit Slot — ${s.start_time} – ${s.end_time}`;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hapus(id) {
    if (!confirm('Yakin mau hapus slot ini?')) return;
    fetch(`/api/slots/${id}`, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF_TOKEN } })
        .then(r => { if (!r.ok) throw new Error('Gagal menghapus'); return r.json(); })
        .then(() => { showAlert('🗑️ Slot berhasil dihapus!'); load(); })
        .catch(err => showAlert(err.message, 'danger'));
}

// Set default tanggal filter ke hari ini
document.getElementById('filter-date').value = new Date().toISOString().split('T')[0];
document.getElementById('gen-date').value    = new Date().toISOString().split('T')[0];

loadFields();
load();
</script>

@endsection
