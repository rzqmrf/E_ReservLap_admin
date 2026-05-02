@extends('layouts.user')

@section('styles')
<style>

/* HEADER */
.header-field {
    background: var(--white);
    padding: 0;
    display: flex;
    flex-direction: column;
}

.header-field-top {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    position: relative;
    z-index: 10;
}

.back-btn {
    width: 35px; height: 35px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 10px;
    background: #F1F5F9;
    text-decoration: none;
    color: var(--text-dark);
    flex-shrink: 0;
}

.header-field h2 {
    font-size: 18px;
    font-weight: 700;
}

.header-field-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    object-fit: cover;
}

/* DATE */
.date-selection {
    padding: 15px 20px;
    display: flex;
    gap: 10px;
    overflow-x: auto;
}

.date-card {
    min-width: 60px;
    padding: 10px;
    background: #F1F5F9;
    border-radius: 12px;
    text-align: center;
    border: 2px solid transparent;
}

.date-card.active {
    border-color: var(--primary);
    background: #EFF6FF;
}

.date-card span:first-child {
    font-size: 10px;
    color: #64748B;
}

.date-card span:last-child {
    font-size: 16px;
    font-weight: 700;
}

/* LEGEND */
.legend {
    display: flex;
    gap: 15px;
    padding: 0 20px;
    margin-bottom: 10px;
    font-size: 11px;
}

.legend span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 3px;
}

.green { background: #22C55E; }
.red { background: #EF4444; }
.blue { background: #3B82F6; }

/* SLOT */
.slot-grid {
    padding: 0 20px 120px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* CARD BASE */
.slot-card {
    border-radius: 14px;
    padding: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 2px solid;
}

/* STATUS WARNA */
.slot-card.available {
    border-color: #22C55E;
    background: rgba(34,197,94,0.08);
}

.slot-card.full {
    border-color: #EF4444;
    background: rgba(239,68,68,0.08);
}

.slot-card.selected {
    border-color: #3B82F6;
    background: rgba(59,130,246,0.08);
}

/* TEXT */
.slot-time {
    font-size: 14px;
    font-weight: 600;
}

/* LEFT */
.slot-left {
    display: flex;
    flex-direction: column;
}

.slot-status {
    font-size: 12px;
    margin-top: 3px;
}

/* RIGHT */
.slot-right {
    text-align: right;
    font-size: 12px;
}

.people {
    font-weight: 600;
}

.sisa {
    font-size: 11px;
    color: #64748B;
}

/* WARNA TEXT */
.slot-card.available .slot-status,
.slot-card.available .people {
    color: #22C55E;
}

.slot-card.full .slot-status,
.slot-card.full .people {
    color: #EF4444;
}

.slot-card.selected .slot-status,
.slot-card.selected .people {
    color: #3B82F6;
}

/* FOOTER */
.booking-footer {
    position: fixed;
    bottom: 80px;
    width: 100%;
    max-width: 480px;
    padding: 15px 20px;
    background: var(--white);
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 -10px 30px rgba(0,0,0,0.05);
}

.total-price span:first-child {
    font-size: 12px;
    color: #64748B;
}

.total-price span:last-child {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary);
}

.btn-book {
    background: #3B82F6;
    color: white;
    padding: 12px 20px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

/* RESPONSIVE */
@media (min-width: 769px) {
    .slot-grid {
        max-width: 600px;
        margin: auto;
    }
}

</style>
@endsection


@section('content')

<div class="header-field">
    <div class="header-field-top">
        <a href="{{ route('lapangan.index') }}" class="back-btn">
            <i class="fa-solid fa-chevron-left"></i>
        </a>
        <h2>{{ $field->name }}</h2>
    </div>
    <img src="{{ $field->foto_lapangan ? (str_starts_with($field->foto_lapangan, 'http') ? $field->foto_lapangan : asset('storage/' . $field->foto_lapangan)) : 'https://via.placeholder.com/600x200?text=Lapangan' }}" 
         alt="{{ $field->name }}"
         class="header-field-image"
         onerror="this.onerror=null;this.src='https://via.placeholder.com/600x200?text=Lapangan';">
</div>

<!-- DATE -->
<div class="date-selection">
    @php
        $dates = $slots->pluck('date')->unique()->map(fn($d) => \Carbon\Carbon::parse($d));
    @endphp

    @foreach($dates as $i => $date)
    <div class="date-card {{ $i == 0 ? 'active' : '' }}">
        <span>{{ $date->isoFormat('ddd') }}</span>
        <span>{{ $date->format('d') }}</span>
    </div>
    @endforeach
</div>

<!-- LEGEND -->
<div class="legend">
    <span><div class="dot green"></div> Tersedia</span>
    <span><div class="dot red"></div> Penuh</span>
    <span><div class="dot blue"></div> Dipilih</span>
</div>

<!-- SLOT -->
<div class="slot-grid">
@forelse($slots as $slot)

@php
    $isFull = $slot->remaining_capacity <= 0;
@endphp

<div class="slot-card {{ $isFull ? 'full' : 'available' }}">

    <div class="slot-left">
        <div class="slot-time">
            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - 
            {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
        </div>

        <div class="slot-status">
            {{ $isFull ? 'Penuh' : 'Tersedia' }}
        </div>
    </div>

    <div class="slot-right">
        <div class="people">
            👥 {{ $slot->capacity - $slot->remaining_capacity }}/{{ $slot->capacity }} orang
        </div>

        <div class="sisa">
            {{ $isFull ? 'Sisa 0 slot' : 'Sisa '.$slot->remaining_capacity.' slot' }}
        </div>
    </div>

</div>

@empty
<p style="text-align:center;">Belum ada jadwal</p>
@endforelse
</div>

<!-- FOOTER -->
<div class="booking-footer">
    <div class="total-price">
        <span>Total Biaya</span>
        <span>Rp {{ number_format($field->price, 0, ',', '.') }}</span>
    </div>

    <a href="#" class="btn-book">Booking slot ini</a>
</div>

@endsection