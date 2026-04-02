import 'package:flutter/material.dart';
import '../models/models.dart';
import '../theme/app_theme.dart';
import '../widgets/common_widgets.dart';
import 'status_screen.dart';

class PaymentScreen extends StatefulWidget {
  final BookingData booking;
  const PaymentScreen({super.key, required this.booking});

  @override
  State<PaymentScreen> createState() => _PaymentScreenState();
}

class _PaymentScreenState extends State<PaymentScreen> {
  PaymentMethod _selected = PaymentMethod.bankTransfer;
  String? _proofFileName;
  bool _isLoading = false;

  String _fmtPrice(int p) {
    final s = p.toString();
    final buf = StringBuffer();
    for (int i = 0; i < s.length; i++) {
      if ((s.length - i) % 3 == 0 && i != 0) buf.write('.');
      buf.write(s[i]);
    }
    return buf.toString();
  }

  void _simulatePickImage() {
    setState(() => _proofFileName = 'bukti_transfer_${DateTime.now().millisecondsSinceEpoch}.jpg');
    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Row(children: [
          Icon(Icons.check_circle_outline_rounded, color: Colors.white, size: 18),
          SizedBox(width: 8),
          Text('Bukti pembayaran berhasil diunggah'),
        ]),
      ),
    );
  }

  Future<void> _confirm() async {
    if (_proofFileName == null) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Row(children: [
            Icon(Icons.warning_amber_rounded, color: Colors.white, size: 18),
            SizedBox(width: 8),
            Text('Upload bukti pembayaran terlebih dahulu'),
          ]),
          backgroundColor: AppColors.warning,
        ),
      );
      return;
    }

    setState(() => _isLoading = true);
    await Future.delayed(const Duration(seconds: 2));

    final record = BookingRecord(
      booking: widget.booking,
      paymentMethod: _selected,
      status: BookingStatus.pending,
      createdAt: DateTime.now(),
    );
    bookingHistory.insert(0, record);

    if (!mounted) return;
    setState(() => _isLoading = false);

    ScaffoldMessenger.of(context).showSnackBar(
      const SnackBar(
        content: Row(children: [
          Icon(Icons.check_circle_outline_rounded, color: Colors.white, size: 18),
          SizedBox(width: 8),
          Text('Pembayaran berhasil dikonfirmasi!'),
        ]),
        backgroundColor: AppColors.success,
      ),
    );

    await Future.delayed(const Duration(milliseconds: 800));
    if (!mounted) return;
    Navigator.pushAndRemoveUntil(
      context,
      MaterialPageRoute(builder: (_) => const StatusScreen()),
      (route) => route.isFirst,
    );
  }

  @override
  Widget build(BuildContext context) {
    final b = widget.booking;
    return Scaffold(
      appBar: AppBar(
        title: const Text('Pembayaran'),
        leading: const BackButton(),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(20),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Booking summary
            const Text('Ringkasan Booking',
                style: TextStyle(
                    fontSize: 15,
                    fontWeight: FontWeight.w700,
                    color: AppColors.textPrimary)),
            const SizedBox(height: 12),
            Card(
              child: Padding(
                padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
                child: Column(
                  children: [
                    // Field header
                    Padding(
                      padding: const EdgeInsets.symmetric(vertical: 14),
                      child: Row(
                        children: [
                          Container(
                            width: 44,
                            height: 44,
                            decoration: BoxDecoration(
                              color: b.field.accentBg,
                              borderRadius: BorderRadius.circular(12),
                            ),
                            child: Center(
                              child: Text(b.field.emoji,
                                  style: const TextStyle(fontSize: 22)),
                            ),
                          ),
                          const SizedBox(width: 12),
                          Expanded(
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                Text(b.field.name,
                                    style: const TextStyle(
                                        fontSize: 15,
                                        fontWeight: FontWeight.w700,
                                        color: AppColors.textPrimary)),
                                Text(b.field.category,
                                    style: const TextStyle(
                                        fontSize: 12,
                                        color: AppColors.textSecondary)),
                              ],
                            ),
                          ),
                          Container(
                            padding: const EdgeInsets.symmetric(
                                horizontal: 10, vertical: 4),
                            decoration: BoxDecoration(
                              color: AppColors.primaryLight,
                              borderRadius: BorderRadius.circular(8),
                            ),
                            child: Text(b.bookingId,
                                style: const TextStyle(
                                    fontSize: 11,
                                    fontWeight: FontWeight.w700,
                                    color: AppColors.primary)),
                          ),
                        ],
                      ),
                    ),
                    const Divider(height: 1),
                    InfoRow(
                      icon: Icons.calendar_today_outlined,
                      label: 'Tanggal',
                      value: b.formattedDate,
                    ),
                    const Divider(height: 1),
                    InfoRow(
                      icon: Icons.schedule_outlined,
                      label: 'Waktu',
                      value:
                          '${b.formatTime(b.startTime)} – ${b.formatTime(b.endTime)}',
                    ),
                    const Divider(height: 1),
                    InfoRow(
                      icon: Icons.timer_outlined,
                      label: 'Durasi',
                      value: '${b.durationHours} jam',
                    ),
                    const Divider(height: 1),
                    InfoRow(
                      icon: Icons.payments_outlined,
                      label: 'Total',
                      value: 'Rp ${_fmtPrice(b.totalPrice)}',
                      valueColor: AppColors.primary,
                    ),
                  ],
                ),
              ),
            ),

            const SizedBox(height: 24),
            const Text('Metode Pembayaran',
                style: TextStyle(
                    fontSize: 15,
                    fontWeight: FontWeight.w700,
                    color: AppColors.textPrimary)),
            const SizedBox(height: 12),

            // Bank transfer
            _methodTile(
              PaymentMethod.bankTransfer,
              Icons.account_balance_outlined,
              'Transfer Bank',
              'BCA / BNI / Mandiri / BRI',
            ),
            const SizedBox(height: 10),
            // E-wallet
            _methodTile(
              PaymentMethod.eWallet,
              Icons.wallet_outlined,
              'E-Wallet',
              'GoPay / OVO / DANA / ShopeePay',
            ),

            // Bank info if selected
            if (_selected == PaymentMethod.bankTransfer) ...[
              const SizedBox(height: 12),
              _bankInfo(),
            ],
            if (_selected == PaymentMethod.eWallet) ...[
              const SizedBox(height: 12),
              _walletInfo(),
            ],

            const SizedBox(height: 24),
            const Text('Bukti Pembayaran',
                style: TextStyle(
                    fontSize: 15,
                    fontWeight: FontWeight.w700,
                    color: AppColors.textPrimary)),
            const SizedBox(height: 4),
            const Text(
              'Upload screenshot atau foto bukti transfer',
              style: TextStyle(fontSize: 13, color: AppColors.textSecondary),
            ),
            const SizedBox(height: 12),
            _proofUpload(),

            const SizedBox(height: 28),
            PrimaryButton(
              label: 'Konfirmasi Pembayaran',
              icon: Icons.check_rounded,
              isLoading: _isLoading,
              onPressed: _confirm,
            ),
            const SizedBox(height: 24),
          ],
        ),
      ),
    );
  }

  Widget _methodTile(
      PaymentMethod method, IconData icon, String title, String sub) {
    final isSelected = _selected == method;
    return GestureDetector(
      onTap: () => setState(() => _selected = method),
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 150),
        padding: const EdgeInsets.all(16),
        decoration: BoxDecoration(
          color: isSelected ? AppColors.primaryLight : AppColors.white,
          borderRadius: BorderRadius.circular(14),
          border: Border.all(
            color: isSelected ? AppColors.primary : AppColors.border,
            width: isSelected ? 1.5 : 1,
          ),
        ),
        child: Row(
          children: [
            Container(
              width: 42,
              height: 42,
              decoration: BoxDecoration(
                color: isSelected ? AppColors.primary : AppColors.surface,
                borderRadius: BorderRadius.circular(11),
              ),
              child: Icon(icon,
                  color: isSelected ? Colors.white : AppColors.textSecondary,
                  size: 20),
            ),
            const SizedBox(width: 14),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(title,
                      style: TextStyle(
                          fontSize: 14,
                          fontWeight: FontWeight.w700,
                          color: isSelected
                              ? AppColors.primary
                              : AppColors.textPrimary)),
                  Text(sub,
                      style: const TextStyle(
                          fontSize: 12, color: AppColors.textSecondary)),
                ],
              ),
            ),
            Radio<PaymentMethod>(
              value: method,
              groupValue: _selected,
              activeColor: AppColors.primary,
              onChanged: (v) => setState(() => _selected = v!),
            ),
          ],
        ),
      ),
    );
  }

  Widget _bankInfo() {
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: AppColors.surface,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: AppColors.border),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text('Rekening Tujuan',
              style: TextStyle(
                  fontSize: 12,
                  fontWeight: FontWeight.w700,
                  color: AppColors.textSecondary)),
          const SizedBox(height: 8),
          _bankRow('BCA', '1234-5678-9012'),
          const SizedBox(height: 4),
          _bankRow('Mandiri', '9876-5432-1098'),
          const SizedBox(height: 4),
          _bankRow('a.n.', 'E-ReservLap Indonesia'),
        ],
      ),
    );
  }

  Widget _bankRow(String bank, String number) {
    return Row(
      children: [
        SizedBox(
          width: 70,
          child: Text(bank,
              style: const TextStyle(
                  fontSize: 13, color: AppColors.textSecondary)),
        ),
        Text(number,
            style: const TextStyle(
                fontSize: 13,
                fontWeight: FontWeight.w700,
                color: AppColors.textPrimary)),
      ],
    );
  }

  Widget _walletInfo() {
    return Container(
      padding: const EdgeInsets.all(14),
      decoration: BoxDecoration(
        color: AppColors.surface,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: AppColors.border),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          const Text('Nomor E-Wallet',
              style: TextStyle(
                  fontSize: 12,
                  fontWeight: FontWeight.w700,
                  color: AppColors.textSecondary)),
          const SizedBox(height: 8),
          _bankRow('GoPay/OVO', '0812-3456-7890'),
          const SizedBox(height: 4),
          _bankRow('DANA', '0856-7890-1234'),
          const SizedBox(height: 4),
          _bankRow('a.n.', 'E-ReservLap'),
        ],
      ),
    );
  }

  Widget _proofUpload() {
    return GestureDetector(
      onTap: _simulatePickImage,
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 150),
        width: double.infinity,
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
          color: _proofFileName != null ? AppColors.successBg : AppColors.white,
          borderRadius: BorderRadius.circular(14),
          border: Border.all(
            color: _proofFileName != null
                ? AppColors.success
                : AppColors.border,
            width: _proofFileName != null ? 1.5 : 1,
            style: _proofFileName != null ? BorderStyle.solid : BorderStyle.solid,
          ),
        ),
        child: Column(
          children: [
            Icon(
              _proofFileName != null
                  ? Icons.check_circle_rounded
                  : Icons.upload_file_outlined,
              size: 36,
              color: _proofFileName != null
                  ? AppColors.success
                  : AppColors.textHint,
            ),
            const SizedBox(height: 10),
            Text(
              _proofFileName ?? 'Tap untuk upload bukti pembayaran',
              style: TextStyle(
                  fontSize: 13,
                  fontWeight: FontWeight.w600,
                  color: _proofFileName != null
                      ? AppColors.success
                      : AppColors.textSecondary),
              textAlign: TextAlign.center,
            ),
            if (_proofFileName == null) ...[
              const SizedBox(height: 4),
              const Text('JPG, PNG, maks. 5MB',
                  style:
                      TextStyle(fontSize: 11, color: AppColors.textHint)),
            ],
          ],
        ),
      ),
    );
  }
}
