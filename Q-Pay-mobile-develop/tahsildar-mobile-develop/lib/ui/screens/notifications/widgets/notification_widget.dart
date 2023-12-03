import 'package:flutter/material.dart' hide Notification;
import 'package:tahsaldar/extensions/data_extension.dart';
import 'package:tahsaldar/models/data_models.dart';
import 'package:tahsaldar/router/app_router.dart';
import 'package:tahsaldar/ui/resources/dimensions/dimensions.dart';
import 'package:tahsaldar/ui/resources/themes/card_style.dart';
import 'package:tahsaldar/extensions/date_extension.dart';
import 'package:tahsaldar/ui/widgets/animations/animated_gesture.dart';

class NotificationWidget extends StatelessWidget {
  final Notification notification;
  final String format;
  const NotificationWidget({required this.notification, this.format = isoMonthFormat, super.key});

  @override
  Widget build(BuildContext context) {
    return AnimatedGesture(
      callback: () {
        final paymentId = notification.payloadKey('payment_id');
        if (paymentId != 'null') {
          final payment = Payment(id: paymentId.toInteger());
          appRouter.push(TransactionsDetails(transaction: payment));
        }
      },
      child: Column(
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              const SizedBox(),
              Text(
                notification.createdAt?.formatDate(format) ?? "",
                style: const TextStyle(
                  fontSize: verySmallText,
                  fontWeight: FontWeight.w300,
                  color: Color(0XFFB1B1B1),
                ),
              ),
            ],
          ),
          Container(
            width: double.infinity,
            margin: const EdgeInsets.symmetric(vertical: unit),
            padding: const EdgeInsets.all(twoUnits),
            decoration: transactionCardStyle,
            child: Text(notification.dataKey('body')),
          ),
        ],
      ),
    );
  }
}
