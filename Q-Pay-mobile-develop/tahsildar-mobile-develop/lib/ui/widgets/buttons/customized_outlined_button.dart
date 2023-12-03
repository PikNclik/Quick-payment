/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/core/layouts/theme_widget.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';

import '../animations/scale_fade_widget.dart';

class CustomizedOutlinedButton extends StatefulWidget {
  final String text;
  final bool enabled;
  final Function() callback;
  final ButtonStyle? style;
  final Color? color;
  final double? width;
  const CustomizedOutlinedButton({
    required this.text,
    required this.callback,
    this.enabled = true,
    this.style,
    this.color,
    this.width,
    Key? key,
  }) : super(key: key);

  @override
  State<CustomizedOutlinedButton> createState() => _CustomizedOutlinedButtonState();
}

class _CustomizedOutlinedButtonState extends State<CustomizedOutlinedButton> {
  final GlobalKey<ScaleFadeWidgetState> globalKey = GlobalKey<ScaleFadeWidgetState>();
  final GlobalKey<ScaleFadeWidgetState> childKey = GlobalKey<ScaleFadeWidgetState>();
  @override
  Widget build(BuildContext context) {
    return ThemeWidget(
      builder: (context, theme) {
        return ScaleFadeWidget(
          key: globalKey,
          type: AnimationType.scale,
          scaleValue: 0.015,
          duration: const Duration(milliseconds: 175),
          child: GestureDetector(
            onTap: () async {
              if (!widget.enabled) return;
              globalKey.currentState?.animate();
              childKey.currentState?.animate();
              Future.delayed(const Duration(milliseconds: 300), widget.callback);
            },
            child: Container(
              height: 35,
              width: widget.width,
              padding: const EdgeInsets.symmetric(horizontal: 25, vertical: 8),
              decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(20),
                  color: !widget.enabled ? DesignColors.grey : DesignColors.secondaryBackgroundColor,
                  border: Border.all(
                    color: widget.enabled ? DesignColors.primaryColor : DesignColors.secondaryBackgroundColor,
                  )),
              child: Center(
                child: ScaleFadeWidget(
                  duration: const Duration(milliseconds: 200),
                  type: AnimationType.fade,
                  fadeValue: 0.5,
                  key: childKey,
                  child: Text(
                    widget.text.tr(),
                    style: const TextStyle(
                      fontSize: 12,
                      fontWeight: FontWeight.w400,
                      color: DesignColors.primaryColor,
                    ),
                  ),
                ),
              ),
            ),
          ),
        );
      },
    );
  }
}
