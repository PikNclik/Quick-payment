/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/core/layouts/theme_widget.dart';
import "package:tahsaldar/ui/widgets/instance/instance_builder.dart";

import "../viewmodels/initial_viewmodel.dart";

class InitialMobileScreen extends StatelessWidget {
  const InitialMobileScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<InitialViewModel>(
      builder: (viewModel) {
        return ThemeWidget(
          builder: (context, theme) {
            return Container();
          },
        );
      },
    );
  }
}
