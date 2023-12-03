import 'package:flutter/material.dart';
import 'package:flutter_svg/svg.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';
import 'package:tahsaldar/extensions/date_extension.dart';
import 'package:tahsaldar/models/data/payment/payment.dart';

import '../../../resources/colors/colors.dart';
import '../../../resources/text_styles/text_styles.dart';

enum TransactionDateType { created, expired, scheduled, paidAt }

class TransactionDate extends StatelessWidget {
  final Payment transaction;
  final TransactionDateType transactionDateType;
  const TransactionDate({required this.transaction, required this.transactionDateType, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Row(
      children: [
        SvgPicture.asset('calender'.svgAsset, color: DesignColors.primaryColor),
        const SizedBox(width: 4),
        _buildDate(transactionDateType),
        // transaction.status == 3
        //     ? transaction.paidAt
        //     : transaction.scheduledDate,
      ],
    );
  }

  _buildDate(TransactionDateType val) {
    switch (val) {
      case TransactionDateType.created:
        return Text(transaction.createdAt?.displayedDatetime ?? "", style: body4);
      case TransactionDateType.expired:
        return Text(transaction.expiryDate?.displayedDatetime ?? "", style: body4);
      case TransactionDateType.scheduled:
        return Text(transaction.scheduledDate?.displayedDatetime ?? "", style: body4);
      case TransactionDateType.paidAt:
        return Text(transaction.paidAt?.displayedDatetime ?? "", style: body4);
    }
  }
}
