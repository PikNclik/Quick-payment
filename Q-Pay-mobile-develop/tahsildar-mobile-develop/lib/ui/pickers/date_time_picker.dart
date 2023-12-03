import 'package:bottom_picker/bottom_picker.dart';
import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';

import '../resources/colors/colors.dart';
import '../resources/text_styles/text_styles.dart';

class AppDateTimePicker {
  static String horizontalPadding = "   ";
  static void showDateTimePicker({
    required BuildContext context,
    required Function(dynamic) callback,
    required String title,
    required DateTime currentTime,
    DateTime? maxTime,
    DateTime? minTime,
    String confirmButtonText = 'confirm',
  }) {
    BottomPicker.dateTime(
      title: title,
      titleStyle: title2,
      onSubmit: callback,
      buttonText: horizontalPadding + confirmButtonText.tr() + horizontalPadding,
      displayButtonIcon: false,
      buttonTextStyle: const TextStyle(color: Colors.white),
      buttonSingleColor: DesignColors.primaryColor,
      buttonAlignement: MainAxisAlignment.end,
      //initialDateTime: currentTime.compareTo(DateTime.now()) > 0 ? currentTime : DateTime.now(),
      initialDateTime: currentTime,
      minDateTime: minTime,
      maxDateTime: maxTime,
      height: 500,
    ).show(context);
  }

  static void showDatePicker({
    required BuildContext context,
    required Function(dynamic) callback,
    required String title,
    required DateTime currentTime,
    DateTime? maxTime,
    DateTime? minTime,
    String confirmButtonText = 'confirm',
  }) {
    BottomPicker.date(
      title: title,
      titleStyle: title2,
      onSubmit: callback,
      buttonText: horizontalPadding + confirmButtonText.tr() + horizontalPadding,
      displayButtonIcon: false,
      buttonTextStyle: const TextStyle(color: Colors.white),
      buttonSingleColor: DesignColors.primaryColor,
      buttonAlignement: MainAxisAlignment.end,
      initialDateTime: currentTime.compareTo(DateTime.now()) > 0 ? currentTime : DateTime.now(),
      minDateTime: minTime,
      maxDateTime: maxTime,
      height: 500,
    ).show(context);
  }
}
