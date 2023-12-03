import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/extensions/assets_extension.dart';
import 'package:tahsaldar/extensions/data_extension.dart';
import 'package:tahsaldar/extensions/date_extension.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/ui/shared/total_amount/filter_widget.dart';
import 'package:tahsaldar/ui/widgets/filter/filter.dart';

import '../../resources/text_styles/text_styles.dart';

class TotalAmountCard extends StatelessWidget {
  final MutableLiveData<String> month;
  final MutableLiveData<String> year;
  final TotalPaid totalPaid;
  final Function() filter;
  const TotalAmountCard({
    required this.month,
    required this.year,
    required this.totalPaid,
    required this.filter,
    Key? key,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Stack(
      children: [
        Container(
          padding: const EdgeInsets.all(16.0),
          decoration: BoxDecoration(
            image: DecorationImage(image: AssetImage('total-card'.pngAsset), fit: BoxFit.cover),
            borderRadius: BorderRadius.circular(8),
          ),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.start,
                children: [
                  Text('paid_amount'.tr(), style: body1.copyWith(color: Colors.white)),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Row(
                        children: [
                          Text(
                            totalPaid.paid?.totalAmount.toString().formatNumber() ?? "",
                            style: boldText.copyWith(color: Colors.white),
                          ),
                          Text(' ${'sp'.tr()}', style: headline1.copyWith(color: Colors.white)),
                        ],
                      ),
                      const SizedBox(width: 10.0),
                      Row(
                        children: [
                          LiveDataBuilder<String>(
                            data: month,
                            builder: (context, data) {
                              return FilterWidget(
                                label: data,
                                callback: () {
                                  FilterDialog.openDialog(context: context, filters: months, liveData: month, filter: filter, height: 180);
                                },
                              );
                            },
                          ),
                          LiveDataBuilder<String>(
                            data: year,
                            builder: (context, data) {
                              return FilterWidget(
                                label: data,
                                callback: () {
                                  FilterDialog.openDialog(context: context, filters: years, liveData: year, filter: filter, height: 220);
                                },
                              );
                            },
                          ),
                        ],
                      )
                    ],
                  ),
                  const SizedBox(height: 16),
                  Text('pending_amount'.tr(), style: body2.copyWith(color: Colors.white)),
                  Row(
                    children: [
                      Text(
                        totalPaid.pending?.totalAmount.toString().formatNumber() ?? "",
                        style: headline2.copyWith(color: Colors.white),
                      ),
                      Text(' ${'sp'.tr()}', style: headline1.copyWith(color: Colors.white)),
                    ],
                  ),
                ],
              ),
            ],
          ),
        )
      ],
    );
  }
}
