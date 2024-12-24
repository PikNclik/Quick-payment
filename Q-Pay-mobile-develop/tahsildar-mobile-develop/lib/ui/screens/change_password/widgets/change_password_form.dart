import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/ui/screens/change_password/viewmodels/chaneg_password_viewmodel.dart';
import '../../../widgets/instance/instance_builder.dart';
import '../../../widgets/text_fields/labeled_customized_text_form_field.dart';
import '../../../widgets/text_fields/livedata_text_field.dart';

class ChangePasswordForm extends StatelessWidget {
  const ChangePasswordForm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<ChangePasswordViewModel>(
      builder: (viewModel) {
        return Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            LabeledTextField(
              label: 'old_password'.tr(),
              liveDataTextField: LiveDataTextField(
                liveData: viewModel.params.oldPassword,
                onTextChanged: viewModel.passwordChanged,
                keyboardType: TextInputType.text,
                secure: true,
                hint: '******',
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
            LiveDataBuilder<bool>(
              data: viewModel.params.passwordMatch,
              builder: (context, match) => Column(
                children: [
                  /// User bank account number
                  LabeledTextField(
                    label: 'new_password'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.newPassword,
                      errorText: match
                          ? null
                          : "password_does_not_match".tr(),
                      onTextChanged: viewModel.passwordChanged,
                      keyboardType: TextInputType.text,
                      secure: true,
                      hint: '******',
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

                  /// Confirm account number
                  LabeledTextField(
                    label: 'confirm_new_password'.tr(),
                    liveDataTextField: LiveDataTextField(
                      liveData: viewModel.params.confirmNewPassword,
                      errorText: match
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
