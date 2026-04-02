import 'package:flutter/material.dart';
import 'package:intl/intl.dart';
import '../models/models.dart';
import '../theme/app_theme.dart';

class AdminScreen extends StatefulWidget {
  const AdminScreen({super.key});

  @override
  State<AdminScreen> createState() => _AdminScreenState();
}

class _AdminScreenState extends State<AdminScreen> {
  List<Booking> bookings = List.from(dummyBookings);
  BookingStatus? _filterStatus;

  List<Booking> get filtered {
    if (_filterStatus == null) return bookings;
    return bookings.where((b) => b.status == _filterStatus).toList();
  }

  int _countStatus(BookingStatus s) => bookings.where((b) => b.status == s).length;

  void _updateStatus(Booking booking, BookingStatus newStatus) {
    setState(() => booking.status = newStatus);
    final label = newStatus == BookingStatus.approved ? 'Disetujui' : 'Ditolak';
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Row(
          children: [
            Icon(
              newStatus == BookingStatus.approved
                  ? Icons.check_circle_outline
                  : Icons.cancel_outlined,
              color: Colors.white,
              size: 18,
            ),
            const SizedBox(width: 8),
            Text('Booking ${booking.id} $label'),
          ],
        ),
        backgroundColor: newStatus == BookingStatus.approved
            ? const Color(0xFF166534)
            : const Color(0xFF991B1B),
        behavior: SnackBarBehavior.floating,
        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Panel Admin'),
        leading: IconButton(
          icon: const Icon(Icons.arrow_back_ios_new_rounded),
          onPressed: () => Navigator.pop(context),
        ),
      ),
      body: Column(
        children: [
          _buildStatsRow(),
          _buildFilterChips(),
          Expanded(
            child: filtered.isEmpty
                ? const Center(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        Text('📋', style: TextStyle(fontSize: 48)),
                        SizedBox(height: 12),
                        Text('Tidak ada booking',
                            style: TextStyle(color: AppTheme.textMuted)),
                      ],
                    ),
                  )
                : ListView.builder(
                    padding: const EdgeInsets.fromLTRB(16, 4, 16, 24),
                    itemCount: filtered.length,
                    itemBuilder: (ctx, i) => _buildBookingCard(filtered[i]),
                  ),
          ),
        ],
      ),
    );
  }

  Widget _buildStatsRow() {
    return Padding(
      padding: const EdgeInsets.all(16),
      child: Row(
        children: [
          _statTile(bookings.length.toString(), 'Total', const Color(0xFF667EEA)),
          const SizedBox(width: 10),
          _statTile(_countStatus(BookingStatus.pending).toString(), 'Pending',
              const Color(0xFFD97706)),
          const SizedBox(width: 10),
          _statTile(_countStatus(BookingStatus.approved).toString(), 'Approved',
              const Color(0xFF166534)),
          const SizedBox(width: 10),
          _statTile(_countStatus(BookingStatus.rejected).toString(), 'Rejected',
              const Color(0xFF991B1B)),
        ],
      ),
    );
  }

  Widget _statTile(String num, String label, Color color) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 12),
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: const Color(0xFFE8EAF0)),
        ),
        child: Column(
          children: [
            Text(
              num,
              style: TextStyle(
                fontSize: 22,
                fontWeight: FontWeight.w800,
                color: color,
              ),
            ),
            const SizedBox(height: 2),
            Text(label,
                style: const TextStyle(fontSize: 10, color: AppTheme.textMuted)),
          ],
        ),
      ),
    );
  }

  Widget _buildFilterChips() {
    return SingleChildScrollView(
      scrollDirection: Axis.horizontal,
      padding: const EdgeInsets.symmetric(horizontal: 16),
      child: Row(
        children: [
          _filterChip('Semua', null),
          const SizedBox(width: 8),
          _filterChip('Pending', BookingStatus.pending),
          const SizedBox(width: 8),
          _filterChip('Approved', BookingStatus.approved),
          const SizedBox(width: 8),
          _filterChip('Rejected', BookingStatus.rejected),
        ],
      ),
    );
  }

  Widget _filterChip(String label, BookingStatus? status) {
    final isSelected = _filterStatus == status;
    return GestureDetector(
      onTap: () => setState(() => _filterStatus = status),
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 7),
        decoration: BoxDecoration(
          gradient: isSelected ? AppTheme.primaryGradient : null,
          color: isSelected ? null : Colors.white,
          borderRadius: BorderRadius.circular(20),
          border: Border.all(
            color: isSelected ? Colors.transparent : const Color(0xFFE8EAF0),
          ),
        ),
        child: Text(
          label,
          style: TextStyle(
            fontSize: 12,
            fontWeight: FontWeight.w600,
            color: isSelected ? Colors.white : AppTheme.textMuted,
          ),
        ),
      ),
    );
  }

  Widget _buildBookingCard(Booking booking) {
    return Card(
      margin: const EdgeInsets.only(bottom: 12),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              children: [
                Text(
                  booking.id,
                  style: const TextStyle(
                    fontSize: 12,
                    fontWeight: FontWeight.w700,
                    color: AppTheme.textMuted,
                  ),
                ),
                const Spacer(),
                _statusBadge(booking.status),
              ],
            ),
            const SizedBox(height: 10),
            Text(
              booking.fieldName,
              style: const TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.w700,
                color: AppTheme.textDark,
              ),
            ),
            const SizedBox(height: 6),
            Row(
              children: [
                const Icon(Icons.person_outline_rounded,
                    size: 13, color: AppTheme.textMuted),
                const SizedBox(width: 4),
                Text(booking.bookerName,
                    style: const TextStyle(fontSize: 13, color: AppTheme.textMuted)),
              ],
            ),
            const SizedBox(height: 4),
            Row(
              children: [
                const Icon(Icons.calendar_today_outlined,
                    size: 13, color: AppTheme.textMuted),
                const SizedBox(width: 4),
                Text(
                  DateFormat('dd MMM yyyy').format(booking.date),
                  style: const TextStyle(fontSize: 13, color: AppTheme.textMuted),
                ),
                const SizedBox(width: 14),
                const Icon(Icons.schedule_outlined,
                    size: 13, color: AppTheme.textMuted),
                const SizedBox(width: 4),
                Text(
                  '${booking.startTime.format(context)} – ${booking.endTime.format(context)}',
                  style: const TextStyle(fontSize: 13, color: AppTheme.textMuted),
                ),
              ],
            ),
            if (booking.status == BookingStatus.pending) ...[
              const SizedBox(height: 14),
              const Divider(height: 1, color: Color(0xFFF0F0F5)),
              const SizedBox(height: 12),
              Row(
                children: [
                  Expanded(
                    child: OutlinedButton.icon(
                      icon: const Icon(Icons.close_rounded, size: 16),
                      label: const Text('Tolak'),
                      onPressed: () =>
                          _updateStatus(booking, BookingStatus.rejected),
                      style: OutlinedButton.styleFrom(
                        foregroundColor: const Color(0xFF991B1B),
                        side: const BorderSide(color: Color(0xFFFCA5A5)),
                        padding: const EdgeInsets.symmetric(vertical: 10),
                        shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10)),
                        textStyle: const TextStyle(
                            fontWeight: FontWeight.w600, fontSize: 13),
                      ),
                    ),
                  ),
                  const SizedBox(width: 10),
                  Expanded(
                    child: ElevatedButton.icon(
                      icon: const Icon(Icons.check_rounded, size: 16),
                      label: const Text('Setujui'),
                      onPressed: () =>
                          _updateStatus(booking, BookingStatus.approved),
                      style: ElevatedButton.styleFrom(
                        backgroundColor: const Color(0xFF166534),
                        foregroundColor: Colors.white,
                        elevation: 0,
                        padding: const EdgeInsets.symmetric(vertical: 10),
                        shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(10)),
                        textStyle: const TextStyle(
                            fontWeight: FontWeight.w600, fontSize: 13),
                      ),
                    ),
                  ),
                ],
              ),
            ],
          ],
        ),
      ),
    );
  }

  Widget _statusBadge(BookingStatus status) {
    final configs = {
      BookingStatus.pending: (
        label: 'Pending',
        bg: const Color(0xFFFEF9C3),
        text: const Color(0xFF854D0E),
        icon: Icons.hourglass_empty_rounded,
      ),
      BookingStatus.approved: (
        label: 'Approved',
        bg: const Color(0xFFF0FDF4),
        text: const Color(0xFF166534),
        icon: Icons.check_circle_outline_rounded,
      ),
      BookingStatus.rejected: (
        label: 'Rejected',
        bg: const Color(0xFFFFF5F5),
        text: const Color(0xFF991B1B),
        icon: Icons.cancel_outlined,
      ),
    };
    final c = configs[status]!;
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
      decoration: BoxDecoration(
        color: c.bg,
        borderRadius: BorderRadius.circular(20),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(c.icon, size: 12, color: c.text),
          const SizedBox(width: 4),
          Text(
            c.label,
            style: TextStyle(
              fontSize: 11,
              fontWeight: FontWeight.w700,
              color: c.text,
            ),
          ),
        ],
      ),
    );
  }
}
