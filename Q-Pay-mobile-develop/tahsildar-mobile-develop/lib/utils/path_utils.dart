import 'dart:io';

import 'package:flutter/foundation.dart';
import 'package:package_info_plus/package_info_plus.dart';
import 'package:path_provider/path_provider.dart';
import 'package:permission_handler/permission_handler.dart';

Future<String?> getDownloadPath() async {
  Directory? directory;
  PackageInfo packageInfo = await PackageInfo.fromPlatform();
  String appName = packageInfo.appName;
  try {
    if (Platform.isIOS) {
      final status = await Permission.storage.status;
      if (status != PermissionStatus.granted) {

            await Permission.storage.request();
            //await Permission.manageExternalStorage.request();

      }
      directory = await getApplicationDocumentsDirectory();
    } else {
      await Directory('/storage/emulated/0/Download/$appName').create().then((value) => directory = value);
      bool? s = await directory?.exists();
      if (directory == null  ||(s == null  ||s == false)) {
        final status = await Permission.storage.status;
        if (status != PermissionStatus.granted) {

              await Permission.storage.request();
              //await Permission.manageExternalStorage.request();

        }
        directory = await getExternalStorageDirectory() ?? await getTemporaryDirectory();
      }
    }
  } catch (err, _) {
  print("Cannot get download folder path");
  }

  return directory?.path;
}
