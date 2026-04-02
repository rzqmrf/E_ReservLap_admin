import 'package:flutter/material.dart';
import '../models/models.dart';
import '../theme/app_theme.dart';
import '../widgets/field_card.dart';
import 'booking_screen.dart';

class FieldsScreen extends StatefulWidget {
  const FieldsScreen({super.key});

  @override
  State<FieldsScreen> createState() => _FieldsScreenState();
}

class _FieldsScreenState extends State<FieldsScreen> {
  final _searchCtrl = TextEditingController();
  bool _availableOnly = false;
  String _query = '';

  List<SportField> get _filtered {
    return allFields.where((f) {
      final matchQ = f.name.toLowerCase().contains(_query.toLowerCase()) ||
          f.category.toLowerCase().contains(_query.toLowerCase());
      final matchA = !_availableOnly || f.isAvailable;
      return matchQ && matchA;
    }).toList();
  }

  @override
  void dispose() {
    _searchCtrl.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final filtered = _filtered;
    return Scaffold(
      appBar: AppBar(
        title: const Text('Daftar Lapangan'),
        leading: const BackButton(),
      ),
      body: Column(
        children: [
          // Search + filter bar
          Container(
            color: AppColors.white,
            padding: const EdgeInsets.fromLTRB(16, 12, 16, 12),
            child: Column(
              children: [
                TextField(
                  controller: _searchCtrl,
                  onChanged: (v) => setState(() => _query = v),
                  decoration: InputDecoration(
                    hintText: 'Cari lapangan...',
                    prefixIcon: const Icon(Icons.search_rounded,
                        color: AppColors.textHint, size: 20),
                    suffixIcon: _query.isNotEmpty
                        ? IconButton(
                            icon: const Icon(Icons.clear_rounded,
                                color: AppColors.textHint, size: 18),
                            onPressed: () {
                              _searchCtrl.clear();
                              setState(() => _query = '');
                            })
                        : null,
                  ),
                ),
                const SizedBox(height: 10),
                Row(
                  children: [
                    const Text('Hanya yang tersedia',
                        style: TextStyle(
                            fontSize: 13, color: AppColors.textSecondary)),
                    const Spacer(),
                    Switch.adaptive(
                      value: _availableOnly,
                      onChanged: (v) => setState(() => _availableOnly = v),
                      activeColor: AppColors.primary,
                    ),
                  ],
                ),
              ],
            ),
          ),
          // Count bar
          Container(
            color: AppColors.bgPage,
            padding: const EdgeInsets.fromLTRB(16, 12, 16, 4),
            child: Row(
              children: [
                Text(
                  '${filtered.length} lapangan ditemukan',
                  style: const TextStyle(
                      fontSize: 13,
                      fontWeight: FontWeight.w600,
                      color: AppColors.textSecondary),
                ),
              ],
            ),
          ),
          // Grid
          Expanded(
            child: filtered.isEmpty
                ? Center(
                    child: Column(
                      mainAxisSize: MainAxisSize.min,
                      children: [
                        const Icon(Icons.search_off_rounded,
                            size: 48, color: AppColors.textHint),
                        const SizedBox(height: 12),
                        const Text('Lapangan tidak ditemukan',
                            style: TextStyle(
                                fontSize: 16,
                                fontWeight: FontWeight.w600,
                                color: AppColors.textPrimary)),
                        const SizedBox(height: 4),
                        Text('Coba kata kunci lain',
                            style: TextStyle(
                                fontSize: 13,
                                color: AppColors.textSecondary)),
                      ],
                    ),
                  )
                : GridView.builder(
                    padding: const EdgeInsets.all(16),
                    gridDelegate:
                        const SliverGridDelegateWithFixedCrossAxisCount(
                      crossAxisCount: 2,
                      childAspectRatio: 0.72,
                      crossAxisSpacing: 12,
                      mainAxisSpacing: 12,
                    ),
                    itemCount: filtered.length,
                    itemBuilder: (ctx, i) => FieldCard(
                      field: filtered[i],
                      onBook: () => Navigator.push(
                        ctx,
                        MaterialPageRoute(
                          builder: (_) => BookingScreen(
                              preselectedField: filtered[i]),
                        ),
                      ),
                    ),
                  ),
          ),
        ],
      ),
    );
  }
}
