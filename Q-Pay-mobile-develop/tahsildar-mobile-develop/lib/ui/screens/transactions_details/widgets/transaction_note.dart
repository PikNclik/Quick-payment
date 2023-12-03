import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/resources/themes/card_style.dart';

class TransactionNote extends StatelessWidget {
  final String note;
  const TransactionNote({required this.note, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.symmetric(horizontal: 17, vertical: 16),
      decoration: transactionCardStyle,
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'payment_details'.tr(),
            style: body4.copyWith(color: DesignColors.grey),
          ),
          const SizedBox(height: 6),
          Text(
            note,
            style: body4,
          ),
        ],
      ),
    );
  }
}
