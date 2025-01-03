/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/config/instance_config.dart';
import 'package:tahsaldar/controllers/theme_controller.dart';

class ThemeWidget extends StatelessWidget {
  /// callback which wrap your widgets in current appTheme
  final Widget Function(BuildContext context, ThemeData theme) builder;

  /// widget with state management for App [ThemeData]
  const ThemeWidget({required this.builder, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final themeController = findInstance<ThemeController>();
    return LiveDataBuilder<ThemeMode>(
      data: themeController.themeMode,
      builder: (context, value) => builder(context, themeController.theme),
    );
  }
}
