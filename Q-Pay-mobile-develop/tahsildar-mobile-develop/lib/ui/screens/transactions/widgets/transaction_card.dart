import 'package:flutter/material.dart';
import 'package:tahsaldar/extensions/data_extension.dart';
import 'package:tahsaldar/models/data/payment/payment.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_gesture.dart';
import 'package:tahsaldar/ui/widgets/clickable_svg/clickable_svg.dart';

import '../../../resources/themes/card_style.dart';
import '../../transactions_details/widgets/transaction_date.dart';
import '../../transactions_details/widgets/transaction_status.dart';
import '../../transactions_details/widgets/transaction_total_amount.dart';

///Transactions statuses types (Scheduled, Canceled, Paid)
class TransactionCard extends StatelessWidget {
  final Payment transaction;
  final Function() onDelete;
  const TransactionCard(
      {required this.transaction, required this.onDelete, Key? key})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AnimatedGesture(
      callback: () =>
          appRouter.push(TransactionsDetails(transaction: transaction)),
      child: Container(
        margin: const EdgeInsets.symmetric(vertical: 8),
        decoration: transactionCardStyle,
        child: Column(
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                _buildIdBanner('#${transaction.id}'),
                Padding(
                  padding: const EdgeInsetsDirectional.only(end: 16),
                  child: TransactionStatus(
                      status: transactionStatuses[transaction.status] ?? '-'),
                ),
              ],
            ),
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 15),
              child: Column(
                children: [
                  const SizedBox(height: 8),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      _buildPayeeName(transaction.payerName.toString()),
                      TransactionTotalAmount(
                          amount: transaction.amount.toString().formatNumber())
                    ],
                  ),
                  const SizedBox(height: 4),
                  _buildTransactionReason(transaction.details.toString()),
                  const SizedBox(height: 12),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      TransactionDate(
                        transaction: transaction,
                        transactionDateType: TransactionDateType.created,
                      ),
                      if (!transaction.isNotDeletable())
                        ClickableSvg(
                            svg: 'trash',
                            callback: () {
                              onDelete.call();
                            })
                    ],
                  ),
                  const SizedBox(height: 12),
                ],
              ),
            )
          ],
        ),
      ),
    );
  }

  _buildIdBanner(String id) {
    return Container(
      padding: const EdgeInsets.all(15),
      decoration: const BoxDecoration(
        color: DesignColors.purple3,
        borderRadius: BorderRadius.only(
          bottomRight: Radius.circular(10),
          topLeft: Radius.circular(10),
        ),
      ),
      child: Text(id, style: body2),
    );
  }

  _buildPayeeName(String name) {
    return Text(name, style: title2);
  }

  _buildTransactionReason(String reason) {
    return Row(
      children: [
        Text(reason, style: body4),
      ],
    );
  }
}
