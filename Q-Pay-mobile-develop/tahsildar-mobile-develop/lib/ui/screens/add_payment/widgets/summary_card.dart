import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:tahsaldar/extensions/data_extension.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/resources/themes/card_style.dart';

class SummaryCard extends StatelessWidget {
  final String amount;
  final String fees;
  final String totalAmount;
  const SummaryCard({required this.amount, required this.fees, required this.totalAmount, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    //Temp condition until card is sorted out if we need all the other values or not
    return amount.isEmpty && fees.isEmpty && totalAmount.isEmpty
        ? const SizedBox.shrink()
        : Container(
            decoration: summaryCardStyle,
            child: Padding(
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
              child: Column(
                children: [
                  _buildSummaryRow('amount'.tr(), amount.toString().formatNumber()),
                  _buildSummaryRow('fees'.tr(), fees.toString().formatNumber()),
                  _buildSummaryRow('total_amount'.tr(), totalAmount.toString().formatNumber(), isBold: true),
                ],
              ),
            ),
          );
  }

  _buildSummaryRow(String label, String value, {bool isBold = false}) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            label,
            style: body4,
          ),
          Text(
            '$value${'sp'.tr()}',
            style: isBold ? headline1 : body2,
          ),
        ],
      ),
    );
  }
}
