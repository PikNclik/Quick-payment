import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/resources/themes/card_style.dart';

class SettingsCard extends StatelessWidget {
  final double? height;
  final double? width;
  final Widget child;
  const SettingsCard({this.width = double.infinity, this.height = 100, required this.child, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 20),
      // height: height,
      width: width,
      decoration: settingsCardStyle,
      child: child,
    );
  }
}
