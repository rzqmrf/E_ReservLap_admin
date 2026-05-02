@extends('layouts.user')

@section('styles')
<style>

/* HEADER */
.header-page {
    padding: 20px;
    font-size: 18px;
    font-weight: 700;
}

/* LIST */
.status-list {
    padding: 0 16px 80px;
}

/* CARD */
.booking-card {
    background: #fff;
    border-radius: 14px;
    padding: 14px;
    margin-bottom: 14px;
    border: 1px solid #E5E7EB;
}

/* TOP */
.booking-card-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.booking-date {
    font-size: 10px;
    color: #9CA3AF;
}

.booking-id {
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 6px;
    background: #F3F4F6;
}

/* TITLE + BADGE */
.booking-title-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.booking-title {
    font-size: 14px;
    font-weight: 600;
}

/* BADGE */
.status-badge {
    font-size: 9px;
    padding: 3px 7px;
    border-radius: 10px;
    font-weight: 600;
}

.pending {
    color: #F97316;
    border: 1px solid #F97316;
}

.success {
    color: #22C55E;
    border: 1px solid #22C55E;
}

/* STEPPER */
.stepper {
    display: flex;
    justify-content: space-between;
    margin: 12px 0;
    position: relative;
}

.stepper::before {
    content: "";
    position: absolute;
    top: 8px;
    left: 0;
    right: 0;
    height: 1px;
    background: #E5E7EB;
}

.step {
    position: relative;
    z-index: 2;
    text-align: center;
    font-size: 9px;
    color: #9CA3AF;
}

/* ICON STYLE (FIGMA STYLE) */
.step-icon {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #E5E7EB;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    font-size: 8px;
}

/* ACTIVE */
.step.active {
    color: #3B82F6;
}

.step.active .step-icon {
    background: #3B82F6;
    color: white;
}

/* DONE */
.step.done {
    color: #22C55E;
}

.step.done .step-icon {
    background: #22C55E;
    color: white;
}

/* DETAIL */
.booking-details {
    font-size: 11px;
    color: #6B7280;
    margin-top: 8px;
}

.booking-details div {
    margin-bottom: 3px;
}

/* PRICE */
.price {
    font-size: 12px;
    font-weight: 600;
    color: #3B82F6;
    margin-top: 5px;
}

/* EMPTY */
.empty-state {
    text-align: center;
    padding: 80px 20px;
}

.empty-state i {
    font-size: 50px;
    color: #3B82F6;
    margin-bottom: 10px;
}

.empty-state h3 {
    font-size: 14px;
    margin-bottom: 5px;
}

.empty-state p {
    font-size: 12px;
    color: #9CA3AF;
}

</style>
@endsection


@section('content')

<div class="header-page">Status Booking</div>

<div class="status-list">

@forelse($bookings as $booking)

<div class="booking-card">

    <!-- HEADER -->
    <div class="booking-card-header">
        <span class="booking-date">
            {{ \Carbon\Carbon::parse($booking->booking_date)->isoFormat('LL') }}
        </span>

        <span class="booking-id">
            #RES-{{ $booking->id }}
        </span>
    </div>

    <!-- TITLE + BADGE -->
    <div class="booking-title-row">
        <div class="booking-title">{{ $booking->field->name }}</div>

        <div class="status-badge 
            {{ $booking->status == 'completed' ? 'success' : 'pending' }}">
            {{ $booking->status == 'completed' ? 'Selesai' : 'Menunggu' }}
        </div>
    </div>

    <!-- STEPPER -->
    <div class="stepper">

        <!-- STEP 1 -->
        <div class="step 
            {{ $booking->status != 'pending' ? 'done' : 'active' }}">
            <div class="step-icon">
                {!! $booking->status != 'pending' ? '<i class="fa-solid fa-check"></i>' : '1' !!}
            </div>
            Booking
        </div>

        <!-- STEP 2 -->
        <div class="step 
            {{ $booking->status == 'paid' || $booking->status == 'completed' ? 'done' : ($booking->status == 'pending' ? '' : 'active') }}">
            <div class="step-icon">
                {!! $booking->status == 'paid' || $booking->status == 'completed' ? '<i class="fa-solid fa-check"></i>' : '2' !!}
            </div>
            Bayar
        </div>

        <!-- STEP 3 -->
        <div class="step 
            {{ $booking->status == 'completed' ? 'done' : '' }}">
            <div class="step-icon">
                {!! $booking->status == 'completed' ? '<i class="fa-solid fa-check"></i>' : '3' !!}
            </div>
            Selesai
        </div>

    </div>

    <!-- DETAIL -->
    <div class="booking-details">
        <div>
            📅 {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
            {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
        </div>

        <div class="price">
            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
        </div>
    </div>

</div>

@empty

<div class="empty-state">
    <i class="fa-regular fa-file-lines"></i>
    <h3>Belum ada booking</h3>
    <p>Riwayat booking akan muncul di sini</p>
</div>

@endforelse

</div>

@endsection