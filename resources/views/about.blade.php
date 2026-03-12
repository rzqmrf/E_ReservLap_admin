@extends('layouts.app')
@section('title', 'About')
@section('content')

    <!-- ABOUT HERO -->
    <section class="about-hero">
        <h1>Tentang MyCompany</h1>
        <p>Membangun masa depan digital bersama teknologi inovatif</p>
    </section>

    <!-- COMPANY OVERVIEW -->
    <section class="about-overview">
        <div class="overview-content">
            <div class="overview-text">
                <h2>Siapa Kami?</h2>
                <p>MyCompany adalah perusahaan teknologi yang berfokus pada solusi digital inovatif. Kami berdiri pada tahun
                    2020 dengan misi untuk membantu bisnis tumbuh melalui teknologi.</p>
                <p>Tim kami terdiri dari para ahli di bidang pengembangan perangkat lunak, desain, dan pemasaran digital.
                    Kami percaya bahwa teknologi dapat mengubah dunia, dan kami berkomitmen untuk memberikan layanan terbaik
                    kepada klien kami.</p>
            </div>
            <div class="overview-stats">
                <div class="stat-box">
                    <h3>500+</h3>
                    <p>Klien Puas</p>
                </div>
                <div class="stat-box">
                    <h3>50+</h3>
                    <p>Tim Expert</p>
                </div>
                <div class="stat-box">
                    <h3>100+</h3>
                    <p>Proyek Selesai</p>
                </div>
            </div>
        </div>
    </section>

    <!-- COMPANY VALUES -->
    <section class="company-values">
        <h2>Nilai-Nilai Kami</h2>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">💼</div>
                <h3>Profesional</h3>
                <p>Kami mengutamakan profesionalisme dalam setiap aspek bisnis kami.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3>Kolaborasi</h3>
                <p>Bekerja sama dengan klien untuk mencapai hasil yang optimal.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🎯</div>
                <h3>Fokus</h3>
                <p>Fokus pada tujuan dan memberikan hasil yang terukur.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">♻️</div>
                <h3>Berkelanjutan</h3>
                <p>Komitmen terhadap pertumbuhan dan inovasi berkelanjutan.</p>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="about-cta">
        <h2>Mari Bekerja Sama</h2>
        <p>Kami siap membantu mewujudkan visi digital Anda</p>
        <a href="/contact" class="btn btn-primary btn-large">Hubungi Kami</a>
    </section>

@endsection
