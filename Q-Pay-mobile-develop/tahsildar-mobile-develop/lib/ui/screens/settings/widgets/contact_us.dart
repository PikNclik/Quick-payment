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
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: const [
            SocialMediaIcon(
              svg: 'call',
              number: '011-2224101',
            ),
            SizedBox(width: 20),

            SocialMediaIcon(
              svg: 'whatsapp',
              whatsapp: '0943333323',
            ),
            SizedBox(width: 20),
            SocialMediaIcon(
              svg: 'instagram',
              instagram: 'https://www.instagram.com',
            ),
            SizedBox(width: 20),
            SocialMediaIcon(
              svg: 'messenger',
              messenger: 'ammarshaalan',
            ),
            SizedBox(width: 20),
            SocialMediaIcon(
              svg: 'facebook',
              facebook: 'https://www.facebook.com',
            ),

          ],
        ),
        const SizedBox(height: 42)
      ],
    );
  }
}
