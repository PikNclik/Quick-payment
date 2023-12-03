import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/core/layouts/theme_widget.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_gesture.dart';
import 'package:share_plus/share_plus.dart';

class ShareWidget extends StatelessWidget {
  final String message;
  const ShareWidget(this.message, {Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AnimatedGesture(
      callback: () => Share.share(message),
      child: ThemeWidget(
        builder: (context, theme) => Icon(
          Icons.share,
          color: theme.primaryColor,
        ),
      ),
    );
  }
}
