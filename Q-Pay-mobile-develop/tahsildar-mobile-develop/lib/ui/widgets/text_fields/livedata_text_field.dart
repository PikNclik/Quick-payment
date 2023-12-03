import 'package:flutter/material.dart';
import 'package:flutter/services.dart' as fs;
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:formz/formz.dart';
import 'package:tahsaldar/extensions/formz_extension.dart';
import 'package:tahsaldar/models/forms/formz_mobile.dart';
import 'package:tahsaldar/models/forms/formz_text.dart';

import '../../../extensions/data_extension.dart';
import 'customized_text_form_field.dart';

class LiveDataTextField<T extends FormzInput> extends StatefulWidget {
  final String? label;
  final String? hint;
  final MutableLiveData<T> liveData;
  final TextEditingController? controller;
  final Function(MutableLiveData<T>, String) onTextChanged;
  final TextInputType? keyboardType;
  final TextInputAction textInputAction;
  final int minLines;
  final int maxLines;
  final Widget? prefixIcon;
  final Widget? suffixIcon;
  final BoxConstraints? prefixIconConstraints;
  final BoxConstraints? suffixIconConstraints;
  final Function? onEditingComplete;
  final FocusNode? focusNode;
  final bool editable;
  final TextStyle? textStyle;
  final String? errorText;
  final TextCapitalization? textCapitalization;
  final List<fs.TextInputFormatter>? inputFormatters;
  const LiveDataTextField({
    this.label,
    required this.liveData,
    required this.onTextChanged,
    this.controller,
    this.hint,
    this.keyboardType,
    this.textInputAction = TextInputAction.next,
    this.minLines = 1,
    this.maxLines = 1,
    this.prefixIcon,
    this.suffixIcon,
    this.prefixIconConstraints,
    this.suffixIconConstraints,
    this.onEditingComplete,
    this.focusNode,
    this.editable = true,
    this.textStyle,
    this.errorText,
    this.textCapitalization,
    this.inputFormatters,
    Key? key,
  }) : super(key: key);

  @override
  State<LiveDataTextField<T>> createState() => LiveDataTextFieldState<T>();
}

class LiveDataTextFieldState<T extends FormzInput> extends State<LiveDataTextField<T>> {
  final key = generateRandomString();
  final TextEditingController _textController = TextEditingController();
  TextEditingController get textController => widget.controller ?? _textController;
  final FocusNode _focusNode = FocusNode();
  FocusNode get focusNode => widget.focusNode ?? _focusNode;

  @override
  void initState() {
    // check if liveData has a value, this used when user fill the textField
    // and navigate to other screen and back
    if (widget.liveData.isNotEmpty()) {
      textController.text = widget.liveData.inputValue();
    }
    super.initState();
  }

  void updateControllerText(String value) {
    textController.text = value;
    textController.selection = TextSelection.fromPosition(
      TextPosition(offset: textController.text.length),
    );
  }

  @override
  Widget build(BuildContext context) {
    return LiveDataBuilder<T>(
      data: widget.liveData,
      builder: (context, textInput) {
        if (textInput == const FormzText.pure()) {
          // when clear params -> clear the textField
          textController.text = "";
        }

        String? error() {
          if (textInput is FormzText) {
            return textInput.error?.message;
          } else if (textInput is FormzMobile) {
            return textInput.error?.message;
          }
          return null;
        }

        return CustomizedTextFormField(
          key: Key(key),
          labelText: widget.label,
          hintText: widget.hint,
          controller: textController,
          keyboardType: widget.keyboardType,
          textInputAction: widget.textInputAction,
          minLines: widget.minLines,
          maxLines: widget.maxLines,
          focusNode: focusNode,
          onTextChanged: (value) => widget.onTextChanged(widget.liveData, value),
          prefixIcon: widget.prefixIcon,
          suffixIcon: widget.suffixIcon,
          prefixIconConstraints: widget.prefixIconConstraints,
          suffixIconConstraints: widget.suffixIconConstraints,
          onEditingComplete: widget.onEditingComplete,
          editable: widget.editable,
          textStyle: widget.textStyle,
          errorText: widget.errorText ?? error(),
          textCapitalization: widget.textCapitalization,
          inputFormatters: widget.inputFormatters,
        );
      },
    );
  }
}
