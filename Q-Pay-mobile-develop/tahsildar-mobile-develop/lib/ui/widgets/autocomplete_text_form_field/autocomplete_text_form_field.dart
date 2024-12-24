import 'dart:async';

import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutter_typeahead/flutter_typeahead.dart';
import 'package:tahsaldar/extensions/nullable_extension.dart';
import 'package:tahsaldar/extensions/theme_extension.dart';

import '../../core/layouts/theme_widget.dart';
import '../../resources/colors/colors.dart';
import '../../resources/dimensions/dimensions.dart';
import '../../resources/themes/themes.dart';
import '../animations/customized_animated_widget.dart';
import 'autocomplete_item_model.dart';

class AutoCompleteTextField extends StatefulWidget {
  final String? labelText;
  final String? hintText;
  final String? errorText;
  final List<AutoCompleteItemModel> items;
  final Function(AutoCompleteItemModel?)? onItemSelected;
  final Function(String)? onTextChange;
  final Function(String?)? validation;
  final TextAlign? textAlign;
  final String? defaultValue;
  final bool openOnFocus;
  final bool dropdownArrow;
  final AxisDirection? direction;
  final bool errorOnFocus;
  final Widget? suffix;
  final BoxConstraints? suffixIconConstraints;
  final Widget? prefix;
  final Widget? prefixIcon;
  final BoxConstraints? prefixIconConstraints;
  final int debounceDuration;
  final bool editable;
  final Function? onInfiniteScroll;
  const AutoCompleteTextField({
    this.labelText,
    this.hintText,
    this.errorText,
    this.items = const [],
    this.onItemSelected,
    this.onTextChange,
    this.textAlign,
    this.defaultValue,
    this.openOnFocus = false,
    this.dropdownArrow = false,
    this.errorOnFocus = false,
    this.direction,
    this.validation,
    this.suffix,
    this.suffixIconConstraints,
    this.prefix,
    this.prefixIcon,
    this.prefixIconConstraints,
    this.editable = true,
    this.debounceDuration = 500,
    this.onInfiniteScroll,
    Key? key,
  }) : super(key: key);

  @override
  State<AutoCompleteTextField> createState() => AutoCompleteTextFieldState();
}

class AutoCompleteTextFieldState extends State<AutoCompleteTextField> with SingleTickerProviderStateMixin {
  final GlobalKey<TypeAheadFieldState<dynamic>>? globalKey = GlobalKey();
  SuggestionsBoxController suggestionsBoxController = SuggestionsBoxController();
  String? _selected;
  final textController = TextEditingController();
  final focusNode = FocusNode();
  Timer? _debounce;
  List<dynamic> suggestions = [];

  @override
  void initState() {
    widget.defaultValue?.let((it) {
      textController.text = it;
      _selected = it;
    });
    focusNode.addListener(() {
      if (focusNode.hasFocus && widget.openOnFocus) {
        textController.text = "";
      } else if (!focusNode.hasFocus && textController.text != "") {
        textController.text = _selected ?? "";
      }
      setState(() {});
    });
    super.initState();
  }

  void changeSuggestionsList(List<AutoCompleteItemModel> newSuggestions) async {
    widget.items.clear();
    widget.items.addAll(newSuggestions);
    try {
      await globalKey?.currentState?.suggestionsKey.currentState?.invalidateSuggestions();
    } catch (_) {
      // Null check operator used on a null value
    }
    setState(() {});
  }

  @override
  Widget build(BuildContext context) {
    const animationDuration = Duration(milliseconds: 200);
    return ThemeWidget(
      builder: (context, themeData) {
        final primaryColor = themeData.primaryColor;
        bool hasError = focusNode.hasFocus && widget.errorOnFocus || !focusNode.hasFocus;
        Color labelColor() {
          if (hasError && widget.errorText != null) {
            return DesignColors.errorColor;
          } else if (focusNode.hasFocus) {
            return primaryColor;
          } else {
            return DesignColors.grey;
          }
        }

        return TypeAheadFormField(
          fieldKey: globalKey,
          direction: widget.direction ?? AxisDirection.down,
          textFieldConfiguration: TextFieldConfiguration(
            controller: textController,
            focusNode: focusNode,
            textAlign: widget.textAlign ?? TextAlign.start,
            keyboardType: TextInputType.text,
            cursorColor: widget.dropdownArrow ? themeData.colorScheme.background : themeData.primaryColor,
            style: themeData.textTheme.bodyLarge,
            enabled: widget.editable,
            autocorrect: false,
            autofocus: false,
            keyboardAppearance: Brightness.dark,
            decoration: InputDecoration(
              labelText: widget.labelText?.tr(),
              labelStyle: labelStyle().copyWith(color: labelColor()),
              hintText: widget.hintText,
              hintStyle: hintStyle(),
              errorStyle: errorStyle(),
              filled: true,
              fillColor: themeData.colorScheme.background,
              enabledBorder: textFormFieldEnabledBorder(),
              focusedBorder: textFormFieldFocusedBorder(themeData),
              errorBorder: textFormFieldErrorBorder(themeData),
              disabledBorder: textFormFieldEnabledBorder(),
              contentPadding: const EdgeInsets.symmetric(vertical: 0, horizontal: 10),
              suffixIcon: widget.dropdownArrow ? const Icon(Icons.keyboard_arrow_down_rounded) : widget.suffix,
              suffixIconConstraints: widget.suffixIconConstraints,
              prefix: widget.prefix,
              prefixIcon: widget.prefixIcon,
              prefixIconConstraints: widget.prefixIconConstraints ?? const BoxConstraints(maxWidth: 35, maxHeight: 35),

            ),
          ),
          noItemsFoundBuilder: (context) {
            return CustomizedAnimatedWidget(
              from: 0,
              duration: animationDuration,
              child: widget.items.isNotEmpty && textController.text.isNotEmpty
                  ? SizedBox(
                      height: 50,
                      child: Center(
                        child: Text("no_suggestions".tr()),
                      ),
                    )
                  : const SizedBox.shrink(),
            );
          },
          suggestionsBoxDecoration: SuggestionsBoxDecoration(
            borderRadius: BorderRadius.circular(6),
            elevation: 5,
          ),
          onSuggestionSelected: (AutoCompleteItemModel suggestion) {
            textController.text = suggestion.label ?? suggestion.value.toString();
            _selected = textController.text;
            widget.onItemSelected?.call(suggestion);
          },
          suggestionsCallback: (pattern) {
            if (_debounce?.isActive ?? false) _debounce?.cancel();
            _debounce = Timer(Duration(milliseconds: widget.debounceDuration), () => widget.onTextChange?.call(pattern));
            final items = widget.items.where((element) => element.label.toString().toLowerCase().contains(pattern.toLowerCase()));
            suggestions = items.toList();
            return items;
          },
          getImmediateSuggestions: true,
          suggestionsBoxController: suggestionsBoxController,
          itemBuilder: (context, AutoCompleteItemModel suggestion) {
            return ListTile(
              title: Text(
                suggestion.label ?? suggestion.value.toString(),
                style: TextStyle(
                  color: themeData.textColor,
                  fontSize: smallText,
                  fontWeight: FontWeight.w500,
                ),
              ),
            );
          },
          transitionBuilder: (context, suggestionsBox, animationController) {
            return CustomizedAnimatedWidget(
              from: 10,
              duration: animationDuration,
              child: suggestionsBox,
            );
          },
          onInfiniteScroll: () {
            widget.onInfiniteScroll?.call();
          },
          validator: (value) => widget.validation?.call(value),
        );
      },
    );
  }
}
