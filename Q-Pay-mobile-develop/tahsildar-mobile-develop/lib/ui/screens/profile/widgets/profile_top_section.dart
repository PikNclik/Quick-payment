import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/controllers/auth_controller.dart';
import 'package:tahsaldar/ui/screens/profile/widgets/profile_image/profile_image_widget.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_column.dart';

import '../../../../models/data/user/user.dart';
import '../../../resources/text_styles/text_styles.dart';

class ProfileTopSection extends StatelessWidget {
  const ProfileTopSection({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return LiveDataBuilder<User>(
        data: userLiveData,
        builder: (context, user) {
          return AnimatedColumn(children: [
            const ProfileImageWidget(),
            const SizedBox(height: 16),
            //  Image.asset('profile'.pngAsset),
            Text(user.fullName ?? "", style: headline1),
            const SizedBox(height: 4),
            Text(user.phone.toString().replaceAll("+963", "0"), style: title3),
            const SizedBox(height: 4),
            Text(user.bankName(), style: title3),
          ]);
        });
  }
}
