/// Generated By XFlutter Cli.
/// 
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/ui/core/layouts/base_scaffold.dart';
import "package:tahsaldar/ui/widgets/instance/instance_state.dart";
import '../../core/layouts/base_app_bar.dart';
import "./viewmodels/add_transfer_viewmodel.dart";
import 'package:tahsaldar/ui/widgets/loaders/live_data_loader.dart';
import 'package:tahsaldar/ui/core/responsive/screen_type_layout.dart';
import 'mobile/add_transfer_mobile_screen.dart';


import "package:auto_route/auto_route.dart";
class AddTransferScreen extends StatefulWidget {
  const AddTransferScreen({Key? key}) : super(key: key);

  @override
  State<AddTransferScreen> createState() => _AddTransferScreenState();
}

class _AddTransferScreenState extends State<AddTransferScreen> with InstanceState<AddTransferScreen, AddTransferViewModel>, ObserverMixin {
  @override
  Widget screen(context, viewModel) {
    return Stack(
      children: [
         BaseScaffold(
          appBar: (context, theme) => baseAppBar(title: 'add_transfer_request'.tr()),
          builder:(context, theme) =>   const ScreenTypeLayout(mobile: AddTransferMobileScreen() ),
        ),
        LoadingListenerWidget(loading: viewModel.baseParams.loading),
      ],
    );
  }

  @override
  AddTransferViewModel registerInstance() => AddTransferViewModel();
}
