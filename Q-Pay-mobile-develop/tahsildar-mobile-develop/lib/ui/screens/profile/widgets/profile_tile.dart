import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_gesture.dart';

import '../../../resources/themes/card_style.dart';

class ProfileTile extends StatelessWidget {
  final String tile;
  final bool isPassword;
  final Function() callback;
  const ProfileTile({required this.tile, required this.callback, this.isPassword=false,Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return AnimatedGesture(
      callback: callback,
      child: Container(
        margin: const EdgeInsets.only(bottom: 16),
        padding: const EdgeInsets.all(12),
        decoration: profileTileStyle,
        child: Row(
          children: [
            isPassword?const Icon(Icons.lock_outline_rounded,color: DesignColors.primaryColor):SvgPicture.asset(tile.svgAsset, color: DesignColors.primaryColor),
            const SizedBox(width: 12),
            Text(tile.tr(), style: title2),
          ],
        ),
      ),
    );
  }
}
