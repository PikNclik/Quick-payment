import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/widgets/social_media_icon/social_media_icon.dart';

class ContactUs extends StatelessWidget {
  const ContactUs({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Text(
          'contact_us'.tr(),
          style: body3,
        ),
        const SizedBox(height: 10),
        const Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            SocialMediaIcon(
              svg: 'call',
              number: '011-2224101',
            ),
          ],
        ),
        const SizedBox(height: 42)
      ],
    );
  }
}
