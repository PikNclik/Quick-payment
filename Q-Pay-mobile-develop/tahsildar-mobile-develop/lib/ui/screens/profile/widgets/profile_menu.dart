import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/ui/screens/profile/viewmodels/profile_viewmodel.dart';
import 'package:tahsaldar/ui/screens/profile/widgets/profile_tile.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_column.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';
import 'package:tahsaldar/router/app_router.dart';

import '../../../../controllers/auth_controller.dart';
import '../../../widgets/confirmation_dialog/confirmation_dialog.dart';

class ProfileMenu extends StatelessWidget {
  const ProfileMenu({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<ProfileViewModel>(builder: (viewModel) {
      return AnimatedColumn(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          ProfileTile(
            tile: 'settings',
            callback: () => appRouter.push(const Settings()),
          ),
          ProfileTile(
            isPassword: true,
            tile: 'change_password',
            callback: () => appRouter.push(const ChangePassword()),
          ),
          ProfileTile(
            tile: 'logout',
            callback: viewModel.logout,
          ),
          if (user.isFake())
          TextButton(onPressed: (){
            ConfirmDialog.openDialog(
              context: context,
              message: "delete_account_confirmation".tr(),
              onConfirm: () {
                viewModel.deleteUser();
              },
            );

          }, child: Text("delete_account".tr()))
        ],
      );
    });
  }
}
