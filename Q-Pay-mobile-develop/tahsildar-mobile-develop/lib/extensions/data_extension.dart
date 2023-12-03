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
}

extension DataUtils on dynamic {
  int toInteger() {
    return int.tryParse(this) ?? double.tryParse(this)?.toInt() ?? 0;
  }

  double toDouble() {
    return double.tryParse(this) ?? int.tryParse(this)?.toDouble() ?? 0.0;
  }
}
