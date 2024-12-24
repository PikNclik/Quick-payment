import 'dart:math';

import 'package:intl/intl.dart';

String generateRandomString({int len = 15}) {
  var r = Random();
  const chars = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz1234567890';
  final random = List.generate(len, (index) => chars[r.nextInt(chars.length)]).join();
  final now = DateTime.now();
  return "$random$now";
}

extension StringExtension on String {
  String? notEmptyOrNull() {
    if (isEmpty || contains("null")) {
      return null;
    } else {
      return this;
    }
  }

  String formatNumber() {
    var formatter = NumberFormat('###,000');
    return formatter.format(toDouble());
  }

  String replaceArabicNumber() {
    var input = this;
    const english = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    const farsi = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    for (int i = 0; i < english.length; i++) {
      input = input.replaceAll(english[i], farsi[i]);
    }

    return input;
  }
}

extension DataUtils on dynamic {
  int toInteger() {
    return int.tryParse(this) ?? double.tryParse(this)?.toInt() ?? 0;
  }

  double toDouble() {
    return double.tryParse(this) ?? int.tryParse(this)?.toDouble() ?? 0.0;
  }
}
