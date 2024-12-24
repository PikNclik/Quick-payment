import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/screens/login_password/viewmodels/login_password_viewmodel.dart';
import '../../../../router/app_router.dart';
import '../../../resources/colors/colors.dart';
import '../../../resources/text_styles/text_styles.dart';
import '../../../widgets/instance/instance_builder.dart';
import '../../../widgets/text_fields/labeled_customized_text_form_field.dart';
import '../../../widgets/text_fields/livedata_text_field.dart';

class LoginPasswordForm extends StatelessWidget {
  const LoginPasswordForm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<LoginPasswordViewModel>(
      builder: (viewModel) {
        return Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // const SizedBox(height: 12),
            // Text('enter_your_name'.tr(), style: title1),
            // const SizedBox(height: 12),
            Column(
              children: [
                /// User bank account number
                LabeledTextField(
                  label: 'enter_password'.tr(),
                  liveDataTextField: LiveDataTextField(
                    liveData: viewModel.params.password,
                    onTextChanged: viewModel.attrChanged,
                    keyboardType: TextInputType.text,
                    hint: '******',
                    textInputAction: TextInputAction.done,
                    secure: true,
                    validate: (p0) {
                      if(p0!=null){
                        if(p0.length<8){
                          return "password_short".tr();
                        }
                      }
                    },
                  ),
                ),
                const SizedBox(
                  height: 20,
                ),
                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Text(
                      'forget_password'.tr(),
                      style: body1,
                    ),
                    const SizedBox(width: 5),
                    InkWell(
                        onTap: () => appRouter
                            .push(ResetPasswordVerification(mobile: viewModel.params.mobile)),
                        child: Text(
                          "( ${'reset_password'.tr()} )",
                          style: body1.copyWith(color: DesignColors.primaryColor),
                        )),
                  ],
                ),

                const SizedBox(
                  height: 20,
                ),

                Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Text(
                      'login_by'.tr(),
                      style: body1,
                    ),
                    const SizedBox(width: 5),
                    InkWell(
                        onTap: () => appRouter
                            .push(VerifyCode(mobile: viewModel.params.mobile)),
                        child: Text(
                         "(${ 'verification'.tr()})",
                          style: body1.copyWith(color: DesignColors.primaryColor),
                        )),
                  ],
                )

                /// User address
              ],
            ),


          ],
        );
      },
    );
  }
}
