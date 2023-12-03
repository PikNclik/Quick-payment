import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';

class EmptyView extends StatelessWidget {
  final String message;
  const EmptyView({required this.message, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.center,
      children: [
        Center(
          child: Text(
            message,
            style: title2,
          ),
        ),
      ],
    );
  }
}
