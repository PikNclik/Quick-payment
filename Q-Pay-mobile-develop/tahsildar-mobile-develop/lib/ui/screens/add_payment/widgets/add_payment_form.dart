import 'package:easy_localization/easy_localization.dart' as el;
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/config/ui_config.dart';
import 'package:tahsaldar/extensions/text_format_extension.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/storage/storage.dart';
import 'package:tahsaldar/ui/pickers/date_time_picker.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/screens/add_payment/viewmodels/add_payment_viewmodel.dart';
import 'package:tahsaldar/ui/screens/add_payment/widgets/summary_card.dart';
import 'package:tahsaldar/ui/widgets/buttons/customized_button.dart';
import 'package:tahsaldar/ui/widgets/text_fields/date_text_form_field.dart';
import '../../../core/layouts/base_scroll_view.dart';
import '../../../resources/colors/colors.dart';
import '../../../widgets/buttons/outlined_icon_button.dart';
import '../../../widgets/instance/instance_builder.dart';
import '../../../widgets/text_fields/labeled_customized_text_form_field.dart';
import '../../../widgets/text_fields/livedata_text_field.dart';

class AddPaymentForm extends StatelessWidget {
  const AddPaymentForm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<AddPaymentViewModel>(
      builder: (viewModel) {
        return BaseScrollView(
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Form(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  /// payer name
                  LabeledTextField(
                    label: 'payer_name'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.payerName,
                      onTextChanged: viewModel.attrChanged,
                      hint: 'type_customer_name'.tr(),
                    ),
                  ),
                  const SizedBox(height: 16),

                  ///payer mobile number
                  Directionality(
                    textDirection: TextDirection.ltr,
                    child: LabeledTextField(
                      label: 'mobile_number'.tr(),
                      liveDataTextField: LiveDataTextField(
                        liveData: viewModel.params.payerMobile,
                        onTextChanged: viewModel.mobileAttrChanged,
                        keyboardType: TextInputType.number,
                        hint: '9......',
                        prefixIcon: Center(
                          child: Row(
                            children: [
                              const SizedBox(width: 14),
                              Text('+963', style: body2),
                              const SizedBox(width: 14),
                              Text(
                                '|',
                                style: body2.copyWith(color: DesignColors.grey),
                              ),
                            ],
                          ),
                        ),
                        prefixIconConstraints: const BoxConstraints(minWidth: 66, maxWidth: 70),
                      ),
                    ),
                  ),
                  const SizedBox(height: 16),

                  /// payment amount
                  LabeledTextField(
                    label: 'payment_amount'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.paymentAmount,
                      onTextChanged: viewModel.paymentAmountAttrChanged,
                      keyboardType: TextInputType.number,
                      suffixIcon: Text(
                        'sp'.tr(),
                        style: title3,
                      ),
                      suffixIconConstraints: const BoxConstraints(
                        minWidth: 40,
                        maxWidth: 40,
                      ),
                      inputFormatters: [
                        NeatCostFilterFormatter(),
                        // FilteringTextInputFormatter.allow(RegExp(r'^[1-9][0-9]*')),
                      ],
                    ),
                  ),
                  const SizedBox(height: 16),

                  /// payer bank account number
                  LabeledTextField(
                    label: 'payment_details'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.note,
                      onTextChanged: viewModel.attrChanged,
                      textInputAction: TextInputAction.done,
                    ),
                  ),
                  const SizedBox(height: 16),

                  ///Expiry date
                  LabeledTextField(
                    label: "${'expiry_date'.tr()} (${'optional'.tr()})",
                    liveDataTextField: LiveDataBuilder<DateTime?>(
                        data: viewModel.params.expiryDate,
                        builder: (context, expiryDate) {
                          return DateTextFormField(
                            label: 'expiry_date'.tr(),
                            datePickerType: DatePickerType.datetime,
                            title: 'pick_payment_expiry_date_time'.tr(),
                            callback: (datetime, value) {
                              viewModel.pickExpiryDate(datetime);
                            },
                            minTime: DateTime.now().add(const Duration(days: 1)),
                            currentTime: expiryDate ?? DateTime.now().add(const Duration(days: 1)),
                          );
                        }),
                  ),

                  const SizedBox(height: 24),

                  LiveDataBuilder<double>(
                    data: viewModel.params.amount,
                    builder: (context, amount) {
                      return LiveDataBuilder<double>(
                        data: viewModel.params.fees,
                        builder: (context, fees) {
                          return LiveDataBuilder<double>(
                            data: viewModel.params.totalAmount,
                            builder: (context, totalAmount) {
                              return SummaryCard(
                                amount: amount.toString(),
                                fees: fees.toString(),
                                totalAmount: totalAmount.toString(),
                              );
                            },
                          );
                        },
                      );
                    },
                  ),

                  const SizedBox(height: 24),

                  SizedBox(
                    width: 200,
                    child: LiveDataBuilder<bool>(
                      data: viewModel.params.submit,
                      builder: (context, enabled) {
                        return Column(
                          children: [
                            CustomizedButton(
                              enabled: enabled,
                              text: 'request_now',
                              callback: viewModel.addPaymentRequest,
                              width: 200,
                            ),
                            const SizedBox(height: 16),
                            OutlinedIconButton(
                              enabled: enabled,
                              text: 'schedule_request',
                              svg: 'calender',
                              callback: () => AppDateTimePicker.showDateTimePicker(
                                context: context,
                                confirmButtonText: 'request',
                                callback: (date) {
                                  hideSoftKeyboard(context);
                                  appRouter.pop();
                                  viewModel.scheduleAndSend(date);
                                },
                                minTime: DateTime.now(),
                                title: 'pick_payment_scheduled_date_time'.tr(),
                                currentTime: DateTime.now(),
                              ),
                            ),
                            const SizedBox(height: 42),
                          ],
                        );
                      },
                    ),
                  ),
                ],
              ),
            ),
          ),
        );
      },
    );
  }
}
