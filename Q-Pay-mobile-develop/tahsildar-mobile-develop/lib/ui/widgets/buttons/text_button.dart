/// Generated By XFlutter Cli.
/// 
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/resources/themes/themes.dart';
import '../animations/scale_fade_widget.dart';

class AppTextButton extends StatefulWidget {
  final String text;
  final TextStyle? textStyle;
  final bool enabled;
  final Function() callback;

  const AppTextButton({
    required this.text,
    this.textStyle,
    required this.callback,
    this.enabled = true,
    Key? key,
  }) : super(key: key);

  @override
  State<AppTextButton> createState() => _AppTextButtonState();
}

class _AppTextButtonState extends State<AppTextButton> {
  final GlobalKey<ScaleFadeWidgetState> globalKey = GlobalKey<ScaleFadeWidgetState>();

  @override
  Widget build(BuildContext context) {
    final textStyle = widget.textStyle ?? textButtonTextStyle(darkMode: Theme.of(context).brightness == Brightness.dark);
    final buttonTextStyle = widget.enabled ? textStyle : textStyle.copyWith(color: Colors.grey.shade400);
    return ScaleFadeWidget(
      key: globalKey,
      duration: const Duration(milliseconds: 150),
      child: TextButton(
        child: Text(widget.text, style: buttonTextStyle),
        onPressed: () {
          if (!widget.enabled) return;
          globalKey.currentState?.animate(callback: widget.callback);
        },
      ),
    );
  }
}
