@extends('layouts.app')

@section('title', 'Kelola Lapangan')

@section('content')

{{-- CSRF --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- PAGE HERO --}}
<section class="features-hero">
    <h1>🏟️ Kelola Lapangan</h1>
    <p>Tambah, edit, dan hapus data lapangan olahraga yang tersedia di E-ReservLap</p>
</section>

{{-- MAIN CONTENT --}}
<section class="fields-section">

    {{-- ALERT --}}
    <div id="alert" class="fields-alert d-none"></div>

    {{-- FORM CARD --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Form Input</span>
            <h3 id="form-title">Tambah Lapangan Baru</h3>
        </div>

        <div class="fields-form">
            <input type="hidden" id="id">

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Lapangan</label>
                    <input type="text" id="name" class="form-input" placeholder="Contoh: Lapangan A">
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Lapangan</label>
                    <input type="text" id="type" class="form-input" placeholder="Futsal, Badminton, Basket...">
                </div>

                <div class="form-group">
                    <label class="form-label">Harga / Jam</label>
                    <div class="input-prefix-wrap">
                        <span class="input-prefix">Rp</span>
                        <input type="number" id="price" class="form-input has-prefix" placeholder="50000">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select id="status" class="form-input">
                        <option value="available">Available</option>
                        <option value="unavailable">Unavailable</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Deskripsi <span class="optional">(opsional)</span></label>
                    <input type="text" id="description" class="form-input" placeholder="Keterangan tambahan tentang lapangan...">
                </div>
            </div>

            <div class="form-actions">
                <button class="btn btn-primary" onclick="save()">💾 Simpan</button>
                <button class="btn btn-outline" onclick="resetForm()">🔄 Reset</button>
            </div>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Data Lapangan</span>
            <h3>Daftar Lapangan Terdaftar</h3>
        </div>

        <div class="table-wrap">
            <table class="fields-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Lapangan</th>
                        <th>Jenis</th>
                        <th>Harga / Jam</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <tr>
                        <td colspan="7" class="empty-state">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</section>

<style>
/* ── FIELDS PAGE ─────────────────────────────────────── */
.fields-section {
    padding: 64px 80px;
    display: flex;
    flex-direction: column;
    gap: 32px;
    max-width: 1400px;
    margin: 0 auto;
}

/* Alert */
.fields-alert {
    padding: 14px 20px;
    border-radius: var(--radius-md);
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    animation: fadeUp .3s ease;
}

.fields-alert.d-none { display: none; }
.fields-alert.success { background: var(--primary-lt); color: var(--primary-dk); border: 1px solid var(--primary); }
.fields-alert.warning { background: #fef3c7; color: #92400e; border: 1px solid #f59e0b; }
.fields-alert.danger  { background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }

.alert-close {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    line-height: 1;
    color: inherit;
    opacity: 0.7;
    padding: 0 4px;
}
.alert-close:hover { opacity: 1; }

/* Card */
.fields-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: box-shadow var(--transition);
}

.fields-card:hover {
    box-shadow: var(--shadow-md);
}

.fields-card-header {
    padding: 28px 32px 0;
}

.fields-card-header h3 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--text);
    margin-top: 8px;
    margin-bottom: 24px;
}

/* Form */
.fields-form {
    padding: 0 32px 32px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 24px;
}

.form-group { display: flex; flex-direction: column; gap: 8px; }
.form-group.full-width { grid-column: 1 / -1; }

.form-label {
    font-size: 13px;
    font-weight: 700;
    color: var(--text);
    letter-spacing: .2px;
}

.optional {
    font-weight: 400;
    color: var(--text-3);
    font-size: 12px;
}

.form-input {
    width: 100%;
    padding: 11px 16px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    color: var(--text);
    background: var(--bg);
    border: 1.5px solid var(--border);
    border-radius: var(--radius-md);
    outline: none;
    transition: border-color var(--transition), box-shadow var(--transition), background var(--transition);
}

.form-input:focus {
    border-color: var(--primary);
    background: var(--surface);
    box-shadow: 0 0 0 4px rgba(13,148,136,.1);
}

.form-input::placeholder { color: var(--text-3); }

.input-prefix-wrap {
    position: relative;
    display: flex;
    align-items: center;
}

.input-prefix {
    position: absolute;
    left: 14px;
    font-size: 13px;
    font-weight: 700;
    color: var(--text-2);
    pointer-events: none;
}

.form-input.has-prefix { padding-left: 38px; }

.form-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

/* Table */
.table-wrap {
    overflow-x: auto;
    padding: 0 32px 32px;
}

.fields-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

.fields-table thead tr {
    background: var(--bg);
    border-bottom: 2px solid var(--border);
}

.fields-table th {
    padding: 12px 16px;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    color: var(--text-2);
    letter-spacing: .5px;
    text-transform: uppercase;
    white-space: nowrap;
}

.fields-table td {
    padding: 14px 16px;
    color: var(--text);
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.fields-table tbody tr {
    transition: background var(--transition);
}

.fields-table tbody tr:hover {
    background: var(--bg);
}

.fields-table tbody tr:last-child td {
    border-bottom: none;
}

/* Badge */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 12px;
    border-radius: 100px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .3px;
}

.badge-available {
    background: var(--primary-lt);
    color: var(--primary-dk);
}

.badge-unavailable {
    background: #fee2e2;
    color: #991b1b;
}

/* Action buttons */
.btn-edit {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 14px;
    font-size: 12px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    border-radius: var(--radius-sm);
    border: 1.5px solid #f59e0b;
    background: #fef3c7;
    color: #92400e;
    cursor: pointer;
    transition: background var(--transition), transform var(--transition);
}

.btn-edit:hover {
    background: #fde68a;
    transform: translateY(-1px);
}

.btn-delete {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 7px 14px;
    font-size: 12px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    border-radius: var(--radius-sm);
    border: 1.5px solid #ef4444;
    background: #fee2e2;
    color: #991b1b;
    cursor: pointer;
    transition: background var(--transition), transform var(--transition);
}

.btn-delete:hover {
    background: #fecaca;
    transform: translateY(-1px);
}

.action-btns {
    display: flex;
    gap: 8px;
    align-items: center;
}

/* Empty state */
.empty-state {
    text-align: center;
    color: var(--text-3);
    padding: 48px 20px;
    font-size: 14px;
}

/* Responsive */
@media (max-width: 1024px) {
    .fields-section { padding: 48px 40px; }
}

@media (max-width: 768px) {
    .fields-section { padding: 32px 20px; }
    .form-grid { grid-template-columns: 1fr; }
    .fields-card-header,
    .fields-form,
    .table-wrap { padding-left: 20px; padding-right: 20px; }
}
</style>

<script>
let fieldsCache = {};
const CSRF_TOKEN = '{{ csrf_token() }}';

function getToken() { return CSRF_TOKEN; }

function showAlert(message, type = 'success') {
    const alert = document.getElementById('alert');
    alert.className = `fields-alert ${type}`;
    alert.innerHTML = `<span>${message}</span><button class="alert-close" onclick="this.parentElement.className='fields-alert d-none'">✕</button>`;
    if (type === 'success') setTimeout(() => alert.className = 'fields-alert d-none', 3000);
    alert.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

function resetForm() {
    ['id', 'name', 'type', 'price', 'description'].forEach(id => {
        document.getElementById(id).value = '';
    });
    document.getElementById('status').value = 'available';
    document.getElementById('form-title').textContent = 'Tambah Lapangan Baru';
}

function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency', currency: 'IDR', minimumFractionDigits: 0
    }).format(angka);
}

function escapeHtml(str) {
    if (!str) return '-';
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function load() {
    fetch('/api/fields')
        .then(res => { if (!res.ok) throw new Error('Gagal memuat data'); return res.json(); })
        .then(fields => {
            fieldsCache = {};
            let html = '';

            if (fields.length === 0) {
                html = '<tr><td colspan="7" class="empty-state">Belum ada data lapangan</td></tr>';
            } else {
                fields.forEach(f => {
                    fieldsCache[f.id] = f;
                    const badge = f.status === 'available'
                        ? '<span class="badge badge-available">● Available</span>'
                        : '<span class="badge badge-unavailable">● Unavailable</span>';
                    html += `
                    <tr>
                        <td><span style="font-family:'Space Grotesk',monospace;font-weight:600;color:var(--text-3)">#${f.id}</span></td>
                        <td style="font-weight:600">${escapeHtml(f.name)}</td>
                        <td>${escapeHtml(f.type)}</td>
                        <td style="font-family:'Space Grotesk',monospace;font-weight:600;color:var(--primary)">${formatRupiah(f.price)}</td>
                        <td>${badge}</td>
                        <td style="color:var(--text-2)">${escapeHtml(f.description)}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-edit" onclick="edit(${f.id})">✏️ Edit</button>
                                <button class="btn-delete" onclick="hapus(${f.id})">🗑️ Hapus</button>
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
    const id          = document.getElementById('id').value;
    const name        = document.getElementById('name').value.trim();
    const type        = document.getElementById('type').value.trim();
    const price       = document.getElementById('price').value;
    const status      = document.getElementById('status').value;
    const description = document.getElementById('description').value.trim();

    if (!name || !type || !price) {
        showAlert('Nama, jenis, dan harga wajib diisi!', 'warning');
        return;
    }

    const isUpdate = !!id;
    const url = isUpdate ? `/api/fields/${id}` : '/api/fields';

    fetch(url, {
        method: isUpdate ? 'PUT' : 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getToken() },
        body: JSON.stringify({ name, type, price, status, description })
    })
    .then(res => {
        if (!res.ok) return res.json().then(e => { throw new Error(e.message || 'Gagal menyimpan') });
        return res.json();
    })
    .then(() => {
        showAlert(isUpdate ? '✅ Lapangan berhasil diperbarui!' : '✅ Lapangan berhasil ditambahkan!');
        resetForm();
        load();
    })
    .catch(err => showAlert(err.message, 'danger'));
}

function edit(id) {
    const f = fieldsCache[id];
    if (!f) return;
    document.getElementById('id').value          = f.id;
    document.getElementById('name').value        = f.name;
    document.getElementById('type').value        = f.type;
    document.getElementById('price').value       = f.price;
    document.getElementById('status').value      = f.status;
    document.getElementById('description').value = f.description ?? '';
    document.getElementById('form-title').textContent = `Edit Lapangan — ${f.name}`;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hapus(id) {
    if (!confirm('Yakin mau hapus lapangan ini?')) return;
    fetch(`/api/fields/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': getToken() }
    })
    .then(res => { if (!res.ok) throw new Error('Gagal menghapus'); return res.json(); })
    .then(() => { showAlert('🗑️ Lapangan berhasil dihapus!'); load(); })
    .catch(err => showAlert(err.message, 'danger'));
}

load();
</script>

@endsection
