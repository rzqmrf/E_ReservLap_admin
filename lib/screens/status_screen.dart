import 'package:flutter/material.dart';
import '../models/models.dart';
import '../theme/app_theme.dart';
import '../widgets/common_widgets.dart';
import 'booking_screen.dart';

class StatusScreen extends StatefulWidget {
  const StatusScreen({super.key});

  @override
  State<StatusScreen> createState() => _StatusScreenState();
}

class _StatusScreenState extends State<StatusScreen> {
  String _fmtPrice(int p) {
    final s = p.toString();
    final buf = StringBuffer();
    for (int i = 0; i < s.length; i++) {
      if ((s.length - i) % 3 == 0 && i != 0) buf.write('.');
      buf.write(s[i]);
    }
    return buf.toString();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Status Booking'),
        leading: const BackButton(),
        actions: [
          if (bookingHistory.isNotEmpty)
            TextButton(
              onPressed: () {
                showDialog(
                  context: context,
                  builder: (ctx) => AlertDialog(
                    shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(16)),
                    title: const Text('Hapus Riwayat'),
                    content: const Text(
                        'Hapus semua riwayat booking?'),
                    actions: [
                      TextButton(
                          onPressed: () => Navigator.pop(ctx),
                          child: const Text('Batal')),
                      TextButton(
                          onPressed: () {
                            bookingHistory.clear();
                            setState(() {});
                            Navigator.pop(ctx);
                          },
                          child: const Text('Hapus',
                              style: TextStyle(color: AppColors.error))),
                    ],
                  ),
                );
              },
              child: const Text('Hapus',
                  style: TextStyle(
                      color: AppColors.error, fontWeight: FontWeight.w600)),
            ),
        ],
      ),
      body: bookingHistory.isEmpty
          ? _emptyState(context)
          : RefreshIndicator(
              onRefresh: () async {
                await Future.delayed(const Duration(milliseconds: 600));
                setState(() {});
              },
              color: AppColors.primary,
              child: ListView.separated(
                padding: const EdgeInsets.all(20),
                separatorBuilder: (_, __) => const SizedBox(height: 12),
                itemCount: bookingHistory.length,
                itemBuilder: (ctx, i) => _buildCard(bookingHistory[i]),
              ),
            ),
    );
  }

  Widget _emptyState(BuildContext context) {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(40),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            Container(
              width: 88,
              height: 88,
              decoration: BoxDecoration(
                color: AppColors.surface,
                shape: BoxShape.circle,
              ),
              child: const Icon(Icons.receipt_long_outlined,
                  size: 40, color: AppColors.textHint),
            ),
            const SizedBox(height: 20),
            const Text('Belum Ada Booking',
                style: TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.w700,
                    color: AppColors.textPrimary)),
            const SizedBox(height: 8),
            const Text(
              'Riwayat booking Anda akan\nmuncul di sini setelah pembayaran',
              textAlign: TextAlign.center,
              style: TextStyle(
                  fontSize: 14,
                  color: AppColors.textSecondary,
                  height: 1.5),
            ),
            const SizedBox(height: 28),
            PrimaryButton(
              label: 'Booking Sekarang',
              icon: Icons.add_rounded,
              width: 200,
              onPressed: () => Navigator.push(
                context,
                MaterialPageRoute(builder: (_) => const BookingScreen()),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildCard(BookingRecord record) {
    final b = record.booking;
    final statusConfig = _statusConfig(record.status);

    return Card(
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Header row
            Row(
              children: [
                Container(
                  width: 40,
                  height: 40,
                  decoration: BoxDecoration(
                    color: b.field.accentBg,
                    borderRadius: BorderRadius.circular(10),
                  ),
                  child: Center(
                    child: Text(b.field.emoji,
                        style: const TextStyle(fontSize: 20)),
                  ),
                ),
                const SizedBox(width: 12),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(b.field.name,
                          style: const TextStyle(
                              fontSize: 14,
                              fontWeight: FontWeight.w700,
                              color: AppColors.textPrimary)),
                      Text(b.bookingId,
                          style: const TextStyle(
                              fontSize: 12, color: AppColors.textSecondary)),
                    ],
                  ),
                ),
                StatusChip(
                  label: statusConfig.$1,
                  color: statusConfig.$2,
                  bgColor: statusConfig.$3,
                  icon: statusConfig.$4,
                ),
              ],
            ),
            const SizedBox(height: 14),
            const Divider(height: 1),
            const SizedBox(height: 10),

            // Status illustration
            Row(
              children: [
                _statusStep(
                    Icons.receipt_long_outlined,
                    'Dipesan',
                    true),
                _statusLine(record.status != BookingStatus.pending),
                _statusStep(
                  Icons.payments_outlined,
                  'Pembayaran',
                  record.status != BookingStatus.pending,
                ),
                _statusLine(record.status == BookingStatus.success),
                _statusStep(
                  record.status == BookingStatus.success
                      ? Icons.check_circle_outline_rounded
                      : record.status == BookingStatus.rejected
                          ? Icons.cancel_outlined
                          : Icons.hourglass_empty_rounded,
                  record.status == BookingStatus.success
                      ? 'Disetujui'
                      : record.status == BookingStatus.rejected
                          ? 'Ditolak'
                          : 'Menunggu',
                  record.status != BookingStatus.pending,
                  color: statusConfig.$2,
                ),
              ],
            ),
            const SizedBox(height: 14),
            const Divider(height: 1),
            const SizedBox(height: 4),

            // Info
            _infoTile(Icons.calendar_today_outlined, b.formattedDate),
            _infoTile(
                Icons.schedule_outlined,
                '${b.formatTime(b.startTime)} – ${b.formatTime(b.endTime)} · ${b.durationHours} jam'),
            _infoTile(
                record.paymentMethod == PaymentMethod.bankTransfer
                    ? Icons.account_balance_outlined
                    : Icons.wallet_outlined,
                record.paymentMethod == PaymentMethod.bankTransfer
                    ? 'Transfer Bank'
                    : 'E-Wallet'),
            _infoTile(Icons.payments_outlined,
                'Rp ${_fmtPrice(b.totalPrice)}',
                valueColor: AppColors.primary),
          ],
        ),
      ),
    );
  }

  Widget _statusStep(IconData icon, String label, bool active,
      {Color? color}) {
    final c = active ? (color ?? AppColors.primary) : AppColors.textHint;
    return Column(
      children: [
        Icon(icon, size: 20, color: c),
        const SizedBox(height: 4),
        Text(label,
            style: TextStyle(
                fontSize: 10,
                color: c,
                fontWeight: active ? FontWeight.w600 : FontWeight.w400)),
      ],
    );
  }

  Widget _statusLine(bool active) {
    return Expanded(
      child: Container(
        height: 1.5,
        margin: const EdgeInsets.fromLTRB(6, 0, 6, 14),
        color: active ? AppColors.primary : AppColors.border,
      ),
    );
  }

  Widget _infoTile(IconData icon, String text, {Color? valueColor}) {
    return Padding(
      padding: const EdgeInsets.symmetric(vertical: 5),
      child: Row(
        children: [
          Icon(icon, size: 15, color: AppColors.textHint),
          const SizedBox(width: 8),
          Expanded(
            child: Text(
              text,
              style: TextStyle(
                  fontSize: 13,
                  color: valueColor ?? AppColors.textSecondary,
                  fontWeight: valueColor != null
                      ? FontWeight.w700
                      : FontWeight.w400),
            ),
          ),
        ],
      ),
    );
  }

  (String, Color, Color, IconData) _statusConfig(BookingStatus s) {
    switch (s) {
      case BookingStatus.pending:
        return (
          'Menunggu',
          AppColors.warning,
          AppColors.warningBg,
          Icons.hourglass_empty_rounded,
        );
      case BookingStatus.success:
        return (
          'Berhasil',
          AppColors.success,
          AppColors.successBg,
          Icons.check_circle_outline_rounded,
        );
      case BookingStatus.rejected:
        return (
          'Ditolak',
          AppColors.error,
          AppColors.errorBg,
          Icons.cancel_outlined,
        );
    }
  }
}
