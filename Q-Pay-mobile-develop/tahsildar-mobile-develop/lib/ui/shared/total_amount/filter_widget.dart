import 'package:flutter/material.dart';

import '../../resources/colors/colors.dart';
import '../../resources/text_styles/text_styles.dart';
import '../../widgets/animations/animated_gesture.dart';

class FilterWidget extends StatelessWidget {
  final String label;
  final Function() callback;
  const FilterWidget({required this.callback, required this.label, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AnimatedGesture(
      callback: callback,
      child: Row(
        children: [
          Text(
            label,
            style: title3.copyWith(color: DesignColors.secondaryBackgroundColor, decoration: TextDecoration.underline),
          ),
          const Icon(Icons.arrow_drop_down, color: DesignColors.secondaryBackgroundColor)
        ],
      ),
    );
  }
}
