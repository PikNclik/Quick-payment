import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_gesture.dart';

class ClickableSvg extends StatelessWidget {
  final String svg;
  final bool isFilled;
  final Color color;
  final IconData? icon;
  final Function() callback;
  const ClickableSvg({required this.svg, required this.callback, this.isFilled = false,this.icon, this.color = DesignColors.primaryColor, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AnimatedGesture(
      callback: callback,
      child:icon!=null?
      Icon(
       icon,
        color: color,
      )
          : SvgPicture.asset(
        isFilled ? svg.filledSvgAsset : svg.svgAsset,
        color: color,
      ),
    );
  }
}
