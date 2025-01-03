/// Generated By XFlutter Cli.
/// 
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/ui/core/layouts/base_scaffold.dart';
import "package:tahsaldar/ui/widgets/instance/instance_state.dart";
import '../../core/layouts/base_app_bar.dart';
import "./viewmodels/reset_password_viewmodel.dart";
import 'package:tahsaldar/ui/widgets/loaders/live_data_loader.dart';
import 'package:tahsaldar/ui/core/responsive/screen_type_layout.dart';



import 'mobile/reset_password_request_mobile_screen.dart';
class ResetPasswordRequestScreen extends StatefulWidget {
  const ResetPasswordRequestScreen({Key? key}) : super(key: key);

  @override
  State<ResetPasswordRequestScreen> createState() => _ResetPasswordRequestScreenState();
}

class _ResetPasswordRequestScreenState extends State<ResetPasswordRequestScreen> with InstanceState<ResetPasswordRequestScreen, ResetPasswordViewModel>, ObserverMixin {
  @override
  Widget screen(context, viewModel) {
    return Stack(
      children: [
         BaseScaffold(
          appBar: (context, theme) => baseAppBar(title: "reset_password".tr()),
          builder: (context, theme) =>   const ScreenTypeLayout(mobile: ResetPasswordRequestMobileScreen() ),
        ),
        LoadingListenerWidget(loading: viewModel.baseParams.loading),
      ],
    );
  }

  @override
  ResetPasswordViewModel registerInstance() => ResetPasswordViewModel();
}
