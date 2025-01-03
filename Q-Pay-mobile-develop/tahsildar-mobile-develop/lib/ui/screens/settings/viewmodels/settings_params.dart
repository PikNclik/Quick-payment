import 'package:tahsaldar/extensions/live_data_extension.dart';

import '../widgets/language_setting.dart';

/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
///
/// declare and manage viewModel-liveData variables.
///
/// see: https://pub.dev/packages/flutterx_live_data
///
/// more details: https://medium.com/@aghiadodeh/flutter-live-data-tutorial-4c65f1b7ff5e

class SettingsParams {
  final preferredLanguage = Languages.en.liveData;

  final notificationsStatus = true.liveData;

  final notificationSettingLoader = false.liveData;
}
