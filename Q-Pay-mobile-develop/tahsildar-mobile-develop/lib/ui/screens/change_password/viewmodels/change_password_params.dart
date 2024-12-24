import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:image_picker/image_picker.dart';
import 'package:tahsaldar/extensions/date_extension.dart';
import 'package:tahsaldar/extensions/formz_extension.dart';
import 'package:tahsaldar/extensions/live_data_extension.dart';
import 'package:tahsaldar/models/data_models.dart';

import '../../../../models/forms/formz_text.dart';

/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
///
/// declare and manage viewModel-liveData variables.
///
/// see: https://pub.dev/packages/flutterx_live_data
///
/// more details: https://medium.com/@aghiadodeh/flutter-live-data-tutorial-4c65f1b7ff5e

class ChangePasswordParams {
  final oldPassword = const FormzText.pure("").liveData;
  final newPassword = const FormzText.pure("").liveData;
  final confirmNewPassword = const FormzText.pure("").liveData;
  final passwordMatch = true.liveData;
  final submit = false.liveData;

  isFormFilled() {
    return passwordMatch.value&&newPassword.inputValue().isNotEmpty&&oldPassword.inputValue().isNotEmpty;
  }
}
