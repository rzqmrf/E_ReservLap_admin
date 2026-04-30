@extends('layouts.app')
@section('title', 'About')
@section('content')

    <!-- ABOUT HERO -->
    <section class="about-hero">
        <h1>Tentang E-ReservLap</h1>
        <p>Mempermudah reservasi lapangan olahraga dengan sistem digital</p>
    </section>

    <!-- COMPANY OVERVIEW -->
    <section class="about-overview">
        <div class="overview-content">
            <div class="overview-text">
                <h2>Siapa Kami?</h2>
                <p>E-ReservLap adalah aplikasi berbasis digital yang dirancang untuk mempermudah proses reservasi lapangan olahraga secara online. Sistem ini dikembangkan untuk membantu pengguna dalam melihat ketersediaan jadwal secara realtime dan melakukan pemesanan dengan lebih cepat dan efisien.</p>
                <p>Dengan memanfaatkan teknologi, E-ReservLap bertujuan untuk mengatasi permasalahan seperti benturan jadwal, pencatatan manual, dan kurangnya transparansi dalam proses booking lapangan.</p>
            </div>
            <div class="overview-stats">
                <div class="stat-box">
                    <h3>100+</h3>
                    <p>Pengguna</p>
                </div>
                <div class="stat-box">
                    <h3>10+</h3>
                    <p>Lapangan</p>
                </div>
                <div class="stat-box">
                    <h3>200+</h3>
                    <p>Booking</p>
                </div>
            </div>
        </div>
    </section>

    <!-- COMPANY VALUES -->
    <section class="company-values">
        <h2>Tujuan Sistem</h2>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">⚡</div>
                <h3>Efisiensi</h3>
                <p>Mempermudah proses reservasi tanpa perlu pencatatan manual.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">📅</div>
                <h3>Transparansi</h3>
                <p>Menampilkan jadwal lapangan secara realtime dan akurat.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🔒</div>
                <h3>Keamanan</h3>
                <p>Menjamin data booking dan transaksi tersimpan dengan aman.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">📊</div>
                <h3>Manajemen</h3>
                <p>Membantu pengelola dalam mengatur jadwal dan laporan.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="about-cta">
        <h2>Mulai Booking Sekarang</h2>
        <p>Nikmati kemudahan reservasi lapangan olahraga secara digital</p>
        <a href="/booking" class="btn btn-primary btn-large">Booking Sekarang</a>
    </section>

@endsection
