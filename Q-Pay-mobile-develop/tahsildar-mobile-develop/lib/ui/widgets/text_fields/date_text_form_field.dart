import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/extensions/date_extension.dart';
import 'package:tahsaldar/extensions/nullable_extension.dart';

import '../../../config/ui_config.dart';
import '../../pickers/date_time_picker.dart';
import 'customized_text_form_field.dart';

enum DatePickerType { date, datetime, time }

class DateTextFormField extends StatefulWidget {
  final String label;
  final DatePickerType datePickerType;
  final String? defaultValue;
  final Function(DateTime, String)? callback;
  final bool prefix;
  final DateTime? maxTime;
  final DateTime? minTime;
  final Widget? prefixIcon;
  final DateTime? currentTime;
  final String title;
  final MutableLiveData<bool>? isDisabled;
  const DateTextFormField({
    required this.label,
    required this.datePickerType,
    this.defaultValue,
    this.callback,
    this.prefix = true,
    this.maxTime,
    this.minTime,
    this.currentTime,
    this.prefixIcon,
    required this.title,
    this.isDisabled,
    Key? key,
  }) : super(key: key);

  @override
  State<DateTextFormField> createState() => DateTextFormFieldState();
}

class DateTextFormFieldState extends State<DateTextFormField> {
  final focusNode = FocusNode();
  final textController = TextEditingController();
  final sentTextController = TextEditingController();
  DateTime currentTime = DateTime.now();
  Future<void> showPicker() async {
    if (widget.datePickerType == DatePickerType.date) {
      AppDateTimePicker.showDatePicker(
          context: context,
          callback: _callback,
          title: widget.title,
          currentTime: widget.currentTime ?? currentTime,
          maxTime: widget.maxTime,
          minTime: widget.minTime ?? DateTime.now());
    } else if (widget.datePickerType == DatePickerType.datetime) {
      AppDateTimePicker.showDateTimePicker(
          context: context,
          callback: _callback,
          title: widget.title,
          currentTime: widget.currentTime ?? currentTime,
          maxTime: widget.maxTime,
          minTime: widget.minTime ?? DateTime.now());
    }
  }

  _callback(dynamic dateTime) {
    dateTime as DateTime;
    final format = widget.datePickerType == DatePickerType.date ? dateTime.dateFormat : dateTime.datetimeFormat;
    final displayedFormat = widget.datePickerType == DatePickerType.date ? dateTime.displayDate : dateTime.displayedDatetime;
    sentTextController.text = format;
    textController.text = displayedFormat;
    widget.callback?.call(dateTime, format);
    currentTime = dateTime;
    hideSoftKeyboard(context);
  }

  @override
  void initState() {
    widget.defaultValue?.let((it) => sentTextController.text = it);
    widget.defaultValue?.let((it) {
      if (it.isNotEmpty&&it!="null") {
        textController.text = widget.datePickerType == DatePickerType.date ? it.displayedDate() : it.formatStringDateTime();

        /// convert it to datetime type
      //  currentTime = it.dateTimeConverter();
      }
    });
    focusNode.addListener(() {
      if (focusNode.hasFocus) {
        hideSoftKeyboard(context);
        showPicker();
      }
    });
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return LiveDataBuilder<bool>(
      data: widget.isDisabled ?? MutableLiveData(value: false),
      builder: (_, isDisabled) {
        return CustomizedTextFormField(
          hintText: widget.label,
          fillColor: isDisabled ? Colors.grey[200] : null,
          editable: !isDisabled,
          //labelText: widget.label,
          controller: textController,
          focusNode: focusNode,
          // prefixIcon: widget.prefix
          //     ? Padding(
          //         padding: const EdgeInsets.symmetric(horizontal: 16),
          //         child: widget.prefixIcon ??
          //             SvgPicture.asset(
          //               'calendar'.svgAsset,
          //               color: isDisabled
          //                   ? DesignColors.grey
          //                   : DesignColors.primaryColor,
          //               height: 12,
          //             ),
          //       )
          //     : null,
          // prefixIconConstraints: const BoxConstraints(maxWidth: 40),
        );
      },
    );
  }
}
