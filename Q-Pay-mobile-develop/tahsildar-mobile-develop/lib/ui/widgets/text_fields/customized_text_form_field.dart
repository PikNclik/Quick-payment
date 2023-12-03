import 'dart:async';

import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_svg/flutter_svg.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';

import '../../core/layouts/theme_widget.dart';
import '../../resources/colors/colors.dart';
import '../../resources/themes/themes.dart';
import '../animations/animated_gesture.dart';

class CustomizedTextFormField extends StatefulWidget {
  final String? Function(String?)? validator;
  final String? labelText;
  final String? hintText;
  final String? errorText;
  final TextEditingController? controller;
  final TextInputAction textInputAction;
  final TextInputType? keyboardType;
  final int debounceDuration;
  final TextAlign textAlign;
  final TextStyle? textStyle;
  final Function(String)? onTextChanged;
  final bool required;
  final bool editable;
  final bool secure;
  final int maxLines;
  final int minLines;
  final FocusNode? focusNode;
  final bool errorOnFocus;
  final Widget? prefix;
  final Widget? suffix;
  final Widget? prefixIcon;
  final Widget? suffixIcon;
  final BoxConstraints? prefixIconConstraints;
  final BoxConstraints? suffixIconConstraints;
  final Function? onEditingComplete;
  final EdgeInsets? contentPadding;
  final Color? fillColor;
  final bool autofocus;
  final TextCapitalization? textCapitalization;
  final String? hintUnderText;
  final List<TextInputFormatter>? inputFormatters;
  const CustomizedTextFormField({
    this.labelText,
    this.focusNode,
    this.hintText,
    this.errorText,
    this.controller,
    this.textInputAction = TextInputAction.next,
    this.keyboardType,
    this.textAlign = TextAlign.start,
    this.debounceDuration = 0,
    this.textStyle,
    this.onTextChanged,
    this.required = false,
    this.validator,
    this.editable = true,
    this.secure = false,
    this.maxLines = 1,
    this.minLines = 1,
    this.errorOnFocus = false,
    this.prefix,
    this.suffix,
    this.prefixIcon,
    this.suffixIcon,
    this.prefixIconConstraints,
    this.suffixIconConstraints,
    this.onEditingComplete,
    this.contentPadding,
    this.fillColor,
    this.autofocus = false,
    this.textCapitalization,
    this.hintUnderText,
    this.inputFormatters,
    Key? key,
  }) : super(key: key);

  @override
  State<CustomizedTextFormField> createState() => CustomizedTextFormFieldState();
}

class CustomizedTextFormFieldState extends State<CustomizedTextFormField> {
  final GlobalKey<FormState> formKey = GlobalKey();
  final FocusNode _focusNode = FocusNode();
  FocusNode get focusNode => widget.focusNode ?? _focusNode;
  Timer? _debounce;
  bool _hidePassword = true;

  @override
  void initState() {
    super.initState();
    focusNode.addListener(() {
      setState(() {});
    });
  }

  @override
  Widget build(BuildContext context) {
    return ThemeWidget(
      builder: (context, themeData) {
        final primaryColor = themeData.primaryColor;
        bool hasError = (focusNode.hasFocus && widget.errorOnFocus) || !focusNode.hasFocus;
        Color labelColor() {
          if (hasError && widget.errorText != null) {
            return DesignColors.errorColor;
          } else if (focusNode.hasFocus) {
            return primaryColor;
          } else {
            return DesignColors.grey;
          }
        }

        return AbsorbPointer(
          absorbing: !widget.editable,
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              TextFormField(
                key: formKey,
                focusNode: focusNode,
                controller: widget.controller,
                textAlign: widget.textAlign,
                textInputAction: widget.textInputAction,
                keyboardType: widget.keyboardType,
                style: widget.textStyle ?? themeData.textTheme.bodyLarge,
                obscureText: _hidePassword ? widget.secure : false,
                autocorrect: false,
                maxLines: widget.maxLines,
                minLines: widget.minLines,
                autofocus: widget.autofocus,
                keyboardAppearance: Brightness.dark,
                textCapitalization: widget.textCapitalization ?? TextCapitalization.none,
                decoration: InputDecoration(
                  alignLabelWithHint: true,
                  labelText: widget.labelText,
                  hintText: widget.hintText,
                  errorText: hasError ? widget.errorText : null,
                  filled: true,
                  fillColor: widget.fillColor ?? themeData.colorScheme.background,
                  enabled: widget.editable,
                  hintStyle: hintStyle(),
                  labelStyle: labelStyle().copyWith(color: labelColor()),
                  errorStyle: errorStyle(),
                  enabledBorder: textFormFieldEnabledBorder(),
                  focusedBorder: textFormFieldFocusedBorder(themeData),
                  errorBorder: textFormFieldErrorBorder(themeData),
                  focusedErrorBorder: textFormFieldErrorBorder(themeData),
                  disabledBorder: textFormFieldEnabledBorder(),
                  prefix: widget.prefix,
                  prefixIcon: widget.prefixIcon,
                  prefixIconConstraints: widget.prefixIconConstraints,
                  suffix: widget.secure
                      ? AnimatedGesture(
                          callback: () {
                            _hidePassword = !_hidePassword;
                            setState(() {});
                          },
                          child: SvgPicture.asset(
                            "password_icon".svgAsset,
                            color: _hidePassword ? primaryColor : DesignColors.grey,
                          ),
                        )
                      : widget.suffix,
                  suffixIcon: widget.suffixIcon,
                  suffixIconConstraints: widget.suffixIconConstraints,
                  contentPadding: widget.contentPadding ?? const EdgeInsets.all(12),
                ),
                onChanged: (val) {
                  if (_debounce?.isActive ?? false) _debounce?.cancel();
                  _debounce = Timer(Duration(milliseconds: widget.debounceDuration), () {
                    widget.validator?.call(val);
                    widget.onTextChanged?.call(val);
                  });
                },
                onFieldSubmitted: (val) {
                  Form.of(context).validate();
                },
                onSaved: (val) {
                  Form.of(context).validate();
                },
                onEditingComplete: () {
                  if (widget.onEditingComplete != null) {
                    widget.onEditingComplete?.call();
                  } else {
                    try {
                      Form.of(context).validate();
                      FocusScope.of(context).nextFocus();
                    } catch (_) {}
                  }
                },
                validator: widget.validator ??
                    (val) {
                      if (!widget.required) return null;
                      if (val?.isEmpty ?? true) return "${widget.labelText} ${"required".tr()}";
                      return null;
                    },
                inputFormatters: widget.inputFormatters,
              ),
            ],
          ),
        );
      },
    );
  }
}
