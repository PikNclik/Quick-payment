/// Generated By XFlutter Cli.
/// 
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:flutter/material.dart';

class AnimatedColorWidget extends StatefulWidget {
  final Color fromColor;
  final Color toColor;
  final Duration duration;
  final Widget Function(AnimationController, Animation<dynamic>) builder;

  /// Change color of your widget with animation.
  /// 
  /// Just call controller.forward() or controller.reverse() inside [builder]
  /// 
  /// example: 
  // AnimatedColorWidget(
  //   fromColor: Colors.blue,
  //   toColor: Colors.green,
  //   builder: (controller, animation) {
  //     {condition} ? controller.forward() : controller.reverse();
  //     return Container(color: animation.value, width: 50, height: 50);
  //   },
  // )
  const AnimatedColorWidget({
    required this.fromColor,
    required this.toColor,
    this.duration = const Duration(milliseconds: 300),
    required this.builder,
    Key? key,
  }) : super(key: key);

  @override
  State<AnimatedColorWidget> createState() => AnimatedColorWidgetState();
}

class AnimatedColorWidgetState extends State<AnimatedColorWidget> with SingleTickerProviderStateMixin {
  late AnimationController animationController;
  late Animation colorTween;

  @override
  void initState() {
    animationController = AnimationController(vsync: this, duration: widget.duration);
    colorTween = ColorTween(begin: widget.fromColor, end: widget.toColor).animate(animationController);
    super.initState();
  }

  @override
  void dispose() {
    animationController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return AnimatedBuilder(
      animation: colorTween,
      builder: (context, child) {
        return widget.builder.call(animationController, colorTween);
      },
    );
  }
}