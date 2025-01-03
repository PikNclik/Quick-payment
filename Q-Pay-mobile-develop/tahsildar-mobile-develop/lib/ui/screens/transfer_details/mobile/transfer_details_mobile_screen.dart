/// Generated By XFlutter Cli.
/// 
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:flutter/material.dart';
import "package:flutterx_live_data/flutterx_live_data.dart";
import "package:tahsaldar/ui/widgets/instance/instance_builder.dart";
import "../../../../models/data/payment/payment.dart";
import "../../../core/layouts/theme_widget.dart";
import "../../../resources/dimensions/dimensions.dart";
import "../../../resources/text_styles/text_styles.dart";
import "../../../widgets/animations/animated_column.dart";
import "../../../widgets/buttons/customized_button.dart";
import "../../transactions_details/widgets/transaction_date.dart";
import "../../transactions_details/widgets/transaction_details_card.dart";
import "../../transactions_details/widgets/transaction_note.dart";
import "../viewmodels/transfer_details_viewmodel.dart";
import "../widgets/transfer_details_card.dart";


class TransferDetailsMobileScreen extends StatelessWidget {
  const TransferDetailsMobileScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<TransferDetailsViewModel>(
      builder: (viewModel) {
        return ThemeWidget(
          builder: (context, theme) {
            return LiveDataBuilder<Payment>(
              data: viewModel.params.transfer,
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
                        ],
                      ),
                      const SizedBox(height: 13),
                      TransferDetailsCard(transfer: value),


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
