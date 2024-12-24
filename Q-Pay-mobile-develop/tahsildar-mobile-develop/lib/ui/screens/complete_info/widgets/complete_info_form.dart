import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/extensions/formz_extension.dart';
import 'package:tahsaldar/extensions/nullable_extension.dart';
import 'package:tahsaldar/ui/screens/complete_info/viewmodels/complete_info_viewmodel.dart';

import '../../../widgets/autocomplete_text_form_field/autocomplete_text_form_field.dart';
import '../../../widgets/instance/instance_builder.dart';
import '../../../widgets/text_fields/labeled_customized_text_form_field.dart';
import '../../../widgets/text_fields/livedata_text_field.dart';

class CompleteInfoForm extends StatelessWidget {
  const CompleteInfoForm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<CompleteInfoViewModel>(
      builder: (viewModel) {
        return Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // const SizedBox(height: 12),
            // Text('enter_your_name'.tr(), style: title1),
            // const SizedBox(height: 12),

            /// User full name
            LabeledTextField(
              label: 'full_name'.tr(),
              liveDataTextField: LiveDataTextField(
                liveData: viewModel.params.fullName,
                onTextChanged: viewModel.attrChanged,
                hint: 'type_your_name'.tr(),
                textInputAction: TextInputAction.next,
                validate: (p0) {
                  RegExp pattern = RegExp(r'^[\u0621-\u064A\s]+$');
                  if (p0 != null) {
                    if (p0.isEmpty) {
                      return 'name_empty'.tr();
                    } else if (p0.length <5) {
                      return 'name_length'.tr();
                    } else if (!pattern.hasMatch(p0)) {
                      return 'name_invalid'.tr();
                    }
                    else if (p0
                        .split(" ")
                        .length < 3 ||
                        p0.split(" ")[0].length < 2 ||
                        p0.split(" ")[1].length < 2 ||
                        p0.split(" ")[2].length < 2
                    ){
                      return 'name_not_triple'.tr();
                    }
                    return null;
                  }
                },
              ),
            ),
            const SizedBox(height: 16),

            /// User bank
            LiveDataBuilder(
              data: viewModel.params.banks,
              builder: (context, list) => AutoCompleteTextField(
                labelText: "bank_name".tr(),
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

            LiveDataBuilder<bool>(
              data: viewModel.params.bankAccountMatch,
              builder: (context, match) {
              return  Column(
                children: [
                  /// User bank account number
                  LabeledTextField(
                    label: 'account_number'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.bankAccountNumber,
                      // errorText: match
                      //     ? null
                      //     : "back_account_number_does_not_match".tr(),
                      onTextChanged: viewModel.accountNumberChanged,
                      keyboardType: TextInputType.number,
                      hint: '000000',
                      textInputAction: TextInputAction.done,
                      validate: (p0) {
                        if(p0!=null){
                          RegExp regex = RegExp(r'^[0-9]+$');
                          if(!regex.hasMatch(p0)){
                            return "number_invalid".tr();
                          }else if(p0.length < 5 || p0.length > 30){
                            return "account_number_length".tr();

                          }
                        }
                      },
                    ),
                  ),

                  const SizedBox(height: 16),

                  /// Confirm account number
                  LabeledTextField(
                    label: 'confirm_account_number'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.confirmBankAccountNumber,
                      errorText: match || viewModel.params.confirmBankAccountNumber.inputValue().isEmpty
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
                          }else if(p0.length < 5 || p0.length > 30){
                            return "account_number_length".tr();

                          }
                        }
                      },
                    ),

                  ),
                  const SizedBox(height: 16),

                  /// User address
                  LiveDataBuilder(
                    data: viewModel.params.addresses,
                    builder: (context, list) => AutoCompleteTextField(
                      labelText: "address",
                      defaultValue:
                          viewModel.params.addressName.inputValue().tr(),
                      dropdownArrow: true,
                      openOnFocus: true,
                      items: list.reversed.toList(),
                      direction: AxisDirection.up,
                      onItemSelected: (type) {
                        type?.let((it) => viewModel.attrChanged(
                            viewModel.params.addressId, it.id.toString()));
                      },
                    ),
                  ),
                ],
              );}
            ),
            const SizedBox(height: 16),
            LiveDataBuilder<bool>(
              data: viewModel.params.passwordMatch,
              builder: (context, match) => Column(
                children: [
                  LabeledTextField(
                    tooltipMessage:"password_hint".tr(),
                    label: 'password'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.password,
                      // errorText: match
                      //     ? null
                      //     : "password_does_not_match".tr(),
                      onTextChanged: viewModel.passwordChanged,
                      keyboardType: TextInputType.text,
                      secure: true,
                      hint: '******',
                      textInputAction: TextInputAction.done,
                      validate: (p0) {
                        if(p0!=null){
                          String pattern = r'^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$';
                          RegExp regExp = RegExp(pattern);
                          if (!regExp.hasMatch(p0)) {
                            return "password_hint".tr();
                          }
                        }
                      },
                    ),
                  ),

                  const SizedBox(height: 16),

                  /// Confirm account number
                  LabeledTextField(
                    label: 'confirm_password'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.confirmPassword,
                      errorText: match || viewModel.params.confirmPassword.inputValue().isEmpty
                          ? null
                          : "password_does_not_match".tr(),
                      onTextChanged: viewModel.passwordChanged,
                      keyboardType: TextInputType.text,
                      hint: '******',
                      secure: true,
                      textInputAction: TextInputAction.done,
                      validate: (p0) {
                        if(p0!=null){
                          if(p0.length<8){
                            return "password_short".tr();
                          }
                        }
                      },
                    ),

                  ),
                  const SizedBox(height: 16),

                  /// User address
                ],
              ),
            ),


          ],
        );
      },
    );
  }
}
