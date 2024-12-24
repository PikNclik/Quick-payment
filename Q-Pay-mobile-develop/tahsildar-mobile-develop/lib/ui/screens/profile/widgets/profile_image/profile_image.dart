import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';

import '../../../../../models/data/user/user.dart';
import '../../../../../router/app_router.dart';
import '../../../../core/layouts/theme_widget.dart';
import '../../../../widgets/animations/animated_gesture.dart';
import '../../../../widgets/app_image/app_image.dart';
import 'profile_image_container.dart';

class ProfileImage extends StatefulWidget {
  final MutableLiveData<User> user;
  const ProfileImage({
    required this.user,
    Key? key,
  }) : super(key: key);

  @override
  State<ProfileImage> createState() => ProfileImageState();
}

class ProfileImageState extends State<ProfileImage> {
  pickImage() => appRouter.push(const ImageCropper());

  @override
  Widget build(BuildContext context) {
    return ThemeWidget(
      builder: (context, theme) {
        return ProfileImageContainer(
          themeData: theme,
          child: Stack(
            children: [
              AnimatedGesture(
                  scaleValue: 0.01,
                  fadeValue: 0.75,
                  callback: () => pickImage(),
                  child: LiveDataBuilder<User>(
                    data: widget.user,
                    builder: (context, user) {
                      return AppImage(
                        imageUrl: user.imageUrl() ?? "placeholder".webpAsset,
                        size: 110,
                        isCircle: true,
                        //isFile: image != null,
                        imageResolution: 250,
                      );
                    },
                  )),
            ],
          ),
        );
      },
    );
  }
}
