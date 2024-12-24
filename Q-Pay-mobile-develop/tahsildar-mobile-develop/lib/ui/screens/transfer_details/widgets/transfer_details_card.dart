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
import 'package:tahsaldar/ui/screens/transfer_details/viewmodels/transfer_details_viewmodel.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';

import '../../../../utils/fake_utils.dart';

class TransferDetailsCard extends StatelessWidget {
  final Payment transfer;
  const TransferDetailsCard({required this.transfer, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<TransferDetailsViewModel>(
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
                  transfer.customer?.name??'',
                  style: title2,
                ),
              ),
              const SizedBox(height: 13),
              _buildCardRow(
                'account_number_customer',
                Text(
                  transfer.customer?.bankAccountNumber??'',
                  style: title2,
                ),
              ),

              const SizedBox(height: 13),
              _buildCardRow(
                'mobile_number',
                Text(
                  transfer.customer?.phone??'',
                  style: title2,
                ),
              ),
              const SizedBox(height: 13),
              _buildCardRow(
                'amount',
                Text(
                  '${viewModel.amount.toString().formatNumber()} ${FakeUtil.getCurrency()}',
                  style: title3,
                ),
              ),
              const SizedBox(height: 13),
              _buildCardRow(
                'fees',
                Text(
                  '${viewModel.fees.toString().formatNumber()} ${FakeUtil.getCurrency()}',
                  style: title3,
                ),
              ),
              const SizedBox(height: 13),
              _buildCardRow('status', TransactionStatus(status: transactionStatuses[transfer.status] ?? '-')),
              const SizedBox(height: 13),
              _buildCardRow(
                'created_at',
                Text(
                  transfer.customer?.createdAt?.displayedDatetime??'',
                  style: title2,
                ),
              ),            ],
          ),
        );
      },
    );
  }

  _buildCardRow(String label, Widget value) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: [
        Text(label.tr(), style: body4),
        value,
      ],
    );
  }
}
