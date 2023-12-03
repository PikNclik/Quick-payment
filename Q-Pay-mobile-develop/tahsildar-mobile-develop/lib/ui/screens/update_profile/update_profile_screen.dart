/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/ui/core/layouts/base_app_bar.dart';
import 'package:tahsaldar/ui/core/layouts/base_scaffold.dart';
import 'package:tahsaldar/ui/core/responsive/screen_type_layout.dart';
import "package:tahsaldar/ui/widgets/instance/instance_state.dart";
import 'package:tahsaldar/ui/widgets/loaders/live_data_loader.dart';

import "./viewmodels/update_profile_viewmodel.dart";
import 'mobile/update_profile_mobile_screen.dart';

class UpdateProfileScreen extends StatefulWidget {
  const UpdateProfileScreen({Key? key}) : super(key: key);

  @override
  State<UpdateProfileScreen> createState() => _UpdateProfileScreenState();
}

class _UpdateProfileScreenState extends State<UpdateProfileScreen> with InstanceState<UpdateProfileScreen, UpdateProfileViewModel>, ObserverMixin {
  @override
  void observeLiveData(observer, viewModel) {
    // register observers...
  }

  @override
  Widget screen(BuildContext context, viewModel) {
    return Stack(
      children: [
        BaseScaffold(
          appBar: (context, theme) => baseAppBar(title: 'edit_profile'.tr()),
          builder: (context, theme) {
            return const ScreenTypeLayout(mobile: UpdateProfileMobileScreen());
          },
        ),
        LoadingListenerWidget(loading: viewModel.baseParams.loading),
      ],
    );
  }

  @override
  UpdateProfileViewModel registerInstance() => UpdateProfileViewModel();
}
