import 'package:flutter/material.dart';
import '../models/models.dart';
import '../theme/app_theme.dart';
import '../widgets/common_widgets.dart';
import 'payment_screen.dart';

class BookingScreen extends StatefulWidget {
  final SportField? preselectedField;
  const BookingScreen({super.key, this.preselectedField});

  @override
  State<BookingScreen> createState() => _BookingScreenState();
}

class _BookingScreenState extends State<BookingScreen> {
  final _formKey = GlobalKey<FormState>();
  SportField? _selectedField;
  DateTime? _date;
  TimeOfDay? _startTime;
  TimeOfDay? _endTime;
  final _nameCtrl = TextEditingController();
  final _phoneCtrl = TextEditingController();

  @override
  void initState() {
    super.initState();
    _selectedField = widget.preselectedField;
  }

  @override
  void dispose() {
    _nameCtrl.dispose();
    _phoneCtrl.dispose();
    super.dispose();
  }

  int get _durationHours {
    if (_startTime == null || _endTime == null) return 0;
    final startMin = _startTime!.hour * 60 + _startTime!.minute;
    final endMin = _endTime!.hour * 60 + _endTime!.minute;
    final diff = endMin - startMin;
    return diff > 0 ? (diff / 60).ceil() : 0;
  }

  int get _totalPrice =>
      _selectedField == null ? 0 : _selectedField!.pricePerHour * _durationHours;

  // Format price without intl: 80000 → "80.000"
  String _fmtPrice(int p) {
    final s = p.toString();
    final buf = StringBuffer();
    for (int i = 0; i < s.length; i++) {
      if ((s.length - i) % 3 == 0 && i != 0) buf.write('.');
      buf.write(s[i]);
    }
    return buf.toString();
  }

  String _fmtTime(TimeOfDay t) =>
      '${t.hour.toString().padLeft(2, '0')}:${t.minute.toString().padLeft(2, '0')}';

  // Format date without intl
  String _fmtDate(DateTime d) {
    const days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'];
    const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    final dayName = days[d.weekday - 1];
    return '$dayName, ${d.day} ${months[d.month - 1]} ${d.year}';
  }

  Future<void> _pickDate() async {
    final picked = await showDatePicker(
      context: context,
      initialDate: DateTime.now(),
      firstDate: DateTime.now(),
      lastDate: DateTime.now().add(const Duration(days: 90)),
      builder: (ctx, child) => Theme(
        data: Theme.of(ctx).copyWith(
          colorScheme: const ColorScheme.light(primary: AppColors.primary),
        ),
        child: child!,
      ),
    );
    if (picked != null) setState(() => _date = picked);
  }

  Future<void> _pickTime(bool isStart) async {
    final picked = await showTimePicker(
      context: context,
      initialTime: isStart
          ? const TimeOfDay(hour: 8, minute: 0)
          : const TimeOfDay(hour: 10, minute: 0),
      builder: (ctx, child) => Theme(
        data: Theme.of(ctx).copyWith(
          colorScheme: const ColorScheme.light(primary: AppColors.primary),
        ),
        child: child!,
      ),
    );
    if (picked != null) {
      setState(() {
        if (isStart) _startTime = picked;
        else _endTime = picked;
      });
    }
  }

  void _submit() {
    if (!_formKey.currentState!.validate()) return;
    if (_date == null) { _showErr('Pilih tanggal booking terlebih dahulu.'); return; }
    if (_startTime == null || _endTime == null) { _showErr('Pilih jam mulai dan jam selesai.'); return; }
    if (_durationHours <= 0) { _showErr('Jam selesai harus lebih dari jam mulai.'); return; }

    final booking = BookingData(
      field: _selectedField!,
      date: _date!,
      startTime: _startTime!,
      endTime: _endTime!,
      durationHours: _durationHours,
      totalPrice: _totalPrice,
      bookingId: 'BK${DateTime.now().millisecondsSinceEpoch.toString().substring(7)}',
    );

    Navigator.push(context, MaterialPageRoute(builder: (_) => PaymentScreen(booking: booking)));
  }

  void _showErr(String msg) {
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(
      content: Row(children: [
        const Icon(Icons.error_outline_rounded, color: Colors.white, size: 18),
        const SizedBox(width: 8),
        Expanded(child: Text(msg)),
      ]),
      backgroundColor: AppColors.error,
    ));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Form Booking'), leading: const BackButton()),
      body: Form(
        key: _formKey,
        child: SingleChildScrollView(
          padding: const EdgeInsets.all(20),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _stepLabel('1', 'Pilih Lapangan'),
              const SizedBox(height: 10),
              _fieldDropdown(),
              const SizedBox(height: 20),
              _stepLabel('2', 'Tanggal & Waktu'),
              const SizedBox(height: 10),
              _datePicker(),
              const SizedBox(height: 12),
              Row(children: [
                Expanded(child: _timePicker('Jam Mulai', _startTime, () => _pickTime(true))),
                const SizedBox(width: 12),
                Expanded(child: _timePicker('Jam Selesai', _endTime, () => _pickTime(false))),
              ]),
              if (_startTime != null && _endTime != null && _durationHours > 0) ...[
                const SizedBox(height: 12),
                _durationCard(),
              ],
              const SizedBox(height: 20),
              _stepLabel('3', 'Data Pemesan'),
              const SizedBox(height: 10),
              TextFormField(
                controller: _nameCtrl,
                decoration: const InputDecoration(
                  labelText: 'Nama Lengkap',
                  prefixIcon: Icon(Icons.person_outline_rounded, size: 20, color: AppColors.textHint),
                ),
                validator: (v) => (v == null || v.trim().isEmpty) ? 'Nama wajib diisi' : null,
              ),
              const SizedBox(height: 12),
              TextFormField(
                controller: _phoneCtrl,
                keyboardType: TextInputType.phone,
                decoration: const InputDecoration(
                  labelText: 'No. WhatsApp',
                  hintText: '08xxxxxxxxxx',
                  prefixIcon: Icon(Icons.phone_outlined, size: 20, color: AppColors.textHint),
                ),
                validator: (v) => (v == null || v.trim().isEmpty) ? 'Nomor WA wajib diisi' : null,
              ),
              const SizedBox(height: 24),
              if (_totalPrice > 0) _priceSummary(),
              const SizedBox(height: 16),
              PrimaryButton(
                label: 'Lanjut ke Pembayaran',
                icon: Icons.arrow_forward_rounded,
                onPressed: _selectedField != null ? _submit : null,
              ),
              const SizedBox(height: 24),
            ],
          ),
        ),
      ),
    );
  }

  Widget _stepLabel(String num, String label) {
    return Row(children: [
      Container(
        width: 24, height: 24,
        decoration: const BoxDecoration(color: AppColors.primary, shape: BoxShape.circle),
        child: Center(child: Text(num, style: const TextStyle(color: Colors.white, fontSize: 12, fontWeight: FontWeight.w700))),
      ),
      const SizedBox(width: 10),
      Text(label, style: const TextStyle(fontSize: 15, fontWeight: FontWeight.w700, color: AppColors.textPrimary)),
    ]);
  }

  Widget _fieldDropdown() {
    return DropdownButtonFormField<SportField>(
      value: _selectedField,
      isExpanded: true,
      decoration: const InputDecoration(
        labelText: 'Pilih Lapangan',
        prefixIcon: Icon(Icons.stadium_outlined, size: 20, color: AppColors.textHint),
      ),
      items: allFields.map((f) => DropdownMenuItem(
        value: f,
        child: Row(children: [
          Text(f.emoji, style: const TextStyle(fontSize: 16)),
          const SizedBox(width: 8),
          Expanded(child: Text(f.name, style: const TextStyle(fontSize: 14), overflow: TextOverflow.ellipsis)),
          if (!f.isAvailable)
            const Text(' (Penuh)', style: TextStyle(fontSize: 11, color: AppColors.warning)),
        ]),
      )).toList(),
      onChanged: (v) => setState(() => _selectedField = v),
      validator: (v) => v == null ? 'Pilih lapangan terlebih dahulu' : null,
    );
  }

  Widget _datePicker() {
    return GestureDetector(
      onTap: _pickDate,
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
        decoration: BoxDecoration(
          color: AppColors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: AppColors.border, width: 1.2),
        ),
        child: Row(children: [
          const Icon(Icons.calendar_today_outlined, size: 20, color: AppColors.textHint),
          const SizedBox(width: 12),
          Text(
            _date != null ? _fmtDate(_date!) : 'Pilih tanggal booking',
            style: TextStyle(fontSize: 14, color: _date != null ? AppColors.textPrimary : AppColors.textHint),
          ),
          const Spacer(),
          const Icon(Icons.keyboard_arrow_down_rounded, color: AppColors.textHint),
        ]),
      ),
    );
  }

  Widget _timePicker(String label, TimeOfDay? time, VoidCallback onTap) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 14),
        decoration: BoxDecoration(
          color: AppColors.white,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: AppColors.border, width: 1.2),
        ),
        child: Row(children: [
          const Icon(Icons.access_time_rounded, size: 18, color: AppColors.textHint),
          const SizedBox(width: 8),
          Column(crossAxisAlignment: CrossAxisAlignment.start, children: [
            Text(label, style: const TextStyle(fontSize: 10, color: AppColors.textHint)),
            Text(
              time != null ? _fmtTime(time) : '--:--',
              style: TextStyle(
                fontSize: 16, fontWeight: FontWeight.w700,
                color: time != null ? AppColors.textPrimary : AppColors.textHint,
              ),
            ),
          ]),
        ]),
      ),
    );
  }

  Widget _durationCard() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
      decoration: BoxDecoration(color: AppColors.primaryLight, borderRadius: BorderRadius.circular(12)),
      child: Row(children: [
        const Icon(Icons.timer_outlined, color: AppColors.primary, size: 18),
        const SizedBox(width: 10),
        Text('Durasi: $_durationHours jam', style: const TextStyle(color: AppColors.primary, fontWeight: FontWeight.w600, fontSize: 14)),
      ]),
    );
  }

  Widget _priceSummary() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: BorderRadius.circular(14),
        border: Border.all(color: AppColors.border),
      ),
      child: Column(children: [
        Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: [
          const Text('Harga / jam', style: TextStyle(fontSize: 13, color: AppColors.textSecondary)),
          Text('Rp ${_fmtPrice(_selectedField?.pricePerHour ?? 0)}', style: const TextStyle(fontSize: 13, color: AppColors.textSecondary)),
        ]),
        const SizedBox(height: 8),
        Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: [
          const Text('Durasi', style: TextStyle(fontSize: 13, color: AppColors.textSecondary)),
          Text('$_durationHours jam', style: const TextStyle(fontSize: 13, color: AppColors.textSecondary)),
        ]),
        const Padding(padding: EdgeInsets.symmetric(vertical: 10), child: Divider()),
        Row(mainAxisAlignment: MainAxisAlignment.spaceBetween, children: [
          const Text('Total Pembayaran', style: TextStyle(fontSize: 15, fontWeight: FontWeight.w700, color: AppColors.textPrimary)),
          Text('Rp ${_fmtPrice(_totalPrice)}', style: const TextStyle(fontSize: 17, fontWeight: FontWeight.w800, color: AppColors.primary)),
        ]),
      ]),
    );
  }
}
