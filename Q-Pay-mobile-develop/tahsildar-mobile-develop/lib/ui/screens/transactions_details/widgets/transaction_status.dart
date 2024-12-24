import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/svg.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';

import '../../../resources/text_styles/text_styles.dart';

class TransactionStatus extends StatelessWidget {
  final String status;
  final TextStyle? style;
  const TransactionStatus({required this.status, Key? key,this.style
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Row(
      mainAxisAlignment: MainAxisAlignment.end,
      children: [
        SvgPicture.asset(status.svgAsset),
        const SizedBox(width: 4),
        Text(status.tr(), textAlign: TextAlign.end, style:style ?? body4),
      ],
    );
  }
}
