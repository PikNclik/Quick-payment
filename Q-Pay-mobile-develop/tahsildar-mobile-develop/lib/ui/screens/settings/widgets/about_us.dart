import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';

import '../../../resources/text_styles/text_styles.dart';

class AboutUs extends StatelessWidget {
  const AboutUs({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Column(
      mainAxisAlignment: MainAxisAlignment.spaceAround,
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          'about_tahsaldar'.tr(),
          style: body3,
        ),
        const SizedBox(height: 4),
        Text(
          'about_body'.tr(),
          style: body4,
        ),
      ],
    );
  }
}
