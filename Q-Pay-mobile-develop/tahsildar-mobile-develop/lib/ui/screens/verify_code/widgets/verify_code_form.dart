import 'package:easy_localization/easy_localization.dart';
import 'package:flutter/material.dart';
import 'package:flutterx_live_data/flutterx_live_data.dart';
import 'package:tahsaldar/extensions/date_extension.dart';
import 'package:tahsaldar/ui/resources/colors/colors.dart';
import 'package:tahsaldar/ui/resources/text_styles/text_styles.dart';
import 'package:tahsaldar/ui/screens/verify_code/viewmodels/verify_code_viewmodel.dart';
import 'package:flutter_countdown_timer/flutter_countdown_timer.dart';
import 'package:tahsaldar/ui/widgets/buttons/text_button.dart';
import 'package:tahsaldar/ui/widgets/inputs/pin_code_input.dart';
import '../../../widgets/instance/instance_builder.dart';

class VerifyCodeForm extends StatelessWidget {
  const VerifyCodeForm({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return InstanceBuilder<VerifyCodeViewModel>(
      builder: (viewModel) {
        return Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          children: [
            const SizedBox(height: 24),
            PinCodeInput(
              onChanged: viewModel.onPinChanged,
            ),
            const SizedBox(height: 15),
            LiveDataBuilder(
              data: viewModel.params.resendCodeEnabled,
              builder: (context, enabled) => enabled
                  ? AppTextButton(
                      callback: viewModel.resendCode,
                      text: 'resend_the_code'.tr(),
                      textStyle:
                          body3.copyWith(color: DesignColors.primaryColor),
                    )
                  : CountdownTimer(
                      widgetBuilder: (context, time) => Text(
                        "${time?.min?.toString().addZero() ?? '00'}:${time?.sec?.toString().addZero() ?? '00'}",
                        style: body3.copyWith(color: DesignColors.primaryColor),
                      ),
                      endTime:
                          viewModel.enabledDatetime().millisecondsSinceEpoch,
                      endWidget: const SizedBox(),
                      onEnd: () =>
                          viewModel.params.resendCodeEnabled.postValue(true),
                    ),
            ),

          ],
        );
      },
    );
  }
}
