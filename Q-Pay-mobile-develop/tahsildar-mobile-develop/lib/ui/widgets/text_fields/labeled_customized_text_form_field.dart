import 'package:flutter/material.dart';

import '../../resources/text_styles/text_styles.dart';

class LabeledTextField extends StatelessWidget {
  final String label;
  final Widget liveDataTextField;
  const LabeledTextField({required this.label, required this.liveDataTextField, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [const SizedBox(height: 12), Text(label, style: body3), const SizedBox(height: 4), liveDataTextField],
    );
  }
}
