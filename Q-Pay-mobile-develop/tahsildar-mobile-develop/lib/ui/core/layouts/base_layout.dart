import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/core/layouts/base_scroll_view.dart';

class BaseLayout extends StatelessWidget {
  final Widget child;
  final double top;
  const BaseLayout({required this.child, this.top = 50, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: EdgeInsets.fromLTRB(16, top, 16, 0),
      child: BaseScrollView(child: child),
    );
  }
}
