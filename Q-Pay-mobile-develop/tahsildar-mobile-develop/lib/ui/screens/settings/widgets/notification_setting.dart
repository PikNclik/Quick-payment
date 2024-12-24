import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';
import 'package:tahsaldar/ui/widgets/switch/switch.dart';
import '../../../resources/text_styles/text_styles.dart';
import '../viewmodels/settings_viewmodel.dart';

class NotificationSetting extends StatelessWidget {
  const NotificationSetting({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<SettingsViewModel>(builder: (viewModel) {
      return Column(
        mainAxisAlignment: MainAxisAlignment.spaceAround,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.start,
            children: [
              Text(
                'notification_settings'.tr(),
                style: body3,
              ),
            ],
          ),
          const SizedBox(height: 10),
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                'mute_notifications'.tr(),
                style: body3,
              ),
              CustomizedSwitch(
                switchValue: viewModel.params.notificationsStatus,
                loading: viewModel.params.notificationSettingLoader,
                callback: (_) {
                  viewModel.handleReceivingNotifications();
                },
              )
            ],
          )
        ],
      );
    });
  }
}
