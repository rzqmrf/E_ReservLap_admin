@extends('layouts.app')
@section('title', 'Fitur')
@section('content')

    <!-- HERO -->
    <section class="features-hero">
        <h1>Fitur E-ReservLap</h1>
    </section>

    <!-- FEATURES LIST -->
    <section class="features-list">
        <div class="features-grid">

            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Cek Jadwal Realtime</h3>
                <p>Melihat ketersediaan lapangan secara langsung sehingga menghindari benturan jadwal.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Booking Mudah</h3>
                <p>Proses pemesanan lapangan yang cepat dengan memilih tanggal dan waktu sesuai kebutuhan.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">👤</div>
                <h3>Login & Manajemen User</h3>
                <p>Pengguna dapat login untuk mengelola data dan melihat riwayat booking.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">💳</div>
                <h3>Pembayaran & Verifikasi</h3>
                <p>Upload bukti pembayaran dan sistem akan membantu proses verifikasi oleh admin.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Dashboard Admin</h3>
                <p>Admin dapat mengelola lapangan, jadwal, serta memantau seluruh transaksi.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>Data Aman</h3>
                <p>Semua data tersimpan dengan aman dan terstruktur di dalam sistem.</p>
            </div>

        </div>
    </section>

@endsection
