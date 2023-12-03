import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';

import '../../../router/app_router.dart';
import '../../resources/text_styles/text_styles.dart';
import '../../widgets/animations/animated_gesture.dart';

PreferredSize baseAppBar({bool isBack = true, List<Widget>? actions, String? title, Function()? backHandler}) {
  return PreferredSize(
    preferredSize: const Size(
      double.infinity,
      60.0,
    ),
    child: Padding(
      padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 0),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Row(
            children: [
              if (isBack)
                BaseBackButton(
                  backHandler: backHandler,
                ),
              if (title != null) Text(title, style: body2),
            ],
          ),
          Row(
            children: actions ?? [],
          )
        ],
      ),
    ),
  );
}

class BaseBackButton extends StatelessWidget {
  final Function()? backHandler;
  const BaseBackButton({Key? key, this.backHandler}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AnimatedGesture(
      callback: backHandler ?? () => appRouter.pop(),
      child: Center(
        child: SvgPicture.asset('arrow-left'.svgAsset, matchTextDirection: true),
      ),
    );
  }
}
