import 'dart:io';

import 'package:flutter/foundation.dart';
import 'package:path_provider/path_provider.dart';
import 'package:permission_handler/permission_handler.dart';

Future<String?> getDownloadPath() async {
  Directory? directory;
  var result = await Permission.storage.request();
  if (result.isGranted) {
    try {
      if (Platform.isIOS) {
        directory = await getApplicationDocumentsDirectory();
      } else {
        directory = Directory('/storage/emulated/0/Download');
        // Put file in global download folder, if for an unknown reason it didn't exist, we fallback
        // ignore: avoid_slow_async_io
        if (!await directory.exists()) directory = await getExternalStorageDirectory() ?? await getTemporaryDirectory();
        // directory = (await getExternalStorageDirectory() ?? await getDownloadsDirectory() ?? await getTemporaryDirectory());
      }
    } catch (err, _) {
      if (kDebugMode) {
        print("Cannot get download folder path");
      }
    }
  }
  return directory?.path;
}
