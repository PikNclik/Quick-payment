import 'package:flutter/material.dart';

class ProfileImageContainer extends StatelessWidget {
  final ThemeData themeData;
  final Widget child;
  const ProfileImageContainer({required this.themeData, required this.child, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 110,
      height: 110,
      padding: const EdgeInsets.all(7),
      decoration: BoxDecoration(
        shape: BoxShape.circle,
        color: themeData.colorScheme.background,
        boxShadow: const [BoxShadow(blurRadius: 6, color: Color.fromRGBO(0, 0, 0, 0.15))],
      ),
      child: child,
    );
  }
}
