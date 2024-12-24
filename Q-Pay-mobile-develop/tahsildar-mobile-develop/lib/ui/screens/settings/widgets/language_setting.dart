import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/ui/widgets/buttons/customized_outlined_button.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';
import '../../../../../../storage/storage.dart';
import '../../../core/layouts/theme_widget.dart';
import '../../../resources/text_styles/text_styles.dart';
import '../../../widgets/animations/animated_gesture.dart';
import '../viewmodels/settings_viewmodel.dart';


enum Languages { en, ar }

Languages fromStringLanguageToEnum(String? lang) {
  switch (lang) {
    case 'ar':
      return Languages.ar;
    case 'en':
      return Languages.en;
    default:
      return Languages.en;
  }
}

class LanguageSetting extends StatelessWidget {
  final MutableLiveData<Languages> liveData;

  const LanguageSetting({required this.liveData, Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<SettingsViewModel>(
      builder: (viewModel) {
        return Column(
          mainAxisAlignment: MainAxisAlignment.spaceAround,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.start,
              children: [
                Text(
                  'language'.tr(),
                  style: body3,
                ),
              ],
            ),
            Column(
              children: [
                ...Languages.values.map(
                  (e) {
                    return LanguageWidget<Languages>(
                      liveData: liveData,
                      type: e,
                      //callback: callback,
                    );
                  },
                ).toList(),
              ],
            ),
            Row(
              mainAxisAlignment: MainAxisAlignment.end,
              children: [
                CustomizedOutlinedButton(
                  text: 'save'.tr(),
                  callback: () {
                    AppStorage.setLanguage(viewModel.params.preferredLanguage.value.name);
                        viewModel.changeLanguage(() {
                          context.setLocale(Locale(viewModel.params.preferredLanguage.value.name));
                          appRouter.replaceAll([const Initial()]);
                        });
                      },
                ),
              ],
            )
          ],
        );
      },
    );
  }
}

class LanguageWidget<T extends Enum> extends StatelessWidget {
  final MutableLiveData<T> liveData;
  final T type;
  const LanguageWidget({
    required this.liveData,
    required this.type,
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return LiveDataBuilder<T>(
      data: liveData,
      builder: (context, selectedType) {
        return ThemeWidget(
          builder: (context, theme) {
            return AnimatedGesture(
              callback: () => liveData.postValue(type),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.start,
                children: [
                  Radio(
                    value: type.name,
                    groupValue: selectedType.name,
                    onChanged: (value) {
                      liveData.postValue(type);
                    },
                    activeColor: theme.primaryColor,
                  ),
                  Text(
                    type.name.tr(),
                    style: title3,
                  ),
                ],
              ),
            );
          },
        );
      },
    );
  }
}
