<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    // Buat transaksi Midtrans → kirim snap_token ke Flutter
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
        ]);

        $booking = Booking::with(['user', 'field'])->findOrFail($request->booking_id);

        // Buat atau ambil payment yang sudah ada
        $payment = Payment::firstOrCreate(
            ['booking_id' => $booking->id],
            [
                'amount' => $booking->total_price,
                'method' => 'midtrans',
                'status' => 'unpaid',
            ]
        );

        // Parameter Midtrans
        $params = [
            'transaction_details' => [
                'order_id'     => $booking->booking_code,
                'gross_amount' => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email'      => $booking->user->email,
                'phone'      => $booking->user->phone ?? '',
            ],
            'item_details' => [
                [
                    'id'       => $booking->field->id,
                    'price'    => $booking->field->price,
                    'quantity' => $booking->duration_hours,
                    'name'     => $booking->field->name,
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'payment'    => $payment,
        ]);
    }

    // Webhook dari Midtrans → otomatis update status
    public function webhook(Request $request)
    {
        $notification = new Notification();

        $orderId           = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus       = $notification->fraud_status;

        // Cari booking berdasarkan booking_code
        $booking = Booking::where('booking_code', $orderId)->firstOrFail();
        $payment = Payment::where('booking_id', $booking->id)->firstOrFail();

        if ($transactionStatus == 'capture' && $fraudStatus == 'accept') {
            $payment->update(['status' => 'paid', 'paid_at' => now()]);
            $booking->update(['status' => 'approved']);

        } elseif ($transactionStatus == 'settlement') {
            $payment->update(['status' => 'paid', 'paid_at' => now()]);
            $booking->update(['status' => 'approved']);

        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $payment->update(['status' => 'failed']);
            $booking->update(['status' => 'rejected']);

        } elseif ($transactionStatus == 'pending') {
            $payment->update(['status' => 'unpaid']);
            $booking->update(['status' => 'pending']);
        }

        return response()->json(['message' => 'Webhook berhasil diproses']);
    }

    // Lihat semua payment (untuk dashboard admin)
    public function index()
    {
        return response()->json(
            Payment::with(['booking.user', 'booking.field'])->latest()->get()
        );
    }

    // Lihat detail payment
    public function show($id)
    {
        $payment = Payment::with(['booking.user', 'booking.field'])->findOrFail($id);
        return response()->json($payment);
    }
}
