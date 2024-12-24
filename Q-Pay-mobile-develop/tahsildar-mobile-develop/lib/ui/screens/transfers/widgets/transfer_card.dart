import 'package:flutter/material.dart';
import 'package:tahsaldar/extensions/data_extension.dart';
import 'package:tahsaldar/models/data/payment/payment.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import '../../../resources/themes/card_style.dart';
import '../../transactions_details/widgets/transaction_date.dart';
import '../../transactions_details/widgets/transaction_total_amount.dart';

///Transactions statuses types (Scheduled, Canceled, Paid)
class TransferCard extends StatelessWidget {
  final Payment transfer;

  const TransferCard({required this.transfer, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.symmetric(vertical: 8),
      decoration: transactionCardStyle,
      child: Column(
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              _buildIdBanner('#${transfer.id}'),
              Padding(
                padding: const EdgeInsets.symmetric(horizontal:  20.0),
                child: TransactionTotalAmount(
                    amount: (transfer.amount!+transfer.amount!*0.01).toString().formatNumber()),
              )
            ],
          ),
          Padding(
            padding: const EdgeInsets.all(20.0),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                _buildPayeeName(transfer.customer?.name ?? ''),

                TransactionDate(
                  transaction: transfer,
                  transactionDateType: TransactionDateType.created,
                ),

              ],
            ),
          )
        ],
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
