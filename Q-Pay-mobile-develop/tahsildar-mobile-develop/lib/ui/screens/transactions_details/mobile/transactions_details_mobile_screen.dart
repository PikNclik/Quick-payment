/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/models/data/payment/payment.dart';
import 'package:tahsaldar/ui/core/layouts/theme_widget.dart';
import 'package:tahsaldar/ui/resources/dimensions/dimensions.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_column.dart';
import "package:tahsaldar/ui/widgets/instance/instance_builder.dart";

import "../viewmodels/transactions_details_viewmodel.dart";
import '../widgets/transaction_date.dart';
import '../widgets/transaction_details_card.dart';
import '../widgets/transaction_note.dart';

class TransactionsDetailsMobileScreen extends StatelessWidget {
  const TransactionsDetailsMobileScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<TransactionsDetailsViewModel>(
      builder: (viewModel) {
        return ThemeWidget(
          builder: (context, theme) {
            return LiveDataBuilder<Payment>(
              data: viewModel.params.transaction,
              builder: (context, value) {
                return Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 16),
                  child: AnimatedColumn(
                    children: [
                      const SizedBox(height: spaceBelowAppBar),
                      Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Text('#${value.id}', style: headline1),
                          TransactionDate(
                            transaction: value,
                            transactionDateType: value.status == 3
                                ? TransactionDateType.paidAt
                                : TransactionDateType.scheduled,
                          ),
                        ],
                      ),
                      const SizedBox(height: 13),
                      TransactionDetailsCard(transaction: value),
                      const SizedBox(height: 17),
                      TransactionNote(note: value.details ?? ''),
                    ],
                  ),
                );
              },
            );
          },
        );
      },
    );
  }
}