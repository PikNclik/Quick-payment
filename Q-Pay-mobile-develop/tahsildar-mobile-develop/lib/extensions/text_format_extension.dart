import 'package:flutter/services.dart';
import 'package:intl/intl.dart';
import 'package:tahsaldar/extensions/data_extension.dart';

class NeatCostFilterFormatter extends TextInputFormatter {
  @override
  TextEditingValue formatEditUpdate(TextEditingValue oldValue, TextEditingValue newValue) {
    String s=newValue.text.replaceArabicNumber();
    if(newValue.text.length>3){
       s=s.replaceAll(",", "").replaceAll(".", "");
      var formatter = NumberFormat('###,000', 'en');
      print(s);
       print(double.tryParse(s));
       // s= formatter.format(double.parse(s));
       s= formatter.format(double.tryParse(s) ?? 0.0);
      return TextEditingValue(
        text: s,
        selection: TextSelection.collapsed(offset: s.length),
      );
    }else{
      return TextEditingValue(
        text: s,
        selection: TextSelection.collapsed(offset: s.length),
      );
    }

  }
  String formatInitialValue(String initialValue) {
    String s=initialValue.replaceArabicNumber().replaceAll(",", "").replaceAll(".", "");
    var formatter = NumberFormat('###,000',"en");
    s= formatter.format(double.parse(s));
    return s;
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
