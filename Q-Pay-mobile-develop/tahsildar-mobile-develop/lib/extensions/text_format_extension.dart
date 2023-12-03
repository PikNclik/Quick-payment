import 'package:flutter/services.dart';
import 'package:intl/intl.dart';

class NeatCostFilterFormatter extends TextInputFormatter {
  @override
  TextEditingValue formatEditUpdate(TextEditingValue oldValue, TextEditingValue newValue) {
    final StringBuffer newText = StringBuffer();
    final neatCost = _neatCost(newValue.text.replaceAll(",", "").replaceAll(".", ""));
    newText.write(neatCost);
    // print("neat: ${_neatCost(newValue.text.replaceAll(",", ""))}, value: ${newValue.text}");
    return TextEditingValue(
      text: newText.toString(),
      selection: TextSelection.collapsed(offset: neatCost.length),
    );
  }
}

String formatCurrency(num value, {int fractionDigits = 2}) {
  ArgumentError.checkNotNull(value, 'value');

  // convert cents into hundreds.
  value = value / 100;

  return NumberFormat.currency(
    customPattern: '###,###.##',
    // using Netherlands because this country also
    // uses the comma for thousands and dot for decimal separators.
    locale: 'nl_NL',
  ).format(value);
}

String _neatCost(String cost) {
  String res = cost.toString();
  for (int i = 3; i < res.length; i += 4) {
    res = res.replaceRange(res.length - i, res.length - i, ",");
  }
  return res;
}
