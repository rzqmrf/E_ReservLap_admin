@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-content">
            <h1>Selamat Datang di E-ReservLap</h1>
            <p class="hero-subtitle">Solusi mudah untuk reservasi berbagai lapangan olahraga secara cepat dan realtime</p>
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary">Booking Sekarang</a>
                <!-- <a href="/contact" class="btn btn-secondary">Booking Sekarang</a> -->
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="features">
        <h2>Fitur Unggulan</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Cek Jadwal Realtime</h3>
                <p>Lihat ketersediaan lapangan secara langsung tanpa takut bentrok jadwal.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Booking Mudah & Cepat</h3>
                <p>Pilih lapangan dan waktu bermain dengan proses yang praktis dan efisien.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💳</div>
                <h3>Pembayaran Terintegrasi</h3>
                <p>Upload bukti pembayaran dan lakukan konfirmasi dengan sistem yang aman dan terstruktur.</p>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
        <h2>Siap Booking Lapangan?</h2>
        <p>Reservasi sekarang dan nikmati kemudahan tanpa ribet</p>
        <a href="/booking" class="btn btn-primary btn-large">Booking Sekarang</a>
    </section>
@endsection
