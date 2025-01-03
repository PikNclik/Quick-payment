import 'dart:typed_data';

import 'package:flutter/cupertino.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:image_picker/image_picker.dart';

import '../../../../controllers/auth_controller.dart';
import '../../../../models/data/user/user.dart';

/// Generated By XFlutter Cli.
///
/// more info: https://xflutter-cli.aghiadodeh.com
///
/// declare and manage viewModel-liveData variables.
///
/// see: https://pub.dev/packages/flutterx_live_data
///
/// more details: https://medium.com/@aghiadodeh/flutter-live-data-tutorial-4c65f1b7ff5e

class ImageCropperParams {
  final GlobalKey cropperKey = GlobalKey(debugLabel: 'cropperKey');

  /// original image (before crop)
  MutableLiveData<Uint8List?> rawOriginalImage = MutableLiveData(value: null);

  /// cropped image
  MutableLiveData<Uint8List?> tempImage = MutableLiveData();

  /// adjusted image
  MutableLiveData<Uint8List?> rawAdjustedImage = MutableLiveData();

  /// display image which picked from device gallery and uploaded to server
  MutableLiveData<XFile?> pickedImage = MutableLiveData();

  Map<String, dynamic> mappingToFormData(mediaId) {
    User user = userLiveData.value;
    Map<String, dynamic> map = {
      "_method": "PUT",
      "full_name": user.fullName ?? "",
      "bank_id": user.bankId,
      "bank_account_number": user.bankAccountNumber,
    };

    if (user.cityId != null) {
      map["city_id"] = user.cityId;
    }
    if (user.email != null) {
      map["email"] = userLiveData.value.email;
    }
    map["files[0]"] = mediaId;
    return map;
  }
}
