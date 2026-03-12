@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- HERO SECTION -->
    <section class="hero">
        <div class="hero-content">
            <h1>Selamat Datang di Company</h1>
            <p class="hero-subtitle">Kami menyediakan solusi digital terbaik untuk bisnis Anda</p>
            <div class="hero-buttons">
                <a href="#" class="btn btn-primary">Pelajari Lebih Lanjut</a>
                <a href="/contact" class="btn btn-secondary">Hubungi Kami</a>
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="features">
        <h2>Keunggulan Kami</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🚀</div>
                <h3>Cepat & Efisien</h3>
                <p>Solusi kami dirancang untuk memberikan performa maksimal dengan kecepatan yang luar biasa.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>Aman & Terpercaya</h3>
                <p>Keamanan data Anda adalah prioritas utama kami dengan enkripsi tingkat enterprise.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Tim Profesional</h3>
                <p>Tim ahli kami siap membantu Anda mencapai tujuan bisnis dengan dedikasi penuh.</p>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="cta-section">
        <h2>Siap untuk Berkembang?</h2>
        <p>Bergabunglah dengan ribuan pelanggan yang telah merasakan manfaat layanan kami</p>
        <a href="/contact" class="btn btn-primary btn-large">Mulai Sekarang</a>
    </section>
@endsection
