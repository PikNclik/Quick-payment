/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
///
/// state management for UI
///
/// store and manage your liveData in [ProfileParams].
import 'package:easy_localization/easy_localization.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:lazy_evaluation/lazy_evaluation.dart';
import 'package:tahsaldar/extensions/formz_extension.dart';
import 'package:tahsaldar/models/ui_models/ui_message.dart';
import 'package:tahsaldar/repositories/user_repository.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/viewmodels/base_viewmodel.dart';
import '../../../../models/forms/formz_text.dart';
import 'change_password_params.dart';

class ChangePasswordViewModel extends BaseViewModel {
  final _params = Lazy(() => ChangePasswordParams());

  ChangePasswordParams get params => _params.value;

  final _userRepository = Lazy(() => UserRepository());

  UserRepository get userRepository => _userRepository.value;

  /// resetPassword
  void passwordChanged(MutableLiveData<FormzText> attr, String value) {
    final newValue = FormzText.dirty(value);
    attr.postValue(newValue);
    if (params.newPassword.inputValue() !=
        params.confirmNewPassword.inputValue()) {
      params.passwordMatch.postValue(false);
    } else {
      params.passwordMatch.postValue(true);
    }
    params.submit.postValue(params.isFormFilled());
  }

  changePassword() {
    callHttpRequest(
      () => userRepository.changePassword(
          oldPassword: params.oldPassword.inputValue(),
          newPassword: params.newPassword.inputValue(),
          confirmPassword: params.confirmNewPassword.inputValue()),
      loading: baseParams.loading,
      callback: (response) async {
        if (response != null) {
          baseParams.uiMessage.value =
              UiMessage(message: "password_changed".tr());
          appRouter.pop();
        }
      },
    );
  }
}
