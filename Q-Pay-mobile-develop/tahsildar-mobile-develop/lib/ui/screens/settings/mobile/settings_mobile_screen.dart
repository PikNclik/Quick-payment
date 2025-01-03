/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:easy_localization/easy_localization.dart' as d;
import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/core/layouts/theme_widget.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_column.dart';
import "package:tahsaldar/ui/widgets/instance/instance_builder.dart";
import '../../../resources/dimensions/dimensions.dart';
import '../../../resources/text_styles/text_styles.dart';
import '../viewmodels/settings_viewmodel.dart';
import '../widgets/about_us.dart';
import '../widgets/contact_us.dart';
import '../widgets/language_setting.dart';
import '../widgets/notification_setting.dart';
import '../widgets/settings_card.dart';

class SettingsMobileScreen extends StatelessWidget {
  const SettingsMobileScreen({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<SettingsViewModel>(
      builder: (viewModel) {
        return ThemeWidget(
          builder: (context, theme) {
            return Padding(
              padding: const EdgeInsets.fromLTRB(16, spaceBelowAppBar, 16, 0),
              child: AnimatedColumn(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Column(
                    children: [
                      SettingsCard(
                        height: 130,
                        child: LanguageSetting(
                          liveData: viewModel.params.preferredLanguage,
                        ),
                      ),
                      const SizedBox(height: 16),
                      const SettingsCard(
                        child: NotificationSetting(),
                      ),
                      const SizedBox(height: 16),
                      const SettingsCard(
                        child: AboutUs(),
                      ),
                      const SizedBox(height: 16),
                       SettingsCard(
                        child: InkWell(
                            child: Text(
                              'privacy_policy2'.tr(),
                              style: body3,
                            ),
                            onTap: () {
                              showDialog(
                                  context: context,
                                  builder: (context) => Dialog(
                                    alignment: Alignment.center,
                                    elevation: 5,
                                    child: SingleChildScrollView(
                                      child: Padding(
                                        padding: const EdgeInsets.symmetric(horizontal: 20.0),
                                        child: Column(children: [
                                          const SizedBox(height: 20),
                                          Directionality(
                                            textDirection: TextDirection.rtl,
                                            child: Text("privacy_policy".tr(),style: body1,
                                              textAlign: TextAlign.center,
                                            ),
                                          ),
                                          const SizedBox(height: 20),
                                        ]),
                                      ),
                                    ),
                                  ));
                            }
                        ),
                      ),
                    ],
                  ),
                  // const ContactUs(),
                ],
              ),
            );
          },
        );
      },
    );
  }
}
