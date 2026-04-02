import 'package:flutter/material.dart';

// ─── Field Model ───────────────────────────────────────────────
class SportField {
  final String id;
  final String name;
  final String category;
  final int pricePerHour;
  final double rating;
  final int reviewCount;
  final bool isAvailable;
  final String emoji;
  final Color accentColor;
  final Color accentBg;

  const SportField({
    required this.id,
    required this.name,
    required this.category,
    required this.pricePerHour,
    required this.rating,
    required this.reviewCount,
    required this.isAvailable,
    required this.emoji,
    required this.accentColor,
    required this.accentBg,
  });
}

final List<SportField> allFields = [
  SportField(
    id: 'F001',
    name: 'Lapangan Futsal A',
    category: 'Futsal · Indoor',
    pricePerHour: 80000,
    rating: 4.9,
    reviewCount: 128,
    isAvailable: true,
    emoji: '⚽',
    accentColor: Color(0xFF38A169),
    accentBg: Color(0xFFEBF9F0),
  ),
  SportField(
    id: 'F002',
    name: 'Lapangan Badminton 1',
    category: 'Badminton · Indoor',
    pricePerHour: 45000,
    rating: 4.8,
    reviewCount: 96,
    isAvailable: true,
    emoji: '🏸',
    accentColor: Color(0xFF4A90E2),
    accentBg: Color(0xFFEBF3FD),
  ),
  SportField(
    id: 'F003',
    name: 'Lapangan Basket Outdoor',
    category: 'Basket · Outdoor',
    pricePerHour: 120000,
    rating: 4.7,
    reviewCount: 74,
    isAvailable: false,
    emoji: '🏀',
    accentColor: Color(0xFFD69E2E),
    accentBg: Color(0xFFFFF9E6),
  ),
  SportField(
    id: 'F004',
    name: 'Lapangan Voli Indoor',
    category: 'Voli · Indoor',
    pricePerHour: 95000,
    rating: 4.6,
    reviewCount: 52,
    isAvailable: true,
    emoji: '🏐',
    accentColor: Color(0xFF805AD5),
    accentBg: Color(0xFFF3EFFF),
  ),
  SportField(
    id: 'F005',
    name: 'Meja Tenis',
    category: 'Tenis Meja · Indoor',
    pricePerHour: 30000,
    rating: 4.5,
    reviewCount: 41,
    isAvailable: true,
    emoji: '🏓',
    accentColor: Color(0xFFE53E3E),
    accentBg: Color(0xFFFFF0F0),
  ),
  SportField(
    id: 'F006',
    name: 'Lapangan Tenis',
    category: 'Tenis · Outdoor',
    pricePerHour: 150000,
    rating: 4.9,
    reviewCount: 83,
    isAvailable: true,
    emoji: '🎾',
    accentColor: Color(0xFF0D9488),
    accentBg: Color(0xFFECFDF5),
  ),
];

// ─── Booking Model ─────────────────────────────────────────────
class BookingData {
  final SportField field;
  final DateTime date;
  final TimeOfDay startTime;
  final TimeOfDay endTime;
  final int durationHours;
  final int totalPrice;
  final String bookingId;

  BookingData({
    required this.field,
    required this.date,
    required this.startTime,
    required this.endTime,
    required this.durationHours,
    required this.totalPrice,
    required this.bookingId,
  });

  String get formattedDate {
    const months = [
      'Jan','Feb','Mar','Apr','Mei','Jun',
      'Jul','Agu','Sep','Okt','Nov','Des'
    ];
    return '${date.day} ${months[date.month - 1]} ${date.year}';
  }

  String formatTime(TimeOfDay t) {
    final h = t.hour.toString().padLeft(2, '0');
    final m = t.minute.toString().padLeft(2, '0');
    return '$h:$m';
  }
}

// ─── Payment Method ────────────────────────────────────────────
enum PaymentMethod { bankTransfer, eWallet }

enum BookingStatus { pending, success, rejected }

class BookingRecord {
  final BookingData booking;
  final PaymentMethod paymentMethod;
  BookingStatus status;
  final DateTime createdAt;

  BookingRecord({
    required this.booking,
    required this.paymentMethod,
    this.status = BookingStatus.pending,
    required this.createdAt,
  });
}

// ─── Global state (simple) ─────────────────────────────────────
List<BookingRecord> bookingHistory = [];
