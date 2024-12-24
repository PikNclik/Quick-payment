import 'package:easy_localization/easy_localization.dart' as l;
import 'package:flutter/material.dart';
import 'package:tahsaldar/controllers/auth_controller.dart';
import 'package:tahsaldar/extensions/live_data_extension.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/ui/screens/login/viewmodels/login_viewmodel.dart';

import '../../../resources/text_styles/text_styles.dart';
import '../../../widgets/buttons/customized_button.dart';
import '../../../widgets/buttons/customized_outlined_button.dart';
import '../../../widgets/instance/instance_builder.dart';
import '../../../widgets/loaders/live_data_loader.dart';

class PrivacyScreen extends StatefulWidget {
  const PrivacyScreen({super.key});

  @override
  State<PrivacyScreen> createState() => _PrivacyScreenState();
}

class _PrivacyScreenState extends State<PrivacyScreen> {
  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<LoginViewModel>(
      builder: (instance) => Scaffold(
        body: Stack(
          children: [
            Scaffold(
              bottomNavigationBar: SizedBox(
                height: 90,
                child: Padding(
                  padding: const EdgeInsets.all(20.0),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      CustomizedButton(
                        text: "agree".tr(),
                        callback: () => instance.login(),
                      ),
                      CustomizedOutlinedButton(
                          text: 'not_agree'.tr(),
                          callback: () => appRouter.pop()),
                    ],
                  ),
                ),
              ),
              body: SafeArea(
                child: SingleChildScrollView(
                  child: Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 20.0),
                    child: Column(children: [
                      const SizedBox(height: 20),
                      Directionality(
                        textDirection: TextDirection.rtl,
                        child: Text(
                          !instance.params.mobile.value.value
                                  .toString()
                                  .startsWith("09")
                              ? "privacy_policy_fake".tr()
                              : "privacy_policy".tr(),
                          style: body1,
                          textAlign: TextAlign.center,
                        ),
                      ),
                      const SizedBox(height: 20),
                      Directionality(
                        textDirection: TextDirection.rtl,
                        child: Text(
                          !instance.params.mobile.value.value
                                  .toString()
                                  .startsWith("09")
                              ? "about_Q-pay_fake".tr()
                              : "about_Q-pay".tr(),
                          style: body1,
                          textAlign: TextAlign.center,
                        ),
                      ),
                    ]),
                  ),
                ),
              ),
            ),
            LoadingListenerWidget(loading: instance.baseParams.loading),
          ],
        ),
      ),
    );
  }
}
