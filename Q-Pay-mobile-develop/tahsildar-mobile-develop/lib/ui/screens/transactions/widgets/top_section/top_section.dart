import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/controllers/auth_controller.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/screens/transactions/viewmodels/transactions_viewmodel.dart';
import 'package:tahsaldar/ui/screens/transactions/widgets/top_section/profile_icon.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';
import '../../../../resources/text_styles/text_styles.dart';
import '../../../../shared/total_amount/total_amount_card.dart';
import 'direct_send_icon.dart';
import 'notifications_icon.dart';

class TopSection extends StatelessWidget {
  const TopSection({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<TransactionsViewModel>(
      builder: (viewModel) {
        return Container(
          decoration: const BoxDecoration(
            color: DesignColors.purple3,
            borderRadius: BorderRadius.only(
              bottomRight: Radius.circular(10),
              bottomLeft: Radius.circular(10),
            ),
          ),
          child: Stack(
            children: [
              Row(
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  Image.asset('finger-print'.pngAsset),
                ],
              ),
              Padding(
                padding: const EdgeInsets.fromLTRB(16, 16, 16, 0),
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        Text('welcome'.tr(namedArgs: {'model': userLiveData.value.fullName?.split(' ')[0] ?? ''}), style: title2),
                         Row(
                          children: const [
                            ProfileIcon(),
                            SizedBox(width: 16),
                            DirectSend(),
                            SizedBox(width: 16),
                            NotificationsIcon(),
                          ],
                        )
                      ],
                    ),
                    const SizedBox(height: 24),
                    LiveDataBuilder<TotalPaid>(
                      data: viewModel.params.totalPaid,
                      builder: (context, totalPaid) => TotalAmountCard(
                        month: viewModel.params.month,
                        year: viewModel.params.year,
                        totalPaid: totalPaid,
                        filter: viewModel.getTotalPaid,
                      ),
                    ),
                  ],
                ),
              )
            ],
          ),
        );
      },
    );
  }
}
