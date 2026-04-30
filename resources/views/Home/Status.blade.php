@extends('layouts.user')

@section('styles')
<style>
    .header-page {
        padding: 20px;
        background: var(--white);
        margin-bottom: 20px;
    }

    .header-page h2 {
        font-size: 20px;
        font-weight: 700;
    }

    .status-list {
        padding: 0 20px;
    }

    .booking-card {
        background: var(--white);
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: var(--shadow);
    }

    .booking-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }

    .booking-date {
        font-size: 12px;
        color: var(--text-gray);
        font-weight: 600;
    }

    .booking-id {
        font-size: 10px;
        background: #f0f4f8;
        padding: 2px 8px;
        border-radius: 5px;
        color: #4a5568;
    }

    .booking-card-body h4 {
        font-size: 18px;
        margin-bottom: 15px;
    }

    /* Stepper */
    .stepper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        position: relative;
    }

    .stepper::before {
        content: "";
        position: absolute;
        top: 10px;
        left: 0;
        right: 0;
        height: 2px;
        background: #E2E8F0;
        z-index: 1;
    }

    .step {
        position: relative;
        z-index: 2;
        background: var(--white);
        padding: 0 5px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
    }

    .step-circle {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #CBD5E0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: white;
    }

    .step.active .step-circle { background: var(--primary); }
    .step.completed .step-circle { background: #38B2AC; }

    .step-label {
        font-size: 10px;
        font-weight: 600;
        color: var(--text-gray);
    }

    .step.active .step-label { color: var(--primary); }
    .step.completed .step-label { color: #38B2AC; }

    .booking-details {
        background: #F7FAFC;
        padding: 12px;
        border-radius: 12px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 10px;
        color: var(--text-gray);
        margin-bottom: 2px;
    }

    .detail-value {
        font-size: 12px;
        font-weight: 700;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 80px;
        color: var(--primary-light);
        margin-bottom: 20px;
    }

    .empty-state h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .empty-state p {
        font-size: 14px;
        color: var(--text-gray);
        margin-bottom: 25px;
    }
</style>
@endsection

@section('content')
<div class="header-page">
    <h2>Status Booking</h2>
</div>

<div class="status-list">
    @forelse($bookings as $booking)
    <div class="booking-card">
        <div class="booking-card-header">
            <span class="booking-date">{{ \Carbon\Carbon::parse($booking->booking_date)->isoFormat('LL') }}</span>
            <span class="booking-id">#RES-{{ $booking->id }}</span>
        </div>
        <div class="booking-card-body">
            <h4>{{ $booking->field->name }}</h4>
            
            <div class="stepper">
                <div class="step {{ $booking->status != 'pending' ? 'completed' : 'active' }}">
                    <div class="step-circle">{!! $booking->status != 'pending' ? '<i class="fa-solid fa-check"></i>' : '1' !!}</div>
                    <span class="step-label">Menunggu</span>
                </div>
                <div class="step {{ $booking->status == 'paid' || $booking->status == 'completed' ? 'completed' : ($booking->status == 'pending' ? '' : 'active') }}">
                    <div class="step-circle">{!! $booking->status == 'paid' || $booking->status == 'completed' ? '<i class="fa-solid fa-check"></i>' : '2' !!}</div>
                    <span class="step-label">Bayar</span>
                </div>
                <div class="step {{ $booking->status == 'completed' ? 'completed' : '' }}">
                    <div class="step-circle">{!! $booking->status == 'completed' ? '<i class="fa-solid fa-check"></i>' : '3' !!}</div>
                    <span class="step-label">Selesai</span>
                </div>
            </div>

            <div class="booking-details">
                <div class="detail-item">
                    <span class="detail-label">Waktu</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Total Biaya</span>
                    <span class="detail-value" style="color: var(--primary);">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="fa-solid fa-receipt"></i>
        <h3>Belum ada booking</h3>
        <p>Riwayat booking anda akan muncul di sini setelah anda melakukan pemesanan.</p>
        <a href="{{ route('lapangan.index') }}" class="btn-primary" style="text-decoration: none;">Cari Lapangan</a>
    </div>
    @endforelse
</div>
@endsection