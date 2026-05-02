@extends('layouts.user')

@section('styles')
<style>
/* HEADER */
.header-page {
    padding: 20px;
    background: var(--white);
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 10px rgba(0,0,0,0.02);
}

.header-page h2 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 15px;
}

/* SEARCH */
.search-bar {
    position: relative;
    margin-bottom: 15px;
}

.search-bar i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-gray);
}

.search-bar input {
    width: 100%;
    padding: 12px 12px 12px 45px;
    border-radius: 15px;
    border: 1px solid #E2E8F0;
    background: #F7FAFC;
    font-size: 14px;
    outline: none;
}

.search-bar input:focus {
    border-color: var(--primary);
}

/* FILTER */
.filter-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    margin-bottom: 15px;
}

.filter-section span {
    font-size: 14px;
    font-weight: 600;
}

.toggle-switch {
    position: relative;
    width: 44px;
    height: 24px;
}

.toggle-switch input { display: none; }

.slider {
    position: absolute;
    inset: 0;
    background: #CBD5E0;
    border-radius: 20px;
    cursor: pointer;
}

.slider:before {
    content: "";
    position: absolute;
    width: 18px;
    height: 18px;
    left: 3px;
    bottom: 3px;
    background: white;
    border-radius: 50%;
    transition: 0.3s;
}

input:checked + .slider {
    background: var(--primary);
}

input:checked + .slider:before {
    transform: translateX(20px);
}

/* LIST */
.field-list {
    padding: 0 20px;
}

/* GRID DESKTOP */
@media (min-width: 769px) {
    .field-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}

/* CARD */
.field-item {
    background: var(--white);
    border-radius: 18px;
    padding: 0;
    display: flex;
    flex-direction: column;
    gap: 0;
    margin-bottom: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    text-decoration: none;
    color: var(--text-dark);
    overflow: hidden;
    transition: 0.2s;
}

.field-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
}

/* IMAGE */
.field-item-img {
    width: 100%;
    height: 160px;
    border-radius: 0;
    overflow: hidden;
    flex-shrink: 0;
}

.field-item-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* CONTENT */
.field-item-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 14px;
}

/* TOP */
.field-item-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.field-item-top h4 {
    font-size: 14px;
    font-weight: 600;
    margin: 0;
}

/* TEXT */
.location {
    font-size: 12px;
    color: var(--text-gray);
    margin-top: 2px;
}

.capacity {
    font-size: 11px;
    color: #94A3B8;
}

/* STATUS */
.field-status {
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 10px;
    font-weight: 600;
    background: transparent;
}

.status-available {
    color: #22C55E;
    border: 1px solid #22C55E;
}

.status-full {
    color: #EF4444;
    border: 1px solid #EF4444;
}

/* BOTTOM */
.field-item-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 6px;
}

.field-price {
    font-weight: 700;
    color: var(--primary);
    font-size: 13px;
}

/* BUTTON */
.btn-lihat {
    background: #3B82F6;
    color: white;
    border-radius: 8px;
    padding: 6px 14px;
    font-size: 12px;
}

/* MOBILE */
@media (max-width: 480px) {
    .field-list {
        grid-template-columns: 1fr;
    }

    .field-item-img {
        height: 140px;
    }

    .field-item-top h4 {
        font-size: 13px;
    }
}
</style>
@endsection


@section('content')
<div class="header-page">
    <h2>Lapangan</h2>

    <div class="search-bar">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari lapangan...">
    </div>
</div>

<div class="filter-section">
    <span>Yang tersedia</span>
    <label class="toggle-switch">
        <input type="checkbox">
        <span class="slider"></span>
    </label>
</div>

<div class="field-list">
    @forelse($lapangans as $field)
    <a href="{{ route('lapangan.slot', $field->id) }}" class="field-item">
        <div class="field-item-img">
            <img src="{{ $field->foto_lapangan ? (str_starts_with($field->foto_lapangan, 'http') ? $field->foto_lapangan : asset('storage/' . $field->foto_lapangan)) : 'https://via.placeholder.com/400x160?text=Lapangan' }}"
                 alt="{{ $field->name }}"
                 onerror="this.onerror=null;this.src='https://via.placeholder.com/400x160?text=Lapangan';">
        </div>

        <div class="field-item-content">
            <div class="field-item-top">
                <div style="flex: 1;">
                    <h4>{{ $field->name }}</h4>
                    <div class="location">
                        {{ $field->type }} • Indoor
                    </div>
                    <div class="capacity">
                        👥 Kapasitas {{ $field->capacity ?? 10 }} orang
                    </div>
                </div>

                <span class="field-status {{ $field->status == 'available' ? 'status-available' : 'status-full' }}">
                    {{ $field->status == 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                </span>
            </div>

            <div class="field-item-bottom">
                <div class="field-price">
                    Rp {{ number_format($field->price, 0, ',', '.') }}/jam
                </div>
                <div class="btn-lihat">Lihat</div>
            </div>
        </div>
    </a>

    @empty
    <div style="text-align:center; padding:40px;">
        <p style="color: var(--text-gray);">Belum ada lapangan.</p>
    </div>
    @endforelse
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let pollingInterval;
    let isPolling = true;

    // Fungsi untuk memuat ulang data lapangan
    function loadFields() {
        if (!isPolling) return;

        fetch('/api/fields')
            .then(response => response.json())
            .then(data => {
                updateFieldsDisplay(data);
            })
            .catch(error => {
                console.log('Error loading fields:', error);
            });
    }

    // Fungsi untuk update tampilan lapangan
    function updateFieldsDisplay(fields) {
        const fieldList = document.querySelector('.field-list');
        const searchInput = document.querySelector('.search-bar input');
        const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
        const showAvailableOnly = document.querySelector('.toggle-switch input').checked;

        // Filter lapangan berdasarkan pencarian dan status
        let filteredFields = fields.filter(field => {
            const matchesSearch = field.name.toLowerCase().includes(searchTerm) ||
                                field.type.toLowerCase().includes(searchTerm);
            const matchesStatus = !showAvailableOnly || field.status === 'available';
            return matchesSearch && matchesStatus;
        });

        // Jika tidak ada hasil pencarian
        if (filteredFields.length === 0) {
            fieldList.innerHTML = `
                <div style="text-align:center; padding:40px;">
                    <p style="color: var(--text-gray);">
                        ${searchTerm ? 'Tidak ada lapangan yang sesuai dengan pencarian.' : 'Belum ada lapangan.'}
                    </p>
                </div>
            `;
            return;
        }

        // Generate HTML untuk lapangan
        const fieldsHtml = filteredFields.map(field => {
            const statusClass = field.status === 'available' ? 'status-available' : 'status-full';
            const statusText = field.status === 'available' ? 'Tersedia' : 'Tidak Tersedia';
            const imageUrl = field.foto_lapangan ?
                (field.foto_lapangan.startsWith('http') ? field.foto_lapangan : `/storage/${field.foto_lapangan}`) :
                'https://via.placeholder.com/400x160?text=Lapangan';

            return `
                <a href="/lapangan/${field.id}/slot" class="field-item">
                    <div class="field-item-img">
                        <img src="${imageUrl}"
                             alt="${field.name}"
                             onerror="this.onerror=null;this.src='https://via.placeholder.com/400x160?text=Lapangan';">
                    </div>
                    <div class="field-item-content">
                        <div class="field-item-top">
                            <div style="flex: 1;">
                                <h4>${field.name}</h4>
                                <div class="location">
                                    ${field.type} • Indoor
                                </div>
                                <div class="capacity">
                                    👥 Kapasitas ${field.capacity || 10} orang
                                </div>
                            </div>
                            <span class="field-status ${statusClass}">
                                ${statusText}
                            </span>
                        </div>
                        <div class="field-item-bottom">
                            <div class="field-price">
                                Rp ${new Intl.NumberFormat('id-ID').format(field.price)}/jam
                            </div>
                            <div class="btn-lihat">Lihat</div>
                        </div>
                    </div>
                </a>
            `;
        }).join('');

        fieldList.innerHTML = fieldsHtml;
    }

    // Event listener untuk search
    const searchInput = document.querySelector('.search-bar input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            loadFields(); // Reload data saat search berubah
        });
    }

    // Event listener untuk toggle switch
    const toggleSwitch = document.querySelector('.toggle-switch input');
    if (toggleSwitch) {
        toggleSwitch.addEventListener('change', function() {
            loadFields(); // Reload data saat filter berubah
        });
    }

    // Mulai polling setiap 30 detik
    function startPolling() {
        pollingInterval = setInterval(loadFields, 30000); // 30 detik
    }

    // Stop polling
    function stopPolling() {
        if (pollingInterval) {
            clearInterval(pollingInterval);
            pollingInterval = null;
        }
    }

    // Pause polling saat user tidak aktif (opsional)
    let inactivityTimer;
    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);
        inactivityTimer = setTimeout(() => {
            isPolling = false;
            stopPolling();
        }, 300000); // Pause setelah 5 menit tidak aktif
    }

    // Resume polling saat user aktif kembali
    function resumePolling() {
        if (!isPolling) {
            isPolling = true;
            startPolling();
            loadFields(); // Load data terbaru
        }
        resetInactivityTimer();
    }

    // Event listeners untuk mendeteksi aktivitas user
    ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart'].forEach(event => {
        document.addEventListener(event, resumePolling, true);
    });

    // Mulai polling dan timer inactivity
    startPolling();
    resetInactivityTimer();

    // Load initial data
    loadFields();
});
</script>
@endsection