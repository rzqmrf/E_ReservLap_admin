@extends('layouts.user')

@section('styles')
<style>
    .header-field {
        background: var(--white);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }

    .back-btn {
        width: 35px; height: 35px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px;
        background: #f7fafc;
        color: var(--text-dark);
        text-decoration: none;
    }

    .header-field h2 { font-size: 18px; font-weight: 700; }

    .date-selection {
        padding: 20px;
        overflow-x: auto;
        display: flex;
        gap: 12px;
        margin-bottom: 10px;
    }

    .date-selection::-webkit-scrollbar { display: none; }

    .date-card {
        min-width: 65px;
        padding: 12px;
        background: var(--white);
        border-radius: 15px;
        text-align: center;
        box-shadow: var(--shadow);
        border: 2px solid transparent;
        cursor: pointer;
    }

    .date-card.active {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .date-card span:first-child {
        display: block;
        font-size: 10px;
        color: var(--text-gray);
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .date-card span:last-child {
        font-size: 16px;
        font-weight: 700;
    }

    .slot-grid {
        padding: 0 20px;
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
    }

    @media (min-width: 769px) {
        .slot-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
    }

    .slot-card {
        background: var(--white);
        padding: 15px;
        border-radius: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: var(--shadow);
        border: 2px solid transparent;
        cursor: pointer;
    }

    .slot-time { font-weight: 700; font-size: 14px; }
    
    .slot-info { text-align: right; }
    .slot-status { font-size: 11px; font-weight: 600; display: block; }
    .slot-count { font-size: 10px; color: var(--text-gray); }

    .slot-card.available { border-left: 4px solid #38B2AC; }
    .slot-card.full { border-left: 4px solid #F56565; opacity: 0.6; cursor: not-allowed; }
    .slot-card.selected { border-color: var(--primary); background: var(--primary-light); }

    .booking-footer {
        position: fixed;
        bottom: 80px; /* Above bottom nav */
        width: 100%;
        max-width: 480px;
        padding: 20px;
        background: var(--white);
        box-shadow: 0 -10px 30px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top-left-radius: 25px;
        border-top-right-radius: 25px;
    }

    .total-price span { display: block; }
    .total-price span:first-child { font-size: 12px; color: var(--text-gray); }
    .total-price span:last-child { font-size: 18px; font-weight: 800; color: var(--primary); }

    .btn-book {
        background: var(--primary);
        color: var(--white);
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(0, 136, 255, 0.3);
    }
</style>
@endsection

@section('content')
<div class="header-field">
    <a href="{{ route('lapangan.index') }}" class="back-btn"><i class="fa-solid fa-chevron-left"></i></a>
    <h2>{{ $field->name }}</h2>
</div>

<div class="date-selection">
    @php
        $dates = $slots->pluck('date')->unique()->map(function($date) {
            return \Carbon\Carbon::parse($date);
        });
    @endphp
    @forelse($dates as $index => $date)
    <div class="date-card {{ $index == 0 ? 'active' : '' }}">
        <span>{{ $date->isoFormat('ddd') }}</span>
        <span>{{ $date->format('d') }}</span>
    </div>
    @empty
    <div style="padding: 10px; font-size: 12px; color: var(--text-gray);">Belum ada jadwal.</div>
    @endforelse
</div>

<div class="container">
    <div style="display: flex; gap: 15px; margin-bottom: 15px;">
        <span style="font-size: 11px; display: flex; align-items: center; gap: 5px;">
            <div style="width: 10px; height: 10px; background: #38B2AC; border-radius: 2px;"></div> Tersedia
        </span>
        <span style="font-size: 11px; display: flex; align-items: center; gap: 5px;">
            <div style="width: 10px; height: 10px; background: #F56565; border-radius: 2px;"></div> Penuh
        </span>
        <span style="font-size: 11px; display: flex; align-items: center; gap: 5px;">
            <div style="width: 10px; height: 10px; background: var(--primary); border-radius: 2px;"></div> Dipilih
        </span>
    </div>
</div>

<div class="slot-grid">
    @forelse($slots as $slot)
    <div class="slot-card {{ $slot->remaining_capacity > 0 ? 'available' : 'full' }}">
        <div class="slot-time">{{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</div>
        <div class="slot-info">
            <span class="slot-status" style="color: {{ $slot->remaining_capacity > 0 ? '#38B2AC' : '#F56565' }}">
                {{ $slot->remaining_capacity > 0 ? 'Tersedia' : 'Penuh' }}
            </span>
            <span class="slot-count">{{ $slot->remaining_capacity > 0 ? 'Sisa ' . $slot->remaining_capacity . ' slot' : 'Slot Habis' }}</span>
        </div>
    </div>
    @empty
    <div style="text-align: center; padding: 40px;">
        <p style="color: var(--text-gray);">Jadwal belum tersedia untuk lapangan ini.</p>
    </div>
    @endforelse
</div>

<div class="booking-footer">
    <div class="total-price">
        <span>Total Biaya</span>
        <span>Rp {{ number_format($field->price, 0, ',', '.') }}</span>
    </div>
    <a href="#" class="btn-book" onclick="alert('Lanjutkan ke pembayaran...')">Booking Slot Ini</a>
</div>
@endsection
