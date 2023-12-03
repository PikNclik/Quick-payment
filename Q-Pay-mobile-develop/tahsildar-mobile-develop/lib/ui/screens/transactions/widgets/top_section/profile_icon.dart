import 'package:flutter/material.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/ui/widgets/clickable_svg/clickable_svg.dart';

class ProfileIcon extends StatelessWidget {
  const ProfileIcon({super.key});

  @override
  Widget build(BuildContext context) {
    return ClickableSvg(svg: 'profile', callback: () => appRouter.push(const Profile()));
  }
}
