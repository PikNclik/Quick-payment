/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
import 'package:easy_localization/easy_localization.dart';
import 'package:formz/formz.dart';

enum MobileValidationError { invalid, empty }

class FormzMobile extends FormzInput<String, MobileValidationError> {
  const FormzMobile.pure([String value = '']) : super.pure(value);
  const FormzMobile.dirty([String value = '']) : super.dirty(value);

  bool isValidSyrianMobileNumber(String number) {
    var p0 = number;
    return !(p0 == null || !(p0.startsWith("5") || p0.startsWith("9"))  ||
        p0.length != 9);
  }
  @override
  MobileValidationError? validator(String value) {
    if (value.isEmpty) {
      return MobileValidationError.empty;
    }
    if (value.startsWith("0")) {
      value = value.replaceFirst("0", "");
    }
    if (!isValidSyrianMobileNumber(value)) {
      return MobileValidationError.invalid;
    }
    return null;
  }
}

extension Explanation on MobileValidationError {
  String? get message {
    switch (this) {
      case MobileValidationError.invalid:
        return 'phone_invalid'.tr();
      default:
        return null;
    }
  }
}
