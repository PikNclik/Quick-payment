import 'dart:convert';

import 'package:auto_route/auto_route.dart';
import 'package:flutter/foundation.dart';
import 'package:notifications/notifications.dart';
import 'package:tahsaldar/extensions/data_extension.dart';
import 'package:tahsaldar/models/data/payment/payment.dart';

import '../router/app_router.dart';
import '../ui/resources/colors/colors.dart';

final notificationService = NotificationService(
  onSelectNotification: onSelectNotification,
  androidChannelId: "com.tradinos.tahsaldar",
  androidChannelName: "tahsaldar_app",
  color: DesignColors.primaryColor,
  notificationIcon: "ic_notification",
);

/// config notifications
notificationConfig() async {
  await notificationService.initializeNotificationService();
}

/// callback for select notification
bool onSelectNotification(String? payload) {
  try {
    final json = jsonDecode(payload ?? "{}");
    // go to transication details
    if (json["payment_id"] != null) {
      final payment = Payment(id: json["payment_id"].toString().toInteger());
      navigate(TransactionsDetails(transaction: payment));
    } else {
      navigate(const Main());
    }
  } catch (error) {
    if (kDebugMode) print(error);
  }
  return true;
}

/// navigate to screen
void navigate(PageRouteInfo pageRouteInfo) {
  if (appRouter.current.name == pageRouteInfo.routeName) {
    appRouter.replace(pageRouteInfo);
  } else {
    appRouter.push(pageRouteInfo);
  }
}
