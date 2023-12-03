import 'dart:io';

import 'package:image_picker/image_picker.dart';

import '../../permissions/permissions.dart';

const int imageQuality = 40;

Future<List<File>?> openCamera() async {
  bool isGranted = await cameraPermission();
  if (isGranted) {
    List<File> images = [];
    final picker = ImagePicker();
    final XFile? image = await picker.pickImage(source: ImageSource.camera, imageQuality: imageQuality);
    if (image != null) {
      File file = File(image.path);
      images.add(file);
    }
    return images;
  }
  return null;
}

Future<XFile?> openImagePicker() async {
  bool isGranted = await storagePermission();
  if (isGranted) {
    final picker = ImagePicker();
    final XFile? image = await picker.pickImage(source: ImageSource.gallery, imageQuality: imageQuality);
    return image;
  }
  return null;
}
