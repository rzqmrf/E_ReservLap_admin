@extends('layouts.user')

@section('styles')
<style>
    body {
        background-color: #F5F7FA;
        font-family: 'Poppins', sans-serif;
    }

    .home-header {
        padding: 20px;
    }

    .header-content {
        max-width: 1100px;
        margin: auto;
    }

    .logo-text {
        font-size: 22px;
        font-weight: 800;
        margin-bottom: 20px;
    }

    /* HERO */
    .welcome-card {
        background: linear-gradient(135deg, #5B9CFF 0%, #3A7BFF 100%);
        border-radius: 24px;
        padding: 22px;
        color: white;
        box-shadow: 0 8px 25px rgba(58, 123, 255, 0.25);
        margin-bottom: 25px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(255,255,255,0.2);
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 11px;
        margin-bottom: 10px;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        background: #22C55E;
        border-radius: 50%;
        margin-right: 6px;
    }

    .welcome-card h2 {
        font-size: 22px;
        margin: 5px 0;
    }

    .welcome-card p {
        font-size: 13px;
        margin-bottom: 18px;
    }

    .card-actions {
        display: flex;
        gap: 10px;
    }

    .btn-card {
        flex: 1;
        padding: 12px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
    }

    .btn-white {
        background: white;
        color: #3A7BFF;
    }

    .btn-outline {
        border: 1.5px solid rgba(255,255,255,0.6);
        color: white;
    }

    /* SECTION */
    .section-header {
        margin-bottom: 15px;
    }

    .section-header h3 {
        font-size: 16px;
        font-weight: 700;
    }

    .section-header p {
        font-size: 12px;
        color: #718096;
    }

    /* FITUR */
    .features-grid {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        margin-bottom: 25px;
    }

    .features-grid::-webkit-scrollbar {
        display: none;
    }

    .feature-card {
    min-width: 120px;
    background: white;
    border-radius: 18px;
    padding: 16px 12px;
    flex-shrink: 0;

    display: flex;
    flex-direction: column;

    align-items: flex-start; /* ← KUNCI: geser ke kiri */
}

/* ICON */
.feature-icon {
    width: 42px;
    height: 42px;
    background: #EBF4FF;
    border-radius: 12px;

    display: flex;
    align-items: center;
    justify-content: center;

    color: #3A7BFF;
    margin-bottom: 10px;

    margin-left: 4px; /* ← biar ga nempel kiri banget */
}

/* TEXT */
.feature-card h4 {
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 4px;
    margin-left: 4px; /* ← ikut geser */
}

.feature-card span {
    font-size: 10px;
    color: #A0AEC0;
    line-height: 1.3;
    margin-left: 4px; /* ← ikut geser */
}

    /* LAPANGAN */
    .fields-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .fields-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        padding-bottom: 80px;
    }

    .field-card {
        background: white;
        border-radius: 20px;
        padding: 10px;
        transition: 0.2s;
    }

    .field-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    .field-img-wrapper {
        height: 130px;
        border-radius: 15px;
        overflow: hidden;
        position: relative;
        margin-bottom: 10px;
    }

    .field-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .status-pill {
        position: absolute;
        top: 8px;
        right: 8px;
        font-size: 10px;
        padding: 4px 8px;
        border-radius: 20px;
    }

    .status-available {
        background: #E6FFFA;
        color: #22C55E;
    }

    .status-unavailable {
        background: #FFF5F5;
        color: #F56565;
    }

    .field-details h4 {
        font-size: 13px;
        margin-bottom: 4px;
    }

    .field-meta {
        font-size: 11px;
        color: #718096;
    }

    .field-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
    }

    .field-price {
        font-size: 12px;
        font-weight: bold;
        color: #3A7BFF;
    }

    .btn-select {
        background: #3A7BFF;
        color: white;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 11px;
        text-decoration: none;
    }

    .btn-see-all {
        font-size: 12px;
        color: #3A7BFF;
        text-decoration: none;
    }

    /* RESPONSIVE */
    @media (min-width: 768px) {
        .fields-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 480px) {
        .card-actions {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="home-header">
    <div class="header-content">

        <div class="logo-text">E-ReservLap</div>

        <!-- HERO -->
        <div class="welcome-card">
            <div class="status-badge">
                <div class="status-dot"></div>
                Sistem Aktif
            </div>

            <h2>Halo, {{ explode(' ', Auth::user()->name)[0] }} 👋</h2>
            <p>Reservasi Lapangan olahraga mudah & cepat</p>

            <div class="card-actions">
                <a href="{{ route('lapangan.index') }}" class="btn-card btn-white">Lihat Lapangan</a>
                <a href="{{ route('status.index') }}" class="btn-card btn-outline">Riwayat</a>
            </div>
        </div>

        <!-- FITUR -->
        <div class="section-header">
            <h3>Fitur Unggulan</h3>
            <p>Semua yang anda butuhkan</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-regular fa-clock"></i>
                </div>
                <h4>Cek Jadwal</h4>
                <span>Slot & Kapasitas</span>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-hand-pointer"></i>
                </div>
                <h4>Booking Mudah</h4>
                <span>Cepat & simpel</span>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-regular fa-credit-card"></i>
                </div>
                <h4>Bayar Online</h4>
                <span>Via Midtrans</span>
            </div>
        </div>

        <!-- LAPANGAN -->
        <div class="fields-header">
            <div>
                <h3>Lapangan</h3>
                <p>{{ $lapangans->count() }} lapangan</p>
            </div>
            <a href="{{ route('lapangan.index') }}" class="btn-see-all">Lihat Semua</a>
        </div>

        <div class="fields-container">
            @foreach($lapangans as $field)
            <div class="field-card">
                <div class="field-img-wrapper">
                    <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=400" />
                    <div class="status-pill {{ $field->status == 'available' ? 'status-available' : 'status-full' }}">
                        {{ $field->status == 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                    </div>
                </div>

                <div class="field-details">
                    <h4>{{ $field->name }}</h4>
                    <div class="field-meta">Indoor • {{ $field->type }}</div>

                    <div class="field-footer">
                        <div class="field-price">
                            Rp {{ number_format($field->price, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('lapangan.slot', $field->id) }}" class="btn-select">Lihat</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection