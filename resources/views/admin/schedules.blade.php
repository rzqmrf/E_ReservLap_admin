@extends('layouts.admin')

@section('title', 'Kelola Jadwal')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<section class="features-hero">
    <h1>📅 Kelola Jadwal</h1>
    <p>Atur jadwal buka dan tutup tiap lapangan olahraga</p>
</section>

<section class="fields-section">

    <div id="alert" class="fields-alert d-none"></div>

    {{-- FORM --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Form Input</span>
            <h3 id="form-title">Tambah Jadwal Baru</h3>
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
                    <label class="form-label">Hari</label>
                    <select id="day_of_week" class="form-input">
                        <option value="senin">Senin</option>
                        <option value="selasa">Selasa</option>
                        <option value="rabu">Rabu</option>
                        <option value="kamis">Kamis</option>
                        <option value="jumat">Jumat</option>
                        <option value="sabtu">Sabtu</option>
                        <option value="minggu">Minggu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Buka</label>
                    <input type="time" id="open_time" class="form-input" value="08:00">
                </div>
                <div class="form-group">
                    <label class="form-label">Jam Tutup</label>
                    <input type="time" id="close_time" class="form-input" value="22:00">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="is_open" class="form-input">
                        <option value="1">Buka</option>
                        <option value="0">Tutup</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button class="btn btn-primary" onclick="save()">💾 Simpan</button>
                <button class="btn btn-outline" onclick="resetForm()">🔄 Reset</button>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Data Jadwal</span>
            <h3>Daftar Jadwal Terdaftar</h3>
        </div>
        <div class="table-wrap">
            <table class="fields-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lapangan</th>
                        <th>Hari</th>
                        <th>Jam Buka</th>
                        <th>Jam Tutup</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <tr><td colspan="7" class="empty-state">Memuat data...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

</section>

<style>
.fields-section {
    padding: 64px 80px;
    display: flex;
    flex-direction: column;
    gap: 32px;
    max-width: 1400px;
    margin: 0 auto;
}
.fields-alert { padding:14px 20px; border-radius:var(--radius-md); font-size:14px; font-weight:600; display:flex; align-items:center; justify-content:space-between; gap:12px; }
.fields-alert.d-none  { display:none; }
.fields-alert.success { background:var(--primary-lt); color:var(--primary-dk); border:1px solid var(--primary); }
.fields-alert.warning { background:#fef3c7; color:#92400e; border:1px solid #f59e0b; }
.fields-alert.danger  { background:#fee2e2; color:#991b1b; border:1px solid #ef4444; }
.alert-close { background:none; border:none; cursor:pointer; font-size:16px; color:inherit; opacity:.7; padding:0 4px; }
.alert-close:hover { opacity:1; }
.fields-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-lg); overflow:hidden; box-shadow:var(--shadow-sm); transition:box-shadow var(--transition); }
.fields-card:hover { box-shadow:var(--shadow-md); }
.fields-card-header { padding:28px 32px 0; }
.fields-card-header h3 { font-size:1.15rem; font-weight:700; color:var(--text); margin-top:8px; margin-bottom:24px; }
.fields-form { padding:0 32px 32px; }
.form-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:20px; margin-bottom:24px; }
.form-group { display:flex; flex-direction:column; gap:8px; }
.form-label { font-size:13px; font-weight:700; color:var(--text); letter-spacing:.2px; }
.form-input { width:100%; padding:11px 16px; font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; color:var(--text); background:var(--bg); border:1.5px solid var(--border); border-radius:var(--radius-md); outline:none; transition:border-color var(--transition),box-shadow var(--transition); }
.form-input:focus { border-color:var(--primary); background:var(--surface); box-shadow:0 0 0 4px rgba(13,148,136,.1); }
.form-actions { display:flex; gap:12px; }
.table-wrap { overflow-x:auto; padding:0 32px 32px; }
.fields-table { width:100%; border-collapse:collapse; font-size:14px; }
.fields-table thead tr { background:var(--bg); border-bottom:2px solid var(--border); }
.fields-table th { padding:12px 16px; text-align:left; font-size:12px; font-weight:700; color:var(--text-2); letter-spacing:.5px; text-transform:uppercase; white-space:nowrap; }
.fields-table td { padding:14px 16px; color:var(--text); border-bottom:1px solid var(--border); vertical-align:middle; }
.fields-table tbody tr { transition:background var(--transition); }
.fields-table tbody tr:hover { background:var(--bg); }
.fields-table tbody tr:last-child td { border-bottom:none; }
.badge { display:inline-flex; align-items:center; gap:5px; padding:4px 12px; border-radius:100px; font-size:12px; font-weight:700; }
.badge-open   { background:var(--primary-lt); color:var(--primary-dk); }
.badge-closed { background:#fee2e2; color:#991b1b; }
.action-btns { display:flex; gap:8px; }
.btn-edit   { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; font-size:12px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; border-radius:var(--radius-sm); border:1.5px solid #f59e0b; background:#fef3c7; color:#92400e; cursor:pointer; transition:background var(--transition),transform var(--transition); }
.btn-edit:hover { background:#fde68a; transform:translateY(-1px); }
.btn-delete { display:inline-flex; align-items:center; gap:5px; padding:7px 14px; font-size:12px; font-weight:700; font-family:'Plus Jakarta Sans',sans-serif; border-radius:var(--radius-sm); border:1.5px solid #ef4444; background:#fee2e2; color:#991b1b; cursor:pointer; transition:background var(--transition),transform var(--transition); }
.btn-delete:hover { background:#fecaca; transform:translateY(-1px); }
.empty-state { text-align:center; color:var(--text-3); padding:48px 20px; font-size:14px; }
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
    ['id','open_time','close_time'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('open_time').value  = '08:00';
    document.getElementById('close_time').value = '22:00';
    document.getElementById('day_of_week').value = 'senin';
    document.getElementById('is_open').value     = '1';
    document.getElementById('field_id').value    = '';
    document.getElementById('form-title').textContent = 'Tambah Jadwal Baru';
}

function ucFirst(str) {
    return str ? str.charAt(0).toUpperCase() + str.slice(1) : '-';
}

// Load dropdown lapangan
function loadFields() {
    fetch('/api/fields')
        .then(r => r.json())
        .then(fields => {
            const sel = document.getElementById('field_id');
            fields.forEach(f => {
                const opt = document.createElement('option');
                opt.value       = f.id;
                opt.textContent = f.name;
                sel.appendChild(opt);
            });
        });
}

function load() {
    fetch('/api/schedules')
        .then(r => { if (!r.ok) throw new Error('Gagal memuat data'); return r.json(); })
        .then(data => {
            cache = {};
            let html = '';
            if (data.length === 0) {
                html = '<tr><td colspan="7" class="empty-state">Belum ada jadwal</td></tr>';
            } else {
                data.forEach(s => {
                    cache[s.id] = s;
                    const badge = s.is_open
                        ? '<span class="badge badge-open">● Buka</span>'
                        : '<span class="badge badge-closed">● Tutup</span>';
                    html += `
                    <tr>
                        <td><span style="font-family:'Space Grotesk',monospace;font-weight:600;color:var(--text-3)">#${s.id}</span></td>
                        <td style="font-weight:600">${s.field ? s.field.name : '-'}</td>
                        <td>${ucFirst(s.day_of_week)}</td>
                        <td>${s.open_time}</td>
                        <td>${s.close_time}</td>
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

function save() {
    const id         = document.getElementById('id').value;
    const field_id   = document.getElementById('field_id').value;
    const day        = document.getElementById('day_of_week').value;
    const open_time  = document.getElementById('open_time').value;
    const close_time = document.getElementById('close_time').value;
    const is_open    = document.getElementById('is_open').value;

    if (!field_id || !day || !open_time || !close_time) {
        showAlert('Semua field wajib diisi!', 'warning');
        return;
    }

    const isUpdate = !!id;
    const url = isUpdate ? `/api/schedules/${id}` : '/api/schedules';

    fetch(url, {
        method: isUpdate ? 'PUT' : 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ field_id, day_of_week: day, open_time, close_time, is_open: is_open == '1' })
    })
    .then(r => { if (!r.ok) return r.json().then(e => { throw new Error(e.message || 'Gagal menyimpan') }); return r.json(); })
    .then(() => {
        showAlert(isUpdate ? '✅ Jadwal berhasil diperbarui!' : '✅ Jadwal berhasil ditambahkan!');
        resetForm();
        load();
    })
    .catch(err => showAlert(err.message, 'danger'));
}

function edit(id) {
    const s = cache[id];
    if (!s) return;
    document.getElementById('id').value          = s.id;
    document.getElementById('field_id').value    = s.field_id;
    document.getElementById('day_of_week').value = s.day_of_week;
    document.getElementById('open_time').value   = s.open_time;
    document.getElementById('close_time').value  = s.close_time;
    document.getElementById('is_open').value     = s.is_open ? '1' : '0';
    document.getElementById('form-title').textContent = `Edit Jadwal — ${ucFirst(s.day_of_week)}`;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hapus(id) {
    if (!confirm('Yakin mau hapus jadwal ini?')) return;
    fetch(`/api/schedules/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
    })
    .then(r => { if (!r.ok) throw new Error('Gagal menghapus'); return r.json(); })
    .then(() => { showAlert('🗑️ Jadwal berhasil dihapus!'); load(); })
    .catch(err => showAlert(err.message, 'danger'));
}

loadFields();
load();
</script>

@endsection
