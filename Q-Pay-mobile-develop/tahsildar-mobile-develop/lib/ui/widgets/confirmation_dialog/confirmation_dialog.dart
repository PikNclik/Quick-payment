import 'package:flutter/material.dart';
import 'package:tahsaldar/ui/widgets/buttons/customized_button.dart';

import '../animations/customized_animated_widget.dart';
import '../buttons/customized_outlined_button.dart';

class ConfirmDialog extends StatelessWidget {
  final String message;
  final Function()? onConfirm;
  final Function()? onCancel;
  final Widget? confirmationBtn;
  final Widget? cancelBtn;
  final String? confirmationText;
  const ConfirmDialog({
    required this.message,
    this.onConfirm,
    this.onCancel,
    this.confirmationBtn,
    this.cancelBtn,
    this.confirmationText,
    Key? key,
  }) : super(key: key);

  static openDialog({
    required BuildContext context,
    required String message,
    Function()? onConfirm,
    Function()? onCancel,
    bool isDismissible = true,
    Widget? confirmationBtn,
    Widget? cancelBtn,
    Color? barrierColor,
    String? confirmationText,
  }) async {
    showDialog(
      context: context,
      builder: (context) => ConfirmDialog(
        message: message,
        onConfirm: onConfirm,
        onCancel: onCancel,
        confirmationBtn: confirmationBtn,
        cancelBtn: cancelBtn,
        confirmationText: confirmationText,
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Dialog(
      insetPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 20),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      child: CustomizedAnimatedWidget(
        child: Container(
          padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 20),
          width: double.infinity,
          height: 200,
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              Text(
                message,
                textAlign: TextAlign.center,
                style: const TextStyle(fontSize: 20, fontWeight: FontWeight.w500),
              ),
              const SizedBox(height: 40),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceAround,
                children: [
                  confirmationBtn ??
                      CustomizedButton(
                        text: confirmationText ?? "yes",
                        callback: () {
                          Navigator.of(context).pop();
                          onConfirm?.call();
                        },
                      ),
                  cancelBtn ??
                      CustomizedOutlinedButton(
                        text: "cancel",
                        callback: () {
                          onCancel?.call();
                          Navigator.of(context).pop();
                        },
                      ),
                ],
              )
            ],
          ),
        ),
      ),
    );
  }
}
