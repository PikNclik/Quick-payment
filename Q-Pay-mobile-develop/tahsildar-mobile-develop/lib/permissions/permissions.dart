import 'package:easy_localization/easy_localization.dart';
import 'package:fluttertoast/fluttertoast.dart';
import 'package:permission_handler/permission_handler.dart';

import '../extensions/async_extension.dart';

Future<bool> cameraPermission() async {
  bool isGranted = await Permission.camera.isGranted;
  if (isGranted) {
    return isGranted;
  } else {
    var status = await Permission.camera.request();
    if (status.isPermanentlyDenied) {
      openSettings("open_settings_messages.camera");
    }
    return status.isGranted;
  }
}

Future<bool> storagePermission() async {
  bool isGranted = await Permission.storage.isGranted;
  if (isGranted) {
    return isGranted;
  } else {
    var status = await Permission.storage.request();
    if (status.isPermanentlyDenied) {
      openSettings("open_settings_messages.storage");
    }
    return status.isGranted;
  }
}

Future<bool> locationPermission() async {
  var status = await Permission.location.request();
  if (status.isPermanentlyDenied) {
    openSettings("open_settings_messages.location");
  }
  return status.isGranted;
}

openSettings(String msg) async {
  Debouncer debouncer = Debouncer(delay: const Duration(milliseconds: 1500));

  /// show message
  Fluttertoast.showToast(
    msg: msg.tr(),
    toastLength: Toast.LENGTH_LONG,
    gravity: ToastGravity.SNACKBAR,
  );

  /// wait 1.5 second
  debouncer.call(() {
    /// open app settings
    openAppSettings();
  });
}
