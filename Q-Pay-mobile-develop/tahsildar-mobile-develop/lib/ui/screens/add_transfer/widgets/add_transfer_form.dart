import 'package:easy_localization/easy_localization.dart' as el;
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/extensions/formz_extension.dart';
import 'package:tahsaldar/extensions/nullable_extension.dart';
import 'package:tahsaldar/extensions/text_format_extension.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/screens/add_transfer/viewmodels/add_transfer_viewmodel.dart';
import 'package:tahsaldar/ui/widgets/buttons/customized_button.dart';
import '../../../../utils/fake_utils.dart';
import '../../../core/layouts/base_scroll_view.dart';
import '../../../widgets/autocomplete_text_form_field/autocomplete_text_form_field.dart';
import '../../../widgets/instance/instance_builder.dart';
import '../../../widgets/text_fields/labeled_customized_text_form_field.dart';
import '../../../widgets/text_fields/livedata_text_field.dart';

class AddTransferForm extends StatelessWidget {
  AddTransferForm({Key? key}) : super(key: key);
  final formKey = GlobalKey<FormState>();

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<AddTransferViewModel>(
      builder: (viewModel) {
        return BaseScrollView(
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 16),
            child: Form(
              key: formKey,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                children: [
                  const SizedBox(
                    height: 50,
                  ),
                  /// payer name
                  LabeledTextField(
                    label: 'payer_name'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.name,
                      onTextChanged: viewModel.attrChanged,
                      hint: 'type_customer_name'.tr(),
                      validate: (p0) {
                        RegExp pattern = RegExp(r'^[a-zA-Z\u0621-\u064A\s]+$');
                        if (p0 != null) {
                          if (!pattern.hasMatch(p0)) {
                            return 'name_invalid'.tr();
                          }
                          return null;
                        }
                      },
                    ),
                  ),
                  const SizedBox(height: 32),
                  /// User bank
                  LiveDataBuilder(
                    data: viewModel.params.banks,
                    builder: (context, list) => AutoCompleteTextField(
                      labelText: "bank_name_customer".tr(),
                      defaultValue: viewModel.params.bankName.inputValue().tr(),
                      dropdownArrow: true,
                      openOnFocus: true,
                      items: list.reversed.toList(),
                      direction: AxisDirection.down,
                      onItemSelected: (type) {
                        type?.let((it) => viewModel.attrChanged(
                            viewModel.params.bankId, it.id.toString()));
                      },
                    ),
                  ),
                  const SizedBox(height: 16),

                  /// User bank account number
                  LabeledTextField(
                    label: 'account_number_customer'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.bankAccountNumber,
                      onTextChanged: viewModel.attrChanged,
                      keyboardType: TextInputType.number,
                      hint: '000000',
                      textInputAction: TextInputAction.done,
                      validate: (p0) {
                        if (p0 != null) {
                          RegExp regex = RegExp(r'^[0-9]+$');
                          if (!regex.hasMatch(p0)) {
                            return "number_invalid".tr();
                          }else if(p0.length!=7){
                            return "account_number_length".tr();

                          }
                        }
                      },
                    ),
                  ),
                  const SizedBox(height: 16),

                  LiveDataBuilder(
                    data: viewModel.params.bankAccountMatch,
                    builder: (context, match) =>  LabeledTextField(
                      label: 'confirm_account_number'.tr(),
                      liveDataTextField: LiveDataTextField(
                        liveData: viewModel.params.confirmBankAccountNumber,
                        errorText: match
                            ? null
                            : "back_account_number_does_not_match".tr(),
                        onTextChanged: viewModel.accountNumberChanged,
                        keyboardType: TextInputType.number,
                        hint: '000000',
                        textInputAction: TextInputAction.done,
                        validate:  (p0) {
                          if(p0!=null){
                            RegExp regex = RegExp(r'^[0-9]+$');
                            if(!regex.hasMatch(p0)){
                              return "number_invalid".tr();
                            }else if(p0.length!=7){
                              return "account_number_length".tr();

                            }
                          }
                        },
                      ),

                    ),
                  ),

                  const SizedBox(height: 16),

                  ///payer mobile number
                  LabeledTextField(
                    label: 'mobile_number'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.phone,
                      onTextChanged: viewModel.mobileAttrChanged,
                      keyboardType: TextInputType.number,
                      hint: '09',
                      prefixIconConstraints:
                          const BoxConstraints(minWidth: 66, maxWidth: 70),
                    ),
                  ),
                  const SizedBox(height: 16),

                  /// payment amount
                  LabeledTextField(
                    label: 'transfer_value'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.amount,
                      onTextChanged: viewModel.attrChanged,
                      keyboardType: TextInputType.number,
                      isNumber: true,
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
                    ),
                  ),
                  const SizedBox(height: 50),
                  LiveDataBuilder<bool>(
                    data: viewModel.params.submit,
                    builder: (context, value) => CustomizedButton(
                      enabled: value,
                      text: 'add_transfer_request',
                      callback: () async {
                        if (formKey.currentState!.validate()) {
                          await viewModel.addTransferRequest();
                          appRouter.pop(false);
                        }
                      },
                      width: 200,
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
