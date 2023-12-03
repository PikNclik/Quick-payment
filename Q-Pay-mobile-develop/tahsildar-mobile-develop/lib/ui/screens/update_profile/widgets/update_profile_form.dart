import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/extensions/formz_extension.dart';
import 'package:tahsaldar/extensions/nullable_extension.dart';
import 'package:tahsaldar/ui/screens/update_profile/viewmodels/update_profile_viewmodel.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_column.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';

import '../../../widgets/autocomplete_text_form_field/autocomplete_text_form_field.dart';
import '../../../widgets/buttons/customized_button.dart';
import '../../../widgets/text_fields/labeled_customized_text_form_field.dart';
import '../../../widgets/text_fields/livedata_text_field.dart';

class UpdateProfileForm extends StatelessWidget {
  const UpdateProfileForm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<UpdateProfileViewModel>(
      builder: (viewModel) {
        return AnimatedColumn(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Column(
              children: [
                /// User full name
                LabeledTextField(
                  label: 'full_name'.tr(),
                  liveDataTextField: LiveDataTextField(
                    liveData: viewModel.params.fullName,
                    onTextChanged: viewModel.attrChanged,
                    hint: 'type_your_name'.tr(),
                    textInputAction: TextInputAction.next,
                  ),
                ),
                const SizedBox(height: 16),

                /// User bank
                LiveDataBuilder(
                  data: viewModel.params.banks,
                  builder: (context, list) => AutoCompleteTextField(
                    labelText: "bank_name",
                    defaultValue: viewModel.params.bankName.inputValue().tr(),
                    dropdownArrow: true,
                    openOnFocus: true,
                    items: list.reversed.toList(),
                    direction: AxisDirection.up,
                    onItemSelected: (type) {
                      type?.let((it) => viewModel.attrChanged(viewModel.params.bankId, it.id.toString()));
                    },
                  ),
                ),

                const SizedBox(height: 16),

                LiveDataBuilder<bool>(
                  data: viewModel.params.bankAccountMatch,
                  builder: (context, match) => Column(
                    children: [
                      /// User bank account number
                      LabeledTextField(
                        label: 'account_number'.tr(),
                        liveDataTextField: LiveDataTextField(
                          liveData: viewModel.params.bankAccountNumber,
                          errorText: match ? null : "back_account_number_does_not_match".tr(),
                          onTextChanged: viewModel.accountNumberChanged,
                          keyboardType: TextInputType.number,
                          hint: '000000',
                          textInputAction: TextInputAction.done,
                        ),
                      ),

                      const SizedBox(height: 16),

                      /// Confirm account number
                      LabeledTextField(
                        label: 'confirm_account_number'.tr(),
                        liveDataTextField: LiveDataTextField(
                          liveData: viewModel.params.confirmBankAccountNumber,
                          errorText: match ? null : "back_account_number_does_not_match".tr(),
                          onTextChanged: viewModel.accountNumberChanged,
                          keyboardType: TextInputType.number,
                          hint: '000000',
                          textInputAction: TextInputAction.done,
                        ),
                      ),
                    ],
                  ),
                ),

                const SizedBox(height: 16),

                /// User email
                LabeledTextField(
                  label: 'email'.tr(),
                  liveDataTextField: LiveDataTextField(
                    liveData: viewModel.params.email,
                    onTextChanged: viewModel.emailChanged,
                    hint: 'enter_your_email'.tr(),
                    textInputAction: TextInputAction.next,
                  ),
                ),

                const SizedBox(height: 16),

                /// User address
                LiveDataBuilder(
                  data: viewModel.params.addresses,
                  builder: (context, list) => AutoCompleteTextField(
                    labelText: "address",
                    defaultValue: viewModel.params.addressName.inputValue().tr(),
                    dropdownArrow: true,
                    openOnFocus: true,
                    items: list.reversed.toList(),
                    direction: AxisDirection.up,
                    onItemSelected: (type) {
                      type?.let((it) => viewModel.attrChanged(viewModel.params.addressId, it.id.toString()));
                    },
                  ),
                ),
              ],
            ),
            LiveDataBuilder<bool>(
              data: viewModel.params.submit,
              builder: (context, enabled) {
                return Column(
                  children: [
                    const SizedBox(height: 32),
                    CustomizedButton(
                      enabled: enabled,
                      text: 'update',
                      callback: viewModel.updateProfile,
                      width: 120,
                    ),
                    const SizedBox(height: 42),
                  ],
                );
              },
            ),
          ],
        );
      },
    );
  }
}
