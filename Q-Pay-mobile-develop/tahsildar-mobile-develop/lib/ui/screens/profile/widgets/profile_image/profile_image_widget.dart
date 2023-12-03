import 'package:flutter/material.dart';
import 'package:tahsaldar/controllers/auth_controller.dart';
import 'package:tahsaldar/ui/screens/profile/widgets/profile_image/profile_image.dart';

import '../../../../widgets/animations/customized_animated_widget.dart';
import '../../../../widgets/instance/instance_builder.dart';
import '../../viewmodels/profile_viewmodel.dart';

class ProfileImageWidget extends StatelessWidget {
  const ProfileImageWidget({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<ProfileViewModel>(
      builder: (viewModel) {
        return Align(
          alignment: Alignment.topCenter,
          child: Padding(
            padding: const EdgeInsets.only(top: 12),
            child: CustomizedAnimatedWidget(
              from: 0,
              duration: const Duration(milliseconds: 250),
              child: ProfileImage(
                user: userLiveData,
              ),
            ),
          ),
        );
      },
    );
  }
}
