/// Generated By XFlutter Cli.
/// 
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import "package:tahsaldar/ui/widgets/instance/instance_state.dart";
import '../../../models/data/payment/payment.dart';
import '../../core/layouts/base_app_bar.dart';
import '../../core/layouts/base_scaffold.dart';
import "./viewmodels/transfer_details_viewmodel.dart";
import 'package:tahsaldar/ui/widgets/loaders/live_data_loader.dart';
import 'package:tahsaldar/ui/core/responsive/screen_type_layout.dart';
import 'mobile/transfer_details_mobile_screen.dart';


import "package:auto_route/auto_route.dart";
class TransferDetailsScreen extends StatefulWidget {
  final Payment transfer;

  const TransferDetailsScreen({Key? key,required this.transfer}) : super(key: key);

  @override
  State<TransferDetailsScreen> createState() => _TransferDetailsScreenState();
}

class _TransferDetailsScreenState extends State<TransferDetailsScreen> with InstanceState<TransferDetailsScreen, TransferDetailsViewModel>, ObserverMixin {
  @override
  void onInitState(TransferDetailsViewModel instance) {
    super.onInitState(instance);
    instance.params.transfer.postValue(widget.transfer);
  }

  @override
  Widget screen(context, viewModel) {
    return LiveDataBuilder<bool>(
      data: viewModel.baseParams.loading,
      builder: (context, loading) {
        if (loading) return LoadingListenerWidget(loading: viewModel.baseParams.loading);
        return BaseScaffold(
          appBar: (context, theme) => baseAppBar(title: 'transfer_details'.tr(), actions: [
          ]),
          builder: (context, theme) {
            return const ScreenTypeLayout(mobile: TransferDetailsMobileScreen());
          },
        );
      },
    );
  }

  @override
  TransferDetailsViewModel registerInstance() => TransferDetailsViewModel();
}
