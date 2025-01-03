import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:image_picker/image_picker.dart';
import 'package:tahsaldar/controllers/auth_controller.dart';
import 'package:tahsaldar/extensions/formz_extension.dart';
import 'package:tahsaldar/extensions/live_data_extension.dart';
import 'package:tahsaldar/models/data_models.dart';

import '../../../../models/forms/formz_email.dart';
import '../../../../models/forms/formz_text.dart';
import '../../../widgets/autocomplete_text_form_field/autocomplete_item_model.dart';

/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
///
/// declare and manage viewModel-liveData variables.
///
/// see: https://pub.dev/packages/flutterx_live_data
///
/// more details: https://medium.com/@aghiadodeh/flutter-live-data-tutorial-4c65f1b7ff5e

class UpdateProfileParams {
  /// change value when user pick image from device -> the image uploaded automatically,
  /// and loader will appear on image.
  final uploadingImage = false.liveData;

  /// display image which picked from device gallery and uploaded to server
  MutableLiveData<XFile?> pickedImage = null.liveData;

  /// full name field
  final fullName = FormzText.pure(userLiveData.value.fullName ?? "").liveData;

  /// email field
  final email = FormzEmail.pure(userLiveData.value.email ?? "").liveData;

  /// User bank
  final bankId = FormzText.pure(userLiveData.value.bankId.toString()).liveData;
  final bankName = FormzText.pure(userLiveData.value.bankName()).liveData;

  final banks = <AutoCompleteItemModel>[].liveData;

  /// User address
  final addressId = FormzText.pure(userLiveData.value.cityId.toString()).liveData;
  final addressName = FormzText.pure(userLiveData.value.cityName() ?? "").liveData;

  final addresses = <AutoCompleteItemModel>[].liveData;

  /// User bank account number
  final bankAccountNumber = FormzText.pure(userLiveData.value.bankAccountNumber ?? "").liveData;

  /// User bank account number
  final confirmBankAccountNumber = FormzText.pure(userLiveData.value.bankAccountNumber ?? "").liveData;

  final bankAccountMatch = true.liveData;

  /// form enabled for submit
  final submit = false.liveData;

  isFormFilled() {
    return fullName.inputValue().isNotEmpty &&
        bankId.inputValue().isNotEmpty &&
        bankAccountNumber.inputValue().isNotEmpty &&
        confirmBankAccountNumber.inputValue().isNotEmpty &&
        bankAccountMatch.value &&
        (email.inputValue().isEmpty || email.value.valid);
  }

  Map<String, dynamic> mappingToFormData() {
    Map<String, dynamic> map = {
      "_method": "PUT",
      "full_name": fullName.inputValue(),
      "bank_id": bankId.inputValue(),
      "bank_account_number": bankAccountNumber.inputValue(),
      "city_id": addressId.inputValue(),
      "file[0]": userLiveData.value.mediaId(),
    };

    if (email.inputValue().isNotEmpty && email.value.valid) {
      map["email"] = email.inputValue();
    }

    return map;
  }
}
