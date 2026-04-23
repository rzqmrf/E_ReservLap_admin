@extends('layouts.admin')

@section('title', 'Kelola Users')

@section('content')

{{-- CSRF --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- PAGE HERO --}}
<section class="features-hero">
    <h1>👤 Kelola Users</h1>
    <p>Tambah, edit, dan hapus data pengguna yang terdaftar di E-ReservLap</p>
</section>

{{-- MAIN CONTENT --}}
<section class="fields-section">

    {{-- ALERT --}}
    <div id="alert" class="fields-alert d-none"></div>

    {{-- FORM CARD --}}
    <div class="fields-card">
        <div class="fields-card-header">
            <span class="section-tag">Form Input</span>
            <h3 id="form-title">Tambah User Baru</h3>
        </div>

        <div class="fields-form">
            <input type="hidden" id="id">

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <input type="text" id="name" class="form-input" placeholder="Nama lengkap user">
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" id="email" class="form-input" placeholder="email@example.com">
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
            <span class="section-tag">Data Users</span>
            <h3>Daftar Pengguna</h3>
        </div>

        <div class="table-wrap">
            <table class="fields-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <tr>
                        <td colspan="4" class="empty-state">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</section>

<style>
/* ── USERS / FIELDS PAGE ─────────────────────────────── */
.fields-section {
    padding: 64px 80px;
    display: flex;
    flex-direction: column;
    gap: 32px;
    max-width: 1400px;
    margin: 0 auto;
}

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

.fields-alert.d-none   { display: none; }
.fields-alert.success  { background: var(--primary-lt); color: var(--primary-dk); border: 1px solid var(--primary); }
.fields-alert.warning  { background: #fef3c7; color: #92400e; border: 1px solid #f59e0b; }
.fields-alert.danger   { background: #fee2e2; color: #991b1b; border: 1px solid #ef4444; }

.alert-close {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 16px;
    color: inherit;
    opacity: 0.7;
    padding: 0 4px;
}
.alert-close:hover { opacity: 1; }

.fields-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: box-shadow var(--transition);
}
.fields-card:hover { box-shadow: var(--shadow-md); }

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

.fields-form { padding: 0 32px 32px; }

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

.form-actions { display: flex; gap: 12px; flex-wrap: wrap; }

/* Table */
.table-wrap { overflow-x: auto; padding: 0 32px 32px; }

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

.fields-table tbody tr { transition: background var(--transition); }
.fields-table tbody tr:hover { background: var(--bg); }
.fields-table tbody tr:last-child td { border-bottom: none; }

.action-btns { display: flex; gap: 8px; align-items: center; }

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
.btn-edit:hover { background: #fde68a; transform: translateY(-1px); }

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
.btn-delete:hover { background: #fecaca; transform: translateY(-1px); }

.empty-state {
    text-align: center;
    color: var(--text-3);
    padding: 48px 20px;
    font-size: 14px;
}

/* Avatar inisial */
.user-avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: var(--primary-lt);
    color: var(--primary-dk);
    font-size: 13px;
    font-weight: 700;
    font-family: 'Space Grotesk', monospace;
    flex-shrink: 0;
}

.user-name-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

@media (max-width: 1024px) { .fields-section { padding: 48px 40px; } }
@media (max-width: 768px) {
    .fields-section { padding: 32px 20px; }
    .form-grid { grid-template-columns: 1fr; }
    .fields-card-header, .fields-form, .table-wrap { padding-left: 20px; padding-right: 20px; }
}
</style>

<script>
let usersCache = {};
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
    ['id', 'name', 'email'].forEach(id => document.getElementById(id).value = '');
    document.getElementById('form-title').textContent = 'Tambah User Baru';
}

function escapeHtml(str) {
    if (!str) return '-';
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function getInitial(name) {
    return name ? name.charAt(0).toUpperCase() : '?';
}

function load() {
    fetch('/api/users')
        .then(res => { if (!res.ok) throw new Error('Gagal memuat data'); return res.json(); })
        .then(users => {
            usersCache = {};
            let html = '';

            if (users.length === 0) {
                html = '<tr><td colspan="4" class="empty-state">Belum ada data user</td></tr>';
            } else {
                users.forEach(u => {
                    usersCache[u.id] = u;
                    html += `
                    <tr>
                        <td><span style="font-family:'Space Grotesk',monospace;font-weight:600;color:var(--text-3)">#${u.id}</span></td>
                        <td>
                            <div class="user-name-cell">
                                <div class="user-avatar">${getInitial(u.name)}</div>
                                <span style="font-weight:600">${escapeHtml(u.name)}</span>
                            </div>
                        </td>
                        <td style="color:var(--text-2)">${escapeHtml(u.email)}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-edit" onclick="edit(${u.id})">✏️ Edit</button>
                                <button class="btn-delete" onclick="hapus(${u.id})">🗑️ Hapus</button>
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
    const id    = document.getElementById('id').value;
    const name  = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();

    if (!name || !email) {
        showAlert('Nama dan email wajib diisi!', 'warning');
        return;
    }

    const isUpdate = !!id;
    const url = isUpdate ? `/api/users/${id}` : '/api/users';

    fetch(url, {
        method: isUpdate ? 'PUT' : 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getToken() },
        body: JSON.stringify({ name, email })
    })
    .then(res => {
        if (!res.ok) return res.json().then(e => { throw new Error(e.message || 'Gagal menyimpan') });
        return res.json();
    })
    .then(() => {
        showAlert(isUpdate ? '✅ User berhasil diperbarui!' : '✅ User berhasil ditambahkan!');
        resetForm();
        load();
    })
    .catch(err => showAlert(err.message, 'danger'));
}

function edit(id) {
    const u = usersCache[id];
    if (!u) return;
    document.getElementById('id').value    = u.id;
    document.getElementById('name').value  = u.name;
    document.getElementById('email').value = u.email;
    document.getElementById('form-title').textContent = `Edit User — ${u.name}`;
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function hapus(id) {
    if (!confirm('Yakin mau hapus user ini?')) return;
    fetch(`/api/users/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': getToken() }
    })
    .then(res => { if (!res.ok) throw new Error('Gagal menghapus'); return res.json(); })
    .then(() => { showAlert('🗑️ User berhasil dihapus!'); load(); })
    .catch(err => showAlert(err.message, 'danger'));
}

load();
</script>

@endsection
