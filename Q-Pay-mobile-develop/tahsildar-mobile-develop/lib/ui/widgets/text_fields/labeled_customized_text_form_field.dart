import 'package:flutter/material.dart';

import '../../resources/text_styles/text_styles.dart';

class LabeledTextField extends StatelessWidget {
  final String label;
  final String? tooltipMessage;
  final Widget liveDataTextField;
  const LabeledTextField(
      {required this.label,this.tooltipMessage, required this.liveDataTextField, Key? key})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const SizedBox(height: 12),
        Row(
          children: [
            Text(label, style: body3.copyWith(fontSize: 14)),
            if (tooltipMessage!=null)
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 10.0),
              child: Tooltip(
                message:
                tooltipMessage,
                showDuration: Duration(seconds: 7),
                padding: EdgeInsets.symmetric(horizontal: 30),
                margin: EdgeInsets.symmetric(horizontal: 30),
                triggerMode: TooltipTriggerMode.tap,
                child: Icon(Icons.info_outline,
                size: 21,),
              ),
            ),
          ],
        ),
        const SizedBox(height: 4),
        liveDataTextField
      ],
    );
  }
}
