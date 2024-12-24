import 'package:easy_localization/easy_localization.dart' as el;
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/config/ui_config.dart';
import 'package:tahsaldar/extensions/data_extension.dart';
import 'package:tahsaldar/extensions/nullable_extension.dart';
import 'package:tahsaldar/extensions/text_format_extension.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/storage/storage.dart';
import 'package:tahsaldar/ui/pickers/date_time_picker.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/screens/add_payment/viewmodels/add_payment_viewmodel.dart';
import 'package:tahsaldar/ui/screens/add_payment/widgets/summary_card.dart';
import 'package:tahsaldar/ui/widgets/buttons/customized_button.dart';
import 'package:tahsaldar/ui/widgets/text_fields/date_text_form_field.dart';
import '../../../../utils/fake_utils.dart';
import '../../../core/layouts/base_scroll_view.dart';
import '../../../resources/colors/colors.dart';
import '../../../widgets/autocomplete_text_form_field/autocomplete_text_form_field.dart';
import '../../../widgets/buttons/outlined_icon_button.dart';
import '../../../widgets/instance/instance_builder.dart';
import '../../../widgets/text_fields/labeled_customized_text_form_field.dart';
import '../../../widgets/text_fields/livedata_text_field.dart';

class AddPaymentForm extends StatelessWidget {
  AddPaymentForm({Key? key}) : super(key: key);
  final formKey = GlobalKey<FormState>();
  final _nameFocusNode =  FocusNode();
  final _phoneFocusNode =  FocusNode();
  final _amountFocusNode =  FocusNode();
  final _detailsFocusNode =  FocusNode();

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<AddPaymentViewModel>(
      builder: (viewModel) {
        return BaseScrollView(
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 4),
            child: Form(
              key: formKey,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  /// payer name
                  LabeledTextField(
                    label: 'payer_name'.tr(),
                    liveDataTextField: LiveDataTextField(
                      focusNode: _nameFocusNode,
                      liveData: viewModel.params.payerName,
                      onTextChanged: viewModel.attrChanged,
                      hint: 'type_customer_name'.tr(),
                      validate: (p0) {
                        RegExp pattern = RegExp(r'^[\u0621-\u064A\s]+$');
                        if (p0 != null) {
                          if (p0.isEmpty) {
                            _nameFocusNode.requestFocus();
                            return 'name_empty'.tr();
                          } else if (p0.length < 5) {
                            _nameFocusNode.requestFocus();
                            return 'not_complete_name'.tr();
                          } else if (!pattern.hasMatch(p0)) {
                            _nameFocusNode.requestFocus();
                            return 'name_invalid'.tr();
                          }
                          else if (p0
                              .split(" ")
                              .length < 2 || p0
                              .split(" ")[0].length < 2 || p0
                              .split(" ")[1].length < 2) {
                            _nameFocusNode.requestFocus();
                            return 'not_complete_name'.tr();
                          }
                          return null;
                        }
                      },
                    ),
                  ),

                  ///payer mobile number
                  LabeledTextField(
                    label: 'mobile_number'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.payerMobile,
                      onTextChanged: viewModel.mobileAttrChanged,
                      keyboardType: TextInputType.number,
                      hint: '09',
                      prefixIconConstraints:
                          const BoxConstraints(minWidth: 66, maxWidth: 70),
                      // validate: (p0) {
                      //   if (p0 == null || !(p0.startsWith("05") || p0.startsWith("09")) || p0.length != 10) {
                      //     return 'phone_invalid'.tr();
                      //   }
                      //   return null;
                      // },
                    ),
                  ),

                  /// payment amount
                  LabeledTextField(
                    label: 'payment_amount'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.paymentAmount,
                      onTextChanged: viewModel.paymentAmountAttrChanged,
                      isNumber: true,
                      focusNode: _amountFocusNode,
                      keyboardType: TextInputType.number,
                      suffixIcon: Text(
                        FakeUtil.getCurrency(),
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
                      validate: (p0) {
                        if (p0 == null ||
                            p0.replaceAll(",", "").toDouble() > 25000000.0 ||
                            p0.replaceAll(",", "").toDouble() < 50000.0) {
                          _amountFocusNode.requestFocus();
                          return 'amount_invalid'.tr();
                        }
                        return null;
                      },
                    ),
                  ),

                  /// payer bank account number
                  LabeledTextField(
                    label: "${'payment_details'.tr()} (${'optional'.tr()})",
                    liveDataTextField: LiveDataTextField(
                      focusNode: _detailsFocusNode,
                      liveData: viewModel.params.note,
                      onTextChanged: viewModel.attrChanged,
                      textInputAction: TextInputAction.done,
                      validate: (p0) {
                        RegExp pattern = RegExp(r'^[0-9]+$');
                        if (p0 != null && p0.isNotEmpty) {
                         if (pattern.hasMatch(p0) || p0.length < 3) {
                           _detailsFocusNode.requestFocus();
                            return 'details_invalid'.tr();
                          }
                        }
                        return null;
                      },
                    ),
                  ),
                  LabeledTextField(
                    label: "${'schedule_date'.tr()} (${'optional'.tr()})",
                    liveDataTextField:
                    MultipleLiveDataBuilder.with2<DateTime?, DateTime?>(
                        x1: viewModel.params.expiryDate,
                        x2: viewModel.params.scheduledDate,
                        builder: (context, expiryDate, scheduledDate) {
                          return DateTextFormField(
                            defaultValue: scheduledDate.toString(),
                            label: 'select_schedule_date'.tr(),
                            datePickerType: DatePickerType.datetime,
                            title: 'pick_payment_scheduled_date_time'.tr(),
                            callback: (datetime, value) {
                              viewModel.scheduleAndSend(datetime);
                            },
                            minTime: DateTime.now(),
                            currentTime: DateTime.now(),
                          );
                        }),
                  ),
                  ///Expiry date
                  LabeledTextField(
                    label: "${'expiry_date'.tr()} (${'optional'.tr()})",
                    liveDataTextField:
                        MultipleLiveDataBuilder.with2<DateTime?, DateTime?>(
                            x1: viewModel.params.expiryDate,
                            x2: viewModel.params.scheduledDate,
                            builder: (context, expiryDate, scheduledDate) {
                              return DateTextFormField(
                                defaultValue: expiryDate.toString(),
                                label: 'expiry_date'.tr(),
                                datePickerType: DatePickerType.datetime,
                                title: 'pick_payment_expiry_date_time'.tr(),
                                callback: (datetime, value) {
                                  viewModel.pickExpiryDate(datetime);
                                },
                                minTime: scheduledDate != null
                                    ? scheduledDate.add(const Duration(days: 1))
                                    : DateTime.now()
                                        .add(const Duration(days: 1)),
                                currentTime: expiryDate ??
                                    DateTime.now().add(const Duration(days: 1)),
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
                  if (viewModel.params.isUpdate)
                    LiveDataBuilder<bool>(
                      data: viewModel.params.submit,
                      builder: (context, value) => CustomizedButton(
                        enabled: value,
                        text: 'update',
                        callback: () async {
                          if (formKey.currentState!.validate()) {
                            bool? res = await viewModel.updatePaymentRequest();
                            if (res != null && res == true) {
                              appRouter.pop(true);
                            }
                          }
                        },
                        width: 200,
                      ),
                    ),
                  if (!viewModel.params.isUpdate)
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
                                callback: () {
                                  if (formKey.currentState!.validate()) {
                                    viewModel.addPaymentRequest();
                                  }
                                },
                                width: 200,
                              ),
                              const SizedBox(height: 16),

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
