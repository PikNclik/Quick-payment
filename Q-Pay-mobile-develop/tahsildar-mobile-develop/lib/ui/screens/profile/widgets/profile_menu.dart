import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/screens/profile/viewmodels/profile_viewmodel.dart';
import 'package:tahsaldar/ui/screens/profile/widgets/profile_tile.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_column.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';
import 'package:tahsaldar/router/app_router.dart';

class ProfileMenu extends StatelessWidget {
  const ProfileMenu({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<ProfileViewModel>(builder: (viewModel) {
      return AnimatedColumn(
        children: [
          ProfileTile(
            tile: 'settings',
            callback: () => appRouter.push(const Settings()),
          ),
          ProfileTile(
            tile: 'logout',
            callback: viewModel.logout,
          ),
        ],
      );
    });
  }
}
