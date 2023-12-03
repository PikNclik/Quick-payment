import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:url_launcher/url_launcher.dart';

import '../animations/animated_gesture.dart';

class SocialMediaIcon extends StatelessWidget {
  final String svg;
  final String? link;
  final String? number;
  final String? whatsapp;
  final String? facebook;
  final String? messenger;
  final String? instagram;
  final double height;
  final double width;
  const SocialMediaIcon({
    Key? key,
    required this.svg,
    this.link,
    this.number,
    this.whatsapp,
    this.facebook,
    this.instagram,
    this.messenger,
    this.height = 28.0,
    this.width = 28.0,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return link == null && number == null && whatsapp == null && facebook == null && instagram == null && messenger == null
        ? const SizedBox.shrink()
        : AnimatedGesture(
            callback: () async {
              if (link != null) {
                await launchUrl(Uri.parse("$link"));
              } else if (number != null) {
                launchUrl(Uri.parse("tel://$number"));
              } else if (whatsapp != null) {
                launchUrl(Uri.parse("whatsapp://send?phone=$whatsapp&text=hello"));
              } else if (facebook != null) {
                launchUrl(Uri.parse("$facebook"));
              } else if (messenger != null) {
                launchUrl(Uri.parse("m.me/$messenger"));
              } else if (instagram != null) {
                launchUrl(Uri.parse("$instagram"), mode: LaunchMode.externalApplication);
              }
            },
            child: SizedBox(
              height: height,
              width: width,
              child: SvgPicture.asset(
                svg.svgAsset,
                color: DesignColors.primaryColor,
              ),
            ),
          );
  }
}
