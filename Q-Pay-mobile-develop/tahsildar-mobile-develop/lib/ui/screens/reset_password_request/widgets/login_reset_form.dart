import 'package:easy_localization/easy_localization.dart' as el;
import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';
import '../../../widgets/text_fields/labeled_customized_text_form_field.dart';
import '../../../widgets/text_fields/livedata_text_field.dart';
import '../viewmodels/reset_password_viewmodel.dart';

class LoginResetForm extends StatelessWidget {
  const LoginResetForm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<ResetPasswordViewModel>(
      builder: (viewModel) {
        return Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const SizedBox(height: 12),
            Directionality(
              textDirection: TextDirection.ltr,
              child: LabeledTextField(
                label: 'mobile_number'.tr(),
                liveDataTextField: LiveDataTextField(
                  liveData: viewModel.params.mobile,
                  onTextChanged: viewModel.attrChanged,
                  keyboardType: TextInputType.number,
                  textInputAction: TextInputAction.done,
                  hint: '0.....',
                 /* prefixIcon: Center(
                    child: Row(
                      textDirection: TextDirection.ltr,
                      children: [
                        const SizedBox(width: 14),
                        Text('+963', style: body2),
                        const SizedBox(width: 14),
                        Text(
                          '|',
                          style: bo

                          dy2.copyWith(color: DesignColors.grey),
                        ),
                      ],
                    ),
                  ),*/
                  prefixIconConstraints:
                      const BoxConstraints(minWidth: 66, maxWidth: 70),
                ),
              ),
            ),
          ],
        );
      },
    );
  }
}
