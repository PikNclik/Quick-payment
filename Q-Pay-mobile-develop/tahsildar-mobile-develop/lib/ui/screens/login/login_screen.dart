/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/ui/core/layouts/base_scaffold.dart';
import 'package:tahsaldar/ui/core/responsive/screen_type_layout.dart';
import "package:tahsaldar/ui/widgets/instance/instance_state.dart";
import 'package:tahsaldar/ui/widgets/loaders/live_data_loader.dart';

import "./viewmodels/login_viewmodel.dart";
import 'mobile/login_mobile_screen.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({Key? key}) : super(key: key);

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> with InstanceState<LoginScreen, LoginViewModel>, ObserverMixin {
  @override
  void observeLiveData(lifeCycle, viewModel) {
    // register observers...
  }

  @override
  Widget screen(BuildContext context, viewModel) {
    return Stack(
      children: [
        BaseScaffold(
          builder: (context, theme) {
            return const ScreenTypeLayout(mobile: LoginMobileScreen());
          },
        ),
        LoadingListenerWidget(loading: viewModel.baseParams.loading),
      ],
    );
  }

  @override
  LoginViewModel registerInstance() => LoginViewModel();
}
