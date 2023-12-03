import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_gesture.dart';

import '../animations/customized_animated_widget.dart';

class FilterDialog extends StatefulWidget {
  final MutableLiveData<dynamic> liveData;
  final List<dynamic> filters;
  final Function() filter;
  final double height;
  const FilterDialog({required this.filters, required this.filter, required this.liveData, required this.height, Key? key}) : super(key: key);

  static openDialog(
      {required BuildContext context,
      required List<dynamic> filters,
      required Function() filter,
      required MutableLiveData<dynamic> liveData,
      required double height}) async {
    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (context) => FilterDialog(
        liveData: liveData,
        filter: filter,
        filters: filters,
        height: height,
      ),
    );
  }

  @override
  State<FilterDialog> createState() => _FilterDialogState();
}

class _FilterDialogState extends State<FilterDialog> {
  dynamic temp;
  @override
  void initState() {
    temp = widget.liveData.value;
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return LiveDataBuilder<dynamic>(
      data: widget.liveData,
      builder: (context, data) {
        return Dialog(
          insetPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 20),
          shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
          child: CustomizedAnimatedWidget(
            child: Container(
              padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 20),
              width: double.infinity,
              height: widget.height,
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  Wrap(
                      children: widget.filters
                          .map((e) => AnimatedGesture(
                                callback: () {
                                  widget.liveData.postValue(e.toString());
                                },
                                child: buildChip(e.toString(), selected: data.toString() == e.toString()),
                              ))
                          .toList()),
                  SizedBox(
                    height: 30,
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.end,
                      children: [
                        AnimatedGesture(
                          child: Text(
                            "filter".tr(),
                            style: title2.copyWith(color: DesignColors.primaryColor),
                          ),
                          callback: () {
                            widget.filter.call();
                            appRouter.pop(true);
                          },
                        ),
                        const SizedBox(width: 14),
                        AnimatedGesture(
                          child: Text(
                            "cancel".tr(),
                            style: title2.copyWith(color: DesignColors.primaryColor),
                          ),
                          callback: () {
                            widget.liveData.postValue(temp);
                            appRouter.pop();
                          },
                        ),
                      ],
                    ),
                  )
                ],
              ),
            ),
          ),
        );
      },
    );
  }

  Widget buildChip(String label, {bool selected = false}) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 6),
      margin: const EdgeInsets.symmetric(horizontal: 6, vertical: 4),
      decoration: BoxDecoration(
          color: selected ? DesignColors.primaryColor : DesignColors.secondaryBackgroundColor,
          borderRadius: BorderRadius.circular(16),
          border: Border.all(color: DesignColors.primaryColor)),
      child: Text(label, style: body4.copyWith(color: selected ? DesignColors.secondaryBackgroundColor : DesignColors.primaryColor)),
    );
  }
}
