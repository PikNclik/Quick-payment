import 'package:flutter/material.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/ui/widgets/clickable_svg/clickable_svg.dart';

class NotificationsIcon extends StatelessWidget {
  const NotificationsIcon({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return ClickableSvg(svg: 'notifications', callback: () => appRouter.push(const Notifications()));
  }
}
