import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:tahsaldar/extensions/data_extension.dart';
import 'package:tahsaldar/extensions/date_extension.dart';
import 'package:tahsaldar/models/data/payment/payment.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/resources/themes/card_style.dart';
import 'package:tahsaldar/ui/screens/transactions_details/viewmodels/transactions_details_viewmodel.dart';
import 'package:tahsaldar/ui/screens/transactions_details/widgets/transaction_status.dart';
import 'package:tahsaldar/ui/screens/transactions_details/widgets/transaction_total_amount.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';

import '../../../../utils/fake_utils.dart';

class TransactionDetailsCard extends StatelessWidget {
  final Payment transaction;
  const TransactionDetailsCard({required this.transaction, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<TransactionsDetailsViewModel>(
      builder: (viewModel) {
        return Container(
          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 18),
          decoration: transactionCardStyle,
          child: Column(
            children: [
              _buildCardRow(
                'total_amount',
                TransactionTotalAmount(amount: viewModel.totalAmount.toString().formatNumber(), isLarge: true),
              ),
              const Padding(
                padding: EdgeInsets.symmetric(vertical: 14.5),
                child: Divider(),
              ),
              _buildCardRow(
                'payer_name',
                Text(
                  transaction.customer?.name??'',
                  style: title2,
                ),
              ),
              const SizedBox(height: 13),
              _buildCardRow(
                'mobile_number',
                Text(
                  transaction.customer?.phone??'',
                  style: title2,
                ),
              ),
              const SizedBox(height: 13),
              _buildCardRow(
                'amount',
                Text(
                  '${viewModel.amount.toString().formatNumber()} ${FakeUtil.getCurrency()}',
                  style: title2,
                ),
              ),
              const SizedBox(height: 13),
              _buildCardRow(
                'fees',
                Text(
                  '${viewModel.fees.toString().formatNumber()}${FakeUtil.getCurrency()}',
                  style: title2,
                ),
              ),
              const SizedBox(height: 13),
              _buildCardRow('status', TransactionStatus(
                  style: title2,
                  status: transactionStatuses[transaction.status] ?? '-')),
              if (transaction.scheduledDate != null)
                if (transaction.scheduledDate != null) const SizedBox(height: 13),

              _buildCardRow(
                  'schedule_date',
                  Text(
                    transaction.scheduledDate?.displayedDatetime ?? "-",
                    style: title2,
                  ),
                ),
              if (transaction.expiryDate != null) const SizedBox(height: 13),
              if (transaction.expiryDate != null)
                _buildCardRow(
                  'expiry_date',
                  Text(
                    transaction.expiryDate?.displayedDatetime ?? "-",
                    style: title2,
                  ),
                )
            ],
          ),
        );
      },
    );
  }

  _buildCardRow(String label, Widget value) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(label.tr(), style: title2),
        value,
      ],
    );
  }
}
