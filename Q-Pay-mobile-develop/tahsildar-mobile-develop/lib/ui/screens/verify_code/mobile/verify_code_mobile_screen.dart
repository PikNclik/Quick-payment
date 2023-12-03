/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/core/layouts/theme_widget.dart';
import 'package:tahsaldar/ui/screens/verify_code/widgets/verify_code_form.dart';
import "package:tahsaldar/ui/widgets/instance/instance_builder.dart";

import '../../../shared/auth_frame/auth_frame.dart';
import "../viewmodels/verify_code_viewmodel.dart";

class VerifyCodeMobileScreen extends StatelessWidget {
  const VerifyCodeMobileScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<VerifyCodeViewModel>(
      builder: (viewModel) {
        return ThemeWidget(
          builder: (context, theme) {
            return AuthFrame(
              image: 'verify-code',
              animationType: AnimationType.fadeInRight,
              title: 'enter_your_code'.tr(),
              body: '${'we_sent_you_the_code'.tr()} ${viewModel.params.mobile}',
              widget: const VerifyCodeForm(),
              actionText: 'next',
              enabled: viewModel.params.submit,
              action: viewModel.verifyCode,
            );
          },
        );
      },
    );
  }
}