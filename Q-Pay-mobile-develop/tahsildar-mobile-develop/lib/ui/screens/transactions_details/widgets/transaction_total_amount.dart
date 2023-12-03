import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';

import '../../../resources/colors/colors.dart';
import '../../../resources/text_styles/text_styles.dart';

class TransactionTotalAmount extends StatelessWidget {
  final String amount;
  final bool isLarge;
  const TransactionTotalAmount({required this.amount, this.isLarge = false, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        Text(amount, style: isLarge ? headline2.copyWith(color: DesignColors.secondaryColor) : headline1.copyWith(color: DesignColors.secondaryColor)),
        const SizedBox(width: 4),
        Text('sp'.tr(), style: isLarge ? headline1.copyWith(color: DesignColors.secondaryColor) : title3.copyWith(color: DesignColors.secondaryColor)),
      ],
    );
  }
}
