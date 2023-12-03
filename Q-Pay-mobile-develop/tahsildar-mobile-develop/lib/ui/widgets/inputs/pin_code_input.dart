import 'package:flutter/foundation.dart';
import 'package:flutter/material.dart';
import 'package:pinput/pinput.dart';

import '../../resources/colors/colors.dart';

class PinCodeInput extends StatefulWidget {
  final void Function(String) onChanged;
  const PinCodeInput({required this.onChanged, Key? key}) : super(key: key);

  @override
  State<PinCodeInput> createState() => _PinCodeInputState();
}

class _PinCodeInputState extends State<PinCodeInput> {
  final TextEditingController _controller = TextEditingController();
  final appSignatureForSMSRetrieverAPI = kDebugMode ? "8I7u0gSpaGm" : "";
  @override
  Widget build(BuildContext context) {
    BoxDecoration pinPutDecoration = BoxDecoration(
      border: Border.all(color: const Color(0xFFB1B1B1), width: 1),
      borderRadius: BorderRadius.circular(10),
      color: Colors.transparent,
    );
    PinTheme pinTheme = PinTheme(
      decoration: pinPutDecoration,
      height: 48,
      width: 74,
      textStyle: const TextStyle(fontSize: 16),
    );
    return Directionality(
      textDirection: TextDirection.ltr,
      child: Pinput(
        androidSmsAutofillMethod: AndroidSmsAutofillMethod.smsRetrieverApi,
        length: 4,
        defaultPinTheme: pinTheme,
        focusedPinTheme: pinTheme.copyWith(
          decoration: pinPutDecoration.copyWith(
            border: Border.all(color: DesignColors.primaryColor, width: 2),
          ),
        ),
        closeKeyboardWhenCompleted: true,
        mainAxisAlignment: MainAxisAlignment.spaceEvenly,
        controller: _controller,
        onChanged: widget.onChanged,
        keyboardAppearance: Brightness.dark,
      ),
    );
  }
}
