/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/core/layouts/theme_widget.dart';
import 'package:tahsaldar/ui/screens/login/widgets/login_form.dart';
import 'package:tahsaldar/ui/shared/auth_frame/auth_frame.dart';
import "package:tahsaldar/ui/widgets/instance/instance_builder.dart";

import "../viewmodels/login_viewmodel.dart";

class LoginMobileScreen extends StatelessWidget {
  const LoginMobileScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<LoginViewModel>(
      builder: (viewModel) {
        return ThemeWidget(
          builder: (context, theme) {
            return AuthFrame(
              image: 'login',
              animationType: AnimationType.roulette,
              title: 'enter_the_same_mobile_number'.tr(),
              body: 'you_will_receive_otp'.tr(),
              widget: const LoginForm(),
              actionText: 'next',
              enabled: viewModel.params.success,
              action: viewModel.login,
            );
          },
        );
      },
    );
  }
}
