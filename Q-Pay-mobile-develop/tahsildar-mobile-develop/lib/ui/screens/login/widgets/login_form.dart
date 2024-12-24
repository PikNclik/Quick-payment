import 'package:easy_localization/easy_localization.dart' as el;
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/screens/login/viewmodels/login_viewmodel.dart';
import 'package:tahsaldar/ui/widgets/instance/instance_builder.dart';
import '../../../resources/text_styles/text_styles.dart';
import '../../../widgets/text_fields/labeled_customized_text_form_field.dart';
import '../../../widgets/text_fields/livedata_text_field.dart';

class LoginForm extends StatelessWidget {
  const LoginForm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<LoginViewModel>(
      builder: (viewModel) {
        return Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const SizedBox(height: 12),
            Directionality(
              textDirection: TextDirection.ltr,
              child: LabeledTextField(
                label: "",
                //label: 'mobile_number'.tr(),
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
            // LiveDataBuilder(
            //   data: viewModel.params.agreePrivacy,
            //   builder: (context, value) => Row(
            //     children: [
            //       Checkbox(
            //         checkColor: Colors.white,
            //         activeColor: DesignColors.primaryColor,
            //         value: value,
            //         onChanged: (value) => viewModel.changeAgree(),
            //       ),
            //       Text(
            //         'privacy_policy1'.tr(),
            //         style: body2,
            //       ),
            //       TextButton(
            //           child: Text('privacy_policy2'.tr(),
            //               style: body2.copyWith(
            //                   color: (DesignColors.primaryColor))),
            //           onPressed: () {
            //             showDialog(
            //                 context: context,
            //                 builder: (context) => Dialog(
            //                   alignment: Alignment.center,
            //                       elevation: 5,
            //                       child: SingleChildScrollView(
            //                         child: Padding(
            //                           padding: const EdgeInsets.symmetric(horizontal: 20.0),
            //                           child: Column(children: [
            //                             const SizedBox(height: 20),
            //                             Directionality(
            //                               textDirection: TextDirection.rtl,
            //                               child: Text("privacy_policy".tr(),style: body1,
            //                                 textAlign: TextAlign.center,
            //                               ),
            //                             ),
            //                             const SizedBox(height: 20),
            //                           ]),
            //                         ),
            //                       ),
            //                     ));
            //           }),
            //     ],
            //   ),
            // )
          ],
        );
      },
    );
  }
}
